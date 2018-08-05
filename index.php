<?php include("vendor/autoload.php");

$main = new \yandex\alisa\Alisa();
$main->addStartMessage("Добро пожаловать")->setCaseSensitive(false)->listen();