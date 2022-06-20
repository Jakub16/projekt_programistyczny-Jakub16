<?php

    echo "<script type = 'text/javascript' src = 'js_script.js'></script>";
    error_reporting(0);

    session_start();

    if(isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === true) {
        echo "<script>redirectToUserPanel();</script>";
    }

    require_once "db_conn.php";

    $username = $password = "";
    $username_input = $_POST['username'];
    $password_input = $_POST['password'];
    $username_error = $password_error = "";

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(empty(trim($username_input))) {
            $username_error = "Proszę podać nazwę użytkownika! Pole nie może być puste.";
            echo "<script type = 'text/javascript'>errorAlert('$username_error');</script>";
        }
        else {
            $username = trim($username_input);
        }

        if(empty(trim($password_input))) {
            $password_error = "Proszę wprowadzić hasło! Pole nie może być puste.";
            echo "<script type = 'text/javascript'>errorAlert('$password_error');</script>";
        }
        else {
            $password = $password_input;
        }

        if(empty($username_error) && empty($password_error)) {
            if($stmt = $conn->prepare("SELECT id, username, password FROM user WHERE username = :username")) {
                $stmt->bindParam(":username", $p_username, PDO::PARAM_STR);
                $p_username = $username;

                if($stmt->execute()) {
                    if($stmt->rowCount() == 1) {
                        if($array = $stmt->fetch()) {
                            $user_id = $array['id'];
                            $username = $array['username'];
                            $password_hash = $array['password'];

                            if(password_verify($password, $password_hash)) {
                                session_start();

                                $_SESSION['logged_in'] = true;
                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['username'] = $username;

                                echo "<script type = 'text/javascript'>redirectToUserPanel();</script>";
                            }
                            else {
                                $error = "Nieprawidłowa nazwa użytkownika lub hasło" . $password_hash;
                                echo "<script type = 'text/javascript'>errorAlert('$error');</script>";
                            }
                        }
                    }
                    else {
                        $error = "Nieprawidłowa nazwa użytkownika lub hasło.";
                        echo "<script type = 'text/javascript'>errorAlert('$error');</script>";
                    }
                }
                else {
                    error_get_last();
                }
                unset($stmt);
            }
        }
        unset($conn);
    }

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
        <?php
        session_start();
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            echo "<div class = 'right'>" . "Zalogowano jako: " . $_SESSION['username'] . "</div>";
        }
        ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" aria-current="page" href="home_page.php">Strona główna</a>
                <a class="nav-link active" href="login.php">Zaloguj</a>
                <a class="nav-link" href="user_panel.php">Panel klienta</a>
                <a class="nav-link" href="admin_panel.php">Panel administratora</a>
            </div>
        </div>
    </div>
</nav>
<form class = login_form_centre method = "POST" action = "login.php">
    <div id = login_form_inner>
    <div class="mb-3">
        <label for="username" class="form-label">Nazwa użytkownika:</label>
        <input type="text" class="form-control" id="username" name = "username" aria-describedby="usernameHelp">
        <div id="usernameHelp" class="form-text"></div>
    </div><br/>
    <div class="mb-3">
        <label for="password" class="form-label">Hasło:</label>
        <input type="password" class="form-control" id="password" name = "password">
    </div><br>
        <button type="submit" class="btn btn-primary">Zaloguj</button>
        <button class="btn btn-primary" onclick = "redirectToRegisterDelay();">Nie masz jeszcze konta? Zarejestruj się!</button>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>