<?php
require_once('./lib/loadData.php');
require_once('./lib/PolynomialDivision.php');
require_once('./lib/MatrixManager.php');
require_once('./lib/MaskerMaker.php');

class QRCode
{

    static function generate($data, Level $level,  Encoding $encoding, ErrorCorrection $errorCorrection)
    {
        $dataCodewords = QRCode::encode($data, $level,  $encoding, $errorCorrection);


        $dataCodewords = QRCode::splitCodewords($dataCodewords, $level,  $encoding, $errorCorrection);


        //TODO: DUCK è giusto ma sono invertiti - FUCK
        $dataCodewords = [
            'GROUP_1' => [
                'BLOCK_1' => [
                    32, 91, 11, 120, 209, 114, 220, 77, 67, 64, 236, 17, 236
                ]
            ],
            'GROUP_2' => [
                'BLOCK_1' => [],
                'BLOCK_2' => []
            ]
        ];

        $dataCodewords = QRCode::calcErrorCodewords($dataCodewords, $level,  $errorCorrection);

        d_var_dump($dataCodewords);

        $data = QRCode::interleavedCodeword($dataCodewords, $level, $errorCorrection);

        $data = array_map(function ($el) {
            return sprintf("%08b", $el);
        }, $data);
        $data = implode("", $data);
        $data = $data . str_repeat("0", $level->getRemainderBits());

        $matrix = new MatrixManager($level);
        $matrix->setData($data);
        $matrix = $matrix->getMatrix();

        $matrixs = MaskerMaker::generate($errorCorrection, $matrix);
        return $matrixs;
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

    private static function calcErrorCodewords($groups, Level $level, ErrorCorrection $errorCorrection)
    {
        for ($i = 1; $i <= $level->getBlocksInGroup(1, $errorCorrection); $i++) {
            $groups['GROUP_1']['BLOCK_' . $i . "_EC"] = QRCode::calcErrorCodewordsInBlock($groups['GROUP_1']['BLOCK_' . $i], $level->getErrorCorrectionCodewordsForBlock($errorCorrection));
        }
        for ($i = 1; $i <= $level->getBlocksInGroup(2, $errorCorrection); $i++) {
            $groups['GROUP_2']['BLOCK_' . $i . "_EC"] = QRCode::calcErrorCodewordsInBlock($groups['GROUP_2']['BLOCK_' . $i], $level->getErrorCorrectionCodewordsForBlock($errorCorrection));
        }
        return $groups;
    }

    private static function calcErrorCodewordsInBlock($blockCodewords, $errorCorrectionCodewordsInBlock)
    {
        return PolynomialDivision::calc($blockCodewords, $errorCorrectionCodewordsInBlock);
    }

    private static function splitCodewords($dataCodewords, Level $level,  Encoding $encoding, ErrorCorrection $errorCorrection)
    {
        $groups = [
            "GROUP_1" => [
                "BLOCK_1" => []
            ],
            "GROUP_2" => []
        ];

        for ($i = 1; $i <= $level->getBlocksInGroup(1, $errorCorrection); $i++) {
            $groups['GROUP_1']['BLOCK_' . $i] = [];
            for ($j = 1; $j <= $level->getBlocksSizeInGroup(1, $errorCorrection); $j++) {
                array_push($groups['GROUP_1']['BLOCK_' . $i], bindec(array_pop($dataCodewords)));
            }
        }
        for ($i = 1; $i <= $level->getBlocksInGroup(2, $errorCorrection); $i++) {
            $groups['GROUP_2']['BLOCK_' . $i] = [];
            for ($j = 1; $j <= $level->getBlocksSizeInGroup(2, $errorCorrection); $j++) {
                array_push($groups['GROUP_1']['BLOCK_' . $i], bindec(array_pop($dataCodewords)));
            }
        }

        return $groups;
    }

    static function encode($data, Level $level,  Encoding $encoding, ErrorCorrection $errorCorrection)
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
        $bitString = $bitString . "" . str_repeat("0", 8 - strlen($bitString) % 8);
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

    static function  findBestLevel($data, Encoding $encoding, ErrorCorrection $errorCorrection)
    {
        $need = strlen($data);
        for ($i = 1; $i <= 40; $i++) {
            $level = Level::${"LEVEL_" . $i};
            if ($level->getCapacity($encoding, $errorCorrection) > $need) {
                return $level;
            }
        }
        throw new Exception("to much data");
    }
}
