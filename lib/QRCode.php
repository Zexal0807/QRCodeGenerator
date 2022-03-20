<?php
require_once('./lib/loadData.php');

class QRCode
{

    static function generate($data, Level $level, ErrorCorrection $errorCorrection)
    {
    }

    static function  findBestLevel($data, Encoding $encoding, ErrorCorrection $errorCorrection)
    {
        $need = strlen($data);
        for ($i = 1; $i <= 40; $i++) {
            $level = Level::${"LEVEL_" . $i};
            if ($level->getUpperLimit($encoding, $errorCorrection) > $need) {
                return $level;
            }
        }
        throw new Exception("to much data");
    }
}
