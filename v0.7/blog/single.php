<?php

	// get post's title from post-parameter
	$postTitle = $_GET['post'];
	$filename = 'posts/' . $postTitle . '.md';
	
	// throw 404 if post is not found
	if (!file_exists($filename)) {
		$code = 404;
	}

	// include config file for general settings
	require_once('../config.php');
	
	// get contents of corresponding file
	$body = Markdown(file_get_contents($filename));
	
	// add class of 'timestamp' to first paragraph AND append average reading time
	$body = preg_replace('/\<p\>(.*)\<\/p\>/', '<p class="timestamp">$1 &mdash; ' . ceil(((str_word_count(strip_tags($body)) * 310) / 1000) / 60) . ' min</p>', $body, 1);
	
	// print concept bar at top of page if necessary
	$num = preg_replace('/[^0-9]/', '', $postTitle);
	if ($num == 0) {
		print '<div id="concept-notice"><p><strong>Concept Mode:</strong> Only people with a direct link to this page are able to view it.</p></div>';
	}
	
	// variables for sharing purposes
	preg_match('/<h1>(.*?)<\/h1>/s', $body, $title);
	$title = strip_tags($title[0]);

?>

	<div class="section">
		<div class="wrapper narrow">
			<div class="column-100 post">
				<?php echo $body ?>
				
				<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $title ?>" data-via="thomweerd" data-size="large" data-related="thomweerd" data-count="none" data-dnt="true">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</div>
		</div>
	</div>

<?php section('footer') ?>