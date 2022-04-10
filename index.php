<head>
    <style>
        td[color="0"] {
            background-color: black;
        }

        td[color="1"] {
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


/*
echo "<br>";

echo "00100000 01011011 00001011 01111000 11010001 01110010 11011100 01001101 01000011 01000000 11101100 00010001 11101100";
*/


//https://www.thonky.com/qr-code-tutorial/structure-final-message