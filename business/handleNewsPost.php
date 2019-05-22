<?php
require( __DIR__ . "/../persistence/newspostDAO.php" );
require_once ("../includes/functions.php");

$action = $_GET["action"];

if ($action == "create")
{
    $newsPost = new NewsPost();
    $newsPost->setPostTitle($_GET["PostTitle"]);
    $newsPost->setPost($_GET["Post"]);

    createNewsPost( $newsPost->getPostTitle(), $newsPost->getPost());
    redirect_to('../presentation/main.php');
}
else if ($action == "delete")
{
    $newsPost = new NewsPost();
    $newsPost->setNewsPostID($_GET["NewsPostID"]);
    deleteNewsPost($newsPost->getNewsPostID());
    redirect_to('../../presentation/main.php');
}
else if ($action == "update")
{
    $newsPost = new NewsPost();
    $newsPost->setValues($_GET["NewsPostID"], $_GET["newPostTitle"], $_GET["newPost"]);

    updateNewsPost($newsPost->getNewsPostID(), $newsPost->getPostTitle(), $newsPost->getPost());
    redirect_to('../presentation/main.php');
}