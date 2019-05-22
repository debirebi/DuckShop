<?php
require_once( __DIR__ . '/../includes/db/connection.php' );
require_once ("../includes/session.php");
require_once("../includes/model/OpeningHour.php");

function getOpeningHour($OpeningHourID)
{
    try {
        $cxn = connectToDB();
        $handle = $cxn->prepare( "SELECT * FROM OpeningHour WHERE OpeningHourID = :OpeningHourID");
        $handle->bindParam(':OpeningHourID', $OpeningHourID);
        $handle->execute();
        $result = $handle->fetch( \PDO::FETCH_OBJ );
        $OpeningHour = new OpeningHour($result->OpeningHourID, $result->OpeningHour, $result->DayType);
        return $OpeningHour;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}
function readOpeningHour()
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( 'SELECT * FROM OpeningHour ORDER BY OpeningHourID ASC' );
        $handle->execute();
        $result = $handle->fetchAll( \PDO::FETCH_OBJ );

        foreach ( $result as $row ) {
            $OpeningHour = new OpeningHour($row->OpeningHourID, $row->OpeningHour, $row->DayType);
            print( openingHourTemplate($OpeningHour->getOpeningHourID(), $OpeningHour->getOpeningHour(), $OpeningHour->getDayType()) );
        }
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}


function updateOpeningHour($OpeningHour)
{
    try
    {
        $cxn = ConnectToDB();

        $statement = "UPDATE OpeningHour SET OpeningHour = :OpeningHour , DayType = :DayType WHERE OpeningHourID = :OpeningHourID";
        $handle = $cxn->prepare( $statement );
        $handle->bindParam(':OpeningHour', $OpeningHour->OpeningHourID);
        $handle->bindParam(':DayType', $OpeningHour->Day);
        $handle->bindParam(':OpeningHourID', $OpeningHour->OpeningHourID);
        $handle->execute();

        //close the connection
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function getUpdateFormOpeningHour() {
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( "SELECT * FROM OpeningHour ");
        $handle->execute();

        $result = $handle->fetchAll( \PDO::FETCH_OBJ );

        foreach ($result as $row) {
            $OpeningHour = new OpeningHour($row->OpeningHourID, $row->OpeningHour, $row->DayType);
            print( OpeningHourUpdateForm($OpeningHour->getOpeningHourID(), $OpeningHour->getOpeningHour(), $OpeningHour->getDayType()));

        }
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function openingHourTemplate($OpeningHourID, $OpeningHour, $DayType )
{

    if(getIsAdmin() == true)
    {
      return $template = "
      <input class='WebShopID' type=\"hidden\" name='WebShopID' id='WebShopID' value='" . $OpeningHourID . "' >
            <div class='openingHours'>
               <ul> "  . $DayType. " 
                " . $OpeningHour. "</ul>
           </div>
           
           <a href='../presentation/adminPage.php?editOpeningHour=1' class='waves-effect waves-light orange darken-2 white-text btn edit'>Edit</a>
       ";
    } else {
        return $template = "
      <input class='WebShopID' type=\"hidden\" name='WebShopID' id='WebShopID' value='" . $OpeningHourID . "' >
            <div class='openingHours'>
               <ul> "  . $DayType. " 
                " . $OpeningHour. "</ul>
           </div>
           
       ";
    }
}
function OpeningHourUpdateForm($OpeningHourID, $OpeningHour, $DayType) {
    return $template ="
    
    <form action='../business/handleOpeningHours.php' method='get'>
        <input class='ProductID' type='hidden' name='OpeningHourID' value='" . $OpeningHourID. "' >
        <input class='ProductID' type='text' name='OpeningHour' value='" . $OpeningHour. "' >
        <input class='ProductID' type='text' name='Day' value='" . $DayType. "' >
        <input class='ProductID' type='hidden' name='action' value='update' >
        <input type='submit' name='updateOP' value='UpdateOP' class='waves-effect waves-light btn edit'>
    </form>
    
    ";


}