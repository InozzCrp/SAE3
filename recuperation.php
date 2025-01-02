<?php
    require("parametres\constante.php");
    get_head();
    get_header();
    if(isset($_GET["content"])){
        $content=$_GET["content"];
        if($content=="password"){
            $redirection = "nouveaumdp.php";
        }
        elseif($content=="login"){
            $redirection = "donnelogin.php";
        }
        else{
            die("Requête incorrecte");
        }
    }
?>
<div class="d-flex justify-content-center align-items-center m-5">
       <form method="post" action =<?php echo $redirection ?> class="container text-center mx-auto p-2" style="width: 70vw;">
            <h1>Quel est votre adresse e-mail ?</h1>
            <div class="form-group container row gap-1 mx-auto">
                <input type="email" name="mail" id="email" pattern=".+@gerico\.fr" title="Veuillez utiliser une adresse email d'entreprise" required/>
            </div>
            <div class="row">
                <button type="submit" name="submit" class="btn index mx-auto">Valider</button>
            </div>
        </form>
</div>

