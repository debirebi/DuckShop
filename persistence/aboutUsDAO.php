<?php
require_once( __DIR__ . '/../includes/db/connection.php' );
require_once ("../includes/session.php");

function getWebShopInfo($WebShopID)
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( "SELECT * FROM WebShop WHERE WebShopID = :WebShopID");
        $handle->bindParam(':WebShopID', $WebShopID);
        $handle->execute();
        $result = $handle->fetch( \PDO::FETCH_OBJ );

        $cxn = null;


        return $result;

    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}
function readWebShopInfo()
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( 'SELECT * FROM WebShop ORDER BY WebShopID DESC' );
        $handle->execute();
        $result = $handle->fetchAll( \PDO::FETCH_OBJ );

        foreach ( $result as $row ) {
            print( aboutUSTemplate($row) );
        }

        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function readContactInfo()
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( 'SELECT * FROM ContactInfo' );
        $handle->execute();
        $resultInfo = $handle->fetch( \PDO::FETCH_OBJ );

        $handle = $cxn->prepare( "SELECT * FROM Address WHERE AddressID = $resultInfo->AddressID" );
        $handle->execute();
        $resultAddress = $handle->fetch( \PDO::FETCH_OBJ );

        print( contactInfoTemplate($resultInfo, $resultAddress) );

        $cxn = null;

    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function getUpdateContactInfoForm() {
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( 'SELECT * FROM ContactInfo' );
        $handle->execute();
        $resultInfo = $handle->fetch( \PDO::FETCH_OBJ );

        $handle = $cxn->prepare( "SELECT * FROM Address WHERE AddressID = '{$resultInfo->AddressID}'" );
        $handle->execute();
        $resultAddress = $handle->fetch( \PDO::FETCH_OBJ );

        $handle = $cxn->prepare( "SELECT * FROM PostalCode WHERE PostalCodeID = '{$resultAddress->PostalCodeID}'" );
        $handle->execute();
        $resultPostalCode = $handle->fetch( \PDO::FETCH_OBJ );

        print( updateContactInfoFormTemplate($resultInfo, $resultAddress, $resultPostalCode) );

        $cxn = null;

    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function readShortWebInfo()
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( 'SELECT * FROM WebShop ORDER BY WebShopID DESC' );
        $handle->execute();
        $result = $handle->fetchAll( \PDO::FETCH_OBJ );

        foreach ( $result as $row ) {
            print( ShortIntroductionTemplate($row) );
        }

        $cxn = null;

    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}
function getUpdateAboutUsForm() {
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( "SELECT * FROM WebShop WHERE WebShopID = 1");
        $handle->execute();

        $result = $handle->fetch( \PDO::FETCH_OBJ );

        print( AboutUsUpdateForm($result));

        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}
function updateWebShopInfo($WebShopID, $DescOfCompany, $ShortIntroduction, $WebShopName, $StoreUrl)
{
    try
    {
        $cxn = ConnectToDB();

        $statement = "UPDATE WebShop SET 
        DescOfCompany = :DescofCompany,
         ShortIntroduction = :ShortIntroduction,
          WebShopName = :WebShopName,
           StoreURL = :StoreURL WHERE WebShopID = :WebShopID";
        $handle = $cxn->prepare( $statement );

        $handle->bindParam(':DescofCompany', $DescOfCompany);
        $handle->bindParam(':ShortIntroduction', $ShortIntroduction);
        $handle->bindParam(':WebShopName', $WebShopName);
        $handle->bindParam(':StoreURL', $StoreUrl);
        $handle->bindParam(':WebShopID', $WebShopID);

        $handle->execute();

        //close the connection
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function updateContactInfo($ContactInfoID, $AddressID, $Email, $PhoneNumber, $PostalCodeID, $Country, $StreetName, $HouseNumber, $PostalCode, $City)
{
    try
    {
        $cxn = ConnectToDB();
        $statement = "UPDATE PostalCode SET 
        PostalCode = :PostalCode,
         City = :City  WHERE PostalCodeID = :PostalCodeID";
        $handle = $cxn->prepare( $statement );
        $handle->bindParam(':PostalCode', $PostalCode);
        $handle->bindParam(':City', $City);
        $handle->bindParam(':PostalCodeID', $PostalCodeID);
        $handle->execute();

        $statement = "UPDATE Address SET 
         Country = :Country,
          StreetName = :StreetName,
            HouseNumb = :HouseNumber WHERE AddressID = :AddressID";
        $handle = $cxn->prepare( $statement );
        $handle->bindParam(':Country', $Country);
        $handle->bindParam(':StreetName', $StreetName);
        $handle->bindParam(':HouseNumber', $HouseNumber);
        $handle->bindParam(':AddressID', $AddressID);
        $handle->execute();

        $statement = "UPDATE ContactInfo SET 
        Email = :Email,
         PhoneNumber = :PhoneNumber
          WHERE ContactInfoID = :ConatactInfoID";
        $handle = $cxn->prepare( $statement );
        $handle->bindParam(':Email', $Email);
        $handle->bindParam(':PhoneNumber', $PhoneNumber);
        $handle->bindParam(':ConatactInfoID', $ContactInfoID);
        $handle->execute();

        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function aboutUSTemplate($row)
{
    return $template = "	
 
  
  <section>
  
  <h1>About us</h1>

  <div class=\"content\">
<p>" . $row->DescOfCompany. "</p> 
 </div>
  <div class=\"img\">
  <img class='storepic' src='$row->StoreURL'>
  
</section>
";

}
function ShortIntroductionTemplate($row)
{
    return $template = "	
	
  
<section>
  <h1>Welcome!</h1>
  <div class=\"content\">
<p>" . $row->ShortIntroduction. "</p> <a href='../presentation/products.php'>Let's check them!</a>
 </div>
  <div class=\"img\">
  <img class='storepic' src='$row->StoreURL'>
  
</section>
  
  
";

}

function AboutUsUpdateForm($row) {
    if(getIsAdmin() == true)
    {
        return $template = "
    
    
    <form action='../business/handleAboutUs.php' method='get'>
        <input class='ProductID' type='hidden' name='WebShopID' value='1' >
        <input class='ProductID' type='text' name='DescOfCompany' value='" . $row->DescOfCompany. "' >
        <input class='ProductID' type='text' name='ShortIntroduction' value='" . $row->ShortIntroduction. "' >
        <input class='ProductID' type='text' name='WebShopName' value='" . $row->WebShopName. "' >
        <input class='ProductID' type='text' name='StoreURL' value='" . $row->StoreURL. "' >
        <input class='ProductID' type='hidden' name='action' value='updateAboutUS' >
        <input type='submit' name='createNewsPost' value='Update Company information ' class='waves-effect waves-light btn edit'>
    </form>

    
    ";
}{
        return $template = "	

 <form action='../business/handleAboutUs.php' method='get'>
        <input class='ProductID' type='hidden' name='WebShopID' value='1' >
        <input class='ProductID' type='text' name='DescOfCompany' value='" . $row->DescOfCompany. "' >
        <input class='ProductID' type='text' name='ShortIntroduction' value='" . $row->ShortIntroduction. "' >
        <input class='ProductID' type='text' name='WebShopName' value='" . $row->WebShopName. "' >
        <input class='ProductID' type='text' name='StoreURL' value='" . $row->StoreURL. "' >
        <input class='ProductID' type='hidden' name='action' value='updateAboutUS' >
        <input type='submit' name='createNewsPost' value='Update NewsPost' class='waves-effect waves-light btn edit'>
    </form>
	
	";
    }
}

function contactInfoTemplate($resultInfo, $resultAddress) {
    return $template ="
     <div>
         
     <h6> Email: " . $resultInfo->Email. " </3>
     <h6> Phone: " . $resultInfo->PhoneNumber. " </h6>
     <h6> Address: " . $resultAddress->Country. " " . $resultAddress->StreetName. " " . $resultAddress->HouseNumb. " </h6>
     
     <a href='../presentation/contact.php'><h6>or use the Contact form to mail us </h6></a>
     <a href='../presentation/adminPage.php?updateContactInfo=1' class='waves-effect waves-light orange darken-2 white-text btn edit'>Edit</a>

     
     </div>   
    ";
}

function updateContactInfoFormTemplate($resultInfo, $resultAddress, $resultPostalCode) {
    return $template ="
    <form action='../business/handleAboutUs.php' method='get'>
        <input class='ProductID' type='hidden' name='ContactInfoID' value='1' >
        <input class='ProductID' type='hidden' name='AddressID' value='" . $resultInfo->AddressID. "' >
        <input class='ProductID' type='hidden' name='PostalCodeID' value='" . $resultPostalCode->PostalCodeID. "' >
        <input class='ProductID' type='text' name='Email' value='" . $resultInfo->Email. "' >
        <input class='ProductID' type='text' name='PhoneNumber' value='" . $resultInfo->PhoneNumber. "' >
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