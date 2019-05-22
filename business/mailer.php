<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../includes/phpMailer/src/PHPMailer.php';
require '../includes/phpMailer/src/Exception.php';
require '../includes/phpMailer/src/SMTP.php';

function sendInvoiceMail($emailTo, $NameOfUser, $Price)
{
    try {

        $mail = new PHPMailer(true); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = 'duckshopproject@gmail.com';
        $mail->Password = 'kacsakacsa';
        $mail->Sender = 'no-reply@duckshop.dk';
        $mail->setFrom('googleReplacesThisAnyway@gmail.com', 'DuckWebShop');

        $mail->Subject = 'Order Confirmation';
        $mail->Body = "<h4>Thank you for your order on DuckWebShop!</h4>
                       <h4>". $NameOfUser. "</h4>
                       <h5>Your order has been processed and it will be dispatched to your registered address within the system, as soon as possible!.</h5>
                       <br>
                       <p>In the meantime you should keep an eye on our site! You can never know when we add more, exciting rubber ducks! </p>
                       <br>
                        <a href='http://localhost/DuckShop/presentation/main.php'>DuckWbShop</a>
                       <p>The full price of your Order comes to:</p>
                       <h4>". $Price ." DKK</h4>
                       <p> You can review your order on the site under the User Page!</p>
                       "; //Ide köll megírnunk az emailt
        $mail->AltBody = 'HTML messaging not supported';
        $mail->addAddress($emailTo, $NameOfUser);
        $mail->send();
    }
    catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

function sendContactEmail($name, $email, $Subject, $MailText)
{
    try {
        $name=strtoupper($name);
        $mail = new PHPMailer(true); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->addEmbeddedImage(dirname(__DIR__) . '../includes/images/DuckLandLogo.png','1001','DuckLandLogo.png');
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = 'duckshopproject@gmail.com';
        $mail->Password = 'kacsakacsa';
        $mail->setFrom('googleReplacesThis@gmail.com', $name);

        $mail->Subject = $Subject;
        $mail->Body = " <img src='cid:1001'> 
 <img src=\"cid:1001\" width=\"182\" height=\"75\">
                        <h3>Contact email from:</h3>
                        <p>$name</p> 
                        <p>Email address: $email</p><br>
                        <br>
                        <p> $MailText</p>
                      ";
        $mail->AltBody = 'HTML messaging not supported';
        $mail->addAddress('duckshopproject@gmail.com', $name);
        $mail->send();
    }
    catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}
function sendThanksForFeedback($emailTo, $NameOfUser)
{
    try {

        $mail = new PHPMailer(true); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = 'duckshopproject@gmail.com';
        $mail->Password = 'kacsakacsa';
        $mail->Sender = 'no-reply@duckshop.dk';
        $mail->setFrom('googleReplacesThis@gmail.com', 'DuckWebShop');

        $mail->Subject = 'Thank you for you feedback!';
        $mail->Body = "<div>
<p> Thank you for your contact letter! </p>

<p> Our colleagues will reply soon! Until then with the link below you can head back to DuckLand and check out what's new.</p>

<a href='http://localhost/DuckShop/presentation/main.php'>DuckWbShop</a>


</div>";
        $mail->AltBody = 'HTML messaging not supported';
        $mail->addAddress($emailTo, $NameOfUser);
        $mail->send();
    }
    catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

function sendNewUser($emailTo, $NameOfUser)
{
    try {

        $mail = new PHPMailer(true); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = 'duckshopproject@gmail.com';
        $mail->Password = 'kacsakacsa';
        $mail->Sender = 'no-reply@duckshop.dk';
        $mail->setFrom('googleReplacesThis@gmail.com', 'DuckWebShop');

        $mail->Subject = 'Welcome at DuckLand';
        $mail->Body = "<div>
<p> Thank you for your registration on DuckLand  </p>

<p> Noww head back and check out our special duck collection </p>

<a href='http://localhost/DuckShop/presentation/main.php'>DuckWbShop </a>


</div>";
        $mail->AltBody = 'HTML messaging not supported';
        $mail->addAddress($emailTo, $NameOfUser);
        $mail->send();
    }
    catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}