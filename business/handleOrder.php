<?php
require( __DIR__ . "/../persistence/OrderDAO.php" );
require_once ("../includes/functions.php");
require ("../business/mailer.php");

$action = $_GET["action"];

if ($action == "create")
{

    createOrder();
    sendInvoiceMail($_SESSION['userEmail'], $_SESSION['user'], $_SESSION['fullPrice']);
    $_SESSION['shoppingCart'] = array();
    $_SESSION['fullPrice'] = 0;
    redirect_to("../presentation/billpage.php");
}