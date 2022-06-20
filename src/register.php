<?php
    echo "<script type = 'text/javascript' src = 'js_script.js'></script>";

    require_once "db_conn.php";
    error_reporting(0);

    $username_input = $_POST['username'];
    $email_input = $_POST['email'];
    $password_input = $_POST['password'];
    $r_password_input = $_POST['r_password'];

    $username = $email = $password = $r_password = "";
    $email_error = $username_error = $password_error = $r_password_error = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (empty($email_input)) {
            $email_error = "Proszę wprowadzić adres email!";
            echo "<script type = 'text/javascript'>errorAlert('$email_error');</script>";

        }
        elseif (!preg_match("/^[a-z0-9_+-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email_input)) {
            $email_error = "Adres email nie spełnia wymaganych kryteriów.";
            echo "<script type = 'text/javascript'>errorAlert('$email_error');</script>";

        }
        else {
            if ($stmt = $conn->prepare("SELECT id FROM user WHERE email = :email")) {
                $p_email = trim($email_input);
                $stmt->bindParam(":email", $p_email, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $email_error = "Istnieje już konto przypisane do podanego adresu E-mail.";
                        echo "<script type = 'text/javascript'>errorAlert('$email_error');</script>";
                    }
                    else {
                        $email = trim($email_input);
                    }

                }
                else {
                    echo error_get_last();
                }

                unset($stmt);
            }
        }

        if (empty($username_input)) {
            $username_error = "Proszę podać nazwę użytkownika!";
            echo "<script type = 'text/javascript'>errorAlert('$username_error');</script>";
        }

        elseif (!preg_match('/^\w+$/', trim($username_input))) {
            echo $username_error = "Nazwa użytkownika może zawierać jedynie: cyfry oraz małe i wielkie litery.";
            echo "<script type = 'text/javascript'>errorAlert('$username_error');</script>";
        }
        else {
            if ($stmt = $conn->prepare("SELECT id FROM user WHERE username = :username")) {
                $p_username = trim($username_input);
                $stmt->bindParam(":username", $p_username, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $username_error = "Ta nazwa użytkownika jest już zajęta.";
                        echo "<script type = 'text/javascript'>errorAlert('$username_error');</script>";
                    }
                    else {
                        $username = trim($username_input);
                    }
                }
                else {
                    echo error_get_last();
                }

                unset($stmt);
            }
        }

        if (empty(trim($password_input))) {
            $password_error = "Proszę wprowadzić hasło! Pole nie może być puste";
            echo "<script type = 'text/javascript'>errorAlert('$password_error');</script>";
        }
        elseif (strlen(trim($password_input)) < 8) {
            $password_error = "Hasło musi zawierać co najmniej 8 znaków";
            echo "<script type = 'text/javascript'>errorAlert('$password_error');</script>";
        }
        elseif (strlen(trim($password_input)) > 16) {
            $password_error = "Hasło może zawierać maksymalnie 16 znaków";
            echo "<script type = 'text/javascript'>errorAlert('$password_error');</script>";
        }
        elseif (preg_match("/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{14,16}$/", $password_input)) {
            $password_strength = "strong";
        }
        elseif (preg_match("/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{11,13}$/", $password_input)) {
            $password_strength = "medium";
        }
        elseif (preg_match("/^(?=.*[0-9])(?=.*[A-Z]).{8,16}$/", $password_input) || preg_match("/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,10}$/", $password_input)) {
            $password_strength = "weak";
        }
        else {
            $password_error = "Hasło nie spełnia podanych wymogów";
            echo "<script type = 'text/javascript'>errorAlert('$password_error');</script>";
        }

        if (empty(trim($r_password_input))) {
            $r_password_error = "Proszę powtórzyć hasło!";
            echo "<script type = 'text/javascript'>errorAlert('$password_error');</script>";
        }
        else {
            if (empty(trim($r_password_error)) && ($r_password_input != $password_input)) {
                $r_password_error = "Hasła muszą być takie same!";
                echo "<script type = 'text/javascript'>errorAlert('$r_password_error');</script>";
            }
            else {
                $password = $password_input;
            }
        }


        if (empty($email_error) && empty($username_error) && empty($password_error) && empty($r_password_error)) {
            if ($stmt = $conn->prepare("INSERT INTO user (username, password, email) VALUES (:username, :password, :email)")) {
                $stmt->bindParam(":username", $p_username, PDO::PARAM_STR);
                $stmt->bindParam(":password", $p_password, PDO::PARAM_STR);
                $stmt->bindParam(":email", $p_email, PDO::PARAM_STR);

                $p_username = $username;
                $p_email = $email;
                $p_password = password_hash($password, PASSWORD_DEFAULT);

                if ($stmt->execute()) {
                    echo "<script type = 'text/javascript' src = 'js_script.js'></script>";
                    echo "<script type = 'text/javascript'>redirectToLogin();</script>";
                }
                else {
                    error_get_last();
                }

                unset($stmt);
            }

            unset($conn);
        }
    }
?>


<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona rejestracji</title>
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
<form class = login_form_centre method = "POST" action = "register.php">
    <div id = login_form_inner>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="text" class="form-control" id="email" name = "email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Np.: example_email@example.com</div>
        </div><br/>
        <div class="mb-3">
            <label for="username" class="form-label">Nazwa użytkownika:</label>
            <input type="text" class="form-control" id = "username" name="username" aria-describedby="usernameHelp">
            <div id="usernameHelp" class="form-text">Nazwa może zawierać do 10 znaków i składać się jedynie z cyfr oraz małych i wielkich liter.</div>
        </div><br/>
        <div class="mb-3">
            <label for="password" class="form-label">Hasło:</label>
            <input type="password" class="form-control" id="password" name = "password">
            <div id="passwordHelp" class="form-text">Hasło może zawierać od 8 do 16 znaków i musi się składać z przynajmniej: <br>-Jednej wielkiej litery,<br>-Jednej cyfry,<br>-Jednego znaku specjalnego (!,@,#,$,%,^,&,* lub -).</div>
        </div><br>
        <div class="mb-3">
            <label for="r_password" class="form-label">Powtórz hasło:</label>
            <input type="password" class="form-control" id="r_password" name = "r_password">
            <div id="passwordHelp" class="form-text">Hasła muszą być takie same.</div>
        </div><br>
        <button type="submit" class="btn btn-primary" name = "submit">Zaloguj</button>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>