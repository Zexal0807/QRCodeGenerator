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
    // TODO: Add different type of content
    /*
        url (link o altri) : "https://www.youtube.com/watch?v=3BhdrSP4v68&ab_channel=ShevanFreeman"
        email: "mailto:gallinar00@gmail.com?subject=gallinar00@gmail.com&body=asasas"
        phone number : "tel:3312831040"
        SMS : "SMSTO:3312831040:yujjt"
        position : "https://maps.google.com/local?q=51.049259,13.73836"
        WIFIPSW : "WIFI:S:name;T:WPA;P:password;;"
                  "WIFI:S:name;T:nopass;P:password;;"
                  "WIFI:S:name;T:WEP;P:password;;"
        EVENT : "BEGIN:VEVENT\nSUMMARY:sddasdas\nLOCATION:asdasd\nDTSTART:20220416T191400\nDTEND:20220416T191400\nEND:VEVENT\n"

    */

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
