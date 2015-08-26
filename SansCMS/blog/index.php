<?php
	
	// get current page's number
	$pageNumber = $_GET['page'];
	$searchQuery = strtolower($_GET['q']);
	
	if ($pageNumber == NULL || $pageNumber == 0) {
		$pageNumber = 1;
	} else {
		$pageNumber = $_GET['page'];
	}

	// glob all md-files in "posts/", except any files starting with "0-"
	$posts = preg_grep('/0-.*\.(md|mdown|markdown|txt|text)$/', array_reverse(glob('posts/*.md')), PREG_GREP_INVERT);

	// some calculations
	$totalPosts = count($posts);
	$postsPerPage = 5;
	$offset = ($pageNumber - 1) * $postsPerPage;
	
	// redirect if insufficient amount of posts
	if ($offset >= count($posts)) {
		include('../system/scripts/error.php');
		exit;
	}

	require_once('../config.php');

?>

	<div id="search">
		<form method="post" action="javascript:void(0)" method="post" onsubmit="search(this);">
			<input type="text" name="q" placeholder="Type, and hit enter..." />
			<a>Cancel</a>
		</form>
	</div>

	<div class="section">
		<div class="wrapper narrow">
			<div class="column-100">
				<h1>Blog</h1>
				<p>Add your first blog post by following the steps below:</p>
				<ol>
					<li>Add a file named <code>3-example.md</code> to <code>/blog/posts</code></li>
					<li>Add a title and timestamp to the newly created file, something like:
					<pre>Example Title
===

March 1, 2015

Lorem ipsum dolor sit amet.</pre></li>
				</ol>
			</div>
			<?php
				
				// loop: render posts				
				if ($searchQuery) {
				
					// loop through posts and push matches to array
					$toRender = array();
					$end = $totalPosts - 1;
					
					for ($i = 0; $i <= $end; $i++) {
						
						// convert markdown-file to html
						$body = markdown(file_get_contents($posts[$i]));
						$body = preg_replace('/\<h1\>(.*)\<\/h1\>/', '<h1><a href="' . basename($posts[$i], '.md') . '">$1</a></h1>', $body);
												
						if (preg_match("/$searchQuery/", strtolower(strip_tags($body)))) {
	
							// add class of 'timestamp' to first paragraph AND append average reading time
							$body = preg_replace('/\<p\>(.*)\<\/p\>/', '<p class="timestamp">$1 &mdash; ' . ceil(((str_word_count(strip_tags($body)) * 310) / 1000) / 60) . ' min</p>', $body, 1);
						
							// strip anything after timestamp
							$body = array_shift(explode('</p>', $body));
							
							// add to queue
							array_push($toRender, $body);
						}
					}
					
					// display how many posts have been found
					if (count($toRender) != 1) {
						$s = 's';
					}
					
					print '<div class="column-100"><p><center><em>' . count($toRender) . ' result' . $s . ' for “' . $searchQuery . '”</em></center></p></div>';
				
					// print posts
					$end = min(($offset + $postsPerPage), count($toRender));
				
					for ($i = $offset; $i < $end; $i++) {
						print '<div class="column-100 post">' . $toRender[$i] . '</div>';
					}
					
				} else {
				
					// loop through posts and push to array
					$end = min(($offset + $postsPerPage), $totalPosts) - 1;
					
					for ($i = $offset; $i <= $end; $i++) {
						
						// convert markdown-file to html
						$body = markdown(file_get_contents($posts[$i]));
						$body = preg_replace('/\<h1\>(.*)\<\/h1\>/', '<h1><a href="' . basename($posts[$i], '.md') . '">$1</a></h1>', $body);
	
						// add class of 'timestamp' to first paragraph AND append average reading time
						$body = preg_replace('/\<p\>(.*)\<\/p\>/', '<p class="timestamp">$1 &mdash; ' . ceil(((str_word_count(strip_tags($body)) * 310) / 1000) / 60) . ' min</p>', $body, 1);
						
						// strip anything after timestamp
						$explode = explode('</p>', $body);
						$body = array_shift($explode);
						
						// print posts
						print '<div class="column-100 post">' . $body . '</div>';
						
					}
				
				}
			
			?>
		</div>
		<div class="wrapper narrow" id="pagination">
			<div class="column-100">
				<?php
				
					if ($searchQuery) {
						$searchQuery = '&q=' . $searchQuery;
						$totalPages = ceil(count($toRender)/$postsPerPage);
					} else {
						$totalPages = ceil($totalPosts/$postsPerPage);
					}
				
					if ($pageNumber > 1) {
						echo '<a class="previous" href="?page=' . ($pageNumber - 1) . $searchQuery . '"><span></span></a>';
					}
					
				?>
				
				<a id="searchToggle"><span class="s1"></span><span class="s2"></span></a>
					
				<?php
				
					if ($totalPages > $pageNumber) {
						echo '<a class="next" href="?page=' . ($pageNumber + 1) . $searchQuery . '"><span></span></a>';
					}
					
				?>
			</div>
		</div>
	</div>

<?php section('footer') ?>