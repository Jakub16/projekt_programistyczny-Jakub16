<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona Główna</title>
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
                <a class="nav-link active" aria-current="page" href="home_page.php">Strona główna</a>
                <a class="nav-link" href="login.php">Zaloguj</a>
                <a class="nav-link" href="user_panel.php">Panel klienta</a>
                <a class="nav-link" href="admin_panel.php">Panel administratora</a>
            </div>
        </div>
    </div>
</nav>

<div class="grid-container" id="main-container">
    <?php
        error_reporting(0);
        session_start();
        require_once "db_conn.php";
        require_once "truncate_function.php";

        if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $sql = "SELECT blog.id, content, is_public, author_id_fk, blog.creation_date, username FROM blog join user on blog.author_id_fk = user.id and is_public = false;";

            if($stmt = $conn->prepare($sql)) {
                if($stmt->execute()) {
                    if($stmt->rowCount() > 0) {
                        while($row = $stmt->fetch()) {
                            echo "<div class = 'grid-item' id = 'redirect_on_click'><div class = 'inside-content'>" . "<div class = 'blog_author_text'>Autor: " . $row['username'] . "</div>" . "<div class = 'creation_date_text'>Utworzono: " . $row['creation_date'] . "</div>" . "<div>" . truncate($row['content'], 1100) . "</div></div></div>";
                        }
                    }
                    else {
                        echo "Brak wyników";
                    }
                }
                else {
                    error_get_last();
                }
                unset($stmt);
            }
            unset($conn);
        }

        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            $sql = "SELECT blog.id, content, is_public, author_id_fk, blog.creation_date, username FROM blog join user on blog.author_id_fk = user.id and is_public = false;";

            if($stmt = $conn->prepare($sql)) {
                if($stmt->execute()) {
                    if($stmt->rowCount() > 0) {
                        while($row = $stmt->fetch()) {
                            echo "<div class = 'grid-item' id = 'redirect_on_click'><div class = 'inside-content'>" . "<div class = 'blog_author_text'>Autor: " . $row['username'] . "</div>" . "<div class = 'creation_date_text'>Utworzono: " . $row['creation_date'] . "</div>" . "<div>" . truncate($row['content'], 1100) . "</div></div></div>";
                        }
                    }
                    else {
                        echo "<h1>Brak wyników.</h1>";
                    }
                }
                else {
                    error_get_last();
                }
                unset($stmt);
            }
            unset($conn);
        }
    ?>
</div>
<script src = "js_script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
