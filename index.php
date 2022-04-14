<head>
    <style>
        td[color="F1"],
        td[color="A1"],
        td[color="T1"],
        td[color="D"],
        td[color="R1"],
        td[color="1"],
        td[color="01"],
        td[color="S1"] {
            color: white;
            background-color: black;
        }

        td[color="F0"],
        td[color="A0"],
        td[color="T0"],
        td[color="R0"],
        td[color="0"],
        td[color="10"],
        td[color="S0"] {
            background-color: white;
        }

        td[color="I1"] {
            background-color: gray;
            background-color: black;
            color: white;
        }

        td[color="I0"] {
            background-color: #404040;
            background-color: white;
        }

        td[color="R"] {
            background-color: blue;
        }

        td {
            /* border: 1px solid black; */
            border-collapse: collapse;
            background-color: #ff0000;
        }

        div {
            display: flex;
        }

        table {
            width: 135;
            height: 135;
            margin: 15px;
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

$matrixs = QRCode::generate($data, $level, $encoding, $errorCorrection);

function printMatrix($matrix)
{
    $html = "<table>";
    for ($i = 0; $i < sizeof($matrix); $i++) {
        $html .= "<tr>";
        for ($j = 0; $j < sizeof($matrix); $j++) {
            $html .= '<td color="' . $matrix[$i][$j] . '"></td>';
        }
        $html .= "</tr>";
    }
    $html .= "</table>";
    return $html;
}
echo "<div>";
foreach ($matrixs as $m) {
    echo printMatrix($m);
}


//https://www.thonky.com/qr-code-tutorial/module-placement-matrix