<?php require("../presentation/header.php"); ?>
<?php

require_once ("../includes/functions.php");
require_once ("../includes/session.php");



$_SESSION= array();
if(isset($_COOKIE[session_name()])){
    setcookie(session_name(),"",time()-999);
}
?>

<html>
<header>
    <style>
        <?php include '../includes/css/logout.css'; ?>
    </style>
</header>
<body>

<div class="buttons">
    <a href="../user/login.php" class="butt1">Log in again</a>
    <a href="../presentation/main.php" class="butt2">Head back to home page</a>

</div>

</body>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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