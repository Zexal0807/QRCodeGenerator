<?php
require_once('./lib/loadData.php');

class QRCode
{

    static function generate($data, Level $level,  Encoding $encoding, ErrorCorrection $errorCorrection)
    {

        $modeIndicator = $encoding->getModeIndicator();
        $characterCountIndicatorLength = $level->getCharacterCountIndicatorLength($encoding);
        $characterCountIndicator = sprintf("%0" . $characterCountIndicatorLength . "b", strlen($data));

        $encodedData = $encoding->encode($data);

        $bitString = $modeIndicator . "" . $characterCountIndicator . "" . $encodedData;

        $requiredNumberBits = $level->getTotalDataCodewords($encoding) * 8;
        // Add Pad Bytes



        //$capacity = $level->getCapacity($encoding, $errorCorrection);
        //$bitString = $bitString . str_repeat("0", $capacity - strlen($bitString));

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
