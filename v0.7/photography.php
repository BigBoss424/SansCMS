<?php require_once('config.php') ?>

	<div class="section">
		<div class="wrapper narrow">
			<div class="column-100">
				<h1>Photography</h1>
				<p>Open <code>/photography.php</code> in your code editor of choice and get the Instagram module up and running by entering the required access token.</p>
			</div>
		</div>
		<div class="wrapper">
			<?php
			
				// instagram module
				echo instagram(array(
					// required, the following page explains well how to get your access token, as it's a bit of a workaround: http://jelled.com/instagram/access-token
					'token' => 'xxxxxxx.xxxxxxx.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
					// optional, defaults to 10, maximum is 20
					'count' => 18,
					// optional, defaults to 33
					'column' => 33
				));
				
			?>
		</div>

<?php section('footer') ?>