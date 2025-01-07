<?php
require_once("constante.php");
// require_once("api.php");

get_session_verification_admin();

get_head();
get_header_dashbord();

// Vérifiez que l'ID de l'employé est passé dans l'URL
if (!isset($_GET['id'])) {
    echo json_encode(["error" => "ID employé manquant"]);
    exit;
}

$id = $_GET['id']; // L'ID de l'employé à récupérer

// // Construire l'URL de l'API
// $url = "http://localhost/api/employes/$id"; // URL de l'API pour récupérer les informations de l'employé

// // Préparer l'en-tête avec le token
// $options = [
//     "http" => [
//         "header" => "Authorization: Bearer fortnite" // Inclure le token dans l'en-tête Authorization
//     ]
// ];

// // Créer un contexte de requête avec l'en-tête
// $context = stream_context_create($options);

// // Effectuer la requête avec ces en-têtes
// $json_data = file_get_contents($url, false, $context);
// var_dump($json_data);

// if ($json_data !== false) {
//     // Décodage du JSON en tableau associatif PHP
//     $employe = json_decode($json_data, true);

//     if (!$employe) {
//         echo json_encode(["error" => "Employe non trouvee"]);
//         exit;
//     }
// }

// Récupérer les données actuelles de l'employé
$employe = get_infos($pdo, $id);

// Si le formulaire est soumis, mettre à jour les informations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'Nom_employe' => trim($_POST['Nom_employe']),
        'Prenom_employe' => trim($_POST['Prenom_employe']),
        'Telephone_employe' => trim($_POST['Telephone_employe']),
        'Email_employe' => trim($_POST['Email_employe']),
        'Location_employe' => trim($_POST['Location_employe']),
        'ID_metier' => (int) $_POST['ID_metier'],
        'Login_employe' => trim($_POST['Login_employe']),
        'Mdp_employe' => trim($employe['Mdp_employe']),
        'Salaire_employe' => (float) $_POST['Salaire_employe'],
        'Date_embauche_employe' => $_POST['Date_embauche_employe'],
        'Nb_congés_restant' => (float) $_POST['Nb_congés_restant'],
    ];

    // var_dump($data);

    // Appel à la fonction de mise à jour
    $good = updateEmploye($pdo, $id, $data);

    if($good)
        header("Location: /admin.php");
    else
    {
        echo '<h1>Erreur jsp</h1>';
        foreach ($data as $key => $value) {
            echo ":$key => " . $value . " (" . gettype($value) . ")\n";
        }
    }
}

?>

<body>
    <h1>Modifier les informations de l'employé</h1>
    <form method="POST">
        <label>Nom :</label><input type="text" name="Nom_employe" value="<?= htmlspecialchars($employe['Nom_employe']) ?>" required><br>
        <label>Prénom :</label><input type="text" name="Prenom_employe" value="<?= htmlspecialchars($employe['Prenom_employe']) ?>" required><br>
        <label>Téléphone :</label><input type="text" name="Telephone_employe" value="<?= htmlspecialchars($employe['Telephone_employe']) ?>" required><br>
        <label>Email :</label><input type="email" name="Email_employe" pattern=".+@gerico\.fr" value="<?= htmlspecialchars($employe['Email_employe']) ?>" required><br>
        <label>Location :</label><input type="text" name="Location_employe" value="<?= htmlspecialchars($employe['Location_employe']) ?>" required><br>
        <label>Métier : 
            <select name="ID_metier">
            <?php
                $metiers = $pdo->query("SELECT ID_metier, Nom_metier FROM metier")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($metiers as $metier) {
                    $selected = $metier['ID_metier'] == $employe['ID_metier'] ? 'selected' : '';
                    echo "<option value='{$metier['ID_metier']}' $selected>{$metier['Nom_metier']}</option>";
                }
            ?>
            </select>
        </label><br>
        <label>Login :</label><input type="text" name="Login_employe" value="<?= htmlspecialchars($employe['Login_employe']) ?>" required><br>
        <label>Salaire :</label><input type="number" name="Salaire_employe" value="<?= htmlspecialchars($employe['Salaire_employe']) ?>" required><br>
        <label>Date d'embauche :</label><input type="date" name="Date_embauche_employe" value="<?= htmlspecialchars($employe['Date_embauche_employe']) ?>" required><br>
        <label>Nb Congés Restants :</label><input type="number" name="Nb_congés_restant" value="<?= htmlspecialchars($employe['Nb_congés_restant']) ?>" required><br>
        <button type="submit">Enregistrer les modifications</button>
    </form>
    <a href="admin.php">Retour</a>
</body>