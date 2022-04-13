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
        $this->addDataBits();
    }

    private function addFinderPatterns()
    {
        $pattern = [
            ["F1", "F1", "F1", "F1", "F1", "F1", "F1"],
            ["F1", "F0", "F0", "F0", "F0", "F0", "F1"],
            ["F1", "F0", "F1", "F1", "F1", "F0", "F1"],
            ["F1", "F0", "F1", "F1", "F1", "F0", "F1"],
            ["F1", "F0", "F1", "F1", "F1", "F0", "F1"],
            ["F1", "F0", "F0", "F0", "F0", "F0", "F1"],
            ["F1", "F1", "F1", "F1", "F1", "F1", "F1"]
        ];
        $this->addPattern($pattern, 0, 0);

        $pattern = [
            ["F1", "F1", "F1", "F1", "F1", "F1", "F1"],
            ["F1", "F0", "F0", "F0", "F0", "F0", "F1"],
            ["F1", "F0", "F1", "F1", "F1", "F0", "F1"],
            ["F1", "F0", "F1", "F1", "F1", "F0", "F1"],
            ["F1", "F0", "F1", "F1", "F1", "F0", "F1"],
            ["F1", "F0", "F0", "F0", "F0", "F0", "F1"],
            ["F1", "F1", "F1", "F1", "F1", "F1", "F1"]
        ];

        $this->addPattern($pattern, $this->level->getSize() - 7, 0);

        $pattern = [
            ["F1", "F1", "F1", "F1", "F1", "F1", "F1"],
            ["F1", "F0", "F0", "F0", "F0", "F0", "F1"],
            ["F1", "F0", "F1", "F1", "F1", "F0", "F1"],
            ["F1", "F0", "F1", "F1", "F1", "F0", "F1"],
            ["F1", "F0", "F1", "F1", "F1", "F0", "F1"],
            ["F1", "F0", "F0", "F0", "F0", "F0", "F1"],
            ["F1", "F1", "F1", "F1", "F1", "F1", "F1"]
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
            ["A1", "A1", "A1", "A1", "A1"],
            ["A1", "A0", "A0", "A0", "A1"],
            ["A1", "A0", "A1", "A0", "A1"],
            ["A1", "A0", "A0", "A0", "A1"],
            ["A1", "A1", "A1", "A1", "A1"]
        ];

        foreach ($this->level->getAlignmentPatternCenter() as $center) {
            $this->addPattern($pattern, $center[0] - 2, $center[1] - 2);
        }
    }

    private function addTimingPatterns()
    {
        for ($i = 0; $i < $this->level->getSize() - 16; $i++) {
            $this->matrix[6][6 + $i + 2] = "T" . ($i + 1) % 2;
            $this->matrix[6 + $i + 2][6] = "T" . ($i + 1) % 2;
        }
    }

    private function addDarkModule()
    {
        $this->matrix[$this->level->getSize() - 8][8] = "D";
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

        $data = $this->level->getVersionInformationString();

        $pattern = [
            ["R" . $data[17], "R" . $data[16], "R" . $data[15]],
            ["R" . $data[14], "R" . $data[13], "R" . $data[12]],
            ["R" . $data[11], "R" . $data[10], "R" . $data[9]],
            ["R" . $data[8], "R" . $data[7], "R" . $data[6]],
            ["R" . $data[5], "R" . $data[4], "R" . $data[3]],
            ["R" . $data[2], "R" . $data[1], "R" . $data[0]]
        ];
        $this->addPattern($pattern, $this->level->getSize() - 10, 0);

        $pattern = [
            ["R" . $data[17], "R" . $data[14], "R" . $data[11], "R" . $data[8], "R" . $data[5], "R" . $data[2]],
            ["R" . $data[16], "R" . $data[13], "R" . $data[10], "R" . $data[7], "R" . $data[4], "R" . $data[1]],
            ["R" . $data[15], "R" . $data[12], "R" . $data[9], "R" . $data[6], "R" . $data[3], "R" . $data[0]]
        ];
        $this->addPattern($pattern, 0, $this->level->getSize() - 10);
    }

    private function addDataBits()
    {
        $x = $this->level->getSize() - 1;
        $y = $this->level->getSize() - 1;

        $dir = "UP";
        $step = "LEFT";

        $i = 0;

        while ($i < strlen($this->data)) {

            // check is free
            $free = false;
            if (!isset($this->matrix[$y][$x])) {
                $free = true;
            }
            if ($free) {
                $this->matrix[$y][$x] = $this->data[$i];
                // $this->matrix[$y][$x] = $i;
                $i++;
            }

            //calc next
            if ($x == 6) {
                $x--;
            }
            if ($dir == "UP") {
                switch ($step) {
                    case "LEFT":
                        $x--;
                        $step = "UP-RIGHT";
                        break;
                    case "UP-RIGHT":
                        if ($y == 0) {
                            $step = "DOUBLE-LEFT";
                        } else {
                            $x++;
                            $y--;
                            $step = "LEFT";
                        }
                        break;
                    case "DOUBLE-LEFT":
                        $x--;
                        $step = "SINGLE-LEFT";
                        break;
                    case "SINGLE-LEFT":
                        $x--;
                        $dir = "DOWN";
                        $step = "RIGHT";
                        break;
                }
            } else {
                switch ($step) {
                    case "RIGHT":
                        $x++;
                        $y++;
                        $step = "DOWN-LEFT";
                        break;
                    case "DOWN-LEFT":
                        if ($y == $this->level->getSize() - 1) {
                            $step = "DOUBLE-RIGHT";
                        } else {
                            $x--;
                            $step = "RIGHT";
                        }
                        break;
                    case "DOUBLE-RIGHT":
                        $x--;
                        $step = "SINGLE-RIGHT";
                        break;
                    case "SINGLE-RIGHT":
                        $x--;
                        $dir = "UP";
                        $step = "LEFT";
                        break;
                }
            }
        }
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
