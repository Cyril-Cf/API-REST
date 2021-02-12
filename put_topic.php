<?php
 include('header.php'); 

// check if the id_post exists in the table topics

$request1 = $pdo->prepare("SELECT * FROM `topics` WHERE `id_topic` LIKE :id_topic");
$request1->bindParam(':id_topic', $_POST["id_topic"]);
$request1-> execute();
$existence = $request1->fetchAll();

// initiation of the modification of the topic

if( !empty($_POST["id_topic"]) && !empty($_POST["title"]) ){

// checks if the id_topic is a real number

	if ( intval($_POST["id_topic"]) > 0) {

        // error if the id_topic is absent from the table topics

		if( empty($existence) ){
			$return["success"] = false;
			$return["message"] = "Aucun id_topic correspondant dans la base de données.";	

        // else success post added

		} else {
			$request2 = $pdo->prepare("UPDATE `topics` SET `title`=:title WHERE `id_topic` LIKE :id_topic");
			$request2->bindParam(':title', $_POST["title"]);
			$request2->bindParam(':id_topic', $_POST["id_topic"]);
			$request2-> execute();
			$return["success"] = true;
			$return["message"] = "Le topic a bien été changé.";
		}
    
    // error when the id_topic is not a real number

	} else {
		$return["success"] = false;
		$return["message"] = "Erreur de format : un id_topic doit être un nombre entier.";
	}

// error when missing information

} else {
	$return["success"] = false;
	$return["message"] = "veuillez entrer les informations correctes de modification de topic : id_topic et title.";
}

 echo json_encode($return);

 ?>