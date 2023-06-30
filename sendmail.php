<?php

$email = $_POST['email'];
$fullname = $_POST['fullname'];
$subject = $_POST['subject'];
$comments = $_POST['comments'];
$phone = $_POST['phone'];

require_once("class.phpmailer.php");

$message = "The following e-mail was sent by $fullname | $email | $phone \n$comments";



require_once("class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SetLanguage('en');
$mail->Port = 587;
$mail->Host = "gmail.google.com";
$mail->SMTPAuth = true;
$mail->Username = "login@gmail.com";
$mail->Password = "password";
$mail->From = "from@gmail.com";
$mail->Fromname = "logo";
$mail->AddAddress($recipientEmail,"Mail Sending");
$mail->Subject = $subject;
$mail->Body = $message;

if(!$mail->Send())
{
    echo '<div class="alert alert-danger">There was an error with sending an e-mail, try again later</div>'; 
    exit;
}

	

?>

