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
);

Level::$LEVEL_3 = new Level(
    'LEVEL_3',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_3.json"), true)
);

Level::$LEVEL_4 = new Level(
    'LEVEL_4',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_4.json"), true)
);

Level::$LEVEL_5 = new Level(
    'LEVEL_5',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_5.json"), true)
);

Level::$LEVEL_6 = new Level(
    'LEVEL_6',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_6.json"), true)
);

Level::$LEVEL_7 = new Level(
    'LEVEL_7',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_7.json"), true)
);

Level::$LEVEL_8 = new Level(
    'LEVEL_8',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_8.json"), true)
);

Level::$LEVEL_9 = new Level(
    'LEVEL_9',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_9.json"), true)
);

Level::$LEVEL_10 = new Level(
    'LEVEL_10',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_10.json"), true)
);

Level::$LEVEL_11 = new Level(
    'LEVEL_11',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_11.json"), true)
);

Level::$LEVEL_12 = new Level(
    'LEVEL_12',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_12.json"), true)
);

Level::$LEVEL_13 = new Level(
    'LEVEL_13',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_13.json"), true)
);

Level::$LEVEL_14 = new Level(
    'LEVEL_14',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_14.json"), true)
);

Level::$LEVEL_15 = new Level(
    'LEVEL_15',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_15.json"), true)
);

Level::$LEVEL_16 = new Level(
    'LEVEL_16',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_16.json"), true)
);

Level::$LEVEL_17 = new Level(
    'LEVEL_17',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_17.json"), true)
);

Level::$LEVEL_18 = new Level(
    'LEVEL_18',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_18.json"), true)
);

Level::$LEVEL_19 = new Level(
    'LEVEL_19',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_19.json"), true)
);

Level::$LEVEL_20 = new Level(
    'LEVEL_20',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_20.json"), true)
);

Level::$LEVEL_21 = new Level(
    'LEVEL_21',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_21.json"), true)
);

Level::$LEVEL_22 = new Level(
    'LEVEL_22',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_22.json"), true)
);

Level::$LEVEL_23 = new Level(
    'LEVEL_23',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_23.json"), true)
);

Level::$LEVEL_24 = new Level(
    'LEVEL_24',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_24.json"), true)
);

Level::$LEVEL_25 = new Level(
    'LEVEL_25',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_25.json"), true)
);

Level::$LEVEL_26 = new Level(
    'LEVEL_26',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_26.json"), true)
);

Level::$LEVEL_27 = new Level(
    'LEVEL_27',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_27.json"), true)
);

Level::$LEVEL_28 = new Level(
    'LEVEL_28',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_28.json"), true)
);

Level::$LEVEL_29 = new Level(
    'LEVEL_29',
    json_decode(file_get_contents(dirname(__FILE__) . "/capacity/LEVEL_29.json"), true)
);
