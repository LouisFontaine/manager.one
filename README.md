# Manager.one

Manager.one is a project carried out during a technical test in order to integrate the development team of manager.one

### Getting Started

In order to run this project you will have to install [Xampp](https://www.apachefriends.org/fr/index.html)

### Installing

* First you need to clone this project in "\xampp\htdocs"
* Then you need to activate rewrite mode in Apache, to do that go to the httpd.conf file of Apache and uncomment the line "LoadModule rewrite_module modules/mod_rewrite.so"
* Then you have to go to your phpMyAdmin (usualy at http://localhost/phpmyadmin/index.php), open SQL console and execute the script in "/apiPHP/database.sql"
* Last, open the file [db_connect.php](db_connect.php) located in "/apiPhp/config/" and change the different DB parmaeters with your informations


EndPoints :
GET 	/tasks			// Renvoie toutes les tâches
POST 	/tasks 		        // Ajoute une nouvelle tâche (la tâche est passé dans le body de la requette)
GET 	/tasks/$id		// Renvoie la tâche spécifiée dans l'url
DELETE 	/tasks/$id		// Supprime la tâche spécifiée associée à l'utilisateur spécifié
GET 	/users			// Renvoie tous les utilisateurs
GET 	/users/$id		// Renvoie l'utilisateur spécifié dans l'url
GET 	/users/$id/tasks	// Renvoie toutes les taches de l'utilisateur spécifié

body pour le create :
{
"user_id":"1",
"title":"Talk to mama",
"description":"talk to mama about how to wash my clothes"
,"creation_date":"2019-04-02",
"status":"TODO"
}
