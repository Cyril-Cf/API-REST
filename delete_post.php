<?php
 include('header.php'); 

// erasing the post

if( !empty($_POST["id_post"]) ){

    // checks if the information entered are real numbers

	if( intval($_POST["id_post"]) > 0) {

		// request database

		$request = $pdo->prepare("SELECT * FROM `posts` WHERE `id_post` LIKE :id_post");
		$request->bindParam(':id_post', $_POST["id_post"]);
		$request-> execute();
		$results = $request->fetchAll();

        // error when the id_post is a real number but absent from the database

		if( empty($results) ){
			$return["success"] = false;
			$return["message"] = "Aucun id_post correspondant dans la base de données. Un id_post est forcément un nombre entier.";			

        // success when the id_post is a real number and present in the database

		} else {
			$request = $pdo->prepare("DELETE FROM `posts` WHERE `id_post` LIKE :id_post");
			$request->bindParam(':id_post', $_POST["id_post"]);
			$request-> execute();
			$return["success"] = true;
			$return["message"] = "Le topic a bien été supprimé.";		
		}

    // error when the id_post is not a real number

	} else {
		$return["success"] = false;
		$return["message"] = "Erreur de format : un id_post est forcément un nombre entier.";
	}

} else {
	$return["success"] = false;
	$return["message"] = "veuillez entrer les informations correctes afin de supprimer le topic : id_post.";
}

 echo json_encode($return);

 ?>