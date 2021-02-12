<?php
 include('header.php'); 


// looking for the post with its ID

if( !empty($_POST["id_post"]) ){

    // checking for typing errors, are the information given by the user real numbers

	if( intval($_POST["id_post"]) > 0) {

		// requests database

		$requete = $pdo->prepare("SELECT * FROM `posts` WHERE `id_post` LIKE :id_post");
		$requete->bindParam(':id_post', $_POST["id_post"]);
		$requete-> execute();
		$results = $requete->fetchAll();

        // error shown when the ID is a real number but not present in the database

		if( empty($results) ){
			$return["success"] = false;
			$return["message"] = "Aucun id_post correspondant dans la base de données. Un id_post est forcément un nombre entier.";			

        // Success when the ID is a real number and in the database

		} else {
			$return["success"] = true;
			$return["message"] = "Voici le post :";
			$return["results"]["post"] = $results;			
		}

    // error when the id is not a number

	} else {
		$return["success"] = false;
		$return["message"] = "Erreur de format : Un id_post est forcément un nombre entier.";
	}

// looking in the database by author

} elseif( !empty($_POST["author"]) ){

	// requests database

	$requete = $pdo->prepare("SELECT * FROM `posts` WHERE `author` LIKE :author");
	$requete->bindParam(':author', $_POST["author"]);
	$requete-> execute();
	$results = $requete->fetchAll();

	// error when the author is a string but not in the database

	if( empty($results) ){
		$return["success"] = false;
		$return["message"] = "Aucun auteur correspondant dans la base de données.";			

	// success when the author is a string and present in the database

	} else {
		$return["success"] = true;
		$return["message"] = "Voici le post :";
		$return["results"]["post"] = $results;			
	}

// looking in the database by date

} elseif( !empty($_POST["date"]) ){

	// requests database

	$requete = $pdo->prepare("SELECT * FROM `posts` WHERE `date` LIKE :date");
	$requete->bindParam(':date', $_POST["date"]);
	$requete-> execute();
	$results = $requete->fetchAll();

    // error invalid date format

	if(strtotime($_POST["date"]) == false){
			$return["success"] = false;
			$return["message"] = "Le format de date n'est pas respecté. Il doit correspondre au modèle yyyy-mm-dd H:m:s.";

    // error when the date is valid but not in the database

	} elseif( empty($results) ){
		$return["success"] = false;
		$return["message"] = "Aucune date correspondante dans la base de données.";			

    // success the date is valid and in the database

	} else {
		$return["success"] = true;
		$return["message"] = "Voici le post :";
		$return["results"]["post"] = $results;			
	}

// error when the parameters are not present in the user's request

} else {
	$return["success"] = false;
	$return["message"] = "veuillez entrer les informations correctes de recherche de post : id_post ou author ou date.";
}

 echo json_encode($return);

 ?>