<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/styles.css" type="text/css" rel="stylesheet">
        <title>HEPL News | Liste des news</title>
    </head>
    <body id="news">
        <p id="newsheader">LISTE DES NEWS</p>

        <!-- CHOISIR LA CATEGORIE -->
        <form method="post" action="">
            <a href="./index.php">RETOUR</a>
            <select>
                <option value="" disabled selected>Categorie</option>
                <option></option>
                <option></option>
                <option></option>
            </select>
            <button type="submit">></button>
        </form>

        <div>
            <?php 
                if($news != null)
                {
                    foreach ($news as $value) 
                    {
                        echo "<div class=\"nouveaute\">";
                            echo "<div class=\"en-tete\">";
                                echo "<p>Date : ".$value['publication']."</p>";
                                echo "<p>Titre : ".$value['titre']."</p>";
                                echo "<p>Auteur : ".$value['pseudo']."</p>";
                            echo "</div>";

                            echo "<div class=\"corp\">";
                                echo "<p>".$value['texte']."</p>";
                            echo "</div>";
                        echo "</div>";
                    }
                }  
            ?>
        </div>

    </body>
</html>