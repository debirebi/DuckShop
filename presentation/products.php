<?php require(__DIR__ . "/../persistence/ProductDAO.php"); ?>
<?php require( __DIR__ . "/header.php");?>


<html>
<header>
    <style>
        <?php include '../includes/css/products.css'; ?>
    </style>
</header>
<body>



<div class="pageContent">

    <br><br><br>

        <ul id='productList'>
            <?php readProduct(); ?>
        </ul>
    </div>



</body>
<footer class="page-footer orange lighten-2" style="clear: both">
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

