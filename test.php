<?php include("vendor/autoload.php");

$m = new \yandex\alisa\Alisa();

$m->prepare('Забранируй мне {what} на {when}',
    'Забронируй мне дом на 15:40 в пятницу.'
);

//
$math = "/Забронируй мне\s.*на\s.*в\s.*/";
//
//echo preg_match($math, 'Забронируй мне дом на 15:40 в пятнцу');