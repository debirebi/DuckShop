<?php
require_once( __DIR__ . '/../includes/db/connection.php' );
require ("../includes/functions.php");
require_once ("../persistence/addressDAO.php");
require_once ("../includes/session.php");


function getUser($UserID)
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( "SELECT * FROM Usertbl WHERE UserID = $UserID");
        $handle->execute();
        $result = $handle->fetch( \PDO::FETCH_OBJ );

        print $result;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function login($email, $password)
{
    try {
        $cxn = connectToDB();

        $statement= "SELECT * FROM Usertbl WHERE Email = :email";
        $handle = $cxn->prepare($statement);
        $handle->bindParam(':email', $email);
        $handle->execute();
        $result = $handle->fetch( \PDO::FETCH_OBJ );

        if(password_verify($password,$result->PassHASH)){
            $shoppingCart =  array();
            $_SESSION['userID'] = $result->UserID;
            $_SESSION['addressID']= $result->AddressID;
            $_SESSION['IsAdmin']= $result->IsAdmin;
            $_SESSION['userEmail']= $result->Email;
            $_SESSION['user'] =$result->FirstName;
            $_SESSION['shoppingCart'] =$shoppingCart;
            redirect_to('../presentation/main.php');
        }
        redirect_to('../user/login.php');

         $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function createUser ( $Email, $PassHASH, $FirstName, $LastName, $BirthDate, $Country, $Street, $hnumber, $City, $PostalCode )
{
    try
    {
        $cxn = connectToDB();

        $statement = "INSERT INTO PostalCode(PostalCode, City)
                      VALUES (:PostalCode, :City)";
        $handle = $cxn->prepare( $statement);
        $handle->bindParam(':PostalCode', $PostalCode);
        $handle->bindParam(':City', $City);
        $handle->execute();

        $lastInsert = $cxn->lastInsertId();

        $statement = "INSERT INTO Address ( PostalCodeID, Country, StreetName, HouseNumb)
                      VALUES ($lastInsert,:Country, :StreetName, :HouseNumb)";

        $handle = $cxn->prepare( $statement);
        $handle->bindParam(':Country', $Country);
        $handle->bindParam(':StreetName', $Street);
        $handle->bindParam(':HouseNumb', $hnumber);
        $handle->execute();

        $lastInsert = $cxn->lastInsertId();

        $statement = "INSERT INTO Usertbl ( AddressID, IsAdmin, Email, PassHASH, FirstName, LastName, BirthDate) 
                      VALUES ($lastInsert, 0, :Email, :PassHash, :FirstName, :LastName, :BirthDate)";

        $handle = $cxn->prepare( $statement);
        $handle->bindParam(':Email', $Email);
        $handle->bindParam(':PassHash', $PassHASH);
        $handle->bindParam(':FirstName', $FirstName);
        $handle->bindParam(':LastName', $LastName);
        $handle->bindParam(':BirthName', $BirthDate);
        $handle->execute();
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function getUserAddress ()
{
    try
    {
        $cxn = connectToDB();
        $AddressID = getAddressID();

        $statement = "SELECT * FROM Address WHERE AddressID = $AddressID";
        $handle = $cxn->prepare($statement);
        $handle->execute();
        $resultAddress = $handle->fetch( \PDO::FETCH_OBJ );

        $statement = "SELECT * FROM PostalCode WHERE PostalCodeID = '{$resultAddress -> PostalCodeID}'";
        $handle = $cxn->prepare($statement);
        $handle->execute();
        $resultPostalCode = $handle->fetch( \PDO::FETCH_OBJ );


        print addressForm($resultAddress, $resultPostalCode);
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}



function readUsers()
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( 'SELECT * FROM Usertbl ORDER BY UserID DESC' );
        $handle->execute();

        $result = $handle->fetchAll( \PDO::FETCH_OBJ );

        foreach ( $result as $row ) {
            print( UserTemplate($row) );
        }
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function getUpdateFormUser() {
    try {
        $cxn = connectToDB();
        $userID = getUserID();

        $handle = $cxn->prepare( "SELECT * FROM Usertbl WHERE UserID = $userID");
        $handle->execute();

        $result = $handle->fetch( \PDO::FETCH_OBJ );

            print( UserUpdateForm($result));

    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function getUpdateFormUserAddress() {
    try {
        $cxn = connectToDB();

        $addressID = getAddressID();

        $handle = $cxn->prepare( "SELECT * FROM Address WHERE AddressID = $addressID");
        $handle->execute();

        $resultAddress = $handle->fetch( \PDO::FETCH_OBJ );

        $handle = $cxn->prepare( "SELECT * FROM PostalCode WHERE PostalCodeID = $resultAddress->PostalCodeID");
        $handle->execute();

        $resultPostalCode = $handle->fetch( \PDO::FETCH_OBJ );

            print( UserAddressUpdateForm($resultAddress, $resultPostalCode));

    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function updateUser ($PassHash, $Email)
{
    try
    {
        $cxn = ConnectToDB();
        $userID = getUserID();
        $statement = "UPDATE Usertbl SET Email = :Email, PassHASH = :PassHash WHERE UserID = :UserID";
        $handle = $cxn->prepare( $statement );
        $handle->bindParam(':Email', $Email);
        $handle->bindParam(':PassHash', $PassHash);
        $handle->bindParam(':UserID', $userID);
        $handle->execute();

        //close the connection
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function updateUserAddress ($PostalCode, $City, $Country, $StreetName, $HouseNumb)
{
    try
    {
        $cxn = ConnectToDB();
        $userID = getUserID();

        $statement = "SELECT * FROM Usertbl WHERE UserID = $userID";

        $handle = $cxn->prepare($statement);
        $handle->execute();
        $resultUser = $handle->fetch( \PDO::FETCH_OBJ );

        $statement = "SELECT * FROM Address WHERE AddressID = $resultUser->AddressID";

        $handle = $cxn->prepare($statement);
        $handle->execute();
        $resultAddress = $handle->fetch( \PDO::FETCH_OBJ );

        $statement = "UPDATE PostalCode SET PostalCode = :PostalCode, City = :City WHERE PostalCodeID = $resultAddress->PostalCodeID";
        $handle = $cxn->prepare( $statement );
        $handle->bindParam(':PostalCode', $PostalCode);
        $handle->bindParam(':City', $City);
        $handle->execute();

        $statement = "UPDATE Address SET Country = :Country, StreetName = :StreetName, HouseNumb = :HouseNumb WHERE AddressID = $resultUser->AddressID";
        $handle = $cxn->prepare( $statement );
        $handle->bindParam(':HouseNumb', $HouseNumb);
        $handle->bindParam(':Country', $Country);
        $handle->bindParam(':StreetName', $StreetName);
        $handle->execute();

        //close the connection
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function deleteUser($UserID)
{
    try {
        $cxn = ConnectToDB();

        $statement = "DELETE FROM Usertbl WHERE UserID = " . $UserID;
        $handle = $cxn->prepare($statement);
        $handle->execute();

        //close the connection
        $cxn = null;
    } catch (\PDOException $ex) {
        print($ex->getMessage());
    }
}

function addressForm($resultAddress, $resultPostalCode) {
    return $template = "
    <form action='../business/handleOrder.php' method='get'>
        <input class='ProductID' type='text' name='Country' value='" . $resultAddress->Country. "' >
        <input class='ProductID' type='text' name='StreetName' value='" .  $resultAddress->StreetName. "' >
        <input class='ProductID' type='text' name='HouseNumber' value='" .  $resultAddress->HouseNumb. "' >
        <input class='ProductID' type='text' name='PostalCode' value='" .  $resultPostalCode->PostalCode. "' >
        <input class='ProductID' type='text' name='City' value='" .  $resultPostalCode->City. "' >
        <input class='ProductID' type='hidden' name='action' value='updateContactInfo' >
        <input type='submit' name='createNewsPost' value='Update ContacInfo' class='waves-effect waves-light btn edit'>
    </form>
    ";
}
function UserTemplate($row)
{
    return $template = "	
	<div>
	<div>
	  <input class='UserID' type=\"hidden\" name='UserID' id='UserID' value='" . $row->UserID . "' >
      
      <label>First Name:</label>
      <label class='FirstName'><strong>" . $row->FirstName. "</strong></label>
    </div>
    
    <label>Last Name:</label>
      <label class='LastName'><strong>" . $row->LastName. "</strong></label>
    </div>
    
    <div>
      <label>Email:</label>
      <label class='Email'>" . $row->Email. "</label>
    </div>
    <div>
    
      <label>Birth date:</label>
     <label class='BirthDate'> . $row->BirthDate.</label>
    </div>
    <br>
    <a class='waves-effect waves-light btn edit'>Edit</a>
    <a href='business/handleUser.php?action=delete&userID=" . $row->UserID . "' class='waves-effect waves-light btn edit'>Delete</a>
	<br><br><br><br>
	</div>

	";
}

function UserUpdateForm($result)
{
    return $template = "
    <form action='../business/handleUser.php' method='get'>
        <input class='ProductID' type='text' name='email' value='" . $result->Email. "' >
        <label>New Password:
        <input class='ProductID' type='password' name='password' value='' >
        </label>
        <input class='ProductID' type='hidden' name='action' value='update' >
        <input type='submit' name='createNewsPost' value='Update ContacInfo' class='waves-effect waves-light btn edit'>
    </form>";
}

function UserAddressUpdateForm($resultAddress, $resultPostalCode)
{
    return $template = "
    <form action='../business/handleUser.php' method='get'>
        <input class='ProductID' type='text' name='country' value='" . $resultAddress->Country. "' >
        <input class='ProductID' type='text' name='streetName' value='" . $resultAddress->StreetName. "' >
        <input class='ProductID' type='text' name='houseNumber' value='" . $resultAddress->HouseNumb. "' >
        <input class='ProductID' type='text' name='postalCode' value='" . $resultPostalCode->PostalCode. "' >
        <input class='ProductID' type='text' name='city' value='" . $resultPostalCode->City. "' >

        <input class='ProductID' type='hidden' name='action' value='updateUserAddress' >
        <input type='submit' name='createNewsPost' value='Update ContacInfo' class='waves-effect waves-light btn edit'>
    </form>";
}