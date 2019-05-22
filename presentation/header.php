<?php include_once '../includes/session.php';
if(!isset($_SESSION['IsAdmin']))
{
    $_SESSION['IsAdmin'] = 0;
}
?>

<html>
<style>
    <?php include_once '../includes/css/header.css'; ?>
</style>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DuckWebShop</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
</head>

<div class="bacgroundpic">
    <div class="topmenu" >
        <?php
        getAdminPageButton();
        getUserPageButton();
        ?>
        <a href="../user/newuser.php" class="newuser">CREATE NEW USER</a>
        <a href="../user/logout.php" class="logout">LOGOUT</a>
        <a  href="../user/login.php" class="login">LOGIN</a>

    </div>
    <br><br>
<div class="centered">
       <img class="logo" src="../includes/images/DuckLandLogo.png" >
</div>
<br><br><br>
    <div class="centered">
        <div class="menu" >
            <a href="../presentation/main.php" class="menubutton">Home</a>
            <a href="../presentation/products.php" class="menubutton">Products</a>
            <a href="../presentation/shoppingCart.php" class="menubutton">Shopping Cart</a>
            <a href="../presentation/aboutUs.php" class="menubutton">About us</a>
            <a href="../presentation/contact.php" class="menubutton">Contact</a>



        </div>

    </div>
</div>
<?php
if (!empty($message)){echo "<p>". $message."<p>";}
?>

</html>