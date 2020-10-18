 <?php
 include('header.php'); 

// recherche du topic via son ID

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
			$retour["success"] = true;
			$retour["message"] = "Voici le topic :";
			$retour["resultats"]["topic"] = $resultats;			
		}

	// ERREUR quand l'id_topic n'est pas un nombre

	} else {
		$retour["success"] = false;
		$retour["message"] = "Erreur de format : Un id_topic est forcément un nombre entier.";
	}

// recherche par titre complet

} elseif( !empty($_POST["title"]) ){

	// requêtes BDD

	$requete = $pdo->prepare("SELECT * FROM `topics` WHERE `title` LIKE :title");
	$requete->bindParam(':title', $_POST["title"]);
	$requete-> execute();
	$resultats = $requete->fetchAll();

	// ERREUR quand le title est correctement entré mais absent de la base de données

	if( empty($resultats) ){
		$retour["success"] = false;
		$retour["message"] = "Aucun topic correspondant dans la base de données. Veuillez entrer le titre entier espace compris.";			

	// REUSSI quand le title est correctement entré et présent dans la base de données

	} else {
		$retour["success"] = true;
		$retour["message"] = "Voici le topic :";
		$retour["resultats"]["topic"] = $resultats;			
	}

// ERREUR quand les paramêtres de recherche sont vides

} else {
	$retour["success"] = false;
	$retour["message"] = "veuillez entrer les informations correctes de recherche de topic : id_topic ou title.";
}

 echo json_encode($retour);

 ?>