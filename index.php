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

// TODO: Add different type of content
/*
    url (link o altri) : "https://www.youtube.com/watch?v=3BhdrSP4v68"
    email: "mailto:test@gmail.com?subject=Hi&body=Hello"
    phone number : "tel:3333333333333"
    SMS : "SMSTO:3333333333333:Hi"
    position : "https://maps.google.com/local?q=51.049259,13.73836"
    WIFIPSW : "WIFI:S:name;T:WPA;P:password;;"
              "WIFI:S:name;T:nopass;P:password;;"
              "WIFI:S:name;T:WEP;P:password;;"
    EVENT : "BEGIN:VEVENT\nSUMMARY:sddasdas\nLOCATION:asdasd\nDTSTART:20220416T191400\nDTEND:20220416T191400\nEND:VEVENT\n"
*/

$data = "tel:3333333333";

$level = Level::$LEVEL_1;
$encoding = Encoding::$ENCODING_BYTE;
$errorCorrection = ErrorCorrection::$CORRECTION_M;

//$level =  QRCode::findBestLevel($data, $encoding, $errorCorrection);

$matrix = QRCode::create($data, $errorCorrection);

echo $matrix->print();
