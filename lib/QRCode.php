<?php
require_once('./lib/loadData.php');

class QRCode
{

    static function generate($data, Level $level,  Encoding $encoding, ErrorCorrection $errorCorrection)
    {
        $dataCodewords = QRCode::encode($data, $level,  $encoding, $errorCorrection);

        $dataCodewords = QRCode::splitCodewords($dataCodewords, $level,  $encoding, $errorCorrection);


        return $dataCodewords;
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
                array_push($groups['GROUP_1']['BLOCK_' . $i], array_pop($dataCodewords));
            }
        }
        for ($i = 1; $i < $level->getBlocksInGroup(2, $errorCorrection); $i++) {
            $groups['GROUP_2']['BLOCK_' . $i] = [];
            for ($j = 1; $j <= $level->getBlocksSizeInGroup(2, $errorCorrection); $j++) {
                array_push($groups['GROUP_1']['BLOCK_' . $i], array_pop($dataCodewords));
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
