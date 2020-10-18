 <?php
 include('header.php'); 

// supp du topic

if( !empty($_POST["id_post"]) ){

	// verification des erreurs de typage, si les informations entrées sont bien un nombre

	if( intval($_POST["id_post"]) > 0) {

		// requêtes BDD

		$requete = $pdo->prepare("SELECT * FROM `posts` WHERE `id_post` LIKE :id_post");
		$requete->bindParam(':id_post', $_POST["id_post"]);
		$requete-> execute();
		$resultats = $requete->fetchAll();

		// ERREUR quand l'id_post est correctement entré mais absent de la base de données

		if( empty($resultats) ){
			$retour["success"] = false;
			$retour["message"] = "Aucun id_post correspondant dans la base de données. Un id_post est forcément un nombre entier.";			

		// REUSSI quand l'id_post est correctement entré et présent dans la base de données

		} else {
			$requete = $pdo->prepare("DELETE FROM `posts` WHERE `id_post` LIKE :id_post");
			$requete->bindParam(':id_post', $_POST["id_post"]);
			$requete-> execute();
			$retour["success"] = true;
			$retour["message"] = "Le topic a bien été supprimé.";		
		}

	// ERREUR quand l'id_post n'est pas un nombre

	} else {
		$retour["success"] = false;
		$retour["message"] = "Erreur de format : un id_post est forcément un nombre entier.";
	}

} else {
	$retour["success"] = false;
	$retour["message"] = "veuillez entrer les informations correctes afin de supprimer le topic : id_post.";
}

 echo json_encode($retour);

 ?>