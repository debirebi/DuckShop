<?php
require( __DIR__ . "/../persistence/openingHoursDAO.php" );
require_once ("../includes/functions.php");

$action = $_GET["action"];


if ($action == "update")
{
    $OpeningHour = new OpeningHour($_GET["OpeningHourID"], $_GET["OpeningHour"], $_GET["Day"]);
    updateOpeningHour($OpeningHour);
    redirect_to('../presentation/aboutUs.php');
}