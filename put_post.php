<?php
 include('header.php'); 

// check if the ID_topic is present in the database

$request1 = $pdo->prepare("SELECT * FROM `posts` WHERE `id_post` LIKE :id_post");
$request1->bindParam(':id_post', $_POST["id_post"]);
$request1-> execute();
$existence = $request1->fetchAll();

// check if the id_post is a real number

if ( intval($_POST["id_post"]) > 0) {

    // error if the id_post is no present in the table posts

	if( empty($existence) ){
		$return["success"] = false;
		$return["message"] = "Aucun id_post correspondant dans la base de données.";	

    // success the content is modified

	} elseif( !empty($_POST["id_post"]) && !empty($_POST["content"]) ){
			$request2 = $pdo->prepare("UPDATE `posts` SET `content`=:content WHERE `id_post` LIKE :id_post");
			$request2->bindParam(':content', $_POST["content"]);
			$request2->bindParam(':id_post', $_POST["id_post"]);
			$request2-> execute();
			$return["success"] = true;
			$return["message"] = "Le post a bien été changé.";

    // success the author is modified

	} elseif( !empty($_POST["id_post"]) && !empty($_POST["author"]) ){
			$request2 = $pdo->prepare("UPDATE `posts` SET `author`=:author WHERE `id_post` LIKE :id_post");
			$request2->bindParam(':author', $_POST["author"]);
			$request2->bindParam(':id_post', $_POST["id_post"]);
			$request2-> execute();
			$return["success"] = true;
			$return["message"] = "Le post a bien été changé.";

    // error invalid date format 

	} elseif(strtotime($_POST["date"]) == false){
			$return["success"] = false;
			$return["message"] = "Le format de date doit correspondre au modèle yyyy-mm-dd H:m:s.";

    // success date modified

	} elseif( !empty($_POST["id_post"]) && !empty($_POST["date"]) ){
			$request2 = $pdo->prepare("UPDATE `posts` SET `date`=:date WHERE `id_post` LIKE :id_post");
			$request2->bindParam(':date', $_POST["date"]);
			$request2->bindParam(':id_post', $_POST["id_post"]);
			$request2-> execute();
			$return["success"] = true;
			$return["message"] = "Le post a bien été changé.";

    // error missing information

	} else {
		$return["success"] = false;
		$return["message"] = "veuillez entrer les informations correctes de modification de post 2 par 2 : l'id_post +  l'élément à modifier (soit content ou author ou date). Si vous souhaitez modifier plusieurs informations de la meme id_post il faudra répéter l'opération.";
	}

// error when the id_topic is not a real number

} else {
	$return["success"] = false;
	$return["message"] = "Erreur de format : un id_post doit être un nombre entier.";
}

 echo json_encode($return);

 ?>