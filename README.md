# Manager.one

Manager.one is a project carried out during a technical test in order to integrate the development team of manager.one

### Getting Started

In order to run this project you will have to install [Xampp](https://www.apachefriends.org/fr/index.html)

### Installing

* First you need to clone this project in "\xampp\htdocs"
* Then you need to activate rewrite mode in Apache, to do that go to the httpd.conf file of Apache and uncomment the line "LoadModule rewrite_module modules/mod_rewrite.so"
* Then you have to go to your phpMyAdmin (usualy at http://localhost/phpmyadmin/index.php), open SQL console and execute the script in "/apiPHP/database.sql"
* Last, open the file [db_connect.php](https://github.com/LouisFontaine/manager.one/blob/master/apiPhp/database.sql) located in "/apiPhp/config/" and change the different DB parmaeters with your informations
```
// DB Params
private $host = 'localhost';
private $db_name = 'manageronedatabase';
private $username = 'root';
private $password = '';
```


### API EndPoints and how to use

GET     /tasks			    
// Return all tasks

POST    /tasks 		        
// add a new task (task is parse in the body of the request)

GET     /tasks/$id		    
// Return the task with the specified ID

DELETE  /tasks/$id		    
// Delete the specified task

GET     /users			    
// Return all users

GET     /users/$id		    
// Return the user specified

GET     /users/$id/tasks	
// Return all tasks of the specified user

Example :
```
GET     http://localhost/manager.one/apiPhp/users
POST    http://localhost/manager.one/apiPhp/users
GET     http://localhost/manager.one/apiPhp/users/1
DELETE  http://localhost/manager.one/apiPhp/users/1
GET     http://localhost/manager.one/apiPhp/users/1/tasks
GET     http://localhost/manager.one/apiPhp/tasks
GET     http://localhost/manager.one/apiPhp/tasks/1
DELETE  http://localhost/manager.one/apiPhp/tasks/1
POST    http://localhost/manager.one/apiPhp/tasks
```
Body of the post request of a user :
{
    "name":"Louis",
    "email":"louis.fontaine@efrei.net"
}

Body of the post request of a task :
{
    "user_id":"1",
    "title":"Talk to mama",
    "description":"talk to mama about how to wash my clothes",
    "creation_date":"2019-04-02",
    "status":"TODO"
}
