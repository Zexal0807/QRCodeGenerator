<?php
abstract class Encoding
{
    private $encoding;
    private $modeInidicator;

    public function __construct($encoding, $modeInidicator)
    {
        $this->encoding = $encoding;
        $this->modeInidicator = $modeInidicator;
    }
    public function getEncoding()
    {
        return $this->encoding;
    }

    public function getModeIndicator()
    {
        return $this->modeInidicator;
    }

    abstract public function encode($data);

    static $ENCODING_NUMERIC;
    static $ENCODING_ALPHANUMERIC;
    static $ENCODING_BYTE;
    static $ENCODING_KANJI;
}
