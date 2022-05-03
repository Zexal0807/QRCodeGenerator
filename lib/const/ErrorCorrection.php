<?php
class ErrorCorrection
{

    private $correction;
    private $value;

    public function __construct($correction, $value)
    {
        $this->correction = $correction;
        $this->value = $value;
    }

    public function getCorrection()
    {
        return $this->correction;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getInformationBitOfMask($mask)
    {
        return ErrorCorrection::$informationBit[$this->getCorrection()][$mask];
    }

    private static $informationBit = [
        "CORRECTION_L" => [
            0 => "111011111000100",
            1 => "111001011110011",
            2 => "111110110101010",
            3 => "111100010011101",
            4 => "110011000101111",
            5 => "110001100011000",
            6 => "110110001000001",
            7 => "110100101110110"
        ],
        "CORRECTION_M" => [
            0 => "101010000010010",
            1 => "101000100100101",
            2 => "101111001111100",
            3 => "101101101001011",
            4 => "100010111111001",
            5 => "100000011001110",
            6 => "100111110010111",
            7 => "100101010100000"
        ],
        "CORRECTION_Q" => [
            0 => "011010101011111",
            1 => "011000001101000",
            2 => "011111100110001",
            3 => "011101000000110",
            4 => "010010010110100",
            5 => "010000110000011",
            6 => "010111011011010",
            7 => "010101111101101"
        ],
        "CORRECTION_H" => [
            0 => "001011010001001",
            1 => "001001110111110",
            2 => "001110011100111",
            3 => "001100111010000",
            4 => "000011101100010",
            5 => "000001001010101",
            6 => "000110100001100",
            7 => "000100000111011"
        ]
    ];

    static $CORRECTION_L;
    static $CORRECTION_M;
    static $CORRECTION_Q;
    static $CORRECTION_H;
}
