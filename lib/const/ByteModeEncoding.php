<?php
require_once('./lib/const/Encoding.php');

class ByteModeEncoding extends Encoding
{
    public function encode($data)
    {
        return $data;
    }
}
