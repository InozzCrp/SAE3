<?php
require("constante.php");

get_session_verification();

get_head();
?>
<?php
    get_header_dashbord();
?>
    <body>
        <div class='p-3 h-100 dashboardcontent col-10'>
            <h1>
                <?php 
                    $infos = get_infos($pdo, $_SESSION["userid"]);
                    
                    echo "Bienvenue sur la page d'accueil de l'espace employé, $infos[Nom_employe] $infos[Prenom_employe].";
                ?>
            </h1>
            <h3>
                <?php
                    $informations = get_infos($pdo,$_SESSION["userid"]);
                    $nbcongés = $informations["Nb_congés_restants"];
                    echo "Il vous reste $nbcongés jour(s) de congés à placer."
                ?>
            </h3>
            <h3>
                <?php
                    $fiches = rechercheFiches($pdo, $_SESSION["userid"], null, null);
                    $fiches = array_reverse($fiches);
                    $premiereFiche = $fiches[0];

                    $formatter = new IntlDateFormatter(
                        'fr_FR', 
                        IntlDateFormatter::LONG, 
                        IntlDateFormatter::NONE
                    );
                
                    $dateDebut = $formatter->format(new DateTime($premiereFiche['debut_periode']));
                    $dateFin = $formatter->format(new DateTime($premiereFiche['fin_periode']));

                    if(empty($fiches))
                        echo "Vous n'avez aucune fiche de paie de disponible.";
                    else
                        echo "Votre fiche de paie disponible la plus récente est celle du " . htmlspecialchars($dateDebut) . " au " . htmlspecialchars($dateFin) . ".";
                ?>
            </h3>
        </div>
        <!--
        <div class="container">
            <h1>Bienvenue, <?php echo htmlspecialchars($name);?> <?php echo htmlspecialchars($surname);?> (<?php echo htmlspecialchars($uid);?>) !</h1>
            <p>Vous êtes connecté.</p>
        </div>
        -->
    </body>