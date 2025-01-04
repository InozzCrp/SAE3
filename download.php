<?php
require("constante.php");

// Vérifier si l'ID est passé via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['ficheId'])) {
    die("Requête non valide.");
}

$id = intval($_POST['ficheId']);

// Récupérer la fiche depuis la base de données
$query = $pdo->prepare("SELECT pdf, debut_periode, fin_periode FROM fiches WHERE ID_Fichedepaie = :id");
$query->execute(['id' => $id]);
$fiche = $query->fetch();

if (!$fiche) {
    die("Fiche non trouvée.");
}

// Définir les en-têtes HTTP pour le téléchargement
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="fiche_' . $fiche['debut_periode'] . '_au_' . $fiche['fin_periode'] . '.pdf"');
header('Content-Length: ' . strlen($fiche['pdf']));

// Envoyer le contenu du PDF
echo $fiche['pdf'];
exit;
