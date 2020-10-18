# CDA_API

## API pour la selection CDA

Cette API a été codée en PHP / requêtes SQL pour (et testée sur) un serveur et une base de données en local (via Apache + MySQL). Les ressources correspondent au diagramme "selection-uml.jpg" également présent dans le repo. Afin de répondre à la convention d'une API REST, chaque endpoint renverra en format JSON :
- sucess (true or false)
- message (erreur spécifiée ou execution correcte)
- data (quand cela est attendu)

Au niveau hierarchique, chaque fichier.php comprennant les endpoints appelle en premier lieu le fichier "header.php" qui comprend les informations de connexion à la BDD via la couche intermédiaire PDO.

## Messages d'erreur

Afin de faciliter l'utilisation de l'API, différents cas d'usage ont été pris en compte, avec notamment des messages d'erreur explicites pour le client. De plus, le code intègre directement la prise en compte des erreurs de typage, limitant la déclaration de paramètres non attendus par la base de données (mauvais format pour les chaînes de caractères, entiers, ous dates).

## Liste des actions disponibles 

### Créer un Topic

    **POST** http://localhost/API/CDA/ajouter_topic.php

**Paramètres**

**Nom**			| **Requis**| **Type** 	| **Valeur par défaut**	| **Description**																| **Valeur possible**
----------------|-----------|-----------|-----------------------|-------------------------------------------------------------------------------|----------------------
Title	| Oui 		| String	| Aucune 				| Préciser ici le titre en body de la requête POST pour l'ajout du topic 												| Non Applicable

**Informations complémentaires**

La table topics comporte 2 colonnes : id_topic + title. L'ajout d'un nouveau titre ne nécessite pas la déclaration de l'id_topic, qui s'incrémente automatiquement (numero du dernier id_topic + 1) au moment de la requête. Chaque ressource possédera donc bien un attribut dans chaque colonne.

**Format de la réponse**

	{
	"sucess ": true, 
	"message": "Le topic a bien été ajouté.
	}

**exemple**

    **POST** http://localhost/API/CDA/ajouter_topic.php Key = title Keyvalue = "Ceci est un exemple"

Cette requête ajoutera un topic à la table, avec comme titre "ceci est un exemple", et un id_topic unique automatiquement attribué.

### Créer un Post

    **POST** http://localhost/API/CDA/ajouter_post.php

**Paramètres**

**Nom**			| **Requis**| **Type** 	| **Valeur par défaut**	| **Description**																| **Valeur possible**
----------------|-----------|-----------|-----------------------|-------------------------------------------------------------------------------|----------------------
id_topic	| Oui 		| Int	| Aucune 				| Préciser ici l'id du topic unique associé à ce post 												| Non Applicable
content	| Oui 		| String	| Aucune 				| Préciser ici le contenu du post 												| Non Applicable
author	| Oui 		| String	| Aucune 				| Préciser ici l'auteur du post 												| Non Applicable
date	| Oui 		| DateTime	| Aucune 				| Préciser ici la date du post au format yyyy-mm-dd h : m : s 												| Non Applicable

**Informations complémentaires**

La table posts comporte également une colonne id_post. Comme pour la création d'un topic, l'ajout d'un nouveau post ne nécessite pas la déclaration de l'id_post, qui s'incrémente automatiquement (numero du dernier id_topic + 1) au moment de la requête. Chaque ressource possédera donc bien cet attribut.

Conformément au diagramme des ressources, un post appartient obligatoirement à un Topic unique. Pour cela, la table posts comprends la colonne id_topic qui précisera la connexion avec la table topics. Cet élément est donc à déclarer obligatoirement au moment de la création du post.

**Format de la réponse**

	{
	"sucess ": true, 
	"message": "Le post a bien été ajouté.
	}

**exemple**

    **POST** http://localhost/API/CDA/ajouter_post.php Key = id_topic Keyvalue = "1" Key = content Keyvalue = "Voici le premier post lié au topic 1." Key = author Keyvalue = "Cyril" Key = date Keyvalue = "2020-10-18 12:00:00"

Cette requête ajoutera un post lié au topic 1, qui dira "Voici le premier post lié au topic 1.", crée par Cyril, et daté au 18 octobre 2020 à midi. Il comprendra bien son id_post et l'association à la table topics via son id_topic unique.


### Afficher un Topic

    **POST** http://localhost/API/CDA/afficher_topic.php

**Paramètres**

**Nom**			| **Requis**| **Type** 	| **Valeur par défaut**	| **Description**																| **Valeur possible**
----------------|-----------|-----------|-----------------------|-------------------------------------------------------------------------------|----------------------
id_topic	| Oui mais seul		| Int	| Aucune 				| Préciser ici l'id du topic  												| Non Applicable
title	| Oui mais seul 		| String	| Aucune 				| Préciser ici le titre complet												| Non Applicable


**Informations complémentaires**

La recherche de topic se fera soit via l'id_topic, soit via le titre complet (espaces inclus), mais jamais les deux à la fois. Ainsi, un seul paramètre est attendu, au choix de l'utilisateur.

**Format de la réponse**

	{
	"sucess ": true, 
	"message": "Voici le topic:" 
	"resultast""topic" = "",
	}

**exemple**

    **POST** http://localhost/API/CDA/afficher_topic.php Key = id_topic Keyvalue = "1"

Cette requête affichera toutes les colonnes (id_post + title) de la ligne correspondant à l'id_topic 1.

### Afficher un Post


**Nom**			| **Requis**| **Type** 	| **Valeur par défaut**	| **Description**																| **Valeur possible**
----------------|-----------|-----------|-----------------------|-------------------------------------------------------------------------------|----------------------
Authorization	| Oui 		| String	| Aucune 				| Jeton d'authentification utilisé 												| bearer <valeur de jeton>

### Modifier un Topic

**Nom**			| **Requis**| **Type** 	| **Valeur par défaut**	| **Description**																| **Valeur possible**
----------------|-----------|-----------|-----------------------|-------------------------------------------------------------------------------|----------------------
Authorization	| Oui 		| String	| Aucune 				| Jeton d'authentification utilisé 												| bearer <valeur de jeton>


### Modifier un Post


**Nom**			| **Requis**| **Type** 	| **Valeur par défaut**	| **Description**																| **Valeur possible**
----------------|-----------|-----------|-----------------------|-------------------------------------------------------------------------------|----------------------
Authorization	| Oui 		| String	| Aucune 				| Jeton d'authentification utilisé 												| bearer <valeur de jeton>

### Suprrimer un Topic

**Nom**			| **Requis**| **Type** 	| **Valeur par défaut**	| **Description**																| **Valeur possible**
----------------|-----------|-----------|-----------------------|-------------------------------------------------------------------------------|----------------------
Authorization	| Oui 		| String	| Aucune 				| Jeton d'authentification utilisé 												| bearer <valeur de jeton>


### Supprimer un Post


**Nom**			| **Requis**| **Type** 	| **Valeur par défaut**	| **Description**																| **Valeur possible**
----------------|-----------|-----------|-----------------------|-------------------------------------------------------------------------------|----------------------
Authorization	| Oui 		| String	| Aucune 				| Jeton d'authentification utilisé 												| bearer <valeur de jeton>
