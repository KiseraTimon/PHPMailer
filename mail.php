<?php
//Session start
session_start();

// Fetching from session
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$uname = $_SESSION['uname'];
$email = $_SESSION['email'];
$vcode = $_SESSION['vcode'];
$senderemail = $_SESSION['senderemail'];
$senderpassword = $_SESSION['senderpassword'];

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $senderemail;                     //SMTP username
    $mail->Password   = $senderpassword;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($email, $fname.' '.$lname);
    $mail->addAddress($email, $uname);     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Welcome to our team';
    $mail->Body    = 'You have successfully registered as one of our company members<br>
    We are looking forward to working with you<br>
    Your verification code is:<br>
    <h1> '.$vcode.' </h1>';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo '
    <script>
        alert("Message has been sent");
        window.location.href = "../../Pages/verify.php";
    </script>
    ';
} catch (Exception $e) {
    echo '
    <script>
        alert("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        window.location.href = "../../Pages/verify.php";
    </script>
    ';
}