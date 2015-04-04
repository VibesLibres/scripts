<?php
/*
Description : Script livre d'or avec antispam simple
Auteur : Niblischim pour Vibrations Libres
URL : http://vibrationslibres.fr
License : GNU GPL v2
*/
?>

<form action="" method="post">
<strong>Pseudo</strong> : <input type="text" name="pseudo" /><br />
<strong>Message</strong> : <input type="text" name="msg" /><br />
<strong>Antispam</strong> | Ecrire 3 en lettres minuscules <input type="text" name="spam" /><br />
<input type="submit" name="envoi" value="Envoyer" /><br />
</form>
<br />
<?php if(isset($_GET['e']) AND $_GET['e'] == "y") { echo "<br /><font color='red'>Donn&eacute;es manquantes !</font><br />"; } ?>
<?php if(isset($_GET['e']) AND $_GET['e'] == "spam") { echo "<br /><font color='red'>Erreur dans la r&eacute;ponse &agrave; l'antispam !</font><br />"; } ?>
<?php
  function date_fran()
  {
  $mois = array("Janvier", "Février", "Mars",
                "Avril","Mai", "Juin", 
                "Juillet", "Août","Septembre",
                "Octobre", "Novembre", "Décembre");
  $jours= array("Dimanche", "Lundi", "Mardi",
                "Mercredi", "Jeudi", "Vendredi",
                "Samedi");
  return $jours[date("w")]." ".date("j").(date("j")==1 ? "er":" ").
         $mois[date("n")-1]." ".date("Y");
  }

	if(isset($_POST['envoi']) AND $_POST['envoi'] == "Envoyer")
{
	if (!empty($_POST['pseudo']) AND !empty($_POST['msg']))
		{
		if(empty($_POST['spam']))
		  {
		header("Location: livreor.php?e=spam");
	  	}
		else
		  {
		if($_POST['spam'] != "trois")
	    	{
		header("Location:livreor.php?e=spam");		
	    	}
		else
		    {
		$date = date_fran()." à ". date("G:i:s");
		$pseudo = htmlspecialchars($_POST['pseudo']);
		$msg = htmlspecialchars($_POST['msg']);
		$bdd = new PDO("mysql:host=changemoi;dbname=changemoi", "changemoi", "changemoi");
		$req = $bdd->prepare('INSERT INTO livre_or(pseudo,msg,date) VALUES(:pseudo,:msg,:date)');
		$req->execute(array(
			'pseudo' => $pseudo,
			'msg' => $msg,
			'date' => $date
			));
		header("Location: livreor.php");
	      }
	    }
	}
		else
		{
		header("Location: livreor.php?e=y");
		}
}
	else
	{
	$connexion = new PDO("mysql:host=changemoi;dbname=changemoi", "changemoi",  "changemoi");
	$reponse = $connexion->query("SELECT id,pseudo,msg, date FROM livre_or ORDER BY id DESC");
	while ($donnees = $reponse->fetch())
	  {
	?>
<div style="max-width:100%; min-height:40px; word-wrap:break-word; margin-bottom:5px;"><b><font color="green"><?php echo $donnees['pseudo']; ?></font></b> : <?php echo $donnees['msg']; ?>
<div style="margin-left:60%;"><p style="font-size:12px;"><i><?php echo $donnees['date']; ?></i></p></div>
<?php
    }
	}
?>
