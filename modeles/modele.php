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

	function afficherNews()
	{
		/* Variable d'accès à la base de donnée */
		global $mysqli;

		/* Requête SQL (Sélectionner résultats dont l'expiration n'est pas atteinte) + ORDRE  */
		$result = mysqli_query($mysqli, "SELECT * FROM news");

		//Si la requête fonctionne
		if($result)
		{
			//Retourner les résultats
			$tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
			return($tab);
		}
	}

?>