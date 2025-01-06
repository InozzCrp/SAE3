<?php
    require("constante.php");

    get_session_verification_admin();

    $password = "password2"; // Mot de passe en clair
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    echo '<p>' . $hashedPassword . '</p>';
?>