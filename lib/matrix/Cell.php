<?php
class Cell
{
    private $type = NULL;

    private $bit = NULL;

    public function __construct()
    {
    }

    public function setData($data)
    {
        if ($data == "R") {
            $this->type = "RESERVED";
            $this->bit = NULL;
        } else if ($data == "D") {
            $this->type = "DARK";
            $this->bit = 1;
        } else if (strlen($data) == 1) {
            $this->type = NULL;
            $this->bit = intval($data);
        } else {
            $this->type = substr($data, 0, -1);
            if ($data[0] == "T") {
                $this->type  = "TIMING";
            }
            $this->bit = intval(substr($data, -1));
        }
    }

    public function getBit()
    {
        return $this->bit;
    }

    public function setBit($bit)
    {
        $this->bit = $bit;
    }

    public function getColor()
    {
        if (!$this->isSet()) {
            return $this->type;
        }

        return $this->bit == 0 ? "WHITE" : "BLACK";
    }

    public function isSet()
    {
        return $this->bit !== NULL;
    }

    public function isDataCell()
    {
        return $this->type === NULL;
    }

    public function isFreeDataCell()
    {
        return $this->isDataCell() && !$this->isSet();
    }
}
