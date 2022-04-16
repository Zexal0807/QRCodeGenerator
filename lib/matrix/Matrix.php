<?php
require_once(dirname(__FILE__) . './Cell.php');

class Matrix
{
    private $data;

    public function __construct($size)
    {
        $this->data = [];
        for ($i = 0; $i < $size; $i++) {
            $this->data[$i] = [];
            for ($j = 0; $j < $size; $j++) {
                $this->data[$i][$j] = new Cell();
            }
        }
    }

    public function setCell($x, $y, $value)
    {
        $this->data[$x][$y]->setData($value);
    }

    public function getCell($x, $y)
    {
        return $this->data[$x][$y];
    }

    public function print()
    {
        $html = "<table>";
        for ($i = 0; $i < sizeof($this->data); $i++) {
            $html .= "<tr>";
            for ($j = 0; $j < sizeof($this->data); $j++) {
                $html .= '<td color="' . $this->data[$i][$j]->getColor() . '"></td>';
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }
}
