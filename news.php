<?php
	/* Lancer la session */
	session_start();

	/* Importer modèle */
	require_once('./modeles/modele.php');

	if(isset($_POST['filter']))
	{
		if(is_numeric($_POST['category']))
		{
			/* Appeler la fonction pour récupérer les news */
			$news = afficherNews($mysqli, $_POST['category']);
		}
	}
	else
	{
		/* Appeler la fonction pour récupérer les news */
		$news = afficherNews($mysqli, null);
	}

	/* Importer la vue */
	require_once('./vues/news_vues.php');

	/* Fermer la connexion à la base de données */
	mysqli_close($mysqli);
?>