<?php
    require("parametres\constante.php");
    get_head();
    get_header_dashbord();
    $infos = get_infos($pdo,$_SESSION["userid"]);
    echo "<h1>Informations de l'employé</h1>";
    echo "<p>Nom : " . htmlspecialchars($infos['Nom_employe']) . "</p>";
    echo "<p>Prénom : " . htmlspecialchars($infos['Prenom_employe']) . "</p>";
    echo "<p>Email : " . htmlspecialchars($infos['Email_employe']) . "</p>";
    echo "<p>Téléphone : " . htmlspecialchars($infos['Telephone_employe']) . "</p>";
    echo "<p>Location : " . htmlspecialchars($infos['Location_employe']) . "</p>";
    echo "<p>Date d'embauche : " . htmlspecialchars($infos['Date_embauche_employe']) . "</p>";
?>