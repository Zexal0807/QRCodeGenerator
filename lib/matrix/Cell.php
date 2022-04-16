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
        if ($data == "D") {
            $this->type = "DARK";
            $this->bit = 1;
        } else if (strlen($data) == 1) {
            $this->type = NULL;
            $this->bit = intval($data);
        } else {
            $this->type = substr($data, 0, -1);
            $this->bit = intval(substr($data, -1));
        }
    }

    public function getColor()
    {
        return $this->bit == 0 ? "WHITE" : "BLACK";
    }

    public function isDataCell()
    {
        return $this->type == NULL;
    }
}
