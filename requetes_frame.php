<?php
/*
Description : Script de propositions de musiques à ajouter à la playlist
Auteur : Niblischim pour Vibrations Libres
URL : http://vibrationslibres.fr
License : GNU GPL v2
*/
?>
<div align="center">
<form action="" method="post">
<font face="Trebuchet MS">Artiste - Titre</font><br /><input type="text" name="musique" /><br /><br />
<font face="Trebuchet MS">Lien pour télécharger (facultatif)</font><br /><input type="text" name="lien" /><br />
<input type="submit" value="Envoyer" name="envoi" />
</form>
<br />
<?php if(isset($_GET['e']) AND $_GET['e'] == "1") { echo "<font color='green' size='+4'><b>Merci !</b></font>"; } ?>
<?php if(isset($_GET['e']) AND $_GET['e'] == "2") { echo "<font color='red' size='+4'><b>Erreur ! Vous n'avez rien rempli !</b></font>"; } ?>
<br />
</div>
<?php
if(isset($_POST['envoi']) AND $_POST['envoi'] == "Envoyer")
	{
	if (!empty($_POST['musique']) AND empty($_POST['lien']))
		{
		$musique = htmlspecialchars($_POST['musique']);
		$bdd = new PDO("mysql:host=HEBERGEUR;dbname=NOMBDD", "UTILISATEUR", "MOTDEPASSE");
		$req = $bdd->prepare('INSERT INTO requetes(musique) VALUES(:musique)');
		$req->execute(array(
			'musique' => $musique
			));
		header("Location: requetes_frame.php?e=1");
		}
			if(!empty($_POST['musique']) AND !empty($_POST['lien']))
			{
			$musique = htmlspecialchars($_POST['musique']);
			$lien = $_POST['lien'];
			$bdd = new PDO("mysql:host=HEBERGEUR;dbname=NOMBDD", "UTILISATEUR", "MOTDEPASSE");
			$req = $bdd->prepare('INSERT INTO requetes(musique, lien) VALUES(:musique, :lien)');
			$req->execute(array(
			'musique' => $musique,
			'lien' => $lien
			));
			header("Location: requetes_frame.php?e=1");
			}
				if(empty($_POST['musique']))
				{
				header("Location: requetes_frame.php?e=2");
				}
	}
?>
