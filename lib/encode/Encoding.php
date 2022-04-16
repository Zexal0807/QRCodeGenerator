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

    protected function decToBin($dec, $bit = false)
    {
        if ($bit == false) {
            switch (strlen($dec)) {
                case 1:
                    return sprintf("%04b", $dec);
                case 2:
                    return sprintf("%07b", $dec);
                case 3:
                default:
                    return sprintf("%010b", $dec);
            }
        } else {
            return sprintf("%0" . $bit . "b", $dec);
        }
    }

    static $ENCODING_NUMERIC;
    static $ENCODING_ALPHANUMERIC;
    static $ENCODING_BYTE;
    static $ENCODING_KANJI;
}
