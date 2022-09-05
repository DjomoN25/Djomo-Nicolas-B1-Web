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
			if(isset($_POST['password']) && mb_strlen($_POST['password'], 'utf8') >= 1)
			{
				//Vérifier si le nom d'utilisateur existe
				if(verifierPresenceUtilisateur($mysqli, $_POST['username']) == true)
				{
					//Vérifier mot de passe
					$row = recupererIdentifiants($mysqli, $_POST['username']);


					//Comparer le hash et mot de passe
					if(password_verify($_POST['password'], $row[1]))
					{
						//Rediriger utilisateur + mettre variable de session
						$_SESSION['connected'] = true;
						$_SESSION['username'] = $row[0];
						header('Location: ./panel.php');
					}
					else
					{
						$info = "<p class=\"errorMessage\">Désolé, vos identifiants sont incorrectes..</p>";
					}
				}
				else
				{
					$info = "<p class=\"errorMessage\">Désolé, ce nom d'utilisateur n'existe pas..</p>";
				}
			}
			else
			{
				$info = "<p class=\"errorMessage\">Veuillez entrer votre mot de passe..</p>";
			}
		}		
		else
		{
			$info = "<p class=\"errorMessage\">Veuillez entrer votre nom d'utilisateur..</p>";
		}
	}

	/* Importer la vue */
	require_once('./vues/index_vue.php');

	/* Fermer la connexion à la base de données */
	mysqli_close($mysqli);
?>