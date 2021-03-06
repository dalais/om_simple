<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body {
            padding-top: 3.5rem;
        }
    </style>
    <title>App</title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="/">App</a>
</nav>

<main role="main">

    <hr>
    <div class="container">
        <h3>Сотрудники</h3>
        <div class="row">
            <p>&nbsp;</p>
            <!--<div class="float-right">
                <button id="new_user" class="btn btn-outline-info" onclick="newUserBtn()">+Добавить</button>
            </div>-->
            <div>
                <form class="form-group" id="user-form">
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input class="form-control" id="username" type="text" name="name" readonly value="">
                    </div>
                    <div class="form-group">
                        <label for="city">Город</label>
                        <input class="form-control" id="cityname" type="text" name="city" readonly value="">
                        <input id="city_id" type="hidden" name="city_id" readonly value="">
                    </div>

                    <div class="form-group">
                        <button class="form-control btn btn-outline-secondary"
                                id="generate-btn"  type="button"
                                onclick="newUserBtn()"
                        >
                            Сгенерировать
                        </button>
                    </div>
                    <div class="form-group">
                        <button class="form-control btn btn-info"
                                id="create-btn" type="button"
                                onclick="createUserBtn()"
                        >
                            Отправить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container">

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Город</th>
                <th scope="col">Навыки</th>
            </tr>
            </thead>
            <tbody id="t_users">
            <tr>
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <hr>

    </div> <!-- /container -->

</main>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous">
</script>
<script src="../js/main.js" defer></script>
</body>
</html>