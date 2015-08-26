<?php
	
	// define ROOT
	define('ROOT', __DIR__ . '/');
	
	// define HTTP
	$uri = preg_replace('/\/[^\/]*$/', '', $_SERVER['REQUEST_URI']);
	
	// URI || URI + file
	if (substr(__DIR__, -strlen($uri)) === $uri) {
		$dir = $uri;
	}
	// URI + page/
	else {
		$dir = preg_replace('/' . addcslashes($_SERVER['DOCUMENT_ROOT'], '/') . '/', '', __DIR__);
	}
	
	define('HTTP', 'http://' . $_SERVER['SERVER_NAME'] . $dir . '/');
	
	// get status
	if (!$code) {
		$code = $_GET['error'];
	}
	
	// associate with message
	$message = array(
		400 => "Bad Request",
		403 => "Forbidden To Access",
		404 => "Page Not Found",
		500 => "Internal Server Error",
		502 => "Bad Gateway",
		504 => "Gateway Timeout",
		509 => "Bandwidth Limit Exceeded"
	);
	
	if (!$message[$code] && basename($_SERVER["SCRIPT_FILENAME"], '.php') == 'config') {
		$code = 404;
	}
	
	if ($message[$code]) {
		include_once(ROOT . 'system/scripts/error.php');
		exit;
	}
	
	// include system
	include_once(ROOT . 'system/system.php');

	// include top of page
	include_once(ROOT . 'system/sections/header.php');

?>