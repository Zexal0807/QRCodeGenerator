<?php
require_once(dirname(__FILE__) . './Cell.php');

class Matrix
{
    private $size;
    private $data;
    private $errorCorrectionValue;

    public function __construct($size, $errorCorrectionValue)
    {
        $this->size = $size;
        $this->errorCorrectionValue = $errorCorrectionValue;

        $this->data = [];
        for ($y = 0; $y < $size; $y++) {
            $this->data[$y] = [];
            for ($x = 0; $x < $size; $x++) {
                $this->data[$y][$x] = new Cell();
            }
        }
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setCell($y, $x, $value)
    {
        $this->data[$y][$x]->setData($value);
    }

    public function getCell($y, $x)
    {
        return $this->data[$y][$x];
    }

    public function print()
    {
        $size = $this->getSize();
        $logoSize = 5;

        $html = "<table>";
        for ($i = 0; $i < $size; $i++) {
            $html .= "<tr>";
            for ($j = 0; $j < $size; $j++) {
                if (
                    $j > ($size - $logoSize) / 2 - 1 &&
                    $j < ($size - $logoSize) / 2 + $logoSize  &&
                    $i > ($size - $logoSize) / 2 - 1 &&
                    $i < ($size - $logoSize) / 2 + $logoSize && false
                ) {
                    // TODO: Implement logo
                    $html .= '<td color="LOGO"></td>';
                } else {
                    $html .= '<td color="' . $this->data[$i][$j]->getColor() . '"></td>';
                }
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }

    public function save($filename)
    {
        // TODO: Implement save
    }
}
