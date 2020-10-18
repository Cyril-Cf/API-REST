 <?php
 include('header.php'); 

// supp du topic

if( !empty($_POST["id_topic"]) ){

	// verification des erreurs de typage, si les informations entrées sont bien un nombre

	if( intval($_POST["id_topic"]) > 0) {

		// requêtes BDD

		$requete = $pdo->prepare("SELECT * FROM `topics` WHERE `id_topic` LIKE :id_topic");
		$requete->bindParam(':id_topic', $_POST["id_topic"]);
		$requete-> execute();
		$resultats = $requete->fetchAll();

		// ERREUR quand l'id_topic est correctement entré mais absent de la base de données

		if( empty($resultats) ){
			$retour["success"] = false;
			$retour["message"] = "Aucun id_topic correspondant dans la base de données. Un id_topic est forcément un nombre entier.";			

		// REUSSI quand l'id_topic est correctement entré et présent dans la base de données

		} else {
			$requete = $pdo->prepare("DELETE FROM `topics` WHERE `id_topic` LIKE :id_topic");
			$requete->bindParam(':id_topic', $_POST["id_topic"]);
			$requete-> execute();
			$retour["success"] = true;
			$retour["message"] = "Le topic a bien été supprimé.";		
		}

	// ERREUR quand l'id_topic n'est pas un nombre

	} else {
		$retour["success"] = false;
		$retour["message"] = "Erreur de format : un id_topic est forcément un nombre entier.";
	}

} else {
	$retour["success"] = false;
	$retour["message"] = "veuillez entrer les informations correctes afin de supprimer le topic : id_topic.";
}

 echo json_encode($retour);

 ?>