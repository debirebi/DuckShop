<?php
require_once ("../includes/session.php");
require_once ("../includes/db/connection.php");
require_once ("../includes/functions.php");
require_once("../presentation/header.php");
require_once("../persistence/userDAO.php");


?>
<html>
<header>
    <style>
        <?php include '../includes/css/newuser.css'; ?>
    </style>
</header>
<body>

<?php
if(!empty($message)){echo "<p>" .$message. "<p>";}
?>


<div class="formdiv" >
<form action="../business/handleUser.php" method="get" class="form">


    <p class="lebels">Email address:</p>
    <input type="text" name="email" maxlength="30" value="" style="margin: 0 0 0 0 "/>
    <p class="lebels">Password:</p>
    <input type="password" name="password" maxlength="30" value="" style="margin: 0 0 0 0 "/>
    <p class="lebels">First name:</p>
    <input type="text" name="firstName" maxlength="30" value="" style="margin: 0 0 0 0 "/>
    <p class="lebels">Last name:</p>
    <input type="text" name="lastName" maxlength="30" value="" style="margin: 0 0 0 0 "/>
    <p class="lebels">Birthday:</p>
    <input type="text" class="datepicker" name="birthday" maxlength="30" value="" style="margin: 0 0 0 0 "/>
    <p class="warning">! Please make sure you write the correct address so there won't be any problem on delivery ! :) </p>
    <p class="lebels">Country:</p>
    <input type="text" name="country" maxlength="30" value="" style="margin: 0 0 0 0 "/>
    <p class="lebels">City:</p>
    <input type="text" name="city" maxlength="30" value="" style="margin: 0 0 0 0 "/>
    <p class="lebels">Postal Code:</p>
    <input type="text" name="postalCode" maxlength="30" value="" style="margin: 0 0 0 0 "/>
    <p class="lebels">Street:</p>
    <input type="text" name="street" maxlength="30" value="" style="margin: 0 0 0 0 "/>
    <p class="lebels">House Number:</p>
    <input type="text" name="hnumber" maxlength="30" value=""/>
    <input type="hidden" name="action" maxlength="30" value="create"/>


    <input class="waves-effect waves-light orange darken-2 white-text btn edit" type="submit" name="submit" value="Create"/>
</form>
</div>
</body>
<footer class="page-footer orange lighten-2">
    <div class="container">
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
