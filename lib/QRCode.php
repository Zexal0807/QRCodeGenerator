<?php
require_once('./lib/loadData.php');
require_once('./lib/PolynomialDivision.php');
require_once('./lib/MatrixManager.php');
require_once('./lib/MaskerMaker.php');

class QRCode
{

    public static function createPhoneNumber($phone, ErrorCorrection $errorCorrection)
    {
        return QRCode::create("tel:" . $phone, $errorCorrection);
    }

    public static function createSms($to, $message, ErrorCorrection $errorCorrection)
    {
        return QRCode::create("SMSTO:" . $to . ":" . $message, $errorCorrection);
    }

    public static function createEmail($to, $subject, $message, ErrorCorrection $errorCorrection)
    {
        return QRCode::create("mailto:" . $to . "?subject=" . urlencode($subject) . "&body=" . urlencode($message), $errorCorrection);
    }

    public static function createUrl($link, ErrorCorrection $errorCorrection)
    {
        return QRCode::create($link, $errorCorrection);
    }

    public static function createWifi($ssid, $cry, $password, ErrorCorrection $errorCorrection)
    {
        return QRCode::create("WIFI:S:" . $ssid . ";T:" . $cry . ";P:" . $password . ";;", $errorCorrection);
    }

    public static function createPosition($lat, $lng, ErrorCorrection $errorCorrection)
    {
        return QRCode::create("https://maps.google.com/local?q=" . $lat . "," . $lng, $errorCorrection);
    }

    public static function createEvent($title, $location, $starttime, $endtime, ErrorCorrection $errorCorrection)
    {
        return QRCode::create("BEGIN:VEVENT\nSUMMARY:" . $title . "\nLOCATION:" . $location . "\nDTSTART:" . str_replace(["/", ":", " "], ["", "", "T"], $starttime) . "\nDTEND:" . str_replace(["/", ":", " "], ["", "", "T"], $endtime) . "\nEND:VEVENT\n", $errorCorrection);
    }

    public static function create($data, ErrorCorrection $errorCorrection)
    {
        $encoding = QRCode::findEnconding($data);
        $level = QRCode::findBestLevel($data, $encoding, $errorCorrection);

        return QRCode::generate($data, $level, $encoding, $errorCorrection);
    }

    private static function findEnconding($data)
    {
        if (preg_match('/^[0-9]*$/', $data)) {
            return Encoding::$ENCODING_NUMERIC;
        }
        if (preg_match('/^[A-Z0-9 $%*+.\/:-]*$/', $data)) {
            return Encoding::$ENCODING_ALPHANUMERIC;
        }

        return Encoding::$ENCODING_BYTE;
    }

    private static function findBestLevel($data, Encoding $encoding, ErrorCorrection $errorCorrection)
    {
        $need = strlen($data);
        for ($i = 1; $i <= 5; $i++) {
            $level = Level::${"LEVEL_" . $i};
            if ($level->getCapacity($encoding, $errorCorrection) > $need) {
                return $level;
            }
        }
        throw new Exception("to much data");
    }

    private static function generate($data, Level $level,  Encoding $encoding, ErrorCorrection $errorCorrection)
    {
        // Encode data
        $dataCodewords = QRCode::encode($data, $level,  $encoding, $errorCorrection);

        // Split data codewords in blocks
        $dataCodewords = QRCode::splitCodewords($dataCodewords, $level, $errorCorrection);

        // Calc error codewords
        $dataCodewords = QRCode::calcErrorCodewords($dataCodewords, $level,  $errorCorrection);

        // Interleaved data cordewords and error correction codewords
        $data = QRCode::interleavedCodeword($dataCodewords, $level, $errorCorrection);

        // Convert to bit, add remainder bits
        $data = array_map(function ($el) {
            return sprintf("%08b", $el);
        }, $data);
        $data = implode("", $data);
        $data = $data . str_repeat("0", $level->getRemainderBits());

        $matrix = new MatrixManager($level, $errorCorrection);
        $matrix->setData($data);
        $matrix = $matrix->getMatrix();

        $matrix = MaskerMaker::generate($errorCorrection, $matrix);
        return $matrix;
    }

    private static function encode($data, Level $level,  Encoding $encoding, ErrorCorrection $errorCorrection)
    {
        $modeIndicator = $encoding->getModeIndicator();
        $characterCountIndicatorLength = $level->getCharacterCountIndicatorLength($encoding);
        $characterCountIndicator = sprintf("%0" . $characterCountIndicatorLength . "b", strlen($data));

        $encodedData = $encoding->encode($data);

        $bitString = $modeIndicator . "" . $characterCountIndicator . "" . $encodedData;

        $requiredNumberBits = $level->getTotalDataCodewords($errorCorrection) * 8;

        // Add terminator 0
        if (strlen($bitString) < $requiredNumberBits) {
            $i = min($requiredNumberBits - strlen($bitString), 4);
            $bitString = $bitString . "" . str_repeat("0", $i);
        }

        // Add 0 for mutiple of 8
        $bitString = $bitString . "" . str_repeat("0", (8 - strlen($bitString) % 8) % 8);

        // Add bytes for cover max capacity
        $bytes = ["11101100", "00010001"];
        $selected = 0;

        while (strlen($bitString) < $requiredNumberBits) {
            $bitString = $bitString . $bytes[$selected];
            $selected = ($selected + 1) % 2;
        }

        $dataCodewords = str_split($bitString, 8);

        return $dataCodewords;
    }

    private static function splitCodewords($dataCodewords, Level $level, ErrorCorrection $errorCorrection)
    {
        $groups = [
            "GROUP_1" => [
                "BLOCK_1" => []
            ],
            "GROUP_2" => []
        ];

        $counter = 0;

        for ($i = 1; $i <= $level->getBlocksInGroup(1, $errorCorrection); $i++) {
            $groups['GROUP_1']['BLOCK_' . $i] = [];
            for ($j = 1; $j <= $level->getBlocksSizeInGroup(1, $errorCorrection); $j++) {
                $codeword =  bindec($dataCodewords[$counter]);
                array_push($groups['GROUP_1']['BLOCK_' . $i], $codeword);
                $counter++;
            }
        }
        for ($i = 1; $i <= $level->getBlocksInGroup(2, $errorCorrection); $i++) {
            $groups['GROUP_2']['BLOCK_' . $i] = [];
            for ($j = 1; $j <= $level->getBlocksSizeInGroup(2, $errorCorrection); $j++) {
                $codeword =  bindec($dataCodewords[$counter]);
                array_push($groups['GROUP_2']['BLOCK_' . $i], $codeword);
                $counter++;
            }
        }

        return $groups;
    }

    private static function calcErrorCodewords($groups, Level $level, ErrorCorrection $errorCorrection)
    {
        $errorCorrectionCodewordsForBlock = $level->getErrorCorrectionCodewordsForBlock($errorCorrection);

        for ($i = 1; $i <= $level->getBlocksInGroup(1, $errorCorrection); $i++) {
            $block = $groups['GROUP_1']['BLOCK_' . $i];
            $groups['GROUP_1']['BLOCK_' . $i . "_EC"] = QRCode::calcErrorCodewordsInBlock($block, $errorCorrectionCodewordsForBlock);
        }
        for ($i = 1; $i <= $level->getBlocksInGroup(2, $errorCorrection); $i++) {
            $block = $groups['GROUP_1']['BLOCK_' . $i];
            $groups['GROUP_2']['BLOCK_' . $i . "_EC"] = QRCode::calcErrorCodewordsInBlock($block, $errorCorrectionCodewordsForBlock);
        }
        return $groups;
    }

    private static function calcErrorCodewordsInBlock($blockCodewords, $errorCorrectionCodewordsInBlock)
    {
        return PolynomialDivision::calc($blockCodewords, $errorCorrectionCodewordsInBlock);
    }

    private static function interleavedCodeword($dataCodewords, Level $level, ErrorCorrection $errorCorrection)
    {
        $groups = [
            'BLOCK' => [],
            'EC' => []
        ];

        for ($i = 1; $i <= $level->getBlocksInGroup(1, $errorCorrection); $i++) {
            array_push($groups['BLOCK'], $dataCodewords['GROUP_1']['BLOCK_' . $i]);
            array_push($groups['EC'], $dataCodewords['GROUP_1']['BLOCK_' . $i . '_EC']);
        }
        for ($i = 1; $i <= $level->getBlocksInGroup(2, $errorCorrection); $i++) {
            array_push($groups['BLOCK'], $dataCodewords['GROUP_2']['BLOCK_' . $i]);
            array_push($groups['EC'], $dataCodewords['GROUP_2']['BLOCK_' . $i . '_EC']);
        }

        $data = [];

        $col = 0;
        $block = 0;
        $maxBlock = sizeof($groups['BLOCK']);

        $dc = $level->getTotalDataCodewords($errorCorrection);

        for ($i = 0; $i < $dc; $i++) {
            if (isset($groups['BLOCK'][$block][$col])) {
                array_push(
                    $data,
                    $groups['BLOCK'][$block][$col]
                );
            } else {
                $i--;
            }

            $block++;

            if ($block == $maxBlock) {
                $block = 0;
                $col++;
            }
        }

        $col = 0;
        $block = 0;
        $maxBlock = sizeof($groups['EC']);

        $ecc = $level->getTotalErrorCorrectionCodewords($errorCorrection);

        for ($i = 0; $i < $ecc; $i++) {
            if (isset($groups['EC'][$block][$col])) {
                array_push(
                    $data,
                    $groups['EC'][$block][$col]
                );
            } else {
                $i--;
            }

            $block++;

            if ($block == $maxBlock) {
                $block = 0;
                $col++;
            }
        }

        return $data;
    }
}
