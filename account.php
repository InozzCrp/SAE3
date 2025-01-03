<?php
require("parametres/constante.php");
get_head();
get_header_dashbord();

$infos = get_infos($pdo, $_SESSION["userid"]);

echo "<div class='employee-info'>";
echo "<h1>Informations de l'employé</h1>";

$labels = [
    'Nom' => 'Nom_employe',
    'Prénom' => 'Prenom_employe',
    'Email' => 'Email_employe',
    'Téléphone' => 'Telephone_employe',
    'Location' => 'Location_employe',
    'Date d\'embauche' => 'Date_embauche_employe'
];

foreach ($labels as $label => $key) {
    echo "<p><strong>" . $label . " :</strong> " . htmlspecialchars($infos[$key]) . "</p>";
}

echo "</div>";

echo "<link rel='stylesheet' type='text/css' href='styles/css/account.css'>";
?>