<?php

require_once('./d_var_dump.php');

require_once('./lib/QRCode.php');

$data = "tel:3333333333";

$level = Level::$LEVEL_1;
$encoding = Encoding::$ENCODING_BYTE;
$errorCorrection = ErrorCorrection::$CORRECTION_M;

$matrix = QRCode::create($data, $errorCorrection);
$matrix->addLogo("doc/logo.png", 60);

echo $matrix->print(500);
