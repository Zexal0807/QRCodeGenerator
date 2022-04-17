<?php
class PolynomialDivision
{
    public static function calc($messagePolynomial, $divisionExponent)
    {
        // Calc max exponent of message polynomial
        $maxExponentDataPolynomial = sizeof($messagePolynomial) - 1;

        // Multiply for x^(divisionExponent)
        $maxExponentDataPolynomial = $maxExponentDataPolynomial + $divisionExponent;

        // Get Generator polynomial
        $generetorPolynomial = PolynomialDivision::getAlphaExponentForErrorCorrection($divisionExponent);
        $maxExponentGeneretorPolynomial = $maxExponentDataPolynomial;

        $workingPolynomial =  $generetorPolynomial;
        $maxExponentWorkingPolynomial = $maxExponentGeneretorPolynomial;

        $precPolynomial = $messagePolynomial;

        for ($k = 0; $k < sizeof($messagePolynomial); $k++) {

            // Calc leadTearm as Alpha
            $leadTearmAlpha =  PolynomialDivision::Integer2Alpha($workingPolynomial[0]);
            if ($k == 0) {
                $leadTearmAlpha = PolynomialDivision::Integer2Alpha($messagePolynomial[$k]);
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
            for ($i = 0; $i < sizeof($messagePolynomial); $i++) {
                $workingPolynomial[$i] =  (isset($workingPolynomial[$i]) ? $workingPolynomial[$i] : 0) ^ (isset($precPolynomial[$i]) ? $precPolynomial[$i] : 0);
            }

            // Remove 0 terms
            array_splice($workingPolynomial, 0, 1);
            $maxExponentWorkingPolynomial--;

            array_push($workingPolynomial, 0);

            $precPolynomial = $workingPolynomial;
        }

        return array_slice($workingPolynomial, 0, $divisionExponent);
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
            [0, 199, 249, 155, 48, 190, 124, 218, 137, 216, 87, 207, 59, 22, 91], //14
            [0, 8, 183, 61, 91, 202, 37, 51, 58, 58, 237, 140, 124, 5, 99, 105], //15
            [0, 120, 104, 107, 109, 102, 161, 76, 3, 91, 191, 147, 169, 182, 194, 225, 120], //16
            [0, 43, 139, 206, 78, 43, 239, 123, 206, 214, 147, 24, 99, 150, 39, 243, 163, 136], //17
            [0, 215, 234, 158, 94, 184, 97, 118, 170, 79, 187, 152, 148, 252, 179, 5, 98, 96, 153], //18
            [0, 67, 3, 105, 153, 52, 90, 83, 17, 150, 159, 44, 128, 153, 133, 252, 222, 138, 220, 171], //19
            [0, 17, 60, 79, 50, 61, 163, 26, 187, 202, 180, 221, 225, 83, 239, 156, 164, 212, 212, 188, 190], //20
            [0, 240, 233, 104, 247, 181, 140, 67, 98, 85, 200, 210, 115, 148, 137, 230, 36, 122, 254, 148, 175, 210], //21
            [0, 210, 171, 247, 242, 93, 230, 14, 109, 221, 53, 200, 74, 8, 172, 98, 80, 219, 134, 160, 105, 165, 231], //22
            [0, 171, 102, 146, 91, 49, 103, 65, 17, 193, 150, 14, 25, 183, 248, 94, 164, 224, 192, 1, 78, 56, 147, 253], //23
            [0, 229, 121, 135, 48, 211, 117, 251, 126, 159, 180, 169, 152, 192, 226, 228, 218, 111, 0, 117, 232, 87, 96, 227, 21], //24
            [0, 231, 181, 156, 39, 170, 26, 12, 59, 15, 148, 201, 54, 66, 237, 208, 99, 167, 144, 182, 95, 243, 129, 178, 252, 45], //25
            [0, 173, 125, 158, 2, 103, 182, 118, 17, 145, 201, 111, 28, 165, 53, 161, 21, 245, 142, 13, 102, 48, 227, 153, 145, 218, 70], //26
            [0, 79, 228, 8, 165, 227, 21, 180, 29, 9, 237, 70, 99, 45, 58, 138, 135, 73, 126, 172, 94, 216, 193, 157, 26, 17, 149, 96], //27
            [0, 168, 223, 200, 104, 224, 234, 108, 180, 110, 190, 195, 147, 205, 205, 27, 232, 201, 21, 43, 245, 87, 42, 195, 212, 119, 242, 37, 9, 123], //28
            [0, 156, 45, 183, 29, 151, 219, 54, 96, 249, 24, 136, 5, 241, 175, 189, 28, 75, 234, 150, 148, 23, 9, 202, 162, 68, 250, 140, 24, 151], //29
            [0, 41, 173, 145, 152, 216, 31, 179, 182, 50, 48, 110, 86, 239, 96, 222, 125, 42, 173, 226, 193, 224, 130, 156, 37, 251, 216, 238, 40, 192, 180] //30
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
