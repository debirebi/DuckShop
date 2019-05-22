<?php
require_once ("../includes/functions.php");
require ("../business/mailer.php");

$action = $_GET["action"];

if ($action == "contact")
{
    $name = $_GET["name"];
    $email = $_GET["email"];
    $subject = $_GET["subject"];
    $mailText = $_GET["mailText"];
    sendContactEmail($name, $email, $subject, $mailText);
    sendThanksForFeedback($email,$name);
    redirect_to("../presentation/main.php");
}