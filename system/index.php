<?php

$filename = str_replace('/ZMS/', '', $_SERVER['REQUEST_URI']);

//====================================== it's a folder, we need to show index
if (is_dir('../pages/' . $filename)) {
	$filename = $filename . 'index.html';
}

//====================================== it's an html file without extension
if (file_exists('../pages/' . $filename . '.html')) {
	$filename = $filename . '.html';
}

//====================================== build cache for the next person, gotta go fast
require('CacheChecker.php');
use CacheChecker as CacheChecker;
(new CacheChecker)->check($filename);

include('public/' . $filename);
