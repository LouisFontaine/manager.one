function loadDoc() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var usersJson = JSON.parse(this.responseText);
            var usersHtml = "";
            usersHtml += "<table> <thead> <tr> <td>ID</td> <td>Name</td> <td>Email</td> </tr> </thead> <tbody>"
            for (var i=0; i<usersJson.length; i++) {
                usersHtml += "<tr><td>" + usersJson[i].id + "</td><td>" + usersJson[i].name + "</td><td>" + usersJson[i].email + "</td> <td><button id=\"" + usersJson[i].id + "\" type=\"button\" onClick=\"deleteClick(this.id)\"> Delete </button> </td></tr>"
            }
            usersHtml += "</tbody> </table>"

            document.getElementById("demo").innerHTML = usersHtml;
        }
    };
    xhttp.open("GET", "http://localhost/manager.one/apiPhp/users", true);
    xhttp.send();
}

function deleteClick(UserId)
{
    console.log("http://localhost/manager.one/apiPhp/users/" + UserId)
    var xhttp = new XMLHttpRequest();
    
    xhttp.open("DELETE", "http://localhost/manager.one/apiPhp/users" + "/" + UserId, true);
    xhttp.setRequestHeader('Content-Type', 'application/json');
    xhttp.setRequestHeader('Accept', '*/*'); // accept all
    xhttp.withCredentials = false;
    xhttp.send();
}