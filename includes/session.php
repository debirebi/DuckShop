<?php
session_start();

function logged_in(){
    if (isset($_SESSION['userID'])) {
        return TRUE;
    } else
    return FALSE;
}

function getShoppingCart(){
    return $_SESSION['shoppingCart'];
}

function getIsAdmin(){
    if($_SESSION['IsAdmin']==1){
        return TRUE;
    }
    else
    return FALSE;
}

function getUserID(){
    return $_SESSION['userID'];
}

function getFullPrice(){
    return $_SESSION['fullPrice'];
}

function getAddressID(){
    return $_SESSION['addressID'];
}

function getLastVisitedCategoryID(){
    return $_SESSION['lastOpenedCategory'];
}

function getAdminPageButton()
{
    if(getIsAdmin() == true)
    {
        print  "<a href='../presentation/adminPage.php' class='login'>AdminPage</a>";
    }
    else
        return null;
}
function getUserPageButton()
{
    if(logged_in() == true && getIsAdmin() == false)
    {
        print  "<a href='../presentation/userPage.php' class='login'>User Page!</a>";
    }
    else
        return null;
}