<?php
	/* Lancer la session */
	session_start();

	/* Importer modèle */
	require_once('./modeles/modele.php');

	/* Appeler la fonction pour récupérer les news */
	$news = afficherNews($mysqli);

	/* Importer la vue */
	require_once('./vues/news_vues.php');

	/* Fermer la connexion à la base de données */
	mysqli_close($mysqli);


?>