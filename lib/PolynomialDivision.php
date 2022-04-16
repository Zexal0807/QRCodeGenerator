<?php
class PolynomialDivision
{
    public static function calc($coefficients, $divisionExponent)
    {
        // Calc max exponent of data polynomial
        $dataPolynomial = $coefficients;
        $maxExponentDataPolynomial = sizeof($coefficients) - 1;

        // Multiply for x^(divisionExponent)
        $maxExponentDataPolynomial = $maxExponentDataPolynomial + $divisionExponent;

        // Get Generator polynomial
        $generetorPolynomial = PolynomialDivision::getAlphaExponentForErrorCorrection($divisionExponent);
        $maxExponentGeneretorPolynomial = $maxExponentDataPolynomial;

        $workingPolynomial =  $generetorPolynomial;
        $maxExponentWorkingPolynomial = $maxExponentGeneretorPolynomial;

        $precPolynomial = $dataPolynomial;

        for ($k = 0; $k < sizeof($coefficients); $k++) {

            // Calc leadTearm as Alpha
            $leadTearmAlpha =  PolynomialDivision::Integer2Alpha($workingPolynomial[0]);
            if ($k == 0) {
                $leadTearmAlpha = PolynomialDivision::Integer2Alpha($coefficients[$k]);
            }


            // Multiply for alpha^leadTearm with module 255
            $workingPolynomial = array_map(function ($el) use ($leadTearmAlpha) {
                return ($el + $leadTearmAlpha) % 255;
            }, $generetorPolynomial);

            // Convert to integer
            $workingPolynomial = array_map(function ($el) {
                return PolynomialDivision::Alpha2Integer($el);
            }, $workingPolynomial);

            // XOR
            for ($i = 0; $i < $divisionExponent; $i++) {
                $workingPolynomial[$i] =  $workingPolynomial[$i] ^ (isset($precPolynomial[$i]) ? $precPolynomial[$i] : 0);
            }

            // Remove 0 terms
            array_splice($workingPolynomial, 0, 1);
            $maxExponentWorkingPolynomial--;

            array_push($workingPolynomial, 0);

            $precPolynomial = $workingPolynomial;
        }
        array_pop($workingPolynomial);

        return $workingPolynomial;
    }

    private static function getAlphaExponentForErrorCorrection($numberCodewords)
    {
        $table = [
            [0, 87, 229, 146, 149, 238, 102, 21],       // 7
            [0, 175, 238, 208, 249, 215, 252, 196, 28],  //8
            [0, 95, 246, 137, 231, 235, 149, 11, 123, 36], //9
            [0, 251, 67, 46, 61, 118, 70, 64, 94, 32, 45], //10
            [0, 220, 192, 91, 194, 172, 177, 209, 116, 227, 10, 55], //11
            [0, 102, 43, 98, 121, 187, 113, 198, 143, 131, 87, 147, 66], //12
            [0, 74, 152, 176, 100, 86, 100, 106, 104, 130, 218, 206, 140, 78], //13
            [], //14
            [], //15
            [], //16
            [], //17
            [0, 215, 234, 158, 94, 184, 97, 118, 170, 79, 187, 152, 148, 252, 179, 5, 98, 96, 153], //18
            [], //19
            [], //20
            [], //21
            [0, 210, 171, 247, 242, 93, 230, 14, 109, 221, 53, 200, 74, 8, 172, 98, 80, 219, 134, 160, 105, 165, 231] //22
        ];
        return $table[$numberCodewords - 7];
    }

    private static $logAntiLogTable = [1, 2, 4, 8, 16, 32, 64, 128, 29, 58, 116, 232, 205, 135, 19, 38, 76, 152, 45, 90, 180, 117, 234, 201, 143, 3, 6, 12, 24, 48, 96, 192, 157, 39, 78, 156, 37, 74, 148, 53, 106, 212, 181, 119, 238, 193, 159, 35, 70, 140, 5, 10, 20, 40, 80, 160, 93, 186, 105, 210, 185, 111, 222, 161, 95, 190, 97, 194, 153, 47, 94, 188, 101, 202, 137, 15, 30, 60, 120, 240, 253, 231, 211, 187, 107, 214, 177, 127, 254, 225, 223, 163, 91, 182, 113, 226, 217, 175, 67, 134, 17, 34, 68, 136, 13, 26, 52, 104, 208, 189, 103, 206, 129, 31, 62, 124, 248, 237, 199, 147, 59, 118, 236, 197, 151, 51, 102, 204, 133, 23, 46, 92, 184, 109, 218, 169, 79, 158, 33, 66, 132, 21, 42, 84, 168, 77, 154, 41, 82, 164, 85, 170, 73, 146, 57, 114, 228, 213, 183, 115, 230, 209, 191, 99, 198, 145, 63, 126, 252, 229, 215, 179, 123, 246, 241, 255, 227, 219, 171, 75, 150, 49, 98, 196, 149, 55, 110, 220, 165, 87, 174, 65, 130, 25, 50, 100, 200, 141, 7, 14, 28, 56, 112, 224, 221, 167, 83, 166, 81, 162, 89, 178, 121, 242, 249, 239, 195, 155, 43, 86, 172, 69, 138, 9, 18, 36, 72, 144, 61, 122, 244, 245, 247, 243, 251, 235, 203, 139, 11, 22, 44, 88, 176, 125, 250, 233, 207, 131, 27, 54, 108, 216, 173, 71, 142, 1];

    private static function Integer2Alpha($integer)
    {
        return array_search($integer, PolynomialDivision::$logAntiLogTable);
    }

    private static function Alpha2Integer($alpha)
    {
        return PolynomialDivision::$logAntiLogTable[$alpha];
    }
}
