<?php require(__DIR__ . "/../persistence/aboutUSDAO.php"); ?>
<?php require( __DIR__ . "/header.php"); ?>
<?php require( __DIR__ . "/../persistence/openingHoursDAO.php"); ?>


<html>
<head>
    <style>
        <?php include '../includes/css/aboutUs.css'; ?>
    </style>
</head>

<body>

<br><br><br>
        <div> <?php readWebShopInfo(); ?></div>

<div style="text-align: center; padding-bottom: 10px">
<div class="openingHours" style="float: left; padding-right: 20px; margin: 0 auto; padding-left: 20%">

    <h3 class="title"> Opening hours </h3>
    <div class=""><?php readOpeningHour()?></div>


</div>
<div class="openingHours" style="">
    <h3 class="title"> Contact Info</h3>
    <div class=""><?php readContactInfo()?></div>

</div>
</div>
<br><br><br>
        <div class="mapdiv" >

            <script>
                function myMap() {
                    var mapProp= {
                        center:new google.maps.LatLng(51.508742,-0.120850),
                        zoom:5,
                    };
                    var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
                }
            </script>

            <iframe width="100%" height="400" style="padding-top: 25px" id="gmap_canvas"
                    src="https://maps.google.com/maps?q=Spangsbjerg%20Kirkevej%20187&t=&z=13&ie=UTF8&iwloc=&output=embed"
                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0" ></iframe>

        </div>

</body>
<br><br><br>
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





