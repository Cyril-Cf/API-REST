<?php
 include('header.php'); 

// erasing the topic

if( !empty($_POST["id_topic"]) ){

    // checks is the informations typed is a real number

	if( intval($_POST["id_topic"]) > 0) {

		// request database

		$request = $pdo->prepare("SELECT * FROM `topics` WHERE `id_topic` LIKE :id_topic");
		$request->bindParam(':id_topic', $_POST["id_topic"]);
		$request-> execute();
		$results = $request->fetchAll();

        // error when the id_topic is a real number but absent from the database

		if( empty($results) ){
			$return["success"] = false;
			$return["message"] = "Aucun id_topic correspondant dans la base de données. Un id_topic est forcément un nombre entier.";			

        // success when the id_topic is a real number and present in the database

		} else {
			$request = $pdo->prepare("DELETE FROM `topics` WHERE `id_topic` LIKE :id_topic");
			$request->bindParam(':id_topic', $_POST["id_topic"]);
			$request-> execute();
			$return["success"] = true;
			$return["message"] = "Le topic a bien été supprimé.";		
		}

    // error when the id_topic is not a real number

	} else {
		$return["success"] = false;
		$return["message"] = "Erreur de format : un id_topic est forcément un nombre entier.";
	}

} else {
	$return["success"] = false;
	$return["message"] = "veuillez entrer les informations correctes afin de supprimer le topic : id_topic.";
}

 echo json_encode($return);

 ?>