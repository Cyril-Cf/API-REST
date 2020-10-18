 <?php
 include('header.php'); 


// Verification de l'existence de l'ID_topic dans la table topics

$requete1 = $pdo->prepare("SELECT * FROM `topics` WHERE `id_topic` LIKE :id_topic");
$requete1->bindParam(':id_topic', $_POST["id_topic"]);
$requete1-> execute();
$existence = $requete1->fetchAll();

// verification des erreurs de typage si id_topic est bien un nombre

if ( intval($_POST["id_topic"]) > 0) {

	// ERREUR si l'id_topic est absent de la table topics

	if( empty($existence) ){
		$retour["success"] = false;
		$retour["message"] = "Aucun id_topic correspondant dans la base de données.";	

	// ERREUR mauvais format de date

	} elseif(strtotime($_POST["date"]) == false){
			$retour["success"] = false;
			$retour["message"] = "Le format de date n'est pas respecté. Il doit correspondre au modèle yyyy-mm-dd H:m:s.";

	// sinon REUSSITE ajout du post

	} elseif ( !empty($_POST["id_topic"]) && !empty($_POST["content"]) && !empty($_POST["author"]) && !empty($_POST["date"]) ){

	// Determine le numéro ID_post à ajouter : requêtes BDD pour comptage

	$requete2 = $pdo->prepare("SELECT * FROM `posts`");
	$requete2-> execute();
	$resultats = count($requete2->fetchAll()) + 1;

	// requêtes BDD pour ajout dans la table posts

	$requete3 = $pdo->prepare("INSERT INTO `posts` (`id_post`, `id_topic`, `content`, `author`, `date`) VALUES (:count, :id_topic, :content, :author, :date)");
	$requete3->bindParam(':id_topic', $_POST["id_topic"]);
	$requete3->bindParam(':content', $_POST["content"]);
	$requete3->bindParam(':author', $_POST["author"]);
	$requete3->bindParam(':date', $_POST["date"]);
	$requete3->bindParam(':count', $resultats);
	$requete3-> execute();
	$retour["success"] = true;
	$retour["message"] = "Le post a bien été ajouté.";

	// ERREUR s'il manque des informations hormis l'id_topic

	} else {
		$retour["success"] = false;
		$retour["message"] = "veuillez entrer toutes les informations correctes d'ajout de post : content et author et date en format yyyy-mm-dd H:i:s.";
	}

// ERREUR quand l'id_topic n'est pas un nombre ou est absent

} else {
	$retour["success"] = false;
	$retour["message"] = "Erreur de format : un id_topic doit être présent et est forcément un nombre entier.";
}


 echo json_encode($retour);

 ?>