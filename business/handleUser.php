<?php
require_once( __DIR__ . "/../persistence/UserDAO.php" );
require_once( __DIR__ . "/../includes/functions.php" );
require_once( __DIR__ . "/mailer.php" );

$action = $_GET["action"];

if ($action == "login")
 {
     $email = $_GET['email'];
     $password = $_GET['pass'];
     login($email, $password);
 }

else if ($action == "delete")
{
    $UserID = $_GET["UserID"];
    deleteUser($UserID);
}

else if ($action == "create")
{

    $Email = $_GET["email"];
    $Password = $_GET["password"];
    $FirstName = $_GET ["firstName"];
    $LastName = $_GET["lastName"];
    $Birthday = $_GET["birthday"];
    $Country = $_GET["country"];
    $Street = $_GET["street"];
    $hnumber =$_GET["hnumber"];
    $City = $_GET["city"];
    $PostalCode = $_GET["postalCode"];

    $iterations= ['cost' => 15];
    $hashed_password = password_hash($Password, PASSWORD_BCRYPT, $iterations);

    createUser( $Email, $hashed_password, $FirstName, $LastName, $Birthday, $Country, $Street, $hnumber, $City, $PostalCode );
    sendNewUser($Email, ($FirstName. ' ' .$LastName));
    redirect_to('../presentation/main.php');

}
else if ($action == "update")
{
    $Email = $_GET["email"];
    $Password = $_GET["password"];

    $iterations= ['cost' => 15];
    $hashed_password = password_hash($Password, PASSWORD_BCRYPT, $iterations);

    updateUser($hashed_password, $Email);
    redirect_to('../user/logout.php');

}
//($PostalCode, $City, $Country, $StreetName, $HouseNumb)

else if ($action == "updateUserAddress")
{
    $PostalCode = $_GET["postalCode"];
    $City = $_GET["city"];
    $HouseNumber = $_GET["houseNumber"];
    $StreetName = $_GET["streetName"];
    $Country = $_GET["country"];

    updateUserAddress($PostalCode, $City, $Country, $StreetName, $HouseNumber);
    redirect_to('../presentation/main.php');

}
