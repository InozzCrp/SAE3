<?php
require_once("constante.php");

get_session_verification_admin();

get_head();
get_header_dashbord();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Préparer et exécuter l'insertion
    $stmt = $pdo->prepare("INSERT INTO employe (Nom_employe, Prenom_employe, Telephone_employe, Email_employe, Location_employe, ID_metier, Login_employe, Mdp_employe, Salaire_employe, Date_embauche_employe, Nb_conges_restant) 
                           VALUES (:nom, :prenom, :telephone, :email, :location, :id_metier, :login, :mdp, :salaire, :date_embauche, :nb_conges)");
    $stmt->execute([
        ':nom' => $_POST['Nom_employe'],
        ':prenom' => $_POST['Prenom_employe'],
        ':telephone' => $_POST['Telephone_employe'],
        ':email' => $_POST['Email_employe'],
        ':location' => $_POST['Location_employe'],
        ':id_metier' => $_POST['ID_metier'],
        ':login' => $_POST['Login_employe'],
        ':mdp' => password_hash($_POST['Mdp_employe'], PASSWORD_DEFAULT),
        ':salaire' => $_POST['Salaire_employe'],
        ':date_embauche' => $_POST['Date_embauche_employe'],
        ':nb_conges' => $_POST['Nb_conges_restant']
    ]);

    header("Location: admin.php");
    exit();
}
?>

<body>
    <h1>Ajouter un Employé</h1>
    <form method="POST">
        <label>Nom :</label><input type="text" name="Nom_employe" required><br>
        <label>Prénom :</label><input type="text" name="Prenom_employe" required><br>
        <label>Téléphone :</label><input type="text" name="Telephone_employe" required><br>
        <label>Email :</label><input type="email" name="Email_employe" required><br>
        <label>Location :</label><input type="text" name="Location_employe" required><br>
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
        <label>Login :</label><input type="text" name="Login_employe" required><br>
        <label>Mot de Passe :</label><input type="password" name="Mdp_employe" required><br>
        <label>Salaire :</label><input type="number" name="Salaire_employe" required><br>
        <label>Date d'embauche :</label><input type="date" name="Date_embauche_employe" required><br>
        <label>Nb Congés Restants :</label><input type="number" name="Nb_conges_restant" required><br>
        <button type="submit">Ajouter</button>
    </form>
</body>