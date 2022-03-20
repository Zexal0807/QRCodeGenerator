<?php
class Encoding
{
    private $encoding;
    private $inidicator;

    public function __construct($encoding, $inidicator)
    {
        $this->encoding = $encoding;
        $this->inidicator = $inidicator;
    }
    public function getEncoding()
    {
        return $this->encoding;
    }

    static $ENCODING_NUMERIC;
    static $ENCODING_ALPHANUMERIC;
    static $ENCODING_BYTE;
    static $ENCODING_KANJI;
}
