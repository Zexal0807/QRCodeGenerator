<?php
require_once('./lib/QRCode.php');

$data = "HELLO WORLD";

$level = Level::$LEVEL_1;
$encoding = Encoding::$ENCODING_ALPHANUMERIC;
$errorCorrection = ErrorCorrection::$CORRECTION_Q;


//$level =  QRCode::findBestLevel($data, $encoding, $errorCorrection);

echo QRCode::generate($data, $level, $encoding, $errorCorrection);
echo "<br>";
echo "00100000 01011011 00001011 01111000 11010001 01110010 11011100 01001101 01000011 01000000 11101100 00010001 11101100";

//https://www.thonky.com/qr-code-tutorial/structure-final-message