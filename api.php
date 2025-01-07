<?php
require_once("constante.php");

get_session_verification_admin();

// Récupérer le chemin de l'URL
$requestUri = $_SERVER['REQUEST_URI']; // Ex : /api/employes/25

// Vérifier si l'URL commence par /api/ pour déterminer si c'est une requête API
$isApiRequest = strpos($requestUri, '/api/') === 0; // Vérifie si l'URL commence par "/api/"

// Si c'est une requête API, définir l'en-tête Content-Type à application/json
if ($isApiRequest) {
    header('Content-Type: application/json');
}

$method = $_SERVER['REQUEST_METHOD'];
$path = $_GET['path'] ?? ''; // Exemple : "employes" ou "employes/1"
$segments = explode('/', trim($path, '/')); // Découpe le chemin

try {
    if ($segments[0] === 'employes') {
        $id = isset($segments[1]) ? intval($segments[1]) : null; // Récupère l'ID de l'employé
        
        if ($id !== null) {
            switch ($method) {
                case 'PUT':
                    parse_str(file_get_contents("php://input"), $putData); // Récupère les données PUT
                    updateEmploye($pdo, $id, $putData);
                    break;
                case 'GET':
                    getEmploye($pdo, $id); // Récupère les détails d'un employé
                    break;
                default:
                    http_response_code(405); // Méthode non autorisée
                    echo json_encode(["error" => "Méthode non autorisée"]);
                    break;
            }
        } else {
            http_response_code(400); // Mauvaise requête
            echo json_encode(["error" => "ID de l'employé manquant"]);
        }
    } else {
        http_response_code(404); // Non trouvé
        echo json_encode(["error" => "Ressource non trouvée"]);
    }
} catch (Exception $e) {
    http_response_code(500); // Erreur interne
    echo json_encode(["error" => $e->getMessage()]);
}

// Fonctions pour chaque route
function listEmployes($pdo, $isArchived) {
    $stmt = $pdo->prepare("SELECT * FROM employe WHERE archive = :archived");
    $stmt->execute(['archived' => $isArchived]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function getEmploye($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM employe WHERE ID_employe = :id");
    $stmt->execute(['id' => $id]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
}

function addEmploye($pdo, $data) {
    $stmt = $pdo->prepare("
        INSERT INTO employe (Nom_employe, Prenom_employe, Telephone_employe, Email_employe, Location_employe, ID_metier, Login_employe, Mdp_employe, Salaire_employe, Date_embauche_employe, Nb_congés_restant, Archive)
        VALUES (:nom, :prenom, :telephone, :email, :location, :metier, :login, :mdp, :salaire, :date_embauche, :nb_conges, 0)");
    $stmt->execute([
        'nom' => $data['Nom_employe'],
        'prenom' => $data['Prenom_employe'],
        'telephone' => $data['Telephone_employe'],
        'email' => $data['Email_employe'],
        'location' => $data['Location_employe'],
        'metier' => $data['ID_metier'],
        'login' => $data['Login_employe'],
        'mdp' => password_hash($data['Mdp_employe'], PASSWORD_BCRYPT),
        'salaire' => $data['Salaire_employe'],
        'date_embauche' => $data['Date_embauche_employe'],
        'nb_conges' => $data['Nb_congés_restant']
    ]);
    echo json_encode(["success" => true]);
}

function updateEmploye($pdo, $id, $data) {
    try {
        $sql = "UPDATE employes SET 
                Nom_employe = :Nom_employe,
                Prenom_employe = :Prenom_employe,
                Telephone_employe = :Telephone_employe,
                Email_employe = :Email_employe,
                Location_employe = :Location_employe,
                ID_metier = :ID_metier,
                Login_employe = :Login_employe,
                Mdp_employe = :Mdp_employe,
                Salaire_employe = :Salaire_employe,
                Date_embauche_employe = :Date_embauche_employe,
                Nb_congés_restant = :Nb_congés_restant,
                Archive = 0
                WHERE ID_employe = :ID_employe";

        $stmt = $pdo->prepare($sql);

        // Bind des paramètres
        $stmt->bindParam(':Nom_employe', $data['Nom_employe']);
        $stmt->bindParam(':Prenom_employe', $data['Prenom_employe']);
        $stmt->bindParam(':Telephone_employe', $data['Telephone_employe']);
        $stmt->bindParam(':Email_employe', $data['Email_employe']);
        $stmt->bindParam(':Location_employe', $data['Location_employe']);
        $stmt->bindParam(':ID_metier', $data['ID_metier']);
        $stmt->bindParam(':Login_employe', $data['Login_employe']);
        $stmt->bindParam(':Salaire_employe', $data['Salaire_employe']);
        $stmt->bindParam(':Date_embauche_employe', $data['Date_embauche_employe']);
        $stmt->bindParam(':Nb_congés_restant', $data['Nb_congés_restant']);
        $stmt->bindParam(':ID_employe', $id, PDO::PARAM_INT);

        // Exécute la requête
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
    echo json_encode(["success" => true]);
}

function restoreEmploye($pdo, $id) {
    $stmt = $pdo->prepare("UPDATE employe SET archive = 0 WHERE ID_employe = :id");
    $stmt->execute(['id' => $id]);
    echo json_encode(["success" => true]);
}
?>
