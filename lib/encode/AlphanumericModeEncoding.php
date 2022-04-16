<?php
require_once(dirname(__FILE__) . './Encoding.php');

class AlphanumericModeEncoding extends Encoding
{

    static $table = [
        "0" => 0,
        "1" => 1,
        "2" => 2,
        "3" => 3,
        "4" => 4,
        "5" => 5,
        "6" => 6,
        "7" => 7,
        "8" => 8,
        "9" => 9,
        "A" => 10,
        "B" => 11,
        "C" => 12,
        "D" => 13,
        "E" => 14,
        "F" => 15,
        "G" => 16,
        "H" => 17,
        "I" => 18,
        "J" => 19,
        "K" => 20,
        "L" => 21,
        "M" => 22,
        "N" => 23,
        "O" => 24,
        "P" => 25,
        "Q" => 26,
        "R" => 27,
        "S" => 28,
        "T" => 29,
        "U" => 30,
        "V" => 31,
        "W" => 32,
        "X" => 33,
        "Y" => 34,
        "Z" => 35,
        " " => 36,
        "$" => 37,
        "%" => 38,
        "*" => 39,
        "+" => 40,
        "-" => 41,
        "." => 42,
        "/" => 43,
        ":" => 44
    ];

    public function encode($data)
    {
        $data = "" . $data;
        $breakData = str_split($data, 2);

        for ($i = 0; $i < sizeof($breakData); $i++) {
            $breakData[$i] = $this->stringToValue($breakData[$i]);
        }

        return implode("", $breakData);
    }
    private function stringToValue($str)
    {
        $breakData = str_split($str, 1);
        $breakData[0] = $this->charToValue($breakData[0]);
        if (isset($breakData[1])) {
            $breakData[1] = $this->charToValue($breakData[1]);
            $value = $breakData[0] * 45 + $breakData[1];
            return sprintf("%011b", $value);
        }
        return sprintf("%06b", $breakData[0]);
    }

    private function charToValue($char)
    {
        return AlphanumericModeEncoding::$table[$char];
    }
}
