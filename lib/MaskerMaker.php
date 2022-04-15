<?php

class MaskerMaker
{
    public static function generate(ErrorCorrection $errorCorrection, $data)
    {
        $matrixs = [];
        for ($i = 0; $i < 8; $i++) {
            $matrixs[$i] = MaskerMaker::generateMatrix($i, $errorCorrection, $data);
        }
        //$matrixs[8] = $data;

        $penalty = [0, 0, 0, 0, 0, 0, 0, 0];

        for ($i = 0; $i < 8; $i++) {
            $penalty[$i] = MaskerMaker::calcPenalty($matrixs[$i]);
        }
        $min = 0;
        for ($i = 1; $i < 8; $i++) {
            if ($penalty[$i] < $penalty[$min]) {
                $min = $i;
            }
        }

        return $matrixs[$min];
    }

    private static function color($cell)
    {
        if ($cell == "D")
            return "1";
        if (strlen($cell) == 1)
            return $cell;
        return substr($cell, -1);
    }

    private static function calcPenalty($matrix)
    {
        $penalty = 0;

        //penalty for each group of five or more same-colored modules in a row (or column)
        $counter = 1;
        $color = NULL;
        for ($x = 0; $x < sizeof($matrix); $x++) {
            $counter = 1;
            $color = NULL;
            for ($y = 0; $y < sizeof($matrix); $y++) {
                $value = MaskerMaker::color($matrix[$x][$y]);
                if ($color == $value) {
                    $counter++;
                } else {
                    if ($counter >= 5) {
                        $penalty += $counter - 5 + 3;
                    }
                    $counter = 1;
                    $color = $value;
                }
            }
            if ($counter >= 5) {
                $penalty += $counter - 5 + 3;
            }
        }

        $counter = 1;
        $color = NULL;
        for ($x = 0; $x < sizeof($matrix); $x++) {
            $counter = 1;
            $color = NULL;
            for ($y = 0; $y < sizeof($matrix); $y++) {
                $value = MaskerMaker::color($matrix[$y][$x]);
                if ($color == $value) {
                    $counter++;
                } else {
                    if ($counter >= 5) {
                        $penalty += $counter - 5 + 3;
                    }
                    $counter = 1;
                    $color = $value;
                }
            }
            if ($counter >= 5) {
                $penalty += $counter - 5 + 3;
            }
        }


        //penalty for each 2x2 area of same-colored modules in the matrix
        for ($x = 0; $x < sizeof($matrix) - 1; $x++) {
            for ($y = 0; $y < sizeof($matrix) - 1; $y++) {
                $nw = MaskerMaker::color($matrix[$x][$y]);
                $ne = MaskerMaker::color($matrix[$x + 1][$y]);
                $sw = MaskerMaker::color($matrix[$x][$y + 1]);
                $se = MaskerMaker::color($matrix[$x + 1][$y + 1]);

                if ($nw == $ne && $nw == $sw && $nw == $se) {
                    $penalty += 3;
                }
            }
        }


        // large penalty if there are patterns that look similar to the finder patterns
        $pattern = ["1", "0", "1", "1", "1", "0", "1", "0", "0", "0", "0"];
        for ($x = 0; $x < sizeof($matrix) - sizeof($pattern); $x++) {
            for ($y = 0; $y < sizeof($matrix) - sizeof($pattern); $y++) {
                $find = true;
                for ($k = 0; $k < sizeof($pattern) && $find; $k++) {
                    if (MaskerMaker::color($matrix[$x][$y]) != $pattern[$k]) {
                        $find = false;
                    }
                }
                if ($find) {
                    $penalty += 40;
                }
            }
        }
        for ($x = 0; $x < sizeof($matrix) - sizeof($pattern); $x++) {
            for ($y = 0; $y < sizeof($matrix) - sizeof($pattern); $y++) {
                $find = true;
                for ($k = 0; $k < sizeof($pattern) && $find; $k++) {
                    if (MaskerMaker::color($matrix[$y][$x]) != $pattern[$k]) {
                        $find = false;
                    }
                }
                if ($find) {
                    $penalty += 40;
                }
            }
        }

        $pattern = ["0", "0", "0", "0", "1", "0", "1", "1", "1", "0", "1"];
        for ($x = 0; $x < sizeof($matrix) - sizeof($pattern); $x++) {
            for ($y = 0; $y < sizeof($matrix) - sizeof($pattern); $y++) {
                $find = true;
                for ($k = 0; $k < sizeof($pattern) && $find; $k++) {
                    if (MaskerMaker::color($matrix[$x][$y]) != $pattern[$k]) {
                        $find = false;
                    }
                }
                if ($find) {
                    $penalty += 40;
                }
            }
        }
        for ($x = 0; $x < sizeof($matrix) - sizeof($pattern); $x++) {
            for ($y = 0; $y < sizeof($matrix) - sizeof($pattern); $y++) {
                $find = true;
                for ($k = 0; $k < sizeof($pattern) && $find; $k++) {
                    if (MaskerMaker::color($matrix[$y][$x]) != $pattern[$k]) {
                        $find = false;
                    }
                }
                if ($find) {
                    $penalty += 40;
                }
            }
        }


        //penalty if more than half of the modules are dark or light, with a larger penalty for a larger difference
        $b = 0;
        $w = 0;
        for ($x = 0; $x < sizeof($matrix); $x++) {
            for ($y = 0; $y < sizeof($matrix); $y++) {
                if (MaskerMaker::color($matrix[$x][$y]) == "0") {
                    $w++;
                } else {
                    $b++;
                }
            }
        }

        $pe = $b / ($b + $w) * 100;

        $prev = intval($pe / 5) * 5;
        $next = intval($pe / 5 + 1) * 5;

        $penalty += min(abs($prev - 50) / 5, abs($next - 50) / 5) * 10;

        return $penalty;
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
