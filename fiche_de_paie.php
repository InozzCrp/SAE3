<?php
require("constante.php");

get_session_verification();

get_head();
get_header_dashbord();

$startPeriode = isset($_POST["debutPeriode"]) ? $_POST["debutPeriode"] : null;
$finPeriode = isset($_POST["finPeriode"]) ? $_POST["finPeriode"] : null;

if (!$startPeriode && !$finPeriode) {
    $fiches = rechercheFiches($pdo, $_SESSION["userid"], null, null);
} else {
    $fiches = rechercheFiches($pdo, $_SESSION["userid"], $startPeriode, $finPeriode);
}
// Pour avoir les fiches du plus récent au plus vieux
$fiches = array_reverse($fiches);

$ficheToDisplay = null;

// Vérifier si une fiche a été demandée
if (isset($_POST['ficheId'])) {
    $ficheId = intval($_POST['ficheId']);
    foreach ($fiches as $fiche) {
        if ($fiche['ID_Fichedepaie'] === $ficheId) {
            $ficheToDisplay = $fiche;
            break;
        }
    }
}
?>

<link rel="stylesheet" type="text/css" href='styles/css/fiche_de_paye.css'>

<div class='p-3 h-100 dashboardcontent'>
    <div class="fiche-filter d-flex flex-column align-items-center">
        <div class="form-group w-100">
            <label for="startPeriode">Start</label>
            <input type="date" name="debutPeriode" id="debutPeriode" class="form-control" value="<?= htmlspecialchars($startPeriode) ?>" />
        </div>
        <div class="form-group w-100">
            <label for="finPeriode">Fin</label>
            <input type="date" name="finPeriode" id="finPeriode" class="form-control" value="<?= htmlspecialchars($finPeriode) ?>" />
        </div>
        <button type="submit" class="btn btn-primary mt-3">Soumettre</button>
    </div>

    <?php if (empty($fiches)) : ?>
        <p>Aucune fiche trouvée dans cette période</p>
    <?php else :
        ?>
            <div class="fiche-list mt-4">
            <p>Fiche la plus récente :</p> <!-- Utile même ???-->
            <?php foreach ($fiches as $fiche) : ?>
                <div class="fiche-item mb-3 p-3">
                    <p>Fiche du <?= htmlspecialchars($fiche['debut_periode']) ?> au <?= htmlspecialchars($fiche['fin_periode']) ?></p>
                    <form method="post" class="d-inline">
                        <input type="hidden" name="ficheId" value="<?= htmlspecialchars($fiche['ID_Fichedepaie']) ?>" />
                        <button type="submit" name="submit" class="btn btn-success me-2">Voir</button>
                    </form>
                    <form method="post" action="download.php" class="d-inline">
                        <input type="hidden" name="ficheId" value="<?= htmlspecialchars($fiche['ID_Fichedepaie']) ?>" />
                        <button type="submit" class="btn btn-secondary">Télécharger</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($ficheToDisplay) : ?>
            <div>
                <h4>Affichage de la fiche :</h4>
                <?php
                $base64pdf = base64_encode($ficheToDisplay['pdf']);
                echo '<embed src="data:application/pdf;base64,' . $base64pdf . '" width="100%" height="90%" />';
                ?>
            </div>
        <?php endif; ?>
    <?php endif;?>
</div>
