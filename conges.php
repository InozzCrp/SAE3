<?php
require("constante.php");
get_head();
get_header_dashbord();
$id = $_SESSION["userid"];
$informations = get_infos($pdo,$_SESSION["userid"]);
$nbcongés = $informations["Nb_congés_restants"];
echo "Bonjour ". $informations["Nom_employe"] ."&nbsp". $informations["Prenom_employe"] .", il vous reste " . $nbcongés. " jour(s) de congés restant.";
if($nbcongés==0){
    echo "</br> Par conséquent, vous ne pouvez plus réserver de congés";
}
else{
    if(isset($_POST["date-conges"])){
        $date=$_POST["date-conges"];
        if(isweekend($date)){
            header("location: ../conges.php?error=weekend");
        }
        $resultat = isFerie($pdo,$date);
        if(!empty($resultat)){
            $event = $resultat['nom_evenement'];
            header("location: ../conges.php?error=ferie&event=$event");
        }
        else{
            $periode = $_POST["periode"];
            if(insererConges($pdo,$id,$date,$periode)){
                echo "Votre demande à été transmise";
            }
            else{
                echo "Erreur dans la transmission de votre demande";
            }
        }
    }
    ?>

    <form method="post">
    <input type="date" id="start" name="date-conges" value="2024-09-01" min="2024-09-01" max="2025-08-31" required />
    <select name="periode" id="selection-periode" required>
    <option value="">--Veuillez choisir une période--</option>
    <option value="matin">Matin</option>
    <option value="aprem">Après-midi</option>
    <?php
        if($nbcongés>0.5){
            echo "<option value='journee'>Journée entière</option>";
        }
    ?>
    </select>
    <button type="submit" class="btn btn-primary mt-3">Soumettre</button>
    </form>
    
    <?php

        if(isset($_GET["error"])){
            $error=$_GET["error"];
            if($error=="weekend"){
                echo "<p class='text-danger my-3'>La date choisie est durant le weekend</p>";
            }
            elseif($error=="ferie"){
                $event=$_GET['event'];
                echo "<p class='text-danger my-3'>La date choisie est férié, durant $event </p>";
            }
        }
}
?>
