<?php

function redirect_to($location){
    header("location:{$location}");
    exit;
}