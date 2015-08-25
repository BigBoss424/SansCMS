<?php require_once('config.php') ?>

	<div class="section">
		<div class="wrapper narrow">
			<div class="column-100">
				<h1>Let’s connect!</h1>
				<p>Open <code>/system/scripts/send.php</code> in your code editor of choice and add your email address to get the form up and running. Open <code>/contact.php</code> to modify the form itself.</p>
				
				<noscript>
					<p class="error">Email can’t be sent when JavaScript is turned off.</p>
				</noscript>
			
				<?php $state = $_GET['state']; if ($state == 'success') { ?>
				
					<p class="success">Your message has been sent.</p>
				
				<?php } else if ($state == 'error') { ?>
				
					<p class="error">Something went wrong and your message has not been sent. <a href="<?php echo HTTP ?>contact">Try again &#8594;</a></p>
				
				<?php } else { ?>
				
					<form id="contact" action="javascript:void(0);" method="post" onsubmit="return validate(this);" novalidate>
					
						<input style="display: none;" type="text" name="antibot" class="required antibot" value="antibot" />
						
						<div class="float-label">
							<input type="text" name="name" class="required" placeholder="Name" />
							<label>Name</label>
						</div>
						
						<div class="float-label">
							<input type="email" name="email" class="required" placeholder="Email" />
							<label>Email</label>
						</div>
						
						<div class="float-label">
							<span class="drop-down"></span>
							<select name="select" class="required">
								<option selected>First Option</option>
								<option>Second Option</option>
								<option>Third Option</option>
							</select>
						</div>
						
						<div class="float-label">
							<textarea name="message" class="required" placeholder="Message"></textarea>
							<label>Message</label>
						</div>
						
						<button type="submit">Send Message</button>
						
					</form>
				
				<?php } ?>
			</div>
		</div>
	</div>

<?php section('footer') ?>