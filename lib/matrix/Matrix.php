<?php
require_once(dirname(__FILE__) . './Cell.php');

class Matrix
{
    private $size;
    private $data;

    public function __construct($size)
    {
        $this->size = $size;

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

    // TODO: Implement logo space using errorCorrection perc
    public function print()
    {
        $html = "<table>";
        for ($i = 0; $i < sizeof($this->data); $i++) {
            $html .= "<tr>";
            for ($j = 0; $j < sizeof($this->data); $j++) {
                $html .= '<td color="' . $this->data[$i][$j]->getColor() . '">' . substr($this->data[$i][$j]->getColor(), 0, 1) . '</td>';
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }
}
