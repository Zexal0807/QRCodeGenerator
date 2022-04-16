<?php
require_once(dirname(__FILE__) . './matrix/Matrix.php');

class MaskerMaker
{
    public static function generate(ErrorCorrection $errorCorrection, Matrix $matrix)
    {
        $matrixs = [];
        $penalty = [0, 0, 0, 0, 0, 0, 0, 0];

        for ($i = 0; $i < 8; $i++) {
            $matrixs[$i] = MaskerMaker::generateMatrix($i, $errorCorrection, $matrix);
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

    private static function generateMatrix($mask, ErrorCorrection $errorCorrection, Matrix $data)
    {
        $matrix = new Matrix($data->getSize());
        for ($y = 0; $y < $data->getSize(); $y++) {
            for ($x = 0; $x < $data->getSize(); $x++) {
                if ($data->getCell($y, $x)->isDataCell()) {
                    $matrix->getCell($y, $x)->setBit(MaskerMaker::{"mask" . $mask}($y, $x, $data->getCell($y, $x)));
                } else {
                    $matrix->getCell($y, $x)->setBit($data->getCell($y, $x)->getBit());
                }
            }
        }

        $informationBit = $errorCorrection->getInformationBitOfMask($mask);
        $mx = $data->getSize() - 1;

        // Set information bits
        $matrix->setCell(8, 0, "I" . $informationBit[0]);
        $matrix->setCell(8, 1, "I" . $informationBit[1]);
        $matrix->setCell(8, 2, "I" . $informationBit[2]);
        $matrix->setCell(8, 3, "I" . $informationBit[3]);
        $matrix->setCell(8, 4, "I" . $informationBit[4]);
        $matrix->setCell(8, 5, "I" . $informationBit[5]);
        $matrix->setCell(8, 7, "I" . $informationBit[6]);
        $matrix->setCell(8, 8, "I" . $informationBit[7]);
        $matrix->setCell(7, 8, "I" . $informationBit[8]);
        $matrix->setCell(5, 8, "I" . $informationBit[9]);
        $matrix->setCell(4, 8, "I" . $informationBit[10]);
        $matrix->setCell(3, 8, "I" . $informationBit[11]);
        $matrix->setCell(2, 8, "I" . $informationBit[12]);
        $matrix->setCell(1, 8, "I" . $informationBit[13]);
        $matrix->setCell(0, 8, "I" . $informationBit[14]);

        $matrix->setCell($mx, 8, "I" . $informationBit[0]);
        $matrix->setCell($mx - 1, 8, "I" . $informationBit[1]);
        $matrix->setCell($mx - 2, 8, "I" . $informationBit[2]);
        $matrix->setCell($mx - 3, 8, "I" . $informationBit[3]);
        $matrix->setCell($mx - 4, 8, "I" . $informationBit[4]);
        $matrix->setCell($mx - 5, 8, "I" . $informationBit[5]);
        $matrix->setCell($mx - 6, 8, "I" . $informationBit[6]);
        $matrix->setCell(8, $mx - 7, "I" . $informationBit[7]);
        $matrix->setCell(8, $mx - 6, "I" . $informationBit[8]);
        $matrix->setCell(8, $mx - 5, "I" . $informationBit[9]);
        $matrix->setCell(8, $mx - 4, "I" . $informationBit[10]);
        $matrix->setCell(8, $mx - 3, "I" . $informationBit[11]);
        $matrix->setCell(8, $mx - 2, "I" . $informationBit[12]);
        $matrix->setCell(8, $mx - 1, "I" . $informationBit[13]);
        $matrix->setCell(8, $mx, "I" . $informationBit[14]);

        return $matrix;
    }

    private static function mask0($row, $col, Cell $cell)
    {
        if (($row + $col) % 2 == 0) {
            return $cell->getBit() == 0 ? 1 : 0;
        }
        return $cell->getBit();
    }

    private static function mask1($row, $col, Cell $cell)
    {
        if ($row  % 2 == 0) {
            return $cell->getBit() == 0 ? 1 : 0;
        }
        return $cell->getBit();
    }

    private static function mask2($row, $col, Cell $cell)
    {
        if ($col  % 3 == 0) {
            return $cell->getBit() == 0 ? 1 : 0;
        }
        return $cell->getBit();
    }

    private static function mask3($row, $col, Cell $cell)
    {
        if (($row + $col) % 3 == 0) {
            return $cell->getBit() == 0 ? 1 : 0;
        }
        return $cell->getBit();
    }

    private static function mask4($row, $col, Cell $cell)
    {
        if ((floor($row / 2) + floor($col / 3)) % 2 ==  0) {
            return $cell->getBit() == 0 ? 1 : 0;
        }
        return $cell->getBit();
    }

    private static function mask5($row, $col, Cell $cell)
    {
        if ((($row * $col) % 2) + (($row * $col) % 3) == 0) {
            return $cell->getBit() == 0 ? 1 : 0;
        }
        return $cell->getBit();
    }

    private static function mask6($row, $col, Cell $cell)
    {
        if (((($row * $col) % 2) + (($row * $col) % 3)) % 2 == 0) {
            return $cell->getBit() == 0 ? 1 : 0;
        }
        return $cell->getBit();
    }

    private static function mask7($row, $col, Cell $cell)
    {
        if (((($row + $col) % 2) + (($row * $col) % 3)) % 2 == 0) {
            return $cell->getBit() == 0 ? 1 : 0;
        }
        return $cell->getBit();
    }

    private static function calcPenalty(Matrix $matrix)
    {
        $penalty = 0;

        //penalty for each group of five or more same-colored modules in a row (or column)
        $counter = 1;
        $color = NULL;
        for ($y = 0; $y < $matrix->getSize(); $y++) {
            $counter = 1;
            $color = NULL;
            for ($x = 0; $x < $matrix->getSize(); $x++) {
                $value = $matrix->getCell($y, $x)->getColor();
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
        for ($x = 0; $x < $matrix->getSize(); $x++) {
            $counter = 1;
            $color = NULL;
            for ($y = 0; $y < $matrix->getSize(); $y++) {
                $value = $matrix->getCell($y, $x)->getColor();
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
        for ($y = 0; $y < $matrix->getSize() - 1; $y++) {
            for ($x = 0; $x < $matrix->getSize() - 1; $x++) {
                $nw = $matrix->getCell($y, $x)->getColor();
                $ne = $matrix->getCell($y, $x + 1)->getColor();
                $sw = $matrix->getCell($y + 1, $x)->getColor();
                $se = $matrix->getCell($y + 1, $x + 1)->getColor();

                if ($nw == $ne && $nw == $sw && $nw == $se) {
                    $penalty += 3;
                }
            }
        }

        // large penalty if there are patterns that look similar to the finder patterns
        $pattern = ["BLACK", "WHITE", "BLACK", "BLACK", "BLACK", "WHITE", "BLACK", "WHITE", "WHITE", "WHITE", "WHITE"];

        for ($y = 0; $y < $matrix->getSize() - sizeof($pattern); $y++) {
            for ($x = 0; $x < $matrix->getSize() - sizeof($pattern); $x++) {
                $find = true;
                for ($k = 0; $k < sizeof($pattern) && $find; $k++) {
                    if ($matrix->getCell($y, $x)->getColor() != $pattern[$k]) {
                        $find = false;
                    }
                }
                if ($find) {
                    $penalty += 40;
                }
            }
        }

        for ($y = 0; $y < $matrix->getSize() - sizeof($pattern); $y++) {
            for ($x = 0; $x < $matrix->getSize() - sizeof($pattern); $x++) {
                $find = true;
                for ($k = 0; $k < sizeof($pattern) && $find; $k++) {
                    if ($matrix->getCell($x, $y)->getColor() != $pattern[$k]) {
                        $find = false;
                    }
                }
                if ($find) {
                    $penalty += 40;
                }
            }
        }

        $pattern = ["WHITE", "WHITE", "WHITE", "WHITE", "BLACK", "WHITE", "BLACK", "BLACK", "BLACK", "WHITE", "BLACK"];
        for ($y = 0; $y < $matrix->getSize() - sizeof($pattern); $y++) {
            for ($x = 0; $x < $matrix->getSize() - sizeof($pattern); $x++) {
                $find = true;
                for ($k = 0; $k < sizeof($pattern) && $find; $k++) {
                    if ($matrix->getCell($y, $x)->getColor() != $pattern[$k]) {
                        $find = false;
                    }
                }
                if ($find) {
                    $penalty += 40;
                }
            }
        }

        for ($y = 0; $y < $matrix->getSize() - sizeof($pattern); $y++) {
            for ($x = 0; $x < $matrix->getSize() - sizeof($pattern); $x++) {
                $find = true;
                for ($k = 0; $k < sizeof($pattern) && $find; $k++) {
                    if ($matrix->getCell($x, $y)->getColor() != $pattern[$k]) {
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
        for ($y = 0; $y < $matrix->getSize() - sizeof($pattern); $y++) {
            for ($x = 0; $x < $matrix->getSize() - sizeof($pattern); $x++) {
                if ($matrix->getCell($x, $y)->getColor() == "WHITE") {
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
}
