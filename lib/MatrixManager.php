<?php
class MatrixManager
{
    private $data;
    private $level;
    private $matrix;

    public function __construct(Level $level)
    {
        $this->level = $level;
    }

    private function resetMatrix()
    {
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
        $this->resetMatrix();
        $this->addFinderPatterns();
        $this->addSeparetors();
        $this->addAlignmentPatterns();
        $this->addTimingPatterns();
        $this->addDarkModule();
        $this->addReservedFormatInformationArea();
        $this->addReserveVersionInfomationArea();
    }

    private function addFinderPatterns()
    {
        $pattern = [
            [1, 1, 1, 1, 1, 1, 1],
            [1, 0, 0, 0, 0, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 0, 0, 0, 0, 1],
            [1, 1, 1, 1, 1, 1, 1]
        ];
        $this->addPattern($pattern, 0, 0);

        $pattern = [
            [1, 1, 1, 1, 1, 1, 1],
            [1, 0, 0, 0, 0, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 0, 0, 0, 0, 1],
            [1, 1, 1, 1, 1, 1, 1]
        ];
        $this->addPattern($pattern, $this->level->getSize() - 7, 0);

        $pattern = [
            [1, 1, 1, 1, 1, 1, 1],
            [1, 0, 0, 0, 0, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 0, 0, 0, 0, 1],
            [1, 1, 1, 1, 1, 1, 1]
        ];
        $this->addPattern($pattern, 0, $this->level->getSize() - 7);
    }

    private function addSeparetors()
    {
        $pattern = [
            [0],
            [0],
            [0],
            [0],
            [0],
            [0],
            [0],
            [0]
        ];
        $this->addPattern($pattern, 7, 0);
        $this->addPattern($pattern, $this->level->getSize() - 8, 0);
        $this->addPattern($pattern, 7, $this->level->getSize() - 8);


        $pattern = [
            [0, 0, 0, 0, 0, 0, 0, 0]
        ];
        $this->addPattern($pattern, 0, 7);
        $this->addPattern($pattern, $this->level->getSize() - 8, 7);
        $this->addPattern($pattern, 0, $this->level->getSize() - 8);
    }

    private function addAlignmentPatterns()
    {
        $pattern = [
            [1, 1, 1, 1, 1],
            [1, 0, 0, 0, 1],
            [1, 0, 1, 0, 1],
            [1, 0, 0, 0, 1],
            [1, 1, 1, 1, 1]
        ];

        foreach ($this->level->getAlignmentPatternCenter() as $center) {
            $this->addPattern($pattern, $center[0] - 2, $center[1] - 2);
        }
    }

    private function addTimingPatterns()
    {
        for ($i = 0; $i < $this->level->getSize() - 14; $i++) {
            $this->matrix[6][6 + $i] = ($i + 1) % 2;
            $this->matrix[6 + $i][6] = ($i + 1) % 2;
        }
    }

    private function addDarkModule()
    {
        $this->matrix[$this->level->getSize() - 8][8] = 1;
    }

    private function addReservedFormatInformationArea()
    {
        $pattern = [
            ["R"],
            ["R"],
            ["R"],
            ["R"],
            ["R"],
            ["R"],
            ["R"],
            ["R"]
        ];
        $this->addPattern($pattern, 8, 0);
        $this->addPattern($pattern, 8, $this->level->getSize() - 8);

        $this->matrix[8][8] = "R";

        $pattern = [
            ["R", "R", "R", "R", "R", "R", "R", "R"]
        ];
        $this->addPattern($pattern, $this->level->getSize() - 8, 8);
        $this->addPattern($pattern, 0, 8);
    }

    private function addReserveVersionInfomationArea()
    {
        if ($this->level->getSize() < Level::$LEVEL_7->getSize()) {
            return;
        }

        $pattern = [
            ["R", "R", "R"],
            ["R", "R", "R"],
            ["R", "R", "R"],
            ["R", "R", "R"],
            ["R", "R", "R"],
            ["R", "R", "R"]
        ];
        $this->addPattern($pattern, $this->level->getSize() - 10, 0);

        $pattern = [
            ["R", "R", "R", "R", "R", "R"],
            ["R", "R", "R", "R", "R", "R"],
            ["R", "R", "R", "R", "R", "R"]
        ];
        $this->addPattern($pattern, 0, $this->level->getSize() - 10);
    }

    private function addPattern($pattern, $cornerX = 0, $cornerY = 0)
    {
        for ($i = 0; $i < sizeof($pattern); $i++) {
            for ($j = 0; $j < sizeof($pattern[0]) || 0; $j++) {
                if (!isset($this->matrix[$i + $cornerY][$j + $cornerX])) {
                    $this->matrix[$i + $cornerY][$j + $cornerX] = $pattern[$i][$j];
                }
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
