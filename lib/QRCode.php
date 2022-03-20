<?php

require_once('./lib/const/Level.php');
require_once('./lib/const/Encoding.php');
require_once('./lib/const/ErrorCorrection.php');

class QRCode
{

    static function generate($data, Level $level, ErrorCorrection $errorCorrection)
    {
    }

    static function findBestLevel($data, Encoding $encoding, ErrorCorrection $errorCorrection)
    {
    }

    static function getUpperLimit(Level $level, Encoding $encoding, ErrorCorrection $errorCorrection)
    {
    }
}
