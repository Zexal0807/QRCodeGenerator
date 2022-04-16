<head>
    <style>
        td[color="F1"],
        td[color="A1"],
        td[color="T1"],
        td[color="D"],
        td[color="R1"],
        td[color="1"],
        td[color="01"],
        td[color="S1"],
        td[color="BLACK"] {
            color: white;
            background-color: black;
        }

        td[color="F0"],
        td[color="A0"],
        td[color="T0"],
        td[color="R0"],
        td[color="0"],
        td[color="10"],
        td[color="S0"],
        td[color="WHITE"] {
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

        td[color="R"],
        td[color="RESERVED"] {
            background-color: blue;
        }

        td {
            /* border: 1px solid black; */
            border-collapse: collapse;
            background-color: #ff0000;
        }

        div {
            display: flex;
            flex-wrap: wrap;
        }

        table {
            width: 500;
            height: 500;
            margin: 15px;
            /* border: 1px solid black; */
            border-collapse: collapse;
        }
    </style>
</head>
<?php

require_once('./d_var_dump.php');

require_once('./lib/QRCode.php');

$data = "HELLO WORLD";


$level = Level::$LEVEL_1;
$encoding = Encoding::$ENCODING_ALPHANUMERIC;
$errorCorrection = ErrorCorrection::$CORRECTION_Q;

//$level =  QRCode::findBestLevel($data, $encoding, $errorCorrection);

$matrix = QRCode::generate($data, $level, $encoding, $errorCorrection);

//d_var_dump($matrix);

echo $matrix->print();
/*
function printMatrix($matrix)
{
    $logo = 5;
    $html = "<table>";
    for ($i = 0; $i < sizeof($matrix); $i++) {
        $html .= "<tr>";
        for ($j = 0; $j < sizeof($matrix); $j++) {
            if (
                $j > (sizeof($matrix) - $logo) / 2 - 1 &&
                $j < (sizeof($matrix) - $logo) / 2 + $logo  &&
                $i > (sizeof($matrix) - $logo) / 2 - 1 &&
                $i < (sizeof($matrix) - $logo) / 2 + $logo && false
            ) {
                $html .= '<td color="R"></td>';
            } else {
                $html .= '<td color="' . $matrix[$i][$j] . '">' . $matrix[$i][$j] . '</td>';
            }
        }
        $html .= "</tr>";
    }
    $html .= "</table>";
    return $html;
}
echo "<br><br><div>";
echo printMatrix($matrix);
*/

//https://www.thonky.com/qr-code-tutorial/module-placement-matrix