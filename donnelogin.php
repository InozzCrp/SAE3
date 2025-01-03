<?php
require("parametres\constante.php");
get_head();
get_header();
$mail = $_POST["mail"];

if(isset($_POST["mail"]))
    {
            $resultat = checkMail($pdo,$mail);
            if(empty($resultat)){
                echo("E-mail n'appartenant à aucun compte");
                ?>
                <form action="../recuperation.php">
                    <input type="submit" value="Retour" />
                </form>
                <?php
                die();
            }
    }

$sql = "Select login_employe from employe where email_employe = :mail";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':mail',$mail, PDO::PARAM_STR);
$stmt->execute();
$resultat = $stmt->fetch(PDO::FETCH_ASSOC);
if(!empty($resultat)){
    echo "Votre login est $resultat[login_employe]";
    ?>
    <form action="../login.php">
        <input type="submit" value="Retour" />
    </form>
    <?php
}
else{
    die("Erreur dans la récupération du login");
}
?>