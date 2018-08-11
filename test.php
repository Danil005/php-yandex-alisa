<?php

include("vendor/autoload.php");

$main = new yandex\alisa\Alisa();

echo "<pre>";
print_r($main->uploadImage("images/1.jpg"));
