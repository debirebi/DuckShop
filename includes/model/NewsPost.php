<?php


class NewsPost
{
    private $NewsPostID;
    private $PostTitle;
    private $Post;

    public function __construct()
    {

    }

    public function setValues($NewsPostID, $PostTitle, $Post)
    {
        $this->NewsPostID = $NewsPostID;
        $this->PostTitle = $PostTitle;
        $this->Post = $Post;
    }

    public function setNewsPostID($NewsPostID)
    {
         $this->NewsPostID = $NewsPostID;
    }
    public function getNewsPostID()
    {
        return $this->NewsPostID;
    }

    public function setPostTitle($PostTitle)
    {
        $this->PostTitle = $PostTitle;
    }
    public function getPostTitle()
    {
        return $this->PostTitle;
    }

    public function setPost($Post)
    {
        $this->Post = $Post;
    }
    public function getPost()
    {
        return $this->Post;
    }

}