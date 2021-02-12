<?php
 header('Content-Type: application/json');

try {
	$pdo = new PDO('mysql:host=localhost; dbname=cda', 'root', 'test');
	$return["success"] = true;
	$return["message"] = "connexion réussie pour de vrai";

} catch(exception $e){
	$return["success"] = false;
	$return["message"] = "connexion échouée";
}


?>