<?php
class Level
{
    private $level;
    private $version;
    private $size;
    private $capacity;
    private $characterCountIndicatorLength;
    private $codewords;
    private $errorCorrectionCodewordsForBlock;
    private $remainderBits;

    public function __construct($level, $size, $capacity, $characterCountIndicatorLength, $codewords, $errorCorrectionCodewordsForBlock, $remainderBits)
    {
        $this->level = $level;
        $this->version = intval(substr($level, 6));
        $this->size = $size;
        $this->capacity = $capacity;
        $this->characterCountIndicatorLength = $characterCountIndicatorLength;
        $this->codewords = $codewords;
        $this->errorCorrectionCodewordsForBlock = $errorCorrectionCodewordsForBlock;
        $this->remainderBits = $remainderBits;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getSize()
    {
        return $this->size;
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

    public function getBlocksInGroup($group, ErrorCorrection $errorCorrection)
    {
        return $this->codewords[$errorCorrection->getCorrection()]['GROUP_' . $group]['NUMBER_BLOCKS'];
    }

    public function getBlocksSizeInGroup($group, ErrorCorrection $errorCorrection)
    {
        return $this->codewords[$errorCorrection->getCorrection()]['GROUP_' . $group]['BLOCKS_CODEWORDS'];
    }

    public function getErrorCorrectionCodewordsForBlock(ErrorCorrection $errorCorrection)
    {

        return $this->errorCorrectionCodewordsForBlock[$errorCorrection->getCorrection()];
    }

    public function getTotalErrorCorrectionCodewords(ErrorCorrection $errorCorrection)
    {
        $tmp = $this->codewords[$errorCorrection->getCorrection()];
        $ecc = $this->getErrorCorrectionCodewordsForBlock($errorCorrection);
        return $tmp['GROUP_1']['NUMBER_BLOCKS'] * $ecc + $tmp['GROUP_2']['NUMBER_BLOCKS'] * $ecc;
    }

    public function getRemainderBits()
    {
        return $this->remainderBits;
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
