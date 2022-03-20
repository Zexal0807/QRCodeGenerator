<?php
require_once('./lib/const/Encoding.php');

class NumericModeEncoding extends Encoding
{
    public function encode($data)
    {
        return $data;
    }
}
