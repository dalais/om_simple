let req;
if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
} else if (window.ActiveXObject) {
    req = new ActiveXObject("Microsoft.XMLHTTP");
}

getUsersAsync('../components/users.php', req);

function newUserBtn() {
    generateUserData('../components/generate_user_data.php', req);
}

function createUserBtn() {
    let username = document.getElementById('username');
    let cityname = document.getElementById('cityname');
    let city_id = document.getElementById('city_id');

    if (username.value !== '' && cityname.value !== '' && city_id.value !== '') {
        createUser('../components/create_user.php', req);
        setTimeout(function () {
            username.value = '';
            cityname.value = '';
            city_id.value = '';
        }, 500);
    }
}

/**
 * Generate new user data for html form
 *
 * @param file
 * @param req
 * @returns {boolean}
 */
function generateUserData(file, req) {
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
                    let data = JSON.parse(req.responseText);

                    document.getElementById('username').value = '';
                    document.getElementById('username').value = data.name;

                    document.getElementById('cityname').value = '';
                    document.getElementById('cityname').value = data.city.name;

                    document.getElementById('city_id').value = '';
                    document.getElementById('city_id').value = data.city.id;
                }
            }
        };
        req.setRequestHeader('Content-Type', 'application/json');
        req.send(null);
    }
}

/**
 * Create new user
 *
 * @param file
 * @param req
 * @returns {boolean}
 */
function createUser(file, req) {

    if (req !== undefined) {
        let username = document.getElementById('username').value;
        let city_id = document.getElementById('city_id').value;
        const params = "name=" + username+ "&city_id=" + city_id;

        try {
            req.open("POST", file, true);

            req.onreadystatechange = function () {
                if (req.readyState > 3 && req.status === 200) {
                    getUsersAsync('../components/users.php', req)
                }
            };
            req.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            req.send(params);

        } catch (err) {
            console.log("Невозможно выполнить запрос.\\n\\n" + err.message);
            return false;
        }
    }
}

/**
 * Get users
 *
 * @param file
 * @param req
 * @returns {boolean}
 */
function getUsersAsync(file, req) {
    if (req !== undefined) {
        try {
            req.open("GET", file, true);
            req.onreadystatechange = function () {
                if (req.readyState === 4) {
                    if (req.status === 200 || req.status === 0) {
                        usersList(req.responseText);
                    }
                }
            };
            req.setRequestHeader('Content-Type', 'application/json');
            req.send(null);
        } catch (err) {
            console.log("Невозможно выполнить запрос.\\n\\n" + err.message);
            return false;
        }
    }
}

/**
 * Make user list
 *
 * @param response
 */
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