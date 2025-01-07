<?php

$serverName = "localhost";
$dbUsername = "myphpadmin";
$dbPassword = "142857x7";
$dbName = "gericodatabase";

try
{
    mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);
}
catch(Exception $e)
{
    // No error echo
}

if(!$conn)
{
    die("Echec de la connexion: " . mysqli_connect_error() . " | La connexion à la base de données est impossible.");
    header("location: ../index.php");
}