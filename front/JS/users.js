$(document).ready(loadUsers())

// Used to loas the list of users on the page
function loadUsers() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var usersJson = JSON.parse(this.responseText);
            var usersHtml = "";
            usersHtml += newFunction()
            for (var i = 0; i < usersJson.length; i++) {
                usersHtml += "<tr><td>" + usersJson[i].id + "</td><td>" + usersJson[i].name + "</td><td>" + usersJson[i].email + "</td> <td><button class='button' id=\"" + usersJson[i].id + "\" type=\"button\" onClick=\"goToTask(this.id)\"> Tasks </button> <button class='button' id=\"" + usersJson[i].id + "\" type=\"button\" onClick=\"deleteClick(this.id)\"> Delete </button></td></tr>"
            }
            usersHtml += "</tbody> </table>"

            document.getElementById("users").innerHTML = usersHtml;
        }
    };
    xhttp.open("GET", "http://localhost/manager.one/apiPhp/users", true);
    xhttp.send();

    function newFunction() {
        return "<table id='users'> <thead> <th> ID </th> <th> Name </th> <th> Email </th> <th></th> </thead> <tbody>";
    }
}

// Used to delete a user
function deleteClick(UserId) {
    console.log("http://localhost/manager.one/apiPhp/users/" + UserId)
    var xhttp = new XMLHttpRequest();

    xhttp.open("DELETE", "http://localhost/manager.one/apiPhp/users" + "/" + UserId, true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) { loadUsers(); }
    }
}

// used to create a user
function createUser() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "http://localhost/manager.one/apiPhp/users", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(JSON.stringify({ name: document.forms["createUserForm"]["name"].value, email: document.forms["createUserForm"]["email"].value }));
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) { loadUsers(); }
    }
}

// Change the page to the user's task page
function goToTask(UserId) {
    document.location.href = "http://localhost/manager.one/front/HTML/userTasks.html?user_id=" + UserId;
}