<?php require("../presentation/header.php"); ?>
<?php
require_once ("../includes/session.php");
require_once ("../includes/db/connection.php");
require_once ("../includes/functions.php");

if(logged_in()){
    redirect_to("../presentation/main.php");
}
?>

<html>
<body>
<?php
if (!empty($message)){echo "<p>". $message."<p>";}
?>
<style>
    <?php
    include '../includes/css/login.css';
    ?>
</style>

<form action="../business/handleUser.php" method="get">
    Username:
    <input type="text" name="email" maxlength="30" value="" class="userNameInput"/>
    Password:
    <input type="password" name="pass" maxlength="30" value="" class="passInput"/>
    <input type="hidden" name="action" maxlength="30" value="login" class="passInput"/>

    <input type="submit" value="Login"/>
</form>
</body>
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