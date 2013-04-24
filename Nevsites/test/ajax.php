<?php

if ( ! empty($_POST['contact']))
{
	$valid = array
	(
		'name'    => array('/^[\w\d\._\-]+$/iD', 'Your name isn\'t filled out correctly.'),
		'email'   => array('/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD', 'You must provide a valid email.'),
		'message' => array('/(.+){10,}/', 'You can\'t send a blank message.'),
	);
	
	$errors = array();
	
	foreach ($valid as $field => $data)
	{
		$regex = $data[0];
		$message = $data[1];
		
		$input = trim($_POST[$field]);
		
		if (empty($input) OR ! preg_match($regex, $input))
		{
			$errors += array($field => $message);
		}
	}
	
	$result = empty($errors) ? 'success' : 'errors';
	
	echo json_encode(array
	(
		'result' => $result,
		'errors' => $errors,
	));
	exit;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Corey Worrell - Ajax Contact Form Demo</title>
	<style type="text/css">
		html, body, h1, h2, h3, h4, h5, h6, p, span, ul, li, div, form, input, select, textarea, button {margin:0; padding:0;}
		ul {list-style:none;}
		a, a:hover {text-decoration:none; outline:0;}
		a img {border:0;}
		
		body {font:12px/16px Verdana, Arial, sans-serif; background:#001F1E;}
		#container {width:400px; margin:10px auto; padding:10px; overflow:hidden; border:1px solid #000; border-radius:10px; -moz-border-radius:10px; -webkit-border-radius:10px; background:#F9F9F9;}
		#container h1 {margin-bottom:20px; font-size:40px; line-height:40px; font-family:'HelveticaNeue-Light', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight:normal;}
		div.message {margin-bottom:10px; padding:5px;}
		div.success {color:#4F8A10; border:1px solid #4F8A10; background:#DFF2BF;}
		div.error {color:#D8000C; border:1px solid #D8000C; background:#FFBABA;}
		span.error {display:block; text-align:right; color:#C00;}
		label {display:block; margin-bottom:3px; cursor:pointer;}
		.input, textarea, select, button {display:block; width:390px; margin-bottom:10px; padding:3px; font:22px/22px 'HelveticaNeue-Light', 'Helvetica Neue', Helvetica, Arial, sans-serif; border:1px solid #CCC; border-top-width:2px;}
		#form textarea.input {font-size:13px; line-height:16px;}
		select {width:396px;}
		input.error, textarea.error {border:1px solid #C00; border-top-width:2px;}
		button {float:right; width:auto; margin-bottom:0; padding:3px 30px; cursor:pointer; font-size:16px; border:1px solid #999; border-bottom-width:2px; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; background:#EEE;}
		button:active {border-bottom-width:1px; padding:4px 30px 3px; background:#E9E9E9;}
	</style>
</head>
<body>

	<div id="container">
	
		<h1>Ajax Contact Form</h1>
		
		<div id="form">
			<form id="contact" method="post" action="">
				<label for="name">Your Name:</label>
				<input type="text" name="name" id="name" class="input" />
				
				<label for="email">Your Email:</label>
				<input type="text" name="email" id="email" class="input" />
				
				<label for="message">Message:</label>
				<textarea name="message" id="message" rows="4" cols="40" class="input"></textarea>
				
				<input type="hidden" name="contact" value="1" />
				
				<p><button type="submit">Submit!</button></p>
			</form>
		</div>
	
	</div>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script type="text/javascript">
		/**
		 * Just a simple function to enable / disable our submit button
		 * It lets the user know we're working on the request, and something is actually happening.
		 */
		(function() {
			$.fn.toggleButton = function() {
				var $this = $(this),
					disabled = $this.attr('disabled');
					
				( ! disabled) ? $this.html('Submitting...').attr('disabled', 'disabled')
							  : $this.html('Send!').attr('disabled', '');
					
				return this;
			}
		})();
		
		// Shortcut to $(document).ready()
		$(function() {
			
			// Attach function to the 'submit' event of the form
			$('#contact').submit(function() {
				var self = $(this), 		 // Caches the $(this) object for speed improvements
					post = self.serialize(); // Amazing function that gathers all the form fields data
											 // and makes it usable for the PHP
				
				// Disable the submit button
				self.find('button').toggleButton();
				
				// Send our Ajax Request with the serialized form data
				$.post('index.php', post, function(data) {
					// Since we returned a Json encoded string, we need to eval it to work correctly
					var data = eval('(' + data + ')');
					
					// If everything validated and went ok
					if (data.result == 'success') {
						// Fade out the form and add success message
						$('#contact').fadeOut(function() {
							$(this).remove();
							$('<div class="message success"><h4>Thanks for your email!</h4></div>')
								.hide()
								.appendTo($('#form'))
								.fadeIn();
						});
					}
					else {
						// Hide any errors from previous submits
						$('span.error').remove();
						$(':input.error').removeClass('error');
						
						// Re-enable the submit button
						$('#contact').find('button').toggleButton();
						
						// Loop through the errors, and add class and message to each field
						$.each(data.errors, function(field, message) {
							$('#' + field).addClass('error').after('<span class="error">' + message + '</span>');
						});
					}
				});
				
				// Don't let the form re-load the page as would normally happen
				return false;
			});
			
		});
	</script>

</body>
</html>