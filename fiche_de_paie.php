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

<form method="post" class="container text-center mx-auto p-2" style="width: 70vw;">
    <label for="startPeriode">Start</label>
    <input type="date" name="debutPeriode" id="debutPeriode" class="form-control" value="<?= htmlspecialchars($startPeriode) ?>" />
    <label for="finPeriode">Fin</label>
    <input type="date" name="finPeriode" id="finPeriode" class="form-control" value="<?= htmlspecialchars($finPeriode) ?>" />
    <button type="submit" class="btn btn-primary mt-3">Soumettre</button>
</form>

<?php if (empty($fiches)) : ?>
    <p>Aucune fiche trouvée dans cette période</p>
<?php else :
     ?>
    <p>Fiche la plus récente :</p>
    <?php foreach ($fiches as $fiche) : ?>
        <div>
            <p>Fiche du <?= htmlspecialchars($fiche['debut_periode']) ?> au <?= htmlspecialchars($fiche['fin_periode']) ?></p>
            <form method="post">
                <input type="hidden" name="ficheId" value="<?= htmlspecialchars($fiche['ID_Fichedepaie']) ?>" />
                <button type="submit" name="submit" class="btn btn-primary mt-3">Voir</button>
            </form>
            <form method="post" action="download.php">
                <input type="hidden" name="ficheId" value="<?= htmlspecialchars($fiche['ID_Fichedepaie']) ?>" />
                <button type="submit" class="btn btn-secondary mt-3">Télécharger</button>
            </form>
        </div>
    <?php endforeach; ?>

    <?php if ($ficheToDisplay) : ?>
        <div>
            <h4>Affichage de la fiche :</h4>
            <?php
            $base64pdf = base64_encode($ficheToDisplay['pdf']);
            echo '<embed src="data:application/pdf;base64,' . $base64pdf . '" width="100%" height="90%" />';
            ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
