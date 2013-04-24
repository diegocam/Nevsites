<?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $from = 'From: Nevsites'; 
    $to = 'camachojcd@gmail.com'; 
    $subject = 'New message from NEVSITES';
    $human = $_POST['human'];
			
    $body = "From: $name\n E-Mail: $email\n Message:\n $message";
    
        if ($_POST['submit'] && $human == '5') {				 
            if (mail ($to, $subject, $body, $from)) { 
                echo 'Your message has been sent!';
            } else { 
                echo 'Something went wrong, go back and try again!'; 
            } 
        } else if ($_POST['submit'] && $human != '5') {
            echo '<p>You answered the anti-spam question incorrectly!</p>';
        }
?>