<head>
    <style>
        td[color="1"] {
            background-color: black;
        }

        td[color="0"] {
            background-color: white;
        }

        td {
            border: 1px solid black;
            border-collapse: collapse;
            background-color: #ff0000;
        }

        table {
            width: 500px;
            height: 500px;
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<?php

require_once('./d_var_dump.php');

require_once('./lib/QRCode.php');

$data = "HELLO WORLD";


$level = Level::$LEVEL_5;
$encoding = Encoding::$ENCODING_ALPHANUMERIC;
$errorCorrection = ErrorCorrection::$CORRECTION_Q;

//$level =  QRCode::findBestLevel($data, $encoding, $errorCorrection);

$matrix = QRCode::generate($data, $level, $encoding, $errorCorrection);
echo ($matrix->printMatrix());


//https://www.thonky.com/qr-code-tutorial/module-placement-matrix