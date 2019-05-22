<?php
require ("constants.php");
$connection = mysqli_connect(DB_SERVER, DB_USER,DB_PASS, DB_NAME);
if (mysqli_connect_errno()){
    die ("Failed to connect to DB: ". mysqli_connect_error());
}

function connectToDB()
{
    $link = new \PDO(
        'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_PERSISTENT => false
        )
    );

    return $link;
}
function connectionString()
{
    return mysqli_connect(DB_SERVER, DB_USER,DB_PASS, DB_NAME);
}
