# CDA_API

## API pour la selection CDA

Cette API a été codée en PHP / requêtes SQL pour (et testée sur) un serveur et une base de données en local (via Apache + MySQL). Les ressources correspondent au diagramme "selection-uml.jpg" également présent dans le repo. Afin de répondre à la convention d'une API REST, chaque endpoint renverra en format JSON :
- sucess (true or false)
- message (erreur spécifiée ou execution correcte)
- data (quand cela est attendu)

Au niveau hierarchique, chaque fichier.php comprennant les endpoints appelle en premier lieu le fichier "header.php" qui comprend les informations de connexion à la BDD via la couche intermédiaire PDO.

## Messages d'erreur

Afin de faciliter l'utilisation de l'API, les cas d'usage ont été pris en compte, avec notamment des messages d'erreur explicites pour les clients. De plus, le code intègre directement la prise en compte des erreurs de typage, limitant la déclaration de paramètres non attendus par la base de données (chaînes de caractères, entiers, date).

## Liste des actions disponibles 

### Créer un Topic

    **POST** http://localhost/API/CDA/ajouter_topic.php | Key = title | Keyvalue = "" |

**Paramètres**

*Nom :*			title

*Requis :*   		Oui

*Type :*			String

*Valeur par défaut :*	Aucune

*Description :*		Préciser ici le titre en body de la requête POST pour l'ajout du topic


**Informations complémentaires**

La table topic comporte 2 colonnes : id_topic + title. L'ajout d'un nouveau titre ne nécessite pas la déclaration de l'id_topic, qui s'incrémente automatiquement (numero du dernier id_topic + 1) au moment de la requête. Chaque ressource possédera donc bien un attribut dans chaque colonne.

**Format de la réponse**

	{
	"sucess ": true, 
	"message": "Le topic a bien été ajouté.
	}

**exemple**

    **POST** http://localhost/API/CDA/ajouter_topic.php Key = title Keyvalue = "Ceci est un exemple"

Cette requête ajoutera un topic à la table, avec comme title "ceci est un exemple", et un id_topic unique automatiquement attribué.
