<?php

$url = $_SERVER['REQUEST_URI'];
$url = str_replace('/ZMS/', '', $url);

if (!strpos($url, '.html')) {
	$url = $url . '.html';
}

include('system/public/' . $url);

// build cache for next person, gotta go fast
require('system/CacheChecker.php');
use CacheChecker as CacheChecker;
(new CacheChecker)->check();
