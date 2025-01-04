<?php
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire la session
session_destroy();

// Redirection vers la page d'accueil ou de connexion
header("location: /index.php");
exit();
