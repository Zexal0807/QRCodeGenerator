<?php
class Level
{

    private $level;
    private $width;
    private $height;

    public function __construct($level, $width, $height)
    {
        $this->level = $level;
        $this->width = $width;
        $this->height = $height;
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

    static function init()
    {
        Level::$LEVEL_1 = new Level('LEVEL_1', 21, 21);
        Level::$LEVEL_2 = new Level('LEVEL_2', 25, 25);
        Level::$LEVEL_3 = new Level('LEVEL_3', 29, 29);
        Level::$LEVEL_4 = new Level('LEVEL_4', 33, 33);
        Level::$LEVEL_5 = new Level('LEVEL_5', 37, 37);
        Level::$LEVEL_6 = new Level('LEVEL_6', 41, 41);
        Level::$LEVEL_7 = new Level('LEVEL_7', 45, 45);
        Level::$LEVEL_8 = new Level('LEVEL_8', 49, 49);
        Level::$LEVEL_9 = new Level('LEVEL_9', 53, 53);
        Level::$LEVEL_10 = new Level('LEVEL_10', 57, 57);
        Level::$LEVEL_11 = new Level('LEVEL_11', 61, 61);
        Level::$LEVEL_12 = new Level('LEVEL_12', 65, 65);
        Level::$LEVEL_13 = new Level('LEVEL_13', 69, 69);
        Level::$LEVEL_14 = new Level('LEVEL_14', 73, 73);
        Level::$LEVEL_15 = new Level('LEVEL_15', 77, 77);
        Level::$LEVEL_16 = new Level('LEVEL_16', 81, 81);
        Level::$LEVEL_17 = new Level('LEVEL_17', 85, 85);
        Level::$LEVEL_18 = new Level('LEVEL_18', 89, 89);
        Level::$LEVEL_19 = new Level('LEVEL_19', 93, 93);
        Level::$LEVEL_20 = new Level('LEVEL_20', 97, 97);
        Level::$LEVEL_21 = new Level('LEVEL_21', 101, 101);
        Level::$LEVEL_22 = new Level('LEVEL_22', 105, 105);
        Level::$LEVEL_23 = new Level('LEVEL_23', 109, 109);
        Level::$LEVEL_24 = new Level('LEVEL_24', 113, 113);
        Level::$LEVEL_25 = new Level('LEVEL_25', 117, 117);
        Level::$LEVEL_26 = new Level('LEVEL_26', 121, 121);
        Level::$LEVEL_27 = new Level('LEVEL_27', 125, 125);
        Level::$LEVEL_28 = new Level('LEVEL_28', 129, 129);
        Level::$LEVEL_29 = new Level('LEVEL_29', 133, 133);
        Level::$LEVEL_30 = new Level('LEVEL_30', 137, 137);
        Level::$LEVEL_31 = new Level('LEVEL_31', 141, 141);
        Level::$LEVEL_32 = new Level('LEVEL_32', 145, 145);
        Level::$LEVEL_33 = new Level('LEVEL_33', 149, 149);
        Level::$LEVEL_34 = new Level('LEVEL_34', 153, 153);
        Level::$LEVEL_35 = new Level('LEVEL_35', 157, 157);
        Level::$LEVEL_36 = new Level('LEVEL_36', 161, 161);
        Level::$LEVEL_37 = new Level('LEVEL_37', 165, 165);
        Level::$LEVEL_38 = new Level('LEVEL_38', 169, 169);
        Level::$LEVEL_39 = new Level('LEVEL_39', 173, 173);
        Level::$LEVEL_40 = new Level('LEVEL_40', 177, 177);
    }
}
Level::init();
