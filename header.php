 <?php
 header('Content-Type: application/json');

try {
	$pdo = new PDO('mysql:host=localhost; dbname=cda', 'root', 'test');
	$retour["success"] = true;
	$retour["message"] = "connexion réussie pour de vrai";

} catch(exception $e){
	$retour["success"] = false;
	$retour["message"] = "connexion échouée";
}


?>