<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/styles.css" type="text/css" rel="stylesheet">
        <title>HEPL News | Panel d'administration</title>
    </head>
    <body id="panel">
        <!-- Titre -->
        <h1>Panel de gestion de vos news</h1>

        <!-- Déconnexion -->
        <form method="post" action="./deconnexion.php">
            <button type="submit">Se déconnecter</button>
        </form>

        <div>
            <?php
                if(isset($info))
                {
                    echo $info;
                }
            ?>
        </div>

        <!-- Formulaire d'ajout de news -->
        <form method="post" action="">
            <label>Titre : *</label>
            <input type="text" name="title" placeholder="Titre [3-50]" required >

            <label>Votre news : * </label>
            <textarea name="news" placeholder="News [3-1000]" required></textarea>

            <label>Date de publication : *</label>
            <input type="date" name="publicationDate" required>

            <label>Date d'expiration : </label>
            <input type="date" name="expiryDate">

            <label>Catégorie : </label>
            <select name="category" required>
                <?php
                    $categories = recupererToutesCategorie($mysqli);

                    if(!empty($categories))
                    {
                        foreach($categories as $value)
                        {
                            echo "<option value=\"".$value['id']."\">".$value['nom']."</option>";
                        }
                    }
                ?>
            </select>

            <button type="submit" name="ajouter">AJOUTER</button>
        </form>

        <h1> Vos news </h1>

        <!-- Formulaire de vos news -->
        <table>
            <tr>
                <th>TITRE</th>
                <th>TEXTE</th>
                <th>DATE PUBLICATION</th>
                <th>DATE EXPIRATION</th>
                <th>CATEGORIE</th>
                <th>ACTIONS</th>
            </tr>

            <?php
                $tableau = recupererNewsUtilisateur($mysqli);

                if(!empty($tableau))
                {
                    foreach($tableau as $value)
                    {
                        echo "<tr>";
                            echo "<td>". $value['titre'] ."</td>";
                            echo "<td>". $value['texte'] ."</td>";
                            echo "<td>". date("d-m-Y", strtotime($value['publication'])) ."</td>";

                            if($value['expiration'] == null)
                            {
                                echo "<td>Jamais</td>";
                            }
                            else
                            {
                                echo "<td>". date("d-m-Y", strtotime($value['expiration'])) ."</td>";
                            }
                            
                            //Rechercher le nom de la catégorie
                            $categorie = recupererCategorie($mysqli, $value['categorie']);
                            echo "<td>". $categorie[1] . "</td>";

                            //Ajouter les boutons
                            echo "<td>
                                    <a href=\"./supprimer?idNews=".$value['idNews']."\">Supprimer</a>
                                    <a href=\"./modifier?idNews=".$value['idNews']."\">Modifier</a>
                                  </td>";
                        echo "</tr>";
                    }
                }
            ?>
            
        </table>
    </body>
</html>