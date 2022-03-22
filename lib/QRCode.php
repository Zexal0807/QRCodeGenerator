<?php
require_once('./lib/loadData.php');

class QRCode
{

    static function generate($data, Level $level,  Encoding $encoding, ErrorCorrection $errorCorrection)
    {
        $bitString = QRCode::encode($data, $level,  $encoding, $errorCorrection);
        return $bitString;
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

        return $bitString;
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
