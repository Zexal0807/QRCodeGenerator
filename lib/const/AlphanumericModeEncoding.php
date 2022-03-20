<?php
require_once('./lib/const/Encoding.php');

class AlphanumericModeEncoding extends Encoding
{
    public function encode($data)
    {
        return $data;
    }
}
