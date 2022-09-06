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

	/* Vérifier si l'id du formulaire est bien communiquer et récupérer le formulaire si existe si non rediriger */
	if(isset($_GET['idNews']))
	{
		if(is_numeric($_GET['idNews']))
		{
			$news = recupererNews($mysqli, $_GET['idNews']);

			if(empty($news))
			{
				header('Location: ./panel.php');
			}

			//Les informations étant chargées si aucune contrainte, elles sont récupérables dans la vue
		}
		else
		{
			header('Location: ./panel.php');
		}
	}
	else
	{
		header('Location: ./panel.php');
	}

	/* Vérifier si formulaire envoyé */
	/* Vérifier si il y a un envoie de formulaire */
	if(isset($_POST['Modifier']))
	{
		/* Vérifier les données pour pas que les noms soient modifiés*/
		if(isset($_POST['title']))
		{
			if(isset($_POST['news']))
			{
				if(isset($_POST['publicationDate']))
				{
					if(isset($_POST['expiryDate']))
					{
						if(isset($_POST['category']))
						{
							/* Vérifier le contenu des variables */
							if(mb_strlen($_POST['title'], 'utf8') >= 3 && mb_strlen($_POST['title'], 'utf8') <= 50)
							{
								if(mb_strlen($_POST['news'], 'utf8') >= 3 && mb_strlen($_POST['news'], 'utf8') <= 1000)
								{
									$now = date("d-m-Y H:i:s");

									if(!empty($_POST['publicationDate']) && $_POST['publicationDate'] >= $now)
									{

										//Vérifier la catégorie sélectionnée
										$categories = recupererToutesCategorie($mysqli);
										$bool = false;

										foreach($categories as $value)
										{
											if($_POST['category'] == $value['id'])
											{
												$bool = true;
											}
										}

										if($bool == true)
										{
											if(!empty($_POST['expiryDate']))
											{
												if($_POST['expiryDate'] >= $now)
												{
													//Insérer avec date expiration connue
													$info = "<p class=\"successMsg\">La news a bien été modifiée, veuillez actualiser la page</p>";
													updateNews($mysqli, $_POST['title'], $_POST['news'], $_POST['publicationDate'], $_POST['expiryDate'], $_POST['category'], $_GET['idNews']);
												}
												else
												{
													$info = "<p class=\"errorMsg\">La date d'expiration doit toujours >= à aujourd'hui si celle-ci est présente</p>";
												}
											}
											else
											{
												//Insérer avec date expiration nulle
												$info = "<p class=\"successMsg\">La news a bien été modifiée, veuillez actualiser la page</p>";
												
												updateNews($mysqli, $_POST['title'], $_POST['news'], $_POST['publicationDate'], "NULL", $_POST['category'], $_GET['idNews']);
											}
										}
										else
										{
											$info = "<p class=\"errorMsg\">La catégorie séléctionnée n'existe pas..</p>";
										}

										
									}
									else
									{
										$info = "<p class=\"errorMsg\">La date de publication ne peut être null et doit toujours >= à aujourd'hui</p>";
									}
								}
								else
								{
									$info = "<p class=\"errorMsg\">La news doit faire minimum 3 caractères et maximum 1000</p>";
								}
							}
							else
							{
								$info = "<p class=\"errorMsg\">Le titre doit faire minimum 3 caractères</p>";
							}
						}
						else
						{
							$info = "<p class=\"errorMsg\">Vous devez entrer une catégorie..</p>";
						}
					}
					else
					{
						$info = "<p class=\"errorMsg\">Vous devez entrer une date d'expiration..</p>";
					}
				}
				else
				{
					$info = "<p class=\"errorMsg\">Vous devez entrer une date de publication..</p>";
				}
			}
			else
			{
				$info = "<p class=\"errorMsg\">Vous devez entrer une news..</p>";
			}
		}
		else
		{
			$info = "<p class=\"errorMsg\">Vous devez entrer un titre..</p>";
		}
	}

	/* Importer la vue */
	require_once('./vues/modifier_vue.php');

	/* Fermer la connexion à la base de données */
	mysqli_close($mysqli);
?>