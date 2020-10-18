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


POST | http://localhost/API/CDA/ajouter_topic.php | Key = title | Keyvalue = "" |

**Paramètres**

**Nom**	title	
**Requis**	Oui
**Type**	String	
**Valeur par défaut**	Aucune
**Description**	ressource title pour l'ajout du topic
