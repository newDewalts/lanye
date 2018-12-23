<?php 
	$ip = gethostbyname($_SERVER['SERVER_NAME']);
	if ($ip == '127.0.0.1') {
		define('SITE_MODE', 'dev');
		define('APP_DEBUG', true);
	} elseif ($ip == '121.41.34.37') {
		define('SITE_MODE', 'test');
		define('APP_DEBUG', true);
	} else {
		define('SITE_MODE', 'prod');
		define('APP_DEBUG', true);
	}

	define("APP_NAME", 'Home');
	define("APP_PATH", './Home/');
	require "../ThinkPHP/ThinkPHP.php";
?>