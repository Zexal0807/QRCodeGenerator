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

    private $logo = false;
    private $logoFilepath = "";

    public function addLogo($filepath)
    {
        $this->logo = true;
        $this->logoFilepath = $filepath;
    }

    public function print()
    {
        $size = $this->getSize();
        $logoSize = 5;

        $area = $size * $size;
        $recoverArea = $area * $this->errorCorrectionValue;
        $recoverSize = sqrt($recoverArea);

        $logoSize = floor($recoverSize);
        if ($logoSize % 2 == 0) {
            $logoSize = $logoSize - 1;
        }
        $logoSize -= 2;

        $html = "<table>";
        for ($i = 0; $i < $size; $i++) {
            $html .= "<tr>";
            for ($j = 0; $j < $size; $j++) {
                if (
                    $j > ($size - $logoSize) / 2 - 1 &&
                    $j < ($size - $logoSize) / 2 + $logoSize  &&
                    $i > ($size - $logoSize) / 2 - 1 &&
                    $i < ($size - $logoSize) / 2 + $logoSize
                ) {
                    if ($this->logo) {
                        $html .= '<td color="LOGO" rowspan="' . $logoSize . '" colspan="' . $logoSize . '" style="background-image: url(' . $this->logoFilepath . ')"></td>';
                        $this->logo = false;
                    }
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
