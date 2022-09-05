<?php
	/* Importer modèle */
	require_once('./modeles/modele.php');

	/* Appeler la fonction pour récupérer les news */
	$news = afficherNews();

	require_once('./vues/news_vues.php');


?>