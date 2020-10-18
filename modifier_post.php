 <?php
 include('header.php'); 

// Verification de l'existence de l'ID_topic dans la table posts

$requete1 = $pdo->prepare("SELECT * FROM `posts` WHERE `id_post` LIKE :id_post");
$requete1->bindParam(':id_post', $_POST["id_post"]);
$requete1-> execute();
$existence = $requete1->fetchAll();

// verification des erreurs de typage si id_post est bien un nombre

if ( intval($_POST["id_post"]) > 0) {

	// ERREUR si l'id_post est absente de la table posts

	if( empty($existence) ){
		$retour["success"] = false;
		$retour["message"] = "Aucun id_post correspondant dans la base de données.";	

	// REUSSITE modification du content

	} elseif( !empty($_POST["id_post"]) && !empty($_POST["content"]) ){
			$requete2 = $pdo->prepare("UPDATE `posts` SET `content`=:content WHERE `id_post` LIKE :id_post");
			$requete2->bindParam(':content', $_POST["content"]);
			$requete2->bindParam(':id_post', $_POST["id_post"]);
			$requete2-> execute();
			$retour["success"] = true;
			$retour["message"] = "Le post a bien été changé.";

	// REUSSITE modification de l'auteur

	} elseif( !empty($_POST["id_post"]) && !empty($_POST["author"]) ){
			$requete2 = $pdo->prepare("UPDATE `posts` SET `author`=:author WHERE `id_post` LIKE :id_post");
			$requete2->bindParam(':author', $_POST["author"]);
			$requete2->bindParam(':id_post', $_POST["id_post"]);
			$requete2-> execute();
			$retour["success"] = true;
			$retour["message"] = "Le post a bien été changé.";

	// ERREUR mauvais format de date

	} elseif(strtotime($_POST["date"]) == false){
			$retour["success"] = false;
			$retour["message"] = "Le format de date doit correspondre au modèle yyyy-mm-dd H:m:s.";

	// REUSSITE modification de la date

	} elseif( !empty($_POST["id_post"]) && !empty($_POST["date"]) ){
			$requete2 = $pdo->prepare("UPDATE `posts` SET `date`=:date WHERE `id_post` LIKE :id_post");
			$requete2->bindParam(':date', $_POST["date"]);
			$requete2->bindParam(':id_post', $_POST["id_post"]);
			$requete2-> execute();
			$retour["success"] = true;
			$retour["message"] = "Le post a bien été changé.";


	// ERREUR s'il manque des informations

	} else {
		$retour["success"] = false;
		$retour["message"] = "veuillez entrer les informations correctes de modification de post 2 par 2 : l'id_post +  l'élément à modifier (soit content ou author ou date). Si vous souhaitez modifier plusieurs informations de la meme id_post il faudra répéter l'opération.";
	}

// ERREUR quand l'id_topic n'est pas un nombre 

} else {
	$retour["success"] = false;
	$retour["message"] = "Erreur de format : un id_post doit être un nombre entier.";
}

 echo json_encode($retour);

 ?>