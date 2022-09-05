<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/styles.css" type="text/css" rel="stylesheet">
        <title>HEPL News | Se connecter</title>
    </head>
    <body id="index">

        <!-- Message erreur/success -->
        <div>
            <?php
                if(isset($info))
                {
                    echo $info;
                }
            ?>
        </div>

    	<!-- Panel connexion -->
    	<form method="post" action="./">
    		<p>Connexion</p>
    		<input type="text" name="username" placeholder="Nom d'utilisateur">
    		<input type="password" name="password" placeholder="Mot de passe">
    		<button type="submit" name="envoyer">Connexion</button>
    		<p>Pas encore inscrit ? <a href="./nouveau.php">Cliquez-ici !</a></p>
    	</form>

    	<!-- Consulter News -->
        <a href="./news.php">CONSULTER LES NEWS</a>
    </body>
</html>