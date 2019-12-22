$(document).ready(loadTasks())

// Used to loas the list of tasks on the page
function loadTasks() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var tasksJson = JSON.parse(this.responseText);
            var taksHtml = "";
            taksHtml += "<table id='users'> <thead> <th>ID</th> <th>User ID</th> <th>Title</th> <th>Email</th> <th>Description</th> <th>Creation Date</th> <th>Status</th></thead> <tbody>"
            for (var i = 0; i < tasksJson.length; i++) {
                taksHtml += "<tr><td>" + tasksJson[i].id + "</td><td>" + tasksJson[i].user_id + "</td><td>" + tasksJson[i].title + "</td><td>" + tasksJson[i].description + "</td><td>" + tasksJson[i].creation_date + "</td><td>" + tasksJson[i].status + "</td> <td><button class='button' id=\"" + tasksJson[i].id + "\" type=\"button\" onClick=\"deleteClick(this.id)\"> Delete </button></td></tr>"
            }
            taksHtml += "</tbody> </table>"

            document.getElementById("tasks").innerHTML = taksHtml;
        }
    };
    var $_GET = [];
    var parts = window.location.search.substr(1).split("&");
    for (var i = 0; i < parts.length; i++) {
        var temp = parts[i].split("=");
        $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    }
    xhttp.open("GET", "http://localhost/manager.one/apiPhp/users/" + $_GET['user_id'] + "/tasks", true);
    xhttp.send();
}

// Used to delete a task
function deleteClick(taskId) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("DELETE", "http://localhost/manager.one/apiPhp/tasks/" + taskId, true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) { loadTasks(); }
    }
}

// Used to create a user
function createTask() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "http://localhost/manager.one/apiPhp/tasks", true);
    xhttp.setRequestHeader("Content-Type", "application/json");

    var $_GET = [];
    var parts = window.location.search.substr(1).split("&");
    for (var i = 0; i < parts.length; i++) {
        var temp = parts[i].split("=");
        $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    }

    xhttp.send(JSON.stringify({ user_id: $_GET['user_id'], title: document.forms["createTaskForm"]["title"].value, description: document.forms["createTaskForm"]["description"].value, creation_date: document.forms["createTaskForm"]["creation_date"].value, status: document.forms["createTaskForm"]["status"].value }));
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) { loadTasks(); }
    }
}