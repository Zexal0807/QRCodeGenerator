<?php
require_once('./lib/const/Encoding.php');

class KanjiModeEncoding extends Encoding
{
    public function encode($data)
    {
        return $data;
    }
}
