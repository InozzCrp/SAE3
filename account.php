<?php
require_once("constante.php");


get_session_verification();

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

echo '<form action="parametres/logout.php" method="POST">
        <button type="submit">Se déconnecter</button>
      </form>';

echo "</div>";

echo "<link rel='stylesheet' type='text/css' href='styles/css/account.css'>";
?>