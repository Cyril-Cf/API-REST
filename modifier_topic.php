 <?php
 include('header.php'); 

// Verification de l'existence de l'ID_topic dans la table topics

$requete1 = $pdo->prepare("SELECT * FROM `topics` WHERE `id_topic` LIKE :id_topic");
$requete1->bindParam(':id_topic', $_POST["id_topic"]);
$requete1-> execute();
$existence = $requete1->fetchAll();

// modification du topic

if( !empty($_POST["id_topic"]) && !empty($_POST["title"]) ){

// verification des erreurs de typage si id_topic est bien un nombre

	if ( intval($_POST["id_topic"]) > 0) {

		// ERREUR si l'id_topic est absent de la table topics

		if( empty($existence) ){
			$retour["success"] = false;
			$retour["message"] = "Aucun id_topic correspondant dans la base de données.";	

		// sinon REUSSITE ajout du post

		} else {
			$requete2 = $pdo->prepare("UPDATE `topics` SET `title`=:title WHERE `id_topic` LIKE :id_topic");
			$requete2->bindParam(':title', $_POST["title"]);
			$requete2->bindParam(':id_topic', $_POST["id_topic"]);
			$requete2-> execute();
			$retour["success"] = true;
			$retour["message"] = "Le topic a bien été changé.";
		}
	// ERREUR quand l'id_topic n'est pas un nombre 

	} else {
		$retour["success"] = false;
		$retour["message"] = "Erreur de format : un id_topic doit être un nombre entier.";
	}

// ERREUR s'il manque des informations

} else {
	$retour["success"] = false;
	$retour["message"] = "veuillez entrer les informations correctes de modification de topic : id_topic et title.";
}

 echo json_encode($retour);

 ?>