<?php
require_once('./lib/const/Encoding.php');
require_once('./lib/const/ErrorCorrection.php');
require_once('./lib/const/Level.php');

Encoding::$ENCODING_NUMERIC = new Encoding('ENCODING_NUMERIC', '0001');
Encoding::$ENCODING_ALPHANUMERIC = new Encoding('ENCODING_ALPHANUMERIC', '0010');
Encoding::$ENCODING_BYTE = new Encoding('ENCODING_BYTE', '0100');
Encoding::$ENCODING_KANJI = new Encoding('ENCODING_KANJI', '1000');

ErrorCorrection::$CORRECTION_L = new ErrorCorrection('CORRECTION_L', 0.07);
ErrorCorrection::$CORRECTION_M = new ErrorCorrection('CORRECTION_M', 0.15);
ErrorCorrection::$CORRECTION_Q = new ErrorCorrection('CORRECTION_Q', 0.25);
ErrorCorrection::$CORRECTION_H = new ErrorCorrection('CORRECTION_H', 0.30);

Level::$LEVEL_1 = new Level('LEVEL_1', 21, 21, [
    Encoding::$ENCODING_NUMERIC->getEncoding() => [
        ErrorCorrection::$CORRECTION_L->getCorrection() => 41,
        ErrorCorrection::$CORRECTION_M->getCorrection() => 34,
        ErrorCorrection::$CORRECTION_Q->getCorrection() => 27,
        ErrorCorrection::$CORRECTION_H->getCorrection() => 17
    ],
    Encoding::$ENCODING_ALPHANUMERIC->getEncoding() => [
        ErrorCorrection::$CORRECTION_L->getCorrection() => 25,
        ErrorCorrection::$CORRECTION_M->getCorrection() => 20,
        ErrorCorrection::$CORRECTION_Q->getCorrection() => 16,
        ErrorCorrection::$CORRECTION_H->getCorrection() => 10
    ],
    Encoding::$ENCODING_BYTE->getEncoding() => [
        ErrorCorrection::$CORRECTION_L->getCorrection() => 17,
        ErrorCorrection::$CORRECTION_M->getCorrection() => 14,
        ErrorCorrection::$CORRECTION_Q->getCorrection() => 11,
        ErrorCorrection::$CORRECTION_H->getCorrection() => 7
    ],
    Encoding::$ENCODING_KANJI->getEncoding() => [
        ErrorCorrection::$CORRECTION_L->getCorrection() => 10,
        ErrorCorrection::$CORRECTION_M->getCorrection() => 8,
        ErrorCorrection::$CORRECTION_Q->getCorrection() => 7,
        ErrorCorrection::$CORRECTION_H->getCorrection() => 4
    ]
]);