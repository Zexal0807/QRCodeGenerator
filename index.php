<?php
require_once('./lib/QRCode.php');

$data = "Hello World";

$level = Level::$LEVEL_1;
$encoding = Encoding::$ENCODING_ALPHANUMERIC;
$errorCorrection = ErrorCorrection::$CORRECTION_L;


echo QRCode::getUpperLimit($level, $encoding, $errorCorrection);
