<?php
require_once ("../includes/session.php");
require_once ("../includes/functions.php");
require(__DIR__ . "/../persistence/ProductDAO.php");
require(__DIR__ . "/../persistence/aboutUsDAO.php");
require( __DIR__ . "/header.php");
if(!logged_in()){
    redirect_to("../presentation/main.php");
}
?>
<!doctype>
<html>
<header>
    <style>
        <?php include '../includes/css/shoppingCart.css'; ?>
    </style>
</header>

<body>
<?php
if (!empty($_SESSION['shoppingCart']))
{
    echo "<div'>
          <p class='textline1'> Here is an overview about your shopping cart and the item(s) in it </p>
          <h2>Full Price: ".$_SESSION['fullPrice']."</h2>
          </div>";
}
;?>




<div class="pageContent" >

    <ul class="Cart">
        <?php
        if (!empty($_SESSION['shoppingCart']))
        {
            readShoppingCart();
            echo "<a href='../business/handleOrder.php?action=create' class='waves-effect waves-light orange darken-2 white-text btn edit'>Buy Items</a>";
        }
          else echo "<p class='ifEmptyText'>Your cart is empty so far, Click <a href=\"../presentation/products.php\">here</a> to browse our products.</p> ";
        ;?>
    </ul>
    <div> <?php
        if (getLastVisitedCategoryID() != 0)
        {
            getProductsYouMightLike();
        }
        ;?>
    </div>

    </div>





</body>
<br><br><br><br><br>
<footer class="page-footer orange lighten-2">
    <div class="container ">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Footer Content</h5>
                <p class="grey-text text-lighten-4">This page was made for back-end course as the 2nd semester project, 2019 </p>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Follow us on</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="https://www.facebook.com/">Facebook</a></li>
                    <li><a class="grey-text text-lighten-3" href="https://www.instagram.com/">Instagram</a></li>
                    <li><a class="grey-text text-lighten-3" href="https://twitter.com/?lang=en">Twitter</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2019 Copyright Text
        </div>
    </div>
</footer>
</html>

