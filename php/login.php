<div class="d-flex justify-content-center align-items-center" style="height:100vh;">
    <form action="includes/connexion.inc.php" method="post" class="container text-center mx-auto p-2" style="width: 70vw;">
        <h1>Espace de connexion Gérico</h1>
        <div class="form-group container row gap-1 mx-auto">
            <label class="row mx-auto" for="inputID">Identifiant</label>
            <input type="text" name="uid" class="form-control row mx-auto" id="inputID" placeholder="Entrer l'identifiant">
        </div>
        <div class="form-group container row gap-1 mx-auto">
            <label class="row mx-auto" for="inputMDP">Mot de passe</label>
            <input type="password" name="password" class="form-control row mx-auto" id="inputMDP" placeholder="Entrer le mot de passe">
        </div>
        <div class="row">
            <button type="submit" name="submit" class="btn index mx-auto">Se connecter</button>
        </div>
        <!-- Apparition d'un message d'erreur selon le code renvoyé dans l'URL -->
        <?php
            if (isset($_GET["error"]))
            {
                if ($_GET["error"] == "emptyinput")
                {
                    echo "<p class='text-danger my-3'>Veuillez remplir tous les champs</p>";
                }
                elseif ($_GET["error"] == "wronglogin")
                {
                    echo "<p class='text-danger my-3'>Identifiant ou mot de passe incorrect</p>";
                }
                elseif ($_GET["error"] == "stmtfailed")
                {
                    echo "<p class='text-danger my-3'>Erreur interne. Réessayez plus tard.</p>";
                }
                elseif($_GET["error"] == "notconnected")
                {
                    echo "<p class='text-danger my-3'>Accès impossible, vous n'êtes pas connecté(e).</p>";
                }
                else
                {
                    echo "<p class='text-danger my-3'>Erreur inconnue. Assistance système requise.</p>";
                }
            }
            ?>
    </form>
</div>