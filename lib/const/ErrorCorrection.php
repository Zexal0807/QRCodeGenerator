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

    static $CORRECTION_L;
    static $CORRECTION_M;
    static $CORRECTION_Q;
    static $CORRECTION_H;

    static function init()
    {
        ErrorCorrection::$CORRECTION_L = new ErrorCorrection('CORRECTION_L', 0.07);
        ErrorCorrection::$CORRECTION_M = new ErrorCorrection('CORRECTION_M', 0.15);
        ErrorCorrection::$CORRECTION_Q = new ErrorCorrection('CORRECTION_Q', 0.25);
        ErrorCorrection::$CORRECTION_H = new ErrorCorrection('CORRECTION_H', 0.30);
    }
}
ErrorCorrection::init();
