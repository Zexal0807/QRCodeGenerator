<?php
require_once('./lib/const/Encoding.php');

class ByteModeEncoding extends Encoding
{
    public function encode($data)
    {
        $data = utf8_encode($data);

        // TODO: implementare
        return $data;
    }
}
