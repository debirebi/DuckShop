<?php
require( __DIR__ . "/../persistence/aboutUsDAO.php" );
require( __DIR__ . "/../includes/functions.php" );

$action = $_GET["action"];

if ($action == "updateAboutUs")
{
    $ID = $_GET["WebShopID"];
    $DescOfCompany = $_GET["DescOfCompany"];
    $ShortIntroduction = $_GET["ShortIntroduction"];
    $WebShopName = $_GET["WebShopName"];
    $StoreUrl = $_GET["StoreUrl"];
    updateWebShopInfo($ID, $DescOfCompany, $ShortIntroduction, $WebShopName, $StoreUrl);
    redirect_to('../presentation/main.php');
} else

if ($action == "updateContactInfo")
{
    $ContactInfoID = $_GET["ContactInfoID"];
    $AddressID = $_GET["AddressID"];
    $Email = $_GET["Email"];
    $PhoneNumber = $_GET["PhoneNumber"];
    $PostalCodeID = $_GET["PostalCodeID"];
    $Country = $_GET["Country"];
    $StreetName = $_GET["StreetName"];
    $HouseNumber = $_GET["HouseNumber"];
    $PostalCode = $_GET["PostalCode"];
    $City = $_GET["Country"];

    updateContactInfo($ContactInfoID, $AddressID, $Email, $PhoneNumber, $PostalCodeID, $Country, $StreetName, $HouseNumber, $PostalCode, $City);
    redirect_to('../presentation/main.php');
}
