<?php
require("constante.php");
get_session_verification();
get_head();
get_header_dashbord();

$id = $_SESSION["userid"];
$informations = get_infos($pdo,$_SESSION["userid"]);
$conges = recupererConges($pdo,$id);
$nbconges = $informations["Nb_congés_restant"];



echo "Bonjour ". $informations["Nom_employe"] ." ". $informations["Prenom_employe"] .", il vous reste " . $nbconges. " jour(s) de congés restant. <br>";

if($nbconges==0){
    echo "</br> Par conséquent, vous ne pouvez plus réserver de congés";
}
else{
    if(isset($_POST["date-conges"])){
        $date=$_POST["date-conges"];
        if(isweekend($date)){
            header("location: ../conges.php?status=weekend");
            exit();
        }
        $resultat = isFerie($pdo,$date);
        if($resultat){
            $event = $resultat['nom_evenement'];
            header("location: ../conges.php?status=ferie&event=$event");
            exit();
        }
        else{
            $periode = $_POST["periode"];
            if(insererConges($pdo,$id,$date,$periode)){
                updateConge($pdo,$id,$periode,$nbconges);
                header("location: ../conges.php?status=success");
                exit();
            }
            else{
                die("Erreur dans la transmission de votre demande");
            }
        }
    }
}
    ?>

    <form method="post">
    <input type="date" id="start" name="date-conges" value="2024-09-01" min="2024-09-01" max="2025-08-31" required />
    <select name="periode" id="selection-periode" required>
    <option value="">--Veuillez choisir une période--</option>
    <option value="matinée">Matin</option>
    <option value="après-midi">Après-midi</option>
    <?php
        if($nbconges>0.5){
            echo "<option value='journée'>Journée entière</option>";
        }
    ?>
    </select>
    <button type="submit" class="btn btn-primary mt-3">Soumettre</button>
    </form>
    <?php
        if($conges){
            echo '<form method="post" action="">';
            echo '<button type="submit" name="montre_conges">Afficher vos jours de congés</button>';
            echo '</form>';
        }

        if(isset($_POST["montre_conges"])){
            foreach($conges as $jour){
                // Créer un objet DateTime
                $date = $jour["Date_congé"];
                $dateTime = new DateTime($date);

                // Formatter avec IntlDateFormatter
                $formatter = new IntlDateFormatter(
                'fr_FR', // Locale en français
                IntlDateFormatter::FULL, // Niveau de détail pour la date
                IntlDateFormatter::NONE // Pas besoin de l'heure
                );
                $formatter->setPattern('EEEE d MMMM yyyy'); // Personnalisation du format

                if($jour["Date_congé"]==1){
                    $validation=", validé";
                }
                else{
                    $validation=", en attente de validation";
                }

                echo "Le ". $formatter->format($dateTime) . ", ". $jour["Partie_journée"] ." ". $validation . "<br>";
            }
        }
        if(isset($_GET["status"])){
            $status=$_GET["status"];
            if($status=="weekend"){
                echo "<p class='text-danger my-3'>La date choisie est durant le weekend</p>";
            }
            elseif($status=="ferie"){
                $event=$_GET['event'];
                echo "<p class='text-danger my-3'>La date choisie est férié, durant $event </p>";
            }
            elseif($status=="success"){
                echo "<p>Votre demande à été transmise à l'administrateur</p>";
            }
        }
?> 