<?php

class MaskerMaker
{
    public static function generate(ErrorCorrection $errorCorrection, $data)
    {
        $matrixs = [];
        for ($i = 0; $i < 8; $i++) {
            $matrixs[$i] = MaskerMaker::generateMatrix($i, $errorCorrection, $data);
        }
        $matrixs[8] = $data;
        return $matrixs;
    }

    private static function generateMatrix($mask, ErrorCorrection $errorCorrection, $data)
    {
        $matrix = [];
        for ($y = 0; $y < sizeof($data); $y++) {
            for ($x = 0; $x < sizeof($data); $x++) {
                if (in_array($data[$y][$x], ["0", "1"])) {
                    $matrix[$y][$x] = MaskerMaker::{"mask" . $mask}($y, $x, $data[$y][$x]);
                } else {
                    $matrix[$y][$x] = $data[$y][$x];
                }
            }
        }

        $informationBit = $errorCorrection->getInformationBitOfMask($mask);
        $mx = sizeof($data) - 1;
        //set 
        $matrix[8][0] = "I" . $informationBit[0];
        $matrix[8][1] = "I" . $informationBit[1];
        $matrix[8][2] = "I" . $informationBit[2];
        $matrix[8][3] = "I" . $informationBit[3];
        $matrix[8][4] = "I" . $informationBit[4];
        $matrix[8][5] = "I" . $informationBit[5];
        $matrix[8][7] = "I" . $informationBit[6];
        $matrix[8][8] = "I" . $informationBit[7];
        $matrix[7][8] = "I" . $informationBit[8];
        $matrix[5][8] = "I" . $informationBit[9];
        $matrix[4][8] = "I" . $informationBit[10];
        $matrix[3][8] = "I" . $informationBit[11];
        $matrix[2][8] = "I" . $informationBit[12];
        $matrix[1][8] = "I" . $informationBit[13];
        $matrix[0][8] = "I" . $informationBit[14];

        $matrix[$mx][8] = "I" . $informationBit[0];
        $matrix[$mx - 1][8] = "I" . $informationBit[1];
        $matrix[$mx - 2][8] = "I" . $informationBit[2];
        $matrix[$mx - 3][8] = "I" . $informationBit[3];
        $matrix[$mx - 4][8] = "I" . $informationBit[4];
        $matrix[$mx - 5][8] = "I" . $informationBit[5];
        $matrix[$mx - 6][8] = "I" . $informationBit[6];
        $matrix[8][$mx - 7] = "I" . $informationBit[7];
        $matrix[8][$mx - 6] = "I" . $informationBit[8];
        $matrix[8][$mx - 5] = "I" . $informationBit[9];
        $matrix[8][$mx - 4] = "I" . $informationBit[10];
        $matrix[8][$mx - 3] = "I" . $informationBit[11];
        $matrix[8][$mx - 2] = "I" . $informationBit[12];
        $matrix[8][$mx - 1] = "I" . $informationBit[13];
        $matrix[8][$mx] = "I" . $informationBit[14];


        return $matrix;
    }

    private static function mask0($row, $col, $value)
    {
        if (($row + $col) % 2 == 0) {
            return $value == "0" ? "01" : "10";
        }

        return $value;
    }
    private static function mask1($row, $col, $value)
    {
        if ($row  % 2 == 0) {
            return $value == "0" ? "01" : "10";
        }

        return $value;
    }
    private static function mask2($row, $col, $value)
    {
        if ($col  % 3 == 0) {
            return $value == "0" ? "01" : "10";
        }

        return $value;
    }
    private static function mask3($row, $col, $value)
    {
        if (($row + $col) % 3 == 0) {
            return $value == "0" ? "01" : "10";
        }

        return $value;
    }
    private static function mask4($row, $col, $value)
    {
        if ((floor($row / 2) + floor($col / 3)) % 2 ==  0) {
            return $value == "0" ? "01" : "10";
        }

        return $value;
    }
    private static function mask5($row, $col, $value)
    {
        if ((($row * $col) % 2) + (($row * $col) % 3) == 0) {
            return $value == "0" ? "01" : "10";
        }

        return $value;
    }
    private static function mask6($row, $col, $value)
    {
        if (((($row * $col) % 2) + (($row * $col) % 3)) % 2 == 0) {
            return $value == "0" ? "01" : "10";
        }

        return $value;
    }
    private static function mask7($row, $col, $value)
    {
        if (((($row + $col) % 2) + (($row * $col) % 3)) % 2 == 0) {
            return $value == "0" ? "01" : "10";
        }

        return $value;
    }
}
