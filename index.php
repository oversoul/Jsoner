<?php 
require 'jsoner/FileLoader.php';
require 'jsoner/Jsoner.php';

$file = 'data/info.json';

// create instance

$jsoner = new Jsoner();

// set file.
$jsoner->load($file);

var_dump($jsoner->count());
