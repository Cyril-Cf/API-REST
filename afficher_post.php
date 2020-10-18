 <?php
 include('header.php'); 

// recherche du post via son ID

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
			$retour["success"] = true;
			$retour["message"] = "Voici le post :";
			$retour["resultats"]["post"] = $resultats;			
		}

	// ERREUR quand l'id_post n'est pas un nombre

	} else {
		$retour["success"] = false;
		$retour["message"] = "Erreur de format : Un id_post est forcément un nombre entier.";
	}

// recherche par auteur

} elseif( !empty($_POST["author"]) ){

	// requêtes BDD

	$requete = $pdo->prepare("SELECT * FROM `posts` WHERE `author` LIKE :author");
	$requete->bindParam(':author', $_POST["author"]);
	$requete-> execute();
	$resultats = $requete->fetchAll();

	// ERREUR quand l'auteur est correctement entré mais absent de la base de données

	if( empty($resultats) ){
		$retour["success"] = false;
		$retour["message"] = "Aucun auteur correspondant dans la base de données.";			

	// REUSSI quand l'auteur est correctement entré et présent dans la base de données

	} else {
		$retour["success"] = true;
		$retour["message"] = "Voici le post :";
		$retour["resultats"]["post"] = $resultats;			
	}

// recherche par date

} elseif( !empty($_POST["date"]) ){

	// requêtes BDD

	$requete = $pdo->prepare("SELECT * FROM `posts` WHERE `date` LIKE :date");
	$requete->bindParam(':date', $_POST["date"]);
	$requete-> execute();
	$resultats = $requete->fetchAll();

	// ERREUR mauvais format de date

	if(strtotime($_POST["date"]) == false){
			$retour["success"] = false;
			$retour["message"] = "Le format de date n'est pas respecté. Il doit correspondre au modèle yyyy-mm-dd H:m:s.";

	// ERREUR quand la date est absente de la base de données.

	} elseif( empty($resultats) ){
		$retour["success"] = false;
		$retour["message"] = "Aucune date correspondante dans la base de données.";			

	// REUSSI quand la date est correctement entrée et présent dans la base de données

	} else {
		$retour["success"] = true;
		$retour["message"] = "Voici le post :";
		$retour["resultats"]["post"] = $resultats;			
	}

// ERREUR quand les paramètres de recherche sont manquants

} else {
	$retour["success"] = false;
	$retour["message"] = "veuillez entrer les informations correctes de recherche de post : id_post ou author ou date.";
}

 echo json_encode($retour);

 ?>