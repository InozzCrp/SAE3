<?php
require("parametres\constante.php");
get_head();
?>
<?php
    get_header_dashbord();
?>
    <body>
        <div class='p-3 h-100 dashboardcontent col-10'>
            <?php
                if (isset($_GET["content"]))
                {
                    if ($_GET["content"] == "conges")
                    {
                        $file = 'media\pdf\PDF_Test.pdf'; // Chemin vers votre fichier PDF

                        echo '<object data="' . $file . '" type="application/pdf" width="100px" height="100px">
                            <p>Votre navigateur ne supporte pas les fichiers PDF. <a href="' . $file . '">Télécharger le fichier PDF</a>.</p>
                        </object>';
                    }
                    elseif ($_GET["content"] == "fiches")
                    {
                        echo "<p class='text-danger'>Page fiches de paie</p>";
                    }
                    else
                    {
                        echo "<p class='text-danger'>Page accueil</p>";
                    }
                }
            ?>
        </div>
        <!--
        <div class="container">
            <h1>Bienvenue, <?php echo htmlspecialchars($name);?> <?php echo htmlspecialchars($surname);?> (<?php echo htmlspecialchars($uid);?>) !</h1>
            <p>Vous êtes connecté.</p>
        </div>
        -->
    </body>
