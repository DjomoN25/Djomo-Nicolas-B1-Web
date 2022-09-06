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
	function afficherNews($database, $category)
	{
		if($category != null)
		{
			/* Requête SQL (Sélectionner résultats dont l'expiration n'est pas atteinte et ordonner) */
			$result = mysqli_query($database, "SELECT * FROM news WHERE (expiration IS NULL OR expiration > NOW()) AND publication <= NOW() AND categorie = '$category' ORDER BY publication DESC");
		}
		else
		{
			/* Requête SQL (Sélectionner résultats dont l'expiration n'est pas atteinte et ordonner) */
			$result = mysqli_query($database, "SELECT * FROM news WHERE (expiration IS NULL OR expiration > NOW()) AND publication <= NOW() ORDER BY publication DESC");
		}
		

		//Si la requête fonctionne
		if($result)
		{
			//Si il y a des résultats.
			if(mysqli_num_rows($result) != 0)
			{
				//Retourner les résultats
				$tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
				return($tab);
			}
		}
	}

	function verifierPresenceUtilisateur($database, $nomUtilisateur)
	{
		/* Eviter les caractères mysqli */
		mysqli_real_escape_string($database, $nomUtilisateur);

		/* Requête SQL */
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

		/* Requête SQL */
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

	function insererNews($database, $titre, $texte, $datePublication, $dateExpiration, $categorie)
	{
		/* Eviter les caractères mysqli */
		mysqli_real_escape_string($database, $titre);
		mysqli_real_escape_string($database, $texte);
		$pseudo = $_SESSION['username'];

		/* Requête SQL */
		if($dateExpiration != "NULL")
		{
			mysqli_query($database, "INSERT INTO news (titre, texte, pseudo, publication, expiration, categorie) VALUES ('$titre', '$texte' , '$pseudo' , '$datePublication', '$dateExpiration', '$categorie')");
		}
		else
		{
			mysqli_query($database, "INSERT INTO news (titre, texte, pseudo, publication, expiration, categorie) VALUES ('$titre', '$texte' , '$pseudo' , '$datePublication', NULL, '$categorie')");
		}
	}

	function recupererNewsUtilisateur($database)
	{
		$nomUtilisateur = $_SESSION['username'];

		/* Requête SQL */
		$result = mysqli_query($database, "SELECT * FROM news WHERE pseudo = '$nomUtilisateur'");

		//Si la requête fonctionne
		if($result)
		{
			//Si il y a / n'y a pas l'utilisateur dans la base de données.
			if(mysqli_num_rows($result) != 0)
			{
				$tableau = mysqli_fetch_all($result, MYSQLI_ASSOC);
				return($tableau);
			}
			
		}
	}

	function recupererToutesCategorie($database)
	{
		/* Requête SQL */
		$result = mysqli_query($database, "SELECT * FROM categorie ORDER BY id ASC");

		//Si la requête fonctionne
		if($result)
		{
			//Si il y a des résultats.
			if(mysqli_num_rows($result) != 0)
			{
				$tab = mysqli_fetch_all($result, MYSQLI_ASSOC);
				return($tab);
			}
			
		}
	}

	function recupererCategorie($database, $id)
	{
		/* Requête SQL */
		$result = mysqli_query($database, "SELECT * FROM categorie WHERE id = '$id'");

		//Si la requête fonctionne
		if($result)
		{
			//Si il y a des résultats.
			if(mysqli_num_rows($result) != 0)
			{
				//Retourner les résultats
				$row = mysqli_fetch_row($result);
				return($row);
			}
		}
	}

	function supprimerNews($database, $idNews)
	{
		/* Requête */
		$utilisateur = $_SESSION['username'];

		$result = mysqli_query($database, "DELETE FROM news WHERE idNews = '$idNews' AND pseudo = '$utilisateur'");
	}

	function recupererNews($database, $idNews)
	{
		$identifiant = $_SESSION['username'];

		/* Requête SQL */
		$result = mysqli_query($database, "SELECT * FROM news WHERE idNews = '$idNews' AND pseudo = '$identifiant'");

		//Si la requête fonctionne
		if($result)
		{
			//Si il y a des résultats.
			if(mysqli_num_rows($result) != 0)
			{
				//Retourner les résultats
				$row = mysqli_fetch_row($result);
				return($row);
			}
		}
	}

	function updateNews($database, $titre, $texte, $datePublication, $dateExpiration, $categorie, $idNews)
	{
		/* Eviter les caractères mysqli */
		mysqli_real_escape_string($database, $titre);
		mysqli_real_escape_string($database, $texte);

		$datePublication = date("Y-m-d", strtotime($datePublication));

		if($dateExpiration != "NULL")
		{
			$dateExpiration = date("Y-m-d", strtotime($dateExpiration));
		}

		$utilisateur = $_SESSION['username'];

		/* Requête SQL */
		if($dateExpiration != "NULL")
		{
			mysqli_query($database, "UPDATE news SET titre='$titre' , texte='$texte' , publication='$datePublication' , 
									 expiration='$dateExpiration' , categorie='$categorie'
									 WHERE idNews='$idNews' AND pseudo='$utilisateur'");
		}
		else
		{
			mysqli_query($database, "UPDATE news SET titre='$titre' , texte='$texte' , publication='$datePublication' , 
									 expiration=NULL , categorie='$categorie'
									 WHERE idNews='$idNews' AND pseudo='$utilisateur'");
		}
	}
?>