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
        $pattern = [
            [0, 0, 0, 0, 0, 0, 0, 1],
            [0, 1, 1, 1, 1, 1, 0, 1],
            [0, 1, 0, 0, 0, 1, 0, 1],
            [0, 1, 0, 0, 0, 1, 0, 1],
            [0, 1, 0, 0, 0, 1, 0, 1],
            [0, 1, 1, 1, 1, 1, 0, 1],
            [0, 0, 0, 0, 0, 0, 0, 1],
            [1, 1, 1, 1, 1, 1, 1, 1]
        ];
        $this->addPattern($pattern, 0, 0);

        $pattern = [
            [1, 0, 0, 0, 0, 0, 0, 0],
            [1, 0, 1, 1, 1, 1, 1, 0],
            [1, 0, 1, 0, 0, 0, 1, 0],
            [1, 0, 1, 0, 0, 0, 1, 0],
            [1, 0, 1, 0, 0, 0, 1, 0],
            [1, 0, 1, 1, 1, 1, 1, 0],
            [1, 0, 0, 0, 0, 0, 0, 0],
            [1, 1, 1, 1, 1, 1, 1, 1]
        ];
        $this->addPattern($pattern, $this->level->getSize() - 8, 0);

        $pattern = [
            [1, 1, 1, 1, 1, 1, 1, 1],
            [0, 0, 0, 0, 0, 0, 0, 1],
            [0, 1, 1, 1, 1, 1, 0, 1],
            [0, 1, 0, 0, 0, 1, 0, 1],
            [0, 1, 0, 0, 0, 1, 0, 1],
            [0, 1, 0, 0, 0, 1, 0, 1],
            [0, 1, 1, 1, 1, 1, 0, 1],
            [0, 0, 0, 0, 0, 0, 0, 1]
        ];
        $this->addPattern($pattern, 0, $this->level->getSize() - 8);
    }

    private function addPattern($pattern, $cornerX = 0, $cornerY = 0)
    {
        for ($i = 0; $i < sizeof($pattern); $i++) {
            for ($j = 0; $j < sizeof($pattern[0]) || 0; $j++) {
                $this->matrix[$i + $cornerY][$j + $cornerX] = $pattern[$i][$j];
            }
        }
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
