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

The API is developed with PHP and SQL

**GET /tasks**			    
// Return all tasks

**POST /tasks** 		        
// Add a new task (task is parse in the body of the request)

**GET /tasks/$id**		    
// Return the task with the specified ID

**DELETE /tasks/$id**		    
// Delete the specified task

**GET /users**			    
// Return all users

**GET /users/$id**		    
// Return the user specified

**GET /users/$id/tasks**
// Return all tasks of the specified user

**DELETE /user/$id**
// Delete the specified user

**POST /tasks**
// Add a new user (user is parse in the body of the request)

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

### Front (WEB application)

The WEB application is developed with HTML, CSS, Javascript and Ajax.

You can acces to the web application by coing to this link : http://localhost/manager.one/front/users.html
On this page, you can :
* See the differents users with their informations
* Add a new user (by cliking on "Create" button)
* Delete a user (by cliking on "Delete" button)
* See the different ttasks of a user (by cliking on "Tasks" button)

See screen [UsersAdministrationScreen.PNG](https://github.com/LouisFontaine/manager.one/blob/master/UsersAdministrationScreen.PNG)

When you click on the "Tasks" button, you are redirected to a page presenting all the tasks of the selected user, on this page you can :
* Go back to the users list (by cliking on "Go back to user list" button)
* Add a new task (by cliking on "Create" button)
* Delete a task (by cliking on "Delete" button)

See screen [TasksAdministrationScreen.PNG](https://github.com/LouisFontaine/manager.one/blob/master/TasksAdministrationScreen.PNG)
