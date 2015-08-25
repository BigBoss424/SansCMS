<?php
	
	// set basename	
	preg_match('/[^\/]+$/', $_SERVER["REQUEST_URI"], $match);
	$basename = $match[0];
	
	if ($basename == '') {
		$basename = 'about';
	}
	
	if (preg_match('/(blog|work|portfolio)/', $_SERVER["REQUEST_URI"], $match2)) {
		$basename = $match2[0];
	}
	
	// include Markdown
	include_once(ROOT . 'system/scripts/markdown.php');
	
	// get status of webpage (e.g. 200, 404 or 502)
	function getStatus($url) {
	    $headers = get_headers($url);
	    return substr($headers[0], 9, 3);
	}
	
	// section('file') includes file.php
	function section($file) {
		include_once(ROOT . 'system/sections/' . $file . '.php');
	}
	
	// text('file') includes file.md and converts it to html
	function text($file) {
		echo Markdown(file_get_contents(ROOT . 'system/text/' . $file . '.md'));
	}
	
	// navigation(page_array) renders navigation
	function navigation($pages) {
	
		// loop through pages and print a link for each page
		foreach ($pages as $label => $page) {
						
			// check if link is external or internal
			if (preg_match('/http(s?):\/\//', $page, $match3, PREG_OFFSET_CAPTURE) == false) {
				$href = 'href="' . HTTP . preg_replace('/^about$/', '', $page) . '"';
			} else {
				$href = 'href="' . $page . '"';
			}
			
			global $basename;
	
			// compare basename with page-name and add class of "current" when match is found
			if ($page != NULL && strpos($basename, str_replace('/', '', $page)) !== false) {
				$class = 'class="current"';
			} else {
				$class = '';
			}
			
			// render link for this page
			echo '<a ' . $href . $class . '>' . $label . '</a>';
		}
	}
	
	/*
	
	DRIBBBLE MODULE
	
	HOW TO INITIATE:
	dribbble(array(parameters))
	
	REQUIRED PARAMETERS:
	1. "token" = the dribbble api requires an access token, get yours at http://developer.dribbble.com
	
	POSSIBLE PARAMETERS:
	1. "count" = the amount of shots to display, defaults to 10, maximum is 50
	2. "column" = the column width of the photo (eg. 20, 25, 33, 50 or 100)
	
	*/
		
	function dribbble($param) {
		
		// required parameters
		$token = $param["token"];
		
		// possible parameters
		$count = $param["count"];
		
		if (!$count) {
			$count = 10;
		} else {
			$count = min($count, 50);
		}
		
		$column = $param["column"];
		if (!$column) {
			$column = 'column-50';
		} else {
			$column = 'column-' . $column;
		}
		
		// location of cached file
		$file = ROOT . 'assets/cache/dribbble.json';
		
		// update cached file if it's older than 30 minutes
		if ((time() - filemtime($file)) > 1800) {

			// get most recent json data
			$url = 'https://api.dribbble.com/v1/user/shots?access_token=' . $token . '&per_page=' . $count;
			
			// check status
			if (getStatus($url) == 200) {
			
				// update cached file
				$data = file_get_contents($url);
				file_put_contents($file, $data, LOCK_EX);
				
			} else {
				$data = file_get_contents($file);
			}
			
			// prepare fresh data for implementation
			$data = json_decode($data, true);
			
		} else {
			
			// prepare cached data for implementation
			$data = json_decode(file_get_contents($file), true);
			
		}
		
		// loop: render shots
		for ($i = 0; $i < min($count, count($data)); $i++) {
			$url = $data[$i]['html_url'];
			$img = $data[$i]['images']['hidpi']; // teaser (200px) or normal (400px) or hidpi (800px)
			// $views = number_format($data[$i]['views_count']);
			
			// print shots
			echo '<div class="' . $column . '"><p><a href="' . $url . '" target="_blank"><img src="' . $img . '" /></a></p></div>';
		}
	}
	
	/*
	
	// INSTAGRAM MODULE
	
	HOW TO INITIATE:
	instagram(array(parameters))
	
	REQUIRED PARAMETERS:
	1. "token" = the instagram api requires an access token, the following page explains well how to get your access token, as it's a bit of a workaround: http://jelled.com/instagram/access-token
	
	POSSIBLE PARAMETERS:
	1. "count" = the amount of shots to display, defaults to 10, maximum allowed by api is 20
	2. "column" = the column width of the photo (eg. 20, 25, 33, 50 or 100)
	
	*/
	
	function instagram($param) {
		
		// required parameters
		$token = $param["token"];
		
		// possible parameters
		$count = $param["count"];
		if (!$count) {
			$count = 10;
		}
		
		$column = $param["column"];
		if (!$column) {
			$column = 'column-33';
		} else {
			$column = 'column-' . $column;
		}
		
		// location of cached file
		$file = ROOT . 'assets/cache/instagram.json';
		
		// update cached file if it's older than 30 minutes
		if ((time() - filemtime($file)) > 1800) {

			// get most recent json data
			$url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token=' . $token;
			
			// check status
			if (getStatus($url) == 200) {
			
				// update cached file
				$data = file_get_contents($url);
				file_put_contents($file, $data, LOCK_EX);
				
			} else {
				$data = file_get_contents($file);
			}
			
			// prepare fresh data for implementation
			$data = json_decode($data, true);
			
		} else {
			
			// prepare cached data for implementation
			$data = json_decode(file_get_contents($file), true);
			
		}

		// render photos
		for ($i = 0; $i < min($count, count($data['data'])); $i++) {
			$title = $data['data'][$i]['caption']['text'];
			$url = $data['data'][$i]['link'];
			$img = $data['data'][$i]['images']['standard_resolution']['url'];
			
			// echo the html for each item
			echo '<div class="' . $column . '"><p><a href="' . $url . '"><img src="' . $img . '" alt="' . $title . '"></a></p></div>';
		}
	}

?>