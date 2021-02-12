<?php
 include('header.php'); 


// browsing the database to find a topic with its ID

if( !empty($_POST["id_topic"]) ){

	// checking for typing errors, are the information given by the user real numbers

	if( intval($_POST["id_topic"]) > 0) {

		// requests database

		$requete = $pdo->prepare("SELECT * FROM `topics` WHERE `id_topic` LIKE :id_topic");
		$requete->bindParam(':id_topic', $_POST["id_topic"]);
		$requete-> execute();
		$results = $requete->fetchAll();

        // error shown when the ID is a real number but not present in the database

		if( empty($results) ){
			$return["success"] = false;
			$return["message"] = "Aucun id_topic correspondant dans la base de données. Un id_topic est forcément un nombre entier.";			

        // Success when the ID is a real number and in the database

		} else {
			$return["success"] = true;
			$return["message"] = "Voici le topic :";
			$return["results"]["topic"] = $results;			
		}

    // error when the id is not a number

	} else {
		$return["success"] = false;
		$return["message"] = "Erreur de format : Un id_topic est forcément un nombre entier.";
	}

// looking in the database by complete title

} elseif( !empty($_POST["title"]) ){

	// requests database

	$requete = $pdo->prepare("SELECT * FROM `topics` WHERE `title` LIKE :title");
	$requete->bindParam(':title', $_POST["title"]);
	$requete-> execute();
	$results = $requete->fetchAll();

	// error when the title is a string but absent from the database

	if( empty($results) ){
		$return["success"] = false;
		$return["message"] = "Aucun topic correspondant dans la base de données. Veuillez entrer le titre entier espace compris.";			

	// success when the title is a string and present in the database

	} else {
		$return["success"] = true;
		$return["message"] = "Voici le topic :";
		$return["results"]["topic"] = $results;			
	}

// error when the parameters entered are missing

} else {
	$return["success"] = false;
	$return["message"] = "veuillez entrer les informations correctes de recherche de topic : id_topic ou title.";
}

 echo json_encode($return);

 ?>