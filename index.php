<?php include("src/Alisa.php");

$main = new \yandex\alisa\Alisa();

$main->addStartMessage("Добро пожаловать")->setCaseSensitive(false)->listen();