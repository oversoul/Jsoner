<?php 
require 'jsoner/FileLoader.php';
require 'jsoner/Jsoner.php';

$file = 'data/info.json';
$jsoner = new Jsoner($file);

var_dump($jsoner->count());
