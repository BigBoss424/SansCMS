<?php require_once('config.php') ?>

	<div class="section">
		<div class="wrapper narrow">
			<div class="column-100">
				<h1>Portfolio</h1>
				<p>Open <code>/portfolio.php</code> in your code editor of choice and get the Dribbble module up and running by entering the required access token.</p>
			</div>
		</div>
		<div class="wrapper">
			<?php
			
				// dribbble module
				echo dribbble(array(
					// required, visit https://api.dribbble.com to get yours
					'token' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
					// optional, defaults to 10, maximum is 50
					'count' => 10,
					// optional, defaults to 50
					'column' => 50
				));
				
			?>
		</div>

<?php section('footer') ?>