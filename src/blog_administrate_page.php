<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona Bloga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav class="navbar fixed-top" style="background-color: rgb(148,175,187)">
    <div class="container-fluid">
        <a class="navbar-brand" href="home_page.php">Blog</a>
        <?php
        session_start();
        if(isset($_SESSION['logged_in'])) {
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
<div class = "grid-container-fit-content">
    <div class = "grid-item-no-animation">
        <div class = "inside-content" id = "blog-content">
            <?php

            error_reporting(0);
            require_once "db_conn.php";
            $p_blog_id = $_POST['admin_blog_id_input'];

            if ($_SERVER['REQUEST_METHOD'] == "POST" && $_SESSION['userid'] == 33) {
                $sql = "SELECT content, username, blog.creation_date FROM blog join user on blog.author_id_fk = user.id and blog.id = :blog_id;";
                if($stmt = $conn->prepare($sql)) {

                    $stmt->bindParam(":blog_id", $p_blog_id);

                    if($stmt->execute()) {
                        if($stmt->rowCount() == 1) {
                            while($row = $stmt->fetch()) {
                                echo
                                    "<div class = 'blog_author_text'>
                                                Autor: " . $row['username'] . "
                                            </div>
                                            <div class = 'creation_date_text'>
                                                Utworzono: " . $row['creation_date'] . "
                                            </div>
                                            <div>" . $row['content'] . "
                                               
                                            </div>
                                        </div>
                                  </div>";
                            }
                        }
                        else {
                            echo "Ilość wyników inna niż 1";
                        }
                    }
                    else {
                        echo error_get_last();
                    }
                    unset($stmt);
                }
                unset($conn);
            }

            ?>

    </div>
</div>
    <form name = 'mod' method="post" action="edit.php" class = "new_post_form_centre">
        <div class = "new_post_form_inner">
            <textarea name = "text_input" placeholder="Tutaj wpisz swój nowy  tekst. Maksymalnie 10 000 znaków."></textarea><br><br>
            <input type = "submit" name = "submit" value = "Edytuj"><br><br>
            <input type = "submit" name = "delete" value = "Usuń ten wpis">
            <input type = 'hidden' name = 'blog_id_input' value = <?php echo $p_blog_id; ?>>
        </div>
    </form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>