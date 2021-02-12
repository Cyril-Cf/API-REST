<?php
 include('header.php'); 

// adding topic

if( !empty($_POST["title"]) ){

    // Check database to determine which ID_topic to chose from

	$request = $pdo->prepare("SELECT * FROM `topics`");
	$request-> execute();
	$results = count($request->fetchAll()) + 1;

    // success requests database to add the topic to the table

	$request = $pdo->prepare("INSERT INTO `topics` (`id_topic`, `title`) VALUES (:count, :title)");
	$request->bindParam(':title', $_POST["title"]);
	$request->bindParam(':count', $results);
	$request-> execute();
	$return["success"] = true;
	$return["message"] = "Le topic a bien été ajouté.";

// error when there are missing information

} else {
	$return["success"] = false;
	$return["message"] = "veuillez entrer les informations correctes d'ajout de topic : title.";
}

 echo json_encode($return);

 ?>