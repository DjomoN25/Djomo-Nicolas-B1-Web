<?php
	/* Lancer la session */
	session_start();

	/* Supprimer la session */
	session_destroy();

	/* Rediriger sur la page de connexion */
	header('Location: ./index.php');
?>