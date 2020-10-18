 <?php
 include('header.php'); 

// ajout du topic

if( !empty($_POST["title"]) ){

	// Determiner le numéro ID_topic à ajouter : requêtes BDD pour comptage

	$requete = $pdo->prepare("SELECT * FROM `topics`");
	$requete-> execute();
	$resultats = count($requete->fetchAll()) + 1;

	// REUSSI equêtes BDD pour ajout dans la table

	$requete = $pdo->prepare("INSERT INTO `topics` (`id_topic`, `title`) VALUES (:count, :title)");
	$requete->bindParam(':title', $_POST["title"]);
	$requete->bindParam(':count', $resultats);
	$requete-> execute();
	$retour["success"] = true;
	$retour["message"] = "Le topic a bien été ajouté.";

// ERREUR s'il manque des informations

} else {
	$retour["success"] = false;
	$retour["message"] = "veuillez entrer les informations correctes d'ajout de topic : title.";
}

 echo json_encode($retour);

 ?>