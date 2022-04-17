<?php
require_once(dirname(__FILE__) . './Encoding.php');

class ByteModeEncoding extends Encoding
{
    public function encode($data)
    {
        $data = utf8_encode($data);

        $data = str_split($data, 1);

        $data = array_map(function ($el) {
            return sprintf("%08b", ord($el));
        }, $data);

        return implode("", $data);
    }
}
