<?php
function mailContoller($mail_to, $mail_from, $mail_subject, $mail_body){
	$mail_date = "The Email was sent on ". date("l") . " " . date("d.m.Y") . " at " . date("h:i:sa") . "<br>"; //Default setting if not overwritten.
	$mail_content = "
		<html>
			<head>
				<title>New Contact Request</title>
			</head>
			<body>
				<b>$mail_date</b>
				<p>
					$mail_body
				</p>
			</body>
		</html>
		";
	$mail_header  = "MIME-Version: 1.0\r\n";
	$mail_header .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$mail_header .= "From: $mail_from\r\n";
	$mail_header .= "Reply-To: $mail_from\r\n";
	// $mail_header .= "Cc: $cc\r\n";  // falls an CC gesendet werden soll
	$mail_header .= "X-Mailer: PHP ". phpversion();
	
	mail($mail_to, $mail_subject, $mail_content, $mail_header);
}