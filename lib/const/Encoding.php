<?php
class Encoding
{
    private $encoding;
    private $limit;
    private $inidicator;

    public function __construct($encoding, $limit, $inidicator)
    {
        $this->encoding = $encoding;
        $this->limit = $limit;
        $this->inidicator = $inidicator;
    }

    static $ENCODING_NUMERIC;
    static $ENCODING_ALPHANUMERIC;
    static $ENCODING_BYTE;
    static $ENCODING_KANJI;

    static function init()
    {
        Encoding::$ENCODING_NUMERIC = new Encoding('ENCODING_NUMERIC', 7089, '0001');
        Encoding::$ENCODING_ALPHANUMERIC = new Encoding('ENCODING_ALPHANUMERIC', 4296, '0010');
        Encoding::$ENCODING_BYTE = new Encoding('ENCODING_BYTE', 2953, '0100');
        Encoding::$ENCODING_KANJI = new Encoding('ENCODING_KANJI', 1817, '1000');
    }
}
Encoding::init();
