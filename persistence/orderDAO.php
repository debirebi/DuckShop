<?php
require_once ("../includes/session.php");
require ("addressDAO.php");
require_once( __DIR__ . '/../includes/db/connection.php' );


function createOrder()
{
$cxn = connectToDB();
$userID = getUserID();
$addressID = getAddressID();
$shoppingCart = getShoppingCart();
$fullPrice = getFullPrice();
$currentDate = date("Y-m-d");
    $deliveryTime = date('Y-m-d', strtotime($currentDate. ' + 1 days'));

    $statement = "INSERT INTO Delivery (AddressID, DateOfDelivery) VALUES (:AddressID, :DateOfDelivery)";
    $handle = $cxn->prepare($statement);

    $handle->bindParam(':AddressID', $addressID);
    $handle->bindParam(':DateOfDelivery', $deliveryTime);
    $handle->execute();
    $deliveryID = $cxn->lastInsertId();

    $statement = "INSERT INTO Ordertbl (DeliveryID, UserID, DateOfOrder, FullPrice) VALUES ( :DeliveryID, :UserID, :DateOfOrder, :FullPrice)";
    $handle = $cxn->prepare($statement);

    $handle->bindParam(':DeliveryID', $deliveryID);
    $handle->bindParam(':UserID', $userID);
    $handle->bindParam(':DateOfOrder', $currentDate);
    $handle->bindParam(':FullPrice', $fullPrice);

    $handle->execute();
    $orderID = $cxn->lastInsertId();

foreach ($shoppingCart as $row)
{
    $productID = $row['id'];
    $quantity = $row['quantity'];

    $statement = "INSERT INTO OrderProduct (ProductID, OrderID, Quantity) VALUES (:ProductID, :OrderID, :Quantity)";
    $handle = $cxn->prepare($statement);

    $handle->bindParam(':ProductID', $productID);
    $handle->bindParam(':OrderID', $orderID);
    $handle->bindParam(':Quantity', $quantity);
    $handle->execute();
}

$cxn = null;
}

function readOrder()
{
    try {
        $cxn = connectToDB();
        //Get all the Orders from DB
        $handleOrder = $cxn->prepare( "SELECT * FROM Ordertbl ORDER BY OrderID DESC" );
        $handleOrder->execute();
        $resultOrder = $handleOrder->fetchAll( \PDO::FETCH_OBJ );

        foreach ($resultOrder as $row)
        {
            //Parameter binding should not matter here since all the data used in queries is already in the database so should sanitary
            $statement = "SELECT UserID, FirstName, LastName, Email FROM Usertbl WHERE UserID = '" . $row->UserID  . "'";
            $handleUser = $cxn->prepare($statement);
            $handleUser->execute();
            $resultUser = $handleUser->fetch( \PDO::FETCH_OBJ );

            $statement = "SELECT * FROM Delivery WHERE DeliveryID = '" . $row->DeliveryID  . "'";
            $handleUser = $cxn->prepare($statement);
            $handleUser->execute();
            $resultDelivery = $handleUser->fetch( \PDO::FETCH_OBJ );

            $statement = "SELECT * FROM Address WHERE AddressID = '" . $resultDelivery->AddressID  . "'";
            $handleUser = $cxn->prepare($statement);
            $handleUser->execute();
            $resultAddress = $handleUser->fetch( \PDO::FETCH_OBJ );

            $statement = "SELECT * FROM PostalCode WHERE PostalCodeID = '" . $resultAddress->PostalCodeID  . "'";
            $handleUser = $cxn->prepare($statement);
            $handleUser->execute();
            $resultPostalCode = $handleUser->fetch( \PDO::FETCH_OBJ );

            //Print the current order with the User
            print OrderTemplate($row, $resultUser, $resultDelivery, $resultAddress, $resultPostalCode);

            //Get all OrderProducts for the current Order
            $statementOrderProduct = "SELECT * FROM OrderProduct WHERE OrderID= '" . $row->OrderID  . "' ORDER BY OrderProductID DESC";
            $handleOrderProduct = $cxn->prepare($statementOrderProduct);
            $handleOrderProduct->execute();
            $resultOrderProduct = $handleOrderProduct->fetchAll( \PDO::FETCH_OBJ );
            echo "<h6>Ordered Items:</h6>";
            foreach ($resultOrderProduct as $orderProductRow)
            {
                $statementProduct = "SELECT * FROM Product WHERE ProductID= '" . $orderProductRow->ProductID  . "' LIMIT 1";
                $handleProduct = $cxn->prepare($statementProduct);
                $handleProduct->execute();
                $resultProduct = $handleProduct->fetchAll( \PDO::FETCH_OBJ );
                $foundProduct = array_values($resultProduct)[0];
                //Print each OrderProduct for the current Order with the product
                print OrderProductTemplate($foundProduct->ProductName, $orderProductRow->Quantity);
            }
            echo "
                  <h4>Full Price: ". $row->FullPrice ."</h4>
                  <br><br><br><br>
                    ";
        }
        $cxn = null;

    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function readOrderForUser()
{
    try {
        $cxn = connectToDB();
        $userID = getUserID();
        //Get all the Orders from DB
        $handleOrder = $cxn->prepare( "SELECT * FROM Ordertbl WHERE UserID = $userID ORDER BY OrderID DESC " );
        $handleOrder->execute();
        $resultOrder = $handleOrder->fetchAll( \PDO::FETCH_OBJ );

        foreach ($resultOrder as $row)
        {
            //Parameter binding should not matter here since all the data used in queries is already in the database so should sanitary
            $statement = "SELECT UserID, FirstName, LastName, Email FROM Usertbl WHERE UserID = '" . $row->UserID  . "'";
            $handleUser = $cxn->prepare($statement);
            $handleUser->execute();
            $resultUser = $handleUser->fetch( \PDO::FETCH_OBJ );

            $statement = "SELECT * FROM Delivery WHERE DeliveryID = '" . $row->DeliveryID  . "'";
            $handleUser = $cxn->prepare($statement);
            $handleUser->execute();
            $resultDelivery = $handleUser->fetch( \PDO::FETCH_OBJ );

            $statement = "SELECT * FROM Address WHERE AddressID = '" . $resultDelivery->AddressID  . "'";
            $handleUser = $cxn->prepare($statement);
            $handleUser->execute();
            $resultAddress = $handleUser->fetch( \PDO::FETCH_OBJ );

            $statement = "SELECT * FROM PostalCode WHERE PostalCodeID = '" . $resultAddress->PostalCodeID  . "'";
            $handleUser = $cxn->prepare($statement);
            $handleUser->execute();
            $resultPostalCode = $handleUser->fetch( \PDO::FETCH_OBJ );

            //Print the current order with the User
            print OrderTemplate($row, $resultUser, $resultDelivery, $resultAddress, $resultPostalCode);

            //Get all OrderProducts for the current Order
            $statementOrderProduct = "SELECT * FROM OrderProduct WHERE OrderID= '" . $row->OrderID  . "' ORDER BY OrderProductID DESC";
            $handleOrderProduct = $cxn->prepare($statementOrderProduct);
            $handleOrderProduct->execute();
            $resultOrderProduct = $handleOrderProduct->fetchAll( \PDO::FETCH_OBJ );
            echo "<h6>Ordered Products:</h6>";
            foreach ($resultOrderProduct as $orderProductRow)
            {
                $statementProduct = "SELECT * FROM Product WHERE ProductID= '" . $orderProductRow->ProductID  . "' LIMIT 1";
                $handleProduct = $cxn->prepare($statementProduct);
                $handleProduct->execute();
                $resultProduct = $handleProduct->fetchAll( \PDO::FETCH_OBJ );
                $foundProduct = array_values($resultProduct)[0];
                //Print each OrderProduct for the current Order with the product
                print OrderProductTemplate($foundProduct->ProductName, $orderProductRow->Quantity);
            }
            echo "
                  <h4>Full Price: ". $row->FullPrice ."</h4>
                  <br><br><br><br>
                    ";
        }
        $cxn = null;

    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function OrderTemplate($orderRow, $resultUser, $resultShipping, $resultAddress, $resultPostalCode)
{
        return $template =
            "
	        <h6>Order Details:</h6>
	        <label>Order ID:" . $orderRow->OrderID. "</label>
	        <br>
	        <label>Name of User:" . $resultUser->FirstName. "  " . $resultUser->LastName. "</label>
	        <br>
	        <label>Email address:" . $resultUser->Email. "</label>
	        <br>
	        <label>Expected arrival:" . $resultShipping->DateOfDelivery. "</label>
	        <br>
	        <h6>Shipping Address:</h6>
	        <label>Country:" . $resultAddress->Country. "</label>
	        <br>
	        <label>City:" . $resultPostalCode->City. "</label>
	        <br>
	        <label>PostalCode:" . $resultPostalCode->PostalCode. "</label>
	        <br>
	        <label>Street:" . $resultAddress->StreetName. "</label>
	        <br>
	        <label>House Number:" . $resultAddress->HouseNumb. "</label>
	        <br>
	        ";
}

function OrderProductTemplate($ProductName, $Quantity)
{
    return $template = "
	            <label class='ProductName'>Product name:$ProductName</label>
	            <label class='Quantity'>Quantity: <strong>$Quantity</strong></label>
	            <br>
	            ";
}