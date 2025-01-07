<?php
$DEBUG_SELECT = false;
$DEBUG_SELECT_MULTIPLE = false;
$DEBUG_INSERT = false;
$DEBUG_UPDATE = false;
$DEBUG_DELETE = false;

$base = 'sae-3-db';
$host = 'localhost';
$name = 'root';
$pass = '';

date_default_timezone_set('Europe/Paris');

try{
    $pdo = new PDO("mysql:host=$host;dbname=$base", $name, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
}
catch(PDOException $ex)
{
    die('Erreur de connexion à la base de donnée :'.$ex->getMessage());
}


function get_head(){
    include 'pages/includes/head.php';
}

function get_header(){
    include 'pages/includes/header.php';
}

function get_header_dashbord(){
    include 'pages/includes/header_dashbord.php';
}

function get_session_verification(){
    session_start();

    if(get_bearer_token() === "fortnite")
        exit;
    
    if (!isset($_SESSION['userid'])) {
        header("Location: /login.php?error=notconnected");
        exit;
    }
}

function get_session_verification_admin(){
    get_session_verification();
    if ($_SESSION['is_admin'] !== TRUE) {
        header("Location: /dashboard.php");
        exit;
    }
}

function get_bearer_token() {
    $headers = apache_request_headers();
    
    if (isset($headers['Authorization'])) {
        // Extraire le token de l'en-tête Authorization (format: Bearer <token>)
        if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            return $matches[1];
        }
    }
    return null; // Si aucun token n'est fourni
}

function get_footer(){
    include 'pages/includes/footer.php';
}

function get_infos($pdo, $uid)
{
    // Préparez la requête SQL
    $sql = "SELECT * FROM employe WHERE id_employe = :uid";
    $stmt = $pdo->prepare($sql);

    // Vérifiez si la préparation de la requête a échoué
    if (!$stmt)
    {
        header("Location: ?error=stmtfailed");
        exit();
    }

    // Liez le paramètre avec PDO (la requête préparée attend :uid comme paramètre)
    $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);

    // Exécutez la requête
    $stmt->execute();

    // Récupérez le résultat
    $resultData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si une ligne est retournée, l'uid existe
    if ($resultData)
    {
        return $resultData;
    }
    else
    {
        // Si aucune ligne n'est retournée, l'uid n'existe pas
        return false;
    }
}

function updateEmploye($pdo, $id, $data) {
    try {
        // Validation des données nécessaires
        $requiredKeys = [
            'Nom_employe', 'Prenom_employe', 'Telephone_employe', 'Email_employe',
            'Location_employe', 'ID_metier', 'Login_employe', 'Mdp_employe',
            'Salaire_employe', 'Date_embauche_employe', 'Nb_conges_restant'
        ];

        foreach ($requiredKeys as $key) {
            if (!isset($data[$key])) {
                throw new Exception("La clé '$key' est manquante dans les données.");
            }
        }

        // Préparation de la requête SQL
        $sql = "UPDATE employe
                SET Nom_employe = :Nom_employe,
                    Prenom_employe = :Prenom_employe,
                    Telephone_employe = :Telephone_employe,
                    Email_employe = :Email_employe,
                    Location_employe = :Location_employe,
                    ID_metier = :ID_metier,
                    Login_employe = :Login_employe,
                    Mdp_employe = :Mdp_employe,
                    Salaire_employe = :Salaire_employe,
                    Date_embauche_employe = :Date_embauche_employe,
                    Nb_conges_restant = :Nb_conges_restant
                WHERE ID_employe = :ID_employe";

        $stmt = $pdo->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':Nom_employe', $data['Nom_employe'], PDO::PARAM_STR);
        $stmt->bindParam(':Prenom_employe', $data['Prenom_employe'], PDO::PARAM_STR);
        $stmt->bindParam(':Telephone_employe', $data['Telephone_employe'], PDO::PARAM_STR);
        $stmt->bindParam(':Email_employe', $data['Email_employe'], PDO::PARAM_STR);
        $stmt->bindParam(':Location_employe', $data['Location_employe'], PDO::PARAM_STR);
        $stmt->bindParam(':ID_metier', $data['ID_metier'], PDO::PARAM_INT);
        $stmt->bindParam(':Login_employe', $data['Login_employe'], PDO::PARAM_STR);
        $stmt->bindParam(':Mdp_employe', $data['Mdp_employe'], PDO::PARAM_STR);
        $stmt->bindParam(':Salaire_employe', $data['Salaire_employe'], PDO::PARAM_STR);
        $stmt->bindParam(':Date_embauche_employe', $data['Date_embauche_employe'], PDO::PARAM_STR);
        $stmt->bindParam(':Nb_conges_restant', $data['Nb_conges_restant'], PDO::PARAM_STR);
        $stmt->bindParam(':ID_employe', $id, PDO::PARAM_INT);

        // Debug avant exécution
        $stmt->debugDumpParams();

        // Exécution de la requête
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour : " . $e->getMessage();
        return false;
    }
}


function archiveEmploye($pdo, $id) {
    $stmt = $pdo->prepare("UPDATE employe SET archive = 1 WHERE ID_employe = :id");
    $stmt->execute(['id' => $id]);
}

function uidExists($pdo, $uid)
{
    $sql = "SELECT * FROM employe WHERE login_employe = :uid";
    $stmt = $pdo->prepare($sql);

    if (!$stmt) {
        header("location: /login.php?error=stmtfailed");
        exit();
    }

    $stmt->bindParam(':uid', $uid, PDO::PARAM_STR);
    $stmt->execute();

    $resultData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultData) {
        return $resultData;
    } else {
        return false;
    }
}

function emptyInputLogin($uid, $password)
{
    $result = NULL;
    if(empty($uid) || empty($password))
    {
        $result = TRUE;
    }
    else
    {
        $result = FALSE;
    }

    return $result;
}

function loginUser($pdo, $id, $password)
{
    // Vérifiez si les champs sont vides
    if (emptyInputLogin($id, $password)) {
        header("Location: /login.php?error=emptyinput");
        exit();
    }

    // Récupérer l'utilisateur dans la base de données
    $user = uidExists($pdo, $id);
    if (!$user) {
        header("Location: /login.php?error=wronglogin");
        exit();
    }

    // Vérification du mot de passe
    $passwordHashed = $user["Mdp_employe"];
    if (!password_verify($password, $passwordHashed)) {
        header("Location: /login.php?error=problemehash");
        exit();
    }

    // L'utilisateur est authentifié - initialiser les sessions
    session_start();
    $_SESSION["userid"] = $user['ID_employe'];
    $_SESSION["userlogin"] = $user["Login_employe"];
    $_SESSION["is_admin"] = ($user["ID_metier"] == 2);

    header("Location: /dashboard.php");
    exit();
}

function rechercheFiches($pdo,$id,$datedebut,$datefin){
        $sql = "SELECT * FROM `fiches` WHERE ID_employe = :id";
        if (!empty($datedebut)) {
            $sql .= " AND debut_periode >= :datedebut";
        }
        if (!empty($datefin)) {
            $sql .= " AND fin_periode <= :datefin";
        }
        if(empty($datedebut) && empty($datefin)){
            $sql .= " ORDER BY ID_Fichedepaie DESC LIMIT 1";
        }
        $stmt = $pdo->prepare($sql);
        if (!empty($datedebut)) {
            $stmt->bindParam(':datedebut', $datedebut, PDO::PARAM_STR);
        }
        if (!empty($datefin)) {
            $stmt->bindParam(':datefin', $datefin, PDO::PARAM_STR);
        }
        $stmt->bindParam(':id',$id, PDO::PARAM_STR);
        $stmt->execute();
        $fiches = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $fiches;
}

function checkMail($pdo,$mail){
    $sql = "Select 1 from employe where email_employe = :mail";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':mail',$mail, PDO::PARAM_STR);
            $stmt->execute();
            $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $resultat;
}

function isWeekend($date) {
    return (date('N', strtotime($date)) >= 6);
}

function isFerie($pdo,$date){
        $sql = "Select nom_evenement from jours_feries where jour = :date";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':date',$date, PDO::PARAM_STR);
        $stmt->execute();
        $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultat;
}

function insererConges($pdo,$id,$date,$periode){
    $sql = "Insert into conges(Date_conge,partie_journée,id_employe) values (:date,:periode,:id)";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':date',$date, PDO::PARAM_STR);
    $stmt->bindParam(':id',$id, PDO::PARAM_STR);
    $stmt->bindParam(':periode',$periode, PDO::PARAM_STR);
    $success = $stmt->execute();
    return $success;
}

function recupererConges($pdo,$id){
    $sql = "Select * from conges where ID_employe = :id order by Date_conge";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id',$id, PDO::PARAM_STR);
    $stmt->execute();
    $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($resultat){
        return $resultat;
        }
    else{
        return false;
    }
}

function recupererCongesAttente($pdo){
    $sql = 'Select * from conges,employe where validation=:status AND conges.ID_employe = employe.id_employe';
    $stmt=$pdo->prepare($sql);
    $status = "en_attente";
    $stmt->bindParam(':status',$status, PDO::PARAM_STR);
    $stmt->execute();
    $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($resultat){
        return $resultat;
        }
    else{
        return false;
    }
}

function updateConge($pdo,$id,$periode,$nbconges){
    $duree = ($periode === "journée") ? 1 : 0.5;
    $sql = "Update employe set Nb_conges_restant = $nbconges-$duree where id_employe = :id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id',$id, PDO::PARAM_STR);
    $resultat = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $success = $stmt->execute();
    return $success;
}

function validationConges($pdo,$idconge,$status){
    $sql = "update conges set validation=:status where id_conges=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':id',$idconge, PDO::PARAM_STR);
    $stmt->bindParam(':status',$status,PDO::PARAM_STR);
    $success = $stmt->execute();
    return $success;
}
