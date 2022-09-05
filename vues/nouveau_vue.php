<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/styles.css" type="text/css" rel="stylesheet">
        <title>HEPL News | S'enregistrer</title>
    </head>
    <body id="nouveau">

        <!-- Message erreur/success -->
        <div>
            <?php
                if(isset($info))
                {
                    echo $info;
                }
            ?>
        </div>

        <!-- Panel enregistrement -->
    	<form method="post" action="">
    		<p>S'enregistrer</p>
    		<input type="text" name="username" placeholder="Nom d'utilisateur" required>
    		<input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="repeatPassword" placeholder="Répéter mot de passe" required>
    		<button type="submit" name="envoyer">S'enregistrer</button>
    		<p>Déjà inscrit ? <a href="./index.php">Cliquez-ici !</a></p>
    	</form>

        <!-- Consulter News -->
        <a href="./news.php">CONSULTER LES NEWS</a>
    </body>
</html>