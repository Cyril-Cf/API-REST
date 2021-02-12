<?php
 include('header.php'); 

// browsing the database to find a topic with its ID

$request1 = $pdo->prepare("SELECT * FROM `topics` WHERE `id_topic` LIKE :id_topic");
$request1->bindParam(':id_topic', $_POST["id_topic"]);
$request1-> execute();
$existence = $request1->fetchAll();

// checking for typing errors, are the information given by the user real numbers

if ( intval($_POST["id_topic"]) > 0) {

    // error when the id_topic is not present in the table topics

	if( empty($existence) ){
		$return["success"] = false;
		$return["message"] = "Aucun id_topic correspondant dans la base de données.";	

    // error invalid date format

	} elseif(strtotime($_POST["date"]) == false){
			$return["success"] = false;
			$return["message"] = "Le format de date n'est pas respecté. Il doit correspondre au modèle yyyy-mm-dd H:m:s.";

    // success post added to the database

	} elseif ( !empty($_POST["id_topic"]) && !empty($_POST["content"]) && !empty($_POST["author"]) && !empty($_POST["date"]) ){

    // request database to determine the ID_post to select 

	$request2 = $pdo->prepare("SELECT * FROM `posts`");
	$request2-> execute();
	$results = count($request2->fetchAll()) + 1;

    // request database to add in the table posts

	$request3 = $pdo->prepare("INSERT INTO `posts` (`id_post`, `id_topic`, `content`, `author`, `date`) VALUES (:count, :id_topic, :content, :author, :date)");
	$request3->bindParam(':id_topic', $_POST["id_topic"]);
	$request3->bindParam(':content', $_POST["content"]);
	$request3->bindParam(':author', $_POST["author"]);
	$request3->bindParam(':date', $_POST["date"]);
	$request3->bindParam(':count', $results);
	$request3-> execute();
	$return["success"] = true;
	$return["message"] = "Le post a bien été ajouté.";

    // error if not enough information beside the id_topic

	} else {
		$return["success"] = false;
		$return["message"] = "veuillez entrer toutes les informations correctes d'ajout de post : content et author et date en format yyyy-mm-dd H:i:s.";
	}

// error when the id_topic is not a number or not present

} else {
	$return["success"] = false;
	$return["message"] = "Erreur de format : un id_topic doit être présent et est forcément un nombre entier.";
}

 echo json_encode($return);

 ?>