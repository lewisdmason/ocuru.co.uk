<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "vendor/autoload.php";




function MailSelf($consultation, $request_email, $name = '', $message = '')
{
	$loader = new Twig_Loader_Filesystem('twig');
	$twig = new Twig_Environment($loader, [
	    'cache' => false,
	]);

	$mail = new PHPMailer\PHPMailer\PHPMailer();
	$mail->SMTPDebug = 0;                               
	$mail->isSMTP();            
	$mail->Host = "#";
	$mail->SMTPAuth = true;                          
	$mail->Username = "#";                 
	$mail->Password = "#";                           
	//If SMTP requires TLS encryption then set it
	$mail->SMTPSecure = "tls";                           
	//Set TCP port to connect to 
	$mail->Port = 587;                                   

	$mail->From = '#';
	$mail->FromName = "Website Form";
	$mail->addAddress("support@ocuru.co.uk", "Support - Ocuru");
	$mail->addReplyTo($request_email, "Reply");
	$mail->isHTML(true);

	if($consultation)
	{
		$mail->Subject = "Consultation Requested";
		$mail->Body = $twig->render('selfNotification.twig', ['consultation' => true, 'request_email' => $request_email]);
		$mail->AltBody = `Consultation requested from {$request_email}`;
	}else{
		$mail->Subject = "General Query";
		$mail->Body = $twig->render('selfNotification.twig', ['consultation' => false,'request_email' => $request_email, 'name' => $name, 'message' => $message]);
		$mail->AltBody = `General Query from {$request_email}`;
	}

	if(!$mail->send()) 
	{
	    // echo "Mailer Error: " . $mail->ErrorInfo;
	    return json_encode(array('error' => true));
	} 
	else 
	{
	    return json_encode(array('error' => false));
	}
}


if(isset($_POST['consultation']) && isset($_POST['request_email']))
{
	echo MailSelf(true, $_POST['request_email']);
}else if(!isset($_POST['consultation']) && isset($_POST['name']) && isset($_POST['request_email']) && isset($_POST['message']))
{
	echo MailSelf(false, $_POST['request_email'], $_POST['name'], $_POST['message']);
}else{
	echo json_encode(array('error' => true));
}