<?php
require_once(dirname(__FILE__) . './Encoding.php');


class ByteModeEncoding extends Encoding
{
    public function encode($data)
    {
        $data = utf8_encode($data);

        // TODO: implementare
        return $data;
    }
}
