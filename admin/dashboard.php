<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION["userid"])) {
    // Si pas connecté, redirection vers la page de connexion
    header("location: index.php");
    exit();
}

// Connexion à la base de données pour récupérer les informations de l'utilisateur
require_once 'includes/dbh.inc.php';
$userId = $_SESSION["userid"];

// Obtention des informations de l'utilisateur
$sql = "SELECT * FROM users WHERE usersId = ?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql))
{
    die("Erreur de la base de données.");
}

mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result))
{
    $uid = $row["usersUid"];
    $name = $row["usersName"];
    $surname = $row["usersSurname"];
}
else
{
    die("Utilisateur non trouvé.");
}
?>
<html lang="fr">
    <?php
		include_once('head.php');
	?>
    <body>
    <?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION["userid"])) {
    // Si pas connecté, redirection vers la page de connexion
    header("location: index.php?error=notconnected");
    exit();
}

// Connexion à la base de données pour récupérer les informations de l'utilisateur
require_once 'parametres/dbh.inc.php';
$userId = $_SESSION["userid"];

// Obtention des informations de l'utilisateur
$sql = "SELECT * FROM users WHERE usersId = ?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql))
{
    die("Erreur de la base de données.");
}

mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result))
{
    $uid = $row["usersUid"];
    $name = $row["usersName"];
    $surname = $row["usersSurname"];
}
else
{
    die("Utilisateur non trouvé.");
}
?>
    <body>
        <?php
            include_once('pages/includes/navbar.php');
        ?>

        <div class='p-3 h-100 dashboardcontent col-10'>
            <?php
                if (isset($_GET["content"]))
                {
                    if ($_GET["content"] == "accueil")
                    {
                        echo "<p class='text-danger'>Page accueil</p>";
                    }
                    elseif ($_GET["content"] == "conges")
                    {
                        echo "<p class='text-danger'>Page congés</p>";
                    }
                    elseif ($_GET["content"] == "fiches")
                    {
                        echo "<p class='text-danger'>Page fiches de paie</p>";
                    }
                    else
                    {
                        echo "<p class='text-danger'>Page introuvable</p>";
                    }
                }
            ?>
        </div>

        <!--
        <div class="container">
            <h1>Bienvenue, <?php echo htmlspecialchars($name);?> <?php echo htmlspecialchars($surname);?> (<?php echo htmlspecialchars($uid);?>) !</h1>
            <p>Vous êtes connecté.</p>
        </div>
        -->
    </body>
