<?php

    require_once "db_conn.php";
    error_reporting(0);

    $dsn = "mysql:host=localhost;dbname=test;charset=UTF8";
    $username = 'root';
    $password = '';

    $username_input = $_POST['username'];
    $email_input = $_POST['email'];
    $password_input = $_POST['password'];
    $r_password_input = $_POST['r_password'];

    $username = $password = $r_password = "";
    $username_error = $password_error = $r_password_error = "";
    $password_strength = "";

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(empty($username_input)) {
            $username_error = "Proszę podać nazwę użytkownika!";
        }
        elseif(!preg_match('/^\w+$/', trim($username_input))) {
            echo $username_error = "Nazwa użytkownika może zawierać jedynie: cyfry oraz małe i duże litery.";
        }
        else {
            echo "wow";

            if($stmt = $conn->prepare("SELECT id FROM user WHERE username = :username")) {
                $PARAM_STR = PDO::PARAM_STR;
                $p_username = trim($username_input);
                $stmt->bindParam(":username", $p_username, $PARAM_STR);

                if($stmt->execute()) {
                    if($stmt->rowCount() == 1) {
                        $username_error = "Ta nazwa użytkownika jest już zajęta.";
                    }
                    else {
                        $username = trim($username_input);
                    }
                }
                else {
                    echo error_get_last();
                    echo "wow";
                }

                unset($stmt);
            }
        }

        if(empty(trim($password_input))) {
            $password_error = "Proszę wprowadzić hasło!";
        }
        elseif(strlen(trim($password_input)) < 8) {
            $password_error = "Hasło musi zawierać co najmniej 8 znaków";
            echo "debug";
            echo $password_error;
        }
        elseif(strlen(trim($password_input)) > 16) {
            $password_error = "Hasło może zawierać maksymalnie 16 znaków";
        }
        elseif(preg_match("/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{14,16}$/", $password_input)) {
            $password_strength = "strong";
        }
        elseif(preg_match("/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{11,13}$/", $password_input)) {
            $password_strength = "medium";
        }
        elseif(preg_match("/^(?=.*[0-9])(?=.*[A-Z]).{8,16}$/", $password_input) || preg_match("/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,10}$/", $password_input)) {
            $password_strength = "weak";
        }
        else {
            $password_error = "Hasło nie spełnia podanych wymogów";
        }
    }
    echo "<br><br>$password_error";
    echo "<br><br>$password_strength";
?>


<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona logowania</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar fixed-top" style="background-color: rgb(148,175,187)">
    <div class="container-fluid">
        <a class="navbar-brand" href="home_page.php">Blog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" aria-current="page" href="#">Home</a>
                <a class="nav-link active" href="login.php">Log-in</a>
                <a class="nav-link" href="#">Pricing</a>
            </div>
        </div>
    </div>
</nav>
<form class = login_form_centre method = "POST" action = "register.php">
    <div id = login_form_inner>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="text" class="form-control" id="email" name = "email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text"></div>
        </div><br/>
        <div class="mb-3">
            <label for="username" class="form-label">Nazwa użytkownika:</label>
            <input type="text" class="form-control" id = "username" name="username" aria-describedby="usernameHelp">
            <div id="usernameHelp" class="form-text"></div>
        </div><br/>
        <div class="mb-3">
            <label for="password" class="form-label">Hasło:</label>
            <input type="password" class="form-control" id="password" name = "password">
        </div><br>
        <div class="mb-3">
            <label for="r_password" class="form-label">Powtórz hasło:</label>
            <input type="password" class="form-control" id="r_password" name = "r_password">
        </div><br>
        <button type="submit" class="btn btn-primary" name = "submit">Zaloguj</button>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>