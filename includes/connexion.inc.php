<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST["submit"]))
{
    $uid = $_POST["uid"];
    $password = $_POST["password"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputLogin($uid, $password) !== FALSE)
    {
        header("location: ../index.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $uid, $password);
}
else
{
    header("location: ../index.php");
    exit();
}