<?php
require_once( __DIR__ . '/../includes/db/connection.php' );
require ('../includes/model/NewsPost.php');
require_once ("../includes/session.php");


function getNewsPost($NewsPostID)
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( "SELECT * FROM NewsPost WHERE NewsPostID = :NewsPostID");
        $handle->bindParam(':NewsPostID', $NewsPostID);
        $handle->execute();

        $result = $handle->fetch( \PDO::FETCH_OBJ );
        $newsPost = new NewsPost();
        $newsPost->setValues($result->NewsPostID, $result->PostTitle, $result->Post);
         print( NewsPostTemplate($newsPost->getNewsPostID(), $newsPost->getPostTitle(), $newsPost->getPost()));
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function createNewsPost ($PostTitle,$Post)
{
    try
    {
        $cxn = connectToDB();

        $statement = "INSERT INTO NewsPost (PostTitle ,Post) VALUES (:PostTitle, :Post)";

        $handle = $cxn->prepare($statement);
        $handle->bindParam(':PostTitle', $PostTitle);
        $handle->bindParam(':Post', $Post);
        $handle->execute();

        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function readNewsPost()
{
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( 'SELECT * FROM NewsPost ORDER BY NewsPostID DESC' );
        $handle->execute();
        $result = $handle->fetchAll( \PDO::FETCH_OBJ );

        foreach ( $result as $row ) {
            $newsPost = new NewsPost();
            $newsPost->setValues($row->NewsPostID, $row->PostTitle, $row->Post);

            print( NewsPostTemplate($newsPost->getNewsPostID(), $newsPost->getPostTitle(), $newsPost->getPost()));
        }
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function deleteNewsPost($NewsPostID)
{
    try
    {
        $cxn = ConnectToDB();

        $statement = "DELETE FROM NewsPost WHERE NewsPostID = :NewsPostID";
        $handle = $cxn->prepare( $statement );
        $handle->bindParam(':NewsPostID', $NewsPostID);
        $handle->execute();

        //close the connection
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function getUpdateFormNewsPost($NewsPostID) {
    try {
        $cxn = connectToDB();

        $handle = $cxn->prepare( "SELECT * FROM NewsPost WHERE NewsPostID = :NewsPostID");
        $handle->bindParam(':NewsPostID', $NewsPostID);
        $handle->execute();

        $result = $handle->fetch( \PDO::FETCH_OBJ );
        $newsPost = new NewsPost();
        $newsPost->setValues($result->NewsPostID, $result->PostTitle, $result->Post);

        print( NewsPostUpdateForm($newsPost->getNewsPostID(), $newsPost->getPostTitle(), $newsPost->getPost()));
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}

function updateNewsPost($NewsPostID, $PostTitle, $Post)
{
    try
    {
        $cxn = ConnectToDB();

        $statement = "UPDATE NewsPost SET PostTitle = :PostTitle, Post = :Post WHERE NewsPostID = :NewsPostID";
        $handle = $cxn->prepare( $statement );
        $handle->bindParam(':PostTitle', $PostTitle);
        $handle->bindParam(':Post', $Post);
        $handle->bindParam(':NewsPostID', $NewsPostID);
        $handle->execute();

        //close the connection
        $cxn = null;
    }
    catch(\PDOException $ex){
        print($ex->getMessage());
    }
}
function AdminPostForm()
{
    if(getIsAdmin() == true) {
        return $template = " <form action='../business/handleNewsPost.php' method='get'>
        <input class='ProductID' type='text' name='PostTitle' value='Title' >
        <input class='ProductID' type='text' name='Post' value='Post Text' >
        <input class='ProductID' type='hidden' name='action' value='create' >
        <input type='submit' name='createNewsPost' value='Add news post' class='waves-effect waves-light btn edit'>
    </form>	";
    } else
        echo " not working";
}

function NewsPostUpdateForm($NewsPostID, $PostTitle, $Post) {
    return $template ="
    
    <form action='../business/handleNewsPost.php' method='get'>
        <input class='ProductID' type='hidden' name='NewsPostID' value='" . $NewsPostID. "' >
        <input class='ProductID' type='text' name='newPostTitle' value='" . $PostTitle. "' >
        <input class='ProductID' type='text' name='newPost' value='" . $Post. "' >
        <input class='ProductID' type='hidden' name='action' value='update' >
        <input type='submit' name='createNewsPost' value='Update NewsPost' class='waves-effect waves-light btn edit'>
    </form>
    
    ";


}
function NewsPostTemplate($NewsPostID, $PostTitle, $Post)
{
    if(getIsAdmin() == true)
    {
        return $template = "	
	
	<link href='https://fonts.googleapis.com/css?family=PT+Serif:400|Open+Sans:400,700' rel='stylesheet' type='text/css'>

<div class=\"container\">
  <article class=\"post\">
    <h1>" . $PostTitle. "</h1>
    <p>" . $Post. "</p>
                    <div class=\"card-action\">

                        <a href='../presentation/adminPage.php?editNewsPost=" . $NewsPostID . "' class='waves-effect waves-light orange darken-2 white-text btn edit'>Edit</a>
                        <a href='../business/handleNewsPost.php/?action=delete&NewsPostID=" . $NewsPostID . "' class='waves-effect waves-light red darken-4 white-text btn edit'>Delete</a>
                    </div>
  </article>

    </div>
     <br><br><br><br>";
    } else
    {
        return $template = "	
	<link href='https://fonts.googleapis.com/css?family=PT+Serif:400|Open+Sans:400,700' rel='stylesheet' type='text/css'>

<div class=\"container\">
  <article class=\"post\">
    <h1>" . $PostTitle. "</h1>
    <p>" . $Post. "</p>
  </article>
</div>
	
	";
    }

}