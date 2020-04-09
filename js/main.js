getUsersAsync('../components/users.php');

function newUserBtn() {
    createUser('../components/create_user.php');
}

function createUser(file) {
    let req;
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if (req !== undefined) {
        try {
            req.open("POST", file, true);
        } catch (err) {
            console.log("Невозможно выполнить запрос.\\n\\n" + err.message);
            return false;
        }

        req.onreadystatechange = function () {
            if (req.readyState === 4) {
                if (req.status === 200 || req.status === 0) {
                    getUsersAsync('../components/users.php')
                }
            }
        };
        req.send(null);
    }
}
function getUsersAsync(file) {
    let req;
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }

    if (req !== undefined) {
        try {
            req.open("GET", file, true);
        } catch (err) {
            console.log("Невозможно выполнить запрос.\\n\\n" + err.message);
            return false;
        }

        req.onreadystatechange = function () {
            if (req.readyState === 4) {
                if (req.status === 200 || req.status === 0) {
                    usersList(req.responseText);
                }
            }
        };
        req.send(null);
    }
}

function usersList(response) {
    let usersArr = Object.entries(JSON.parse(response));
    let resData = '';
    for (var i = 0; i < usersArr.length; i++) {
        let skills = usersArr[i][1]['skills'] !== null ? usersArr[i][1]['skills'] : '-';
        resData += "<tr>" +
            "                    <th scope=\"row\">" + usersArr[i][1]['id'] + "</th>" +
            "                    <td>" + usersArr[i][1]['name'] + "</td>" +
            "                    <td>" + usersArr[i][1]['city'] + "</td>" +
            "                    <td>" + skills + "</td>" +
            "                </tr>";
    }
    document.getElementById('t_users').innerHTML = '';
    document.getElementById('t_users').innerHTML = resData;
}