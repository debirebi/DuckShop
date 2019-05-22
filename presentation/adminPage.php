<?php
require(__DIR__ . "/../persistence/productDAO.php");
require(__DIR__ . "/../persistence/orderDAO.php");
require(__DIR__ . "/../persistence/newsPostDAO.php");
require(__DIR__ . "/../persistence/aboutUsDAO.php");
require(__DIR__ . "/../persistence/openingHoursDAO.php");
require_once("../includes/functions.php");
require_once("../includes/session.php");
require( __DIR__ . "/header.php");

if (getIsAdmin() != true) {
    redirect_to('../presentation/main.php');
}
?>

<html>
<head>
    <style>
        <?php
         include '../includes/css/adminPage.css';
        ?>
    </style>
</head>
<body>
<div class="pageContent" >


    <h2>Admin page</h2>
    <button class="collapsible">Add new product</button>
    <div class="content">

        <form action='../business/handleProduct.php' method='get'>
            <input class='ProductID' type='text' name='Category' value='Category' >
            <input class='ProductID' type='text' name='Price' value='Price' >
            <input class='ProductID' type='text' name='Size' value='Size' >
            <input class='ProductID' type='text' name='Color' value='Color' >
            <input class='ProductID' type='text' name='ProductName' value='Name' >
            <input class='ProductID' type='text' name='ProdDescription' value='Description' >
            <input class='ProductID' type='text' name='PictureURL' value='URL' >
            <input class='ProductID' type='hidden' name='action' value='create' >
            <input type='submit' name='createProduct' value='Add new Product' class='waves-effect waves-light btn edit'>
        </form>

    </div>

    <button class="collapsible">Set Special Product</button>
    <div class="content">

        <form action='../business/handleProduct.php' method='get'>
            <input class='ProductID' type='text' name='ProductName' value='Type the title of the product' >
            <input class='ProductID' type='hidden' name='action' value='setSpecial' >
            <input type='submit' name='setSpecial' value='Set a Special Product' class='waves-effect waves-light btn edit'>

        </form>

    </div>

    <button class="collapsible" >Update Web Shop Information</button>

    <div class="content">
        <?php
            getUpdateContactInfoForm();
            getUpdateAboutUsForm();
        ?>
    </div>
    <button class="collapsible">Order overview</button>
    <div class="content">
        <p>
            <?php readOrder(); ?>
        </p>
    </div>

    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.maxHeight){
                    content.style.maxHeight = null;
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        }
    </script>



    <br>
    <div class="wrapper">
        <?php
        if (isset($_GET['editNewsPost'])) {
            $id = $_GET['editNewsPost'];
            echo "<p> Update News Post</p>";
            getUpdateFormNewsPost($id);
        }
        ?>
    </div>

    <div class="wrapper">
    <?php
    if (isset($_GET['editProduct'])) {
        $id = $_GET['editProduct'];
        echo "<p> Update Product</p>";
        getUpdatedProduct($id);
    }
    ?>
    </div>
    <div>
        <?php
        if (isset($_GET['editOpeningHour'])) {
            echo "<p> Update OpeningHour</p>";
            getUpdateFormOpeningHour();
        }
        ?>
    </div>
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
