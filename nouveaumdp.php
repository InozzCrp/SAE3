<?php
require_once("constante.php");
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
                    <input type="hidden" name="content" value="password" />
                </form>
                <?php
                die();
            }
    } 


if(isset($_POST["mdp"])){
    $password = $_POST["mdp"];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $requete = $pdo->prepare("UPDATE employe SET mdp_employe = :mdp WHERE email_employe = :mail;");
    $requete->execute([
        ':mail' => $mail, 
        ':mdp' => $hashedPassword 
    ]);
    header("location: ../login.php?error=changedpassword");
    exit();
}

?>
<form method="post" class="container text-center mx-auto p-2" style="width: 70vw;">
    <div class="form-group container row gap-1 mx-auto">
            <input type ="hidden" name="mail" value = <?php echo $mail; ?> >
            <input type="password" name="mdp" class="form-control row mx-auto" placeholder="Entrer votre nouveau mot de passe" required>
    </div>
    <div class="row">
            <button type="submit" name="submit" class="btn index mx-auto">Valider</button>
    </div>
</form>



