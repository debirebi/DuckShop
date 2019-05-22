<?php
require("../persistence/userDAO.php");
require_once("../includes/functions.php");
require_once("../includes/session.php");
require("header.php");


if (logged_in() != true) {
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


    <h2>User page</h2>

    <button class="collapsible" >Update Email and Password</button>

    <div class="content">
        <?php
        getUpdateFormUser()
        ?>
    </div>
    <button class="collapsible">Update Registerd Address</button>
    <div class="content">
        <p>
            <?php getUpdateFormUserAddress(); ?>
        </p>
    </div>
    <button class="collapsible">Order overview</button>
    <div class="content">
        <p>
            <?php readOrderForUser(); ?>
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
