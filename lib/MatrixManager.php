<?php
class MatrixManager
{
    private $data;
    private $level;
    private $matrix;

    public function __construct(Level $level)
    {
        $this->level = $level;

        $this->matrix = [];

        for ($i = 0; $i < $this->level->getSize(); $i++) {
            $this->matrix[$i] = [];
            for ($j = 0; $j < $this->level->getSize(); $j++) {
                $this->matrix[$i][$j] = NULL;
            }
        }
    }


    public function setData($data)
    {
        $this->data = $data;
        $this->addFinderPatterns();
    }

    private function addFinderPatterns()
    {
        $this->matrix[0][0] = 0;
        $this->matrix[1][1] = 0;
        $this->matrix[2][2] = 0;
        $this->matrix[3][3] = 0;
        $this->matrix[4][4] = 0;
        $this->matrix[5][5] = 0;
        $this->matrix[6][6] = 0;
    }

    public function printMatrix()
    {
        $html = "<table>";
        for ($i = 0; $i < $this->level->getSize(); $i++) {
            $html .= "<tr>";
            for ($j = 0; $j < $this->level->getSize(); $j++) {
                $html .= '<td color="' . $this->matrix[$i][$j] . '"></td>';
            }
            $html .= "</tr>";
        }
        $html .= "</table>";
        return $html;
    }
}
