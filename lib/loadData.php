<?php
require_once(dirname(__FILE__) . './encode/NumericModeEncoding.php');
require_once(dirname(__FILE__) . './encode/AlphanumericModeEncoding.php');
require_once(dirname(__FILE__) . './encode/ByteModeEncoding.php');
require_once(dirname(__FILE__) . './encode/KanjiModeEncoding.php');

Encoding::$ENCODING_NUMERIC = new NumericModeEncoding('ENCODING_NUMERIC', '0001');
Encoding::$ENCODING_ALPHANUMERIC = new AlphanumericModeEncoding('ENCODING_ALPHANUMERIC', '0010');
Encoding::$ENCODING_BYTE = new ByteModeEncoding('ENCODING_BYTE', '0100');
Encoding::$ENCODING_KANJI = new KanjiModeEncoding('ENCODING_KANJI', '1000');

require_once(dirname(__FILE__) . './const/ErrorCorrection.php');

ErrorCorrection::$CORRECTION_L = new ErrorCorrection('CORRECTION_L', 0.07);
ErrorCorrection::$CORRECTION_M = new ErrorCorrection('CORRECTION_M', 0.15);
ErrorCorrection::$CORRECTION_Q = new ErrorCorrection('CORRECTION_Q', 0.25);
ErrorCorrection::$CORRECTION_H = new ErrorCorrection('CORRECTION_H', 0.30);

require_once('./lib/const/Level.php');

// TODO: Implement different level
Level::$LEVEL_1 = new Level(
    'LEVEL_1',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_1.json"), true)
);

Level::$LEVEL_2 = new Level(
    'LEVEL_2',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_2.json"), true)
);;

Level::$LEVEL_3 = new Level(
    'LEVEL_3',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_3.json"), true)
);;



Level::$LEVEL_7 = new Level(
    'LEVEL_7',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_7.json"), true)
);
