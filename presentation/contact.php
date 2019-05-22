<?php require( __DIR__ . "/header.php"); ?>
<!doctype html>
<html>
<header>
    <style>
        <?php include '../includes/css/contact.css'; ?>
    </style>
</header>
<body>

<br><br><br><br>
    <div class="pageContent" >

        <div class="feedback">

            <div class="feedbackTitle">
                <h3 class="feedbackTitle">Contact Form</h3>
                <br>
                <p>Do you have any question or have some cool ideas? Don't hazitate to write us !</p>
            </div>
            <form action="../business/handleEmail.php" id="form" method="get" name="form" class="form">
                <input name="name" placeholder="Your Name" type="text" value="">
                <input name="email" placeholder="Your Email" type="text" value="">
                <input name="subject" placeholder="Subject" type="text" value="">
                <label>Your Question/Suggestion/Feedback</label>
                <textarea name="mailText" placeholder="Type your text here..."></textarea>
                <input name="action" type="hidden" value="contact">
                <input id="send" name="submit" type="submit" value="Send Feedback">
            </form>
        </div>

    </div>

    </div>
<br><br><br><br><br>

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