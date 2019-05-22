<?php require(__DIR__ . "/../persistence/UserDAO.php");
require(__DIR__ . "/../persistence/ProductDAO.php");
require(__DIR__ . "/../persistence/NewsPostDAO.php");
require(__DIR__ . "/../persistence/aboutUsDAO.php");
require_once ("../includes/session.php");

require("header.php");



?>

<!doctype html>
<html>
<header>

    <style>
        <?php
        include '../includes/css/main.css';
        ?>
    </style>
</header>
<body>
    <div class="pageContent" >
        <br><br>
        <div> <?php  readShortWebInfo();?></div>

        <br><br><br><br><br><br>
        <br><br>






    <p class="dailyOffer"> Check out our daily offer <br> and save 20% on the special item </p>

        <div> <?php readSpecial();?> </div>

        <br>
        <div class="NewsPost">
            <h1 class="newsSection">
                News Section</h1>
            <br><br>
            <div >
                <div><?php readNewsPost();?></div>
            </div>
            <br><br><br><br>
            <?php
            if(getIsAdmin() != false)
            {
                print "<div class='addNewPostForm'>
                <p class='addNewPostFormTitle'> Create new Post: </p>
                <form action='../business/handleNewsPost.php' method='get' class='PostForm'>
                <input class='PostForm' type='text' name='PostTitle' value='Title' >
                <input class='PostForm' type='text' name='Post' value='Post Text' >
               
                <input class='PostForm' type='hidden' name='action' value='create' >
                <input type='submit' name='createNewsPost' value='Add news post' class='waves-effect waves-light orange darken-3 btn edit'>
            </form>
            </div>";

            }
            ?>

    

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
