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

    static $CORRECTION_L;
    static $CORRECTION_M;
    static $CORRECTION_Q;
    static $CORRECTION_H;
}
