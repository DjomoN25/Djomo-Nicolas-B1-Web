<?php
	/* Connexion à la database */
	$mysqli = new mysqli("localhost", "root", "", "examen");
	
	/* Message d'erreur */
	if (mysqli_connect_errno()) 
	{
    	printf("Échec de la connexion à la base de donnée: %s\n", mysqli_connect_error());
	}

	$mysqli -> set_charset("utf8");

	/* Changer le fuseau horaire */
	date_default_timezone_set("Europe/Brussels");

	/* Fonctions */
	function afficherNews($database)
	{
		/* Requête SQL (Sélectionner résultats dont l'expiration n'est pas atteinte et ordonner) */
		$result = mysqli_query($database, "SELECT * FROM news WHERE expiration IS NULL OR expiration > NOW() ORDER BY publication");

		//Si la requête fonctionne
		if($result)
		{
			//Retourner les résultats
			$tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
			return($tab);
		}
	}

	function verifierPresenceUtilisateur($database, $nomUtilisateur)
	{
		/* Eviter les caractères mysqli */
		mysqli_real_escape_string($database, $nomUtilisateur);

		/* Requête SQL (Sélectionner résultats dont l'expiration n'est pas atteinte et ordonner) */
		$result = mysqli_query($database, "SELECT * FROM utilisateur WHERE pseudo = '$nomUtilisateur'");

		//Si la requête fonctionne
		if($result)
		{
			//Si il y a / n'y a pas l'utilisateur dans la base de données.
			if(mysqli_num_rows($result) == 0)
			{
				return(false);
			}
			else
			{
				return(true);
			}
		}
	}

	function insererUtilisateur($database, $nomUtilisateur, $hash)
	{
		/* Eviter les caractères mysqli */
		mysqli_real_escape_string($database, $nomUtilisateur);

		/* Requête SQL (Sélectionner résultats dont l'expiration n'est pas atteinte et ordonner) */
		mysqli_query($database, "INSERT INTO utilisateur (pseudo, mdp) VALUES ('$nomUtilisateur' , '$hash')");
	}

	function recupererIdentifiants($database, $nomUtilisateur)
	{
		/* Eviter les caractères mysqli */
		mysqli_real_escape_string($database, $nomUtilisateur);

		/* Requête SQL (Sélectionner résultats dont l'expiration n'est pas atteinte et ordonner) */
		$result = mysqli_query($database, "SELECT * FROM utilisateur WHERE pseudo = '$nomUtilisateur'");

		//Si la requête fonctionne
		if($result)
		{
			//Si il y a l'utilisateur dans la base de données.
			if(mysqli_num_rows($result) != 0)
			{
				$row = mysqli_fetch_row($result);
				return($row);
			}
		}
	}



?>