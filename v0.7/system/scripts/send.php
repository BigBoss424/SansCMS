<?php
	
	// validate whether 'antibot' is intact, and validate email address
	if ($_POST['antibot'] == 'antibot' && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				
		// required details
		$recipient = 'name@example.com'; // replace with your email address
		$subject = 'Let’s connect!'; // fallback, used if no subject input is present in form
		
		if ($_POST['name']) {
			$headers = 'From: ' . $recipient . "\r\n" .
				'Reply-To: ' . stripcslashes($_POST['name']) . ' <' . $_POST['email'] . '>';
		} else {
			$headers = 'From: ' . $recipient . "\r\n" .
				'Reply-To: ' . $_POST['email'];
		}
		
		// loop through $_POST array
		foreach ($_POST as $key => $value) {
		
			// if input has value, then insert into email (unless input is antibot, name or email)
			if (!preg_match('/(subject|antibot|name|email|message)/', $key) && $value) {
				$body .= ucfirst($key) . ": " . stripslashes($value) . "\r\n";
			}
			
			// if there's a subject input, then use that as the email subject
			if (preg_match('/subject/', $key)) {
				$subject = stripslashes($value);
			}
			
			// if input is message, then insert into message without label
			if (preg_match('/message/', $key)) {
				$body .= stripslashes($value) . "\r\n";
			}
		}
		
		// send email
		if (mail($recipient, $subject, $body, $headers)) {
			header('Location: ../../contact?state=success');
		} else {
			header('Location: ../../contact?state=error');
		}
	
	} else {
		header('Location: ../../contact?state=error');
	}

?>