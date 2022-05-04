<head>
    <style>
        td[color="BLACK"] {
            color: white;
            background-color: black;
        }

        td[color="WHITE"] {
            background-color: white;
        }

        td[color="RESERVED"] {
            background-color: blue;
        }

        td[color="LOGO"] {
            background-image: url(doc/example.png);
            background-position: center;
            background-size: 90%;
            background-repeat: no-repeat;
        }

        td {
            border-collapse: collapse;
        }

        table {
            width: 500;
            height: 500;
            margin: 15px;
            border-collapse: collapse;
        }
    </style>
</head>
<?php

require_once('./d_var_dump.php');

require_once('./lib/QRCode.php');

$data = "tel:3333333333";

$level = Level::$LEVEL_1;
$encoding = Encoding::$ENCODING_BYTE;
$errorCorrection = ErrorCorrection::$CORRECTION_M;

//$level =  QRCode::findBestLevel($data, $encoding, $errorCorrection);

$matrix = QRCode::create($data, $errorCorrection);
$matrix->addLogo("doc/example.png");

echo $matrix->print();
