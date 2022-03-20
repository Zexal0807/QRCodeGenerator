<?php
class Level
{

    private $level;
    private $width;
    private $height;
    private $capacity;

    public function __construct($level, $width, $height, $capacity)
    {
        $this->level = $level;
        $this->width = $width;
        $this->height = $height;
        $this->capacity = $capacity;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getUpperLimit(Encoding $encoding, ErrorCorrection $errorCorrection)
    {
        return $this->capacity[$encoding->getEncoding()][$errorCorrection->getCorrection()];
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
