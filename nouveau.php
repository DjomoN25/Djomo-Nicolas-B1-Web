<?php
	/* Lancer la session */
	session_start();

	/* Vérifier l'état de connexion */
	if(isset($_SESSION['connected']))
	{
		header('Location: ./panel.php');
	}

	/* Importer modèle */
	require_once('./modeles/modele.php');

	//Vérifier si le formulaire est envoyé ou non
	if(isset($_POST['envoyer']))
	{
		//Si envoyé, vérifier les champs
		if(isset($_POST['username']))
		{
			//Vérifier la composition du nom d'utilisateur
			if(preg_match('#^[0-9a-zA-Z]{3,10}$#', $_POST['username']))
			{
				if(isset($_POST['password']))
				{
					if(mb_strlen($_POST['password'], 'utf8') >= 8)
					{
						if(isset($_POST['repeatPassword']) && mb_strlen($_POST['repeatPassword'], 'utf8') >= 1)
						{
							//Vérifier que le nom d'utilisateur d'existe pas
							if(verifierPresenceUtilisateur($mysqli, $_POST['username']) == false)
							{
								//Vérifier que les mot de passes sont les mêmes.
								if($_POST['password'] == $_POST['repeatPassword'])
								{
									//Hash password
									$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

									//Insérer dans la base de donnée
									insererUtilisateur($mysqli, $_POST['username'], $hashedPassword);

									//Message succès
									$info = "<p class=\"successMessage\">Votre compte a bien été créé, vous pouvez vous connecter..</p>";
								}
								else
								{
									$info = "<p class=\"errorMessage\">Vos mot de passes ne sont pas identiques..</p>";
								}
							}
							else
							{
								$info = "<p class=\"errorMessage\">Cette personne existe déjà, veuillez vous connecter..</p>";
							}
						}
						else
						{
							$info = "<p class=\"errorMessage\">Veuillez répéter votre mot de passe..</p>";
						}
					}
					else
					{
						$info = "<p class=\"errorMessage\">Veuillez entrer un mot de passe contenant 8 caractères minimum..</p>";
					}
					
				}
				else
				{
					$info = "<p class=\"errorMessage\">Veuillez entrer un mot de passe..</p>";
				}
			}
			else
			{
				$info = "<p class=\"errorMessage\">Le nom d'utilisateur doit être composé de : 
							<br> - Lettres ou chiffres (minuscules / majuscules)  
							<br> - 3 caractères minimum et 10 maximum !</p>";
			}
		}
		else
		{
			$info = "<p class=\"errorMessage\">Veuillez entrer un nom d'utilisateur..</p>";
		}
	}

	/* Importer la vue */
	require_once('./vues/nouveau_vue.php');

	/* Fermer la connexion à la base de données */
	mysqli_close($mysqli);
?>