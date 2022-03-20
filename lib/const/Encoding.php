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

    static $ENCODING_NUMERIC;
    static $ENCODING_ALPHANUMERIC;
    static $ENCODING_BYTE;
    static $ENCODING_KANJI;

    static function init()
    {
        Encoding::$ENCODING_NUMERIC = new Encoding('ENCODING_NUMERIC', '0001');
        Encoding::$ENCODING_ALPHANUMERIC = new Encoding('ENCODING_ALPHANUMERIC', '0010');
        Encoding::$ENCODING_BYTE = new Encoding('ENCODING_BYTE', '0100');
        Encoding::$ENCODING_KANJI = new Encoding('ENCODING_KANJI', '1000');
    }
}
Encoding::init();
