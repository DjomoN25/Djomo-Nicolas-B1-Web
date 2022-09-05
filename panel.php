<?php
	/* Lancer la session */
	session_start();

	/* Vérifier l'état de connexion */
	if(!isset($_SESSION['connected']))
	{
		header('Location: ./index.php');
	}

	/* Importer modèle */
	require_once('./modeles/modele.php');



	/* Importer la vue */
	require_once('./vues/panel_vue.php');

	/* Fermer la connexion à la base de données */
	mysqli_close($mysqli);
?>