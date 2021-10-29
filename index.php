<?php

$url = $_SERVER['REQUEST_URI'];
$url = 'pages/' . str_replace('/ZMS/', '', $url);

//====================================== it's a folder, we need to show index
if (is_dir($url)) {
	$url = $url . 'index.html';
}

//====================================== it's an html file without extension
if (
	!strpos($url, '.html') && file_exists($url . '.html')
) {
	$url = $url . '.html';
}

//====================================== build cache for the next person, gotta go fast
require('system/CacheChecker.php');
use CacheChecker as CacheChecker;
(new CacheChecker)->check(str_replace('pages/', '', $url));

include($url);

