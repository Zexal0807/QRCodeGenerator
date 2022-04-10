<?php
class MatrixManager
{
    private $data;
    private $level;
    private $matrix;

    public function __construct($data, Level $level)
    {
        $this->data = $data;
        $this->level = $level;

        $matrix = [];

        for ($i = 0; $i < $this->level->getSize(); $i++) {
            $matrix[$i] = [];
        }
    }
}
