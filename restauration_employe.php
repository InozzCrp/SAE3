<?php
require_once("constante.php");
get_session_verification_admin();

// Vérifiez que l'ID est passé dans l'URL
if (!isset($_GET['id'])) {
    header("Location: admin.php?filter=active&error=missingid");
    exit();
}

$employeId = $_GET['id'];

// Archiver l'employé
$stmt = $pdo->prepare("UPDATE employe SET archive = 0 WHERE ID_employe = :id");
$stmt->execute([':id' => $employeId]);

header("Location: admin.php?filter=archived&success=actived");
exit();