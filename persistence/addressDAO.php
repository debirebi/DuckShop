<?php
require_once( __DIR__ . '/../includes/db/connection.php' );

function getAddress($AddressID)
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( "SELECT * FROM Address WHERE AddressID = $AddressID");
        $handle->execute();

        $result = $handle->fetch( \PDO::FETCH_OBJ );

        return $result;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

// Create a new Address (using Prepared Statements)
function createAddress($Country, $StreetName, $HouseNumber, $PostalCodeID)
{
    try
    {
        $cxn = connectToDB();
        $statement = "INSERT INTO PostalCode (Country, StreetName, HouseNumb, PostalCodeID) VALUES (:Country,:StreetName, :HouseNumb, :PostalCodeID)";

        var_dump($statement);
        $handle = $cxn->prepare($statement);
        $handle->bindParam(':HouseNumb', $HouseNumber);
        $handle->bindParam(':Country', $Country);
        $handle->bindParam(':StreetName', $StreetName);
        $handle->bindParam(':PostalCodeID', $PostalCodeID);
        $statement = "INSERT INTO Address (Country, StreetName, HouseNumb, PostalCodeID) VALUES (:Country,:StreetName, :HouseNumb, :PostalCodeID)";

        var_dump($statement);
        $handle = $cxn->prepare($statement);
        $handle->bindParam(':HouseNumb', $HouseNumber);
        $handle->bindParam(':Country', $Country);
        $handle->bindParam(':StreetName', $StreetName);
        $handle->bindParam(':PostalCodeID', $PostalCodeID);
        $handle->execute();

        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function readAddress()
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( 'SELECT * FROM Address ORDER BY AddressID DESC' );
        $handle->execute();
        $result = $handle->fetchAll( \PDO::FETCH_OBJ );

        foreach ( $result as $row ) {
            print( AddressTemplate($row) );
        }
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function updateAddress($AddressID,  $Country, $StreetName, $HouseNumber)
{
    try
    {
        $cxn = ConnectToDB();

        $statement = "UPDATE Address SET Country = :Country, StreetName = :StreetName, HouseNumb = :HouseNumb WHERE AddressID = :AddressID";
        $handle = $cxn->prepare( $statement );
        $handle->bindParam(':HouseNumb', $HouseNumber);
        $handle->bindParam(':Country', $Country);
        $handle->bindParam(':StreetName', $StreetName);
        $handle->bindParam(':AddressID', $AddressID);
        $handle->execute();

        //close the connection
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function deleteAddress($AddressID)
{
    try
    {
        $cxn = ConnectToDB();

        $statement = "DELETE FROM Address WHERE AddressID = :AddressID";
        $handle = $cxn->prepare( $statement );
        $handle ->bindParam(':AddressID', $AddressID);
        $handle->execute();

        //close the connection
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

// Utility function to provide some basic styling for a Address
function AddressTemplate($row)
{

}
