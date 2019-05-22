<?php
require( __DIR__ . "/../persistence/ProductDAO.php" );
require_once ("../includes/functions.php");

$action = $_GET["action"];

if ($action == "create")
{
    $Category = $_GET["Category"];
    $Price = $_GET["Price"];
    $Size = $_GET["Size"];
    $Color = $_GET["Color"];
    $ProductName = $_GET["ProductName"];
    $ProdDescription = $_GET["ProdDescription"];
    $PictureURL = $_GET["PictureURL"];
    createProduct($Category, $Price, $Size, $Color, $ProductName, $ProdDescription, $PictureURL);
    redirect_to("../presentation/adminPage.php");
}
else if ($action == "edit")
{
    $ProductID = $_GET["ProductID"];
    $Category = $_GET["Category"];
    $Price = $_GET["Price"];
    $Size = $_GET["Size"];
    $Color = $_GET["Color"];
    $ProductName = $_GET["ProductName"];
    $ProdDescription = $_GET["ProdDescription"];
    $PictureURL = $_GET["PictureURL"];

    updateProduct($ProductID, $Category, $Price, $Size, $Color, $ProductName, $ProdDescription, $PictureURL);
    redirect_to("../presentation/adminPage.php");

}

else if ($action == "delete")
{
    $ProductID = $_GET["ProductID"];

    deleteProduct($ProductID);
    redirect_to("../presentation/adminPage.php");
}
else if ($action == "addToCart")
{
    $ProductID = $_GET["ProductID"];
    $Quantity = $_GET["Quantity"];
    $Price = $_GET["Price"];
    if (!isset($_SESSION['fullPrice']))
    {
        $_SESSION['fullPrice'] = $Price * $Quantity;
    } else
        $_SESSION['fullPrice'] = $_SESSION['fullPrice'] + ($Price * $Quantity);
    //Puts an array wtih name "id" and "quantity" into the shoppingCart array. Shopping cart is essentially an array of arrays
    $_SESSION['shoppingCart'][] = array("id"=>$ProductID, "quantity"=>$Quantity);
    redirect_to("../presentation/shoppingCart.php");
}
else if ($action == "removeFromCart")
{
    $ProductID = $_GET["ProductID"];
    foreach ($_SESSION['shoppingCart'] as $key => $value)
    {
        if ($value["id"] == $ProductID)
        {unset($_SESSION['shoppingCart'][$key]);}
    }
    redirect_to("../presentation/shoppingCart.php");
}
else if ($action == "setSpecial")
{
    $ProductName = $_GET["ProductName"];
    updateSpecialProduct($ProductName);
    redirect_to("../presentation/main.php");
}
else if ($action == "updateProduct")
{
    $ProductID = $_GET["ProductID"];
    $Category = $_GET["Category"];
    $Price = $_GET["Price"];
    $Size = $_GET["Size"];
    $Color = $_GET["Color"];
    $ProductName = $_GET["ProductName"];
    $ProdDescription = $_GET["ProdDescription"];
    $PictureURL = $_GET["PictureURL"];
    updateProduct($ProductID,$Category, $Price, $Size, $Color, $ProductName, $ProdDescription, $PictureURL);
    redirect_to("../presentation/adminPage.php");
}