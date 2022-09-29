<?php

    error_reporting(0);
    require_once "db_conn.php";

    echo "<script type = 'text/javascript' src = 'js_script.js'></script>";
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script type = 'text/javascript'>redirectToLogin();</script>";
    }
?>

<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj nowy post</title>
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
                <a class="nav-link" href="login.php">Zaloguj</a>
                <a class="nav-link" href="logout.php">Wyloguj</a>
                <a class="nav-link" href="user_panel.php">Panel klienta</a>
                <a class="nav-link" href="admin_panel.php">Panel administratora</a>
            </div>
        </div>
    </div>
</nav>
<form class = "new_post_form_centre" method="post" action="">
    <div class = "new_post_form_inner">
        <textarea name = "text_input" placeholder="Tutaj wpisz swój tekst. Maksymalnie 10 000 znaków."></textarea><br><br>
        <input type = "submit" name = "submit" value = "Opublikuj">
    </div>
</form>
<script type = 'text/javascript' src = 'js_script.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        if(isset($_POST['submit'])) {

            $sql = "INSERT INTO blog (id, content, is_public, author_id_fk, creation_date) VALUES ('', :content, true, :author_id_fk, '');";

            if($stmt = $conn->prepare($sql)) {

                $p_content = $_POST['text_input'];
                $p_author_id_fk = $_SESSION['user_id'];

                $stmt->bindParam(":content", $p_content, PDO::PARAM_STR);
                $stmt->bindParam(":author_id_fk", $p_author_id_fk, PDO::PARAM_STR);

                if($stmt->execute()) {
                    echo "<script type = 'text/javascript'>alert('Pomyślnie opublikowano wpis.')</script>";
                }
                else {
                    error_get_last();
                }
            }
            else {
                unset($stmt);
            }
        }
        unset($conn);
    }

?>
