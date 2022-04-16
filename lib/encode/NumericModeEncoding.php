<?php
require_once(dirname(__FILE__) . './Encoding.php');

class NumericModeEncoding extends Encoding
{
    public function encode($data)
    {
        $data = "" . $data;
        $breakData = str_split($data, 3);

        for ($i = 0; $i < sizeof($breakData); $i++) {
            $breakData[$i] = $this->decToBin($breakData[$i]);
        }

        return implode("", $breakData);
    }

    private function decToBin($dec)
    {
        switch (strlen($dec)) {
            case 1:
                return sprintf("%04b", $dec);
            case 2:
                return sprintf("%07b", $dec);
            case 3:
            default:
                return sprintf("%010b", $dec);
        }
    }
}
