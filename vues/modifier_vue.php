<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/styles.css" type="text/css" rel="stylesheet">
        <title>HEPL News | Modifier</title>
    </head>
    <body id="modification">
        <h1>Modifier une news</h1>

        <div>
            <a href="./panel.php">RETOUR</a>
        </div>

        <div>
            <?php
                if(isset($info))
                {
                    echo $info;
                }
            ?>
        </div>

        <!-- Formulaire de modification de news -->
        <form method="post" action="">
            <label>Titre : *</label>
            <input type="text" name="title" value='<?php echo $news[1]; ?>' placeholder="Titre [3-50]" >

            <label>Votre news : * </label>
            <textarea name="news" placeholder="News [3-1000]"><?php echo $news[2]; ?></textarea>

            <label>Date de publication : *</label>
            <input type="date" value='<?php echo date("Y-m-d", strtotime($news[4])); ?>' name="publicationDate" >

            <label>Date d'expiration : </label>
            <input type="date" <?php if($news[5] != null) {echo "value='".date("Y-m-d", strtotime($news[5]))."'";} ?> name="expiryDate">

            <label>Catégorie : </label>

            <select name="category">
                <?php
                    $categories = recupererToutesCategorie($mysqli);

                    if(!empty($categories))
                    {
                        foreach($categories as $value)
                        {
                            if($value['id'] == $news[6])
                            {
                                echo "<option selected=\"selected\" value=\"".$value['id']."\">".$value['nom']."</option>";
                            }
                            else
                            {
                                echo "<option value=\"".$value['id']."\">".$value['nom']."</option>";
                            }
                        }
                    }
                ?>
            </select>

            <button type="submit" name="Modifier">Modifier</button>
        </form>
    </body>
</html>