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

	/* Supprimer le tuple en question */
	if(is_numeric($_GET['idNews']))
	{
		supprimerNews($mysqli, $_GET['idNews']);
		header('Location: ./index.php');
	}
	
?>