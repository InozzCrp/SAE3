<?php
    require_once("constante.php");

    if(isset($_POST["submit"]) && isset($_POST["uid"]) && isset($_POST["password"]))
    {
        $uid = $_POST["uid"];
        $password = $_POST["password"];

        loginUser($pdo, $uid, $password);
    }

	get_head();
?>
<body>
	<?php
		get_header();
	?>
    <div class="d-flex justify-content-center align-items-center m-5">
       <form method="post" class="container text-center mx-auto p-2" style="width: 70vw;">
            <h1>Espace de connexion Gérico</h1>
            <div class="form-group container row gap-1 mx-auto">
                <label class="row mx-auto" for="inputID">Identifiant</label>
                <input type="text" name="uid" class="form-control row mx-auto" id="inputID" placeholder="Entrer l'identifiant" required>
            </div>
            <div class="form-group container row gap-1 mx-auto">
                <label class="row mx-auto" for="inputMDP">Mot de passe</label>
                <input type="password" name="password" class="form-control row mx-auto" id="inputMDP" placeholder="Entrer le mot de passe" required>
            </div>
            <div class="container row">
                <button type="submit" name="submit" class="btn btn-primary index mx-auto border border-dark">Se connecter</button>
            </div>
            <div class="form-group container row gap-1 mx-auto">
                <a href="recuperation.php?content=login" class="row mx-auto btn btn-secondary mt-3 border border-dark">Login oublié ?</a>
                <a href="recuperation.php?content=password" class="row mx-auto btn btn-secondary mt-3 border border-dark">Mot de passe oublié ?</a>
            <div class="form-group container row gap-1 mx-auto">
            
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
                elseif($_GET["error"] == "changedpassword")
                {
                    echo '<b><p>Mot de passe modifié.</p></b>';
                }
                else
                {
                    echo "<p class='text-danger my-3'>Erreur inconnue. Assistance système requise.</p>";
                }
            }
            ?>
        </form>
    </div>
</body>