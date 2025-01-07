<?php
require_once("constante.php");

get_session_verification_admin();

get_head();
get_header_dashbord();
if(isset($_POST['idconge'])){
    $idconge = $_POST['idconge'];
}
else{
    die("Requête invalide");
}

if(isset($_GET["status"])){
    $status = $_GET["status"];
    if($status === "accept"){
        validationConges($pdo,$idconge,"Accepté");
        echo "Le congé à bien été validé";
    }
    elseif($status === "deny"){
        validationConges($pdo,$idconge,"Refusé");
        echo "Le congé à bien été refusé";
    }
    else{
        die("Requête invalide");
    }
}
?>
<form action="../admin.php">
                    <input type="submit" value="Retour" />
</form>