<?php
class Level
{

    private $level;
    private $maxWidth;
    private $maxHeight;
    private $capacity;
    private $characterCountIndicatorLength;
    private $codewords;

    public function __construct($level, $maxWidth, $maxHeight, $capacity, $characterCountIndicatorLength, $codewords)
    {
        $this->level = $level;
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
        $this->capacity = $capacity;
        $this->characterCountIndicatorLength = $characterCountIndicatorLength;
        $this->codewords = $codewords;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getCapacity(Encoding $encoding, ErrorCorrection $errorCorrection)
    {
        return $this->capacity[$encoding->getEncoding()][$errorCorrection->getCorrection()];
    }

    public function getCharacterCountIndicatorLength(Encoding $encoding)
    {
        return $this->characterCountIndicatorLength[$encoding->getEncoding()];
    }

    public function getTotalDataCodewords(ErrorCorrection $errorCorrection)
    {
        $tmp = $this->codewords[$errorCorrection->getCorrection()];
        return $tmp['GROUP_1']['NUMBER_BLOCKS'] * $tmp['GROUP_1']['BLOCKS_CODEWORDS'] + $tmp['GROUP_2']['NUMBER_BLOCKS'] * $tmp['GROUP_2']['BLOCKS_CODEWORDS'];
    }

    static $LEVEL_1;
    static $LEVEL_2;
    static $LEVEL_3;
    static $LEVEL_4;
    static $LEVEL_5;
    static $LEVEL_6;
    static $LEVEL_7;
    static $LEVEL_8;
    static $LEVEL_9;
    static $LEVEL_10;
    static $LEVEL_11;
    static $LEVEL_12;
    static $LEVEL_13;
    static $LEVEL_14;
    static $LEVEL_15;
    static $LEVEL_16;
    static $LEVEL_17;
    static $LEVEL_18;
    static $LEVEL_19;
    static $LEVEL_20;
    static $LEVEL_21;
    static $LEVEL_22;
    static $LEVEL_23;
    static $LEVEL_24;
    static $LEVEL_25;
    static $LEVEL_26;
    static $LEVEL_27;
    static $LEVEL_28;
    static $LEVEL_29;
    static $LEVEL_30;
    static $LEVEL_31;
    static $LEVEL_32;
    static $LEVEL_33;
    static $LEVEL_34;
    static $LEVEL_35;
    static $LEVEL_36;
    static $LEVEL_37;
    static $LEVEL_38;
    static $LEVEL_39;
    static $LEVEL_40;
}
