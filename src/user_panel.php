<?php
    error_reporting(0);

    require_once "truncate_function.php";

    echo "<script type = 'text/javascript' src = 'js_script.js'></script>";
    session_start();

    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        echo "<script type = 'text/javascript'>redirectToLogin();</script>";
    }
?>

<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel klienta</title>
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
                <a class="nav-link active" href="user_panel.php">Panel klienta</a>
                <a class="nav-link" href="admin_panel.php">Panel administratora</a>
            </div>
        </div>
    </div>
</nav>
<div class = "grid-container1" style = "margin-top: 100px;">
    <div class = "grid-item">
        <form name = "add_post_form" method="post" action = "new_post.php">
            <input type = "submit" name = "add_post" id = "submit-button-no-margin" value = "Kliknij, aby dodać nowy wpis!">
        </form>
    </div>
</div>
<div class = "grid-container1" style = "margin-top: 20px;">
    <div class = "grid-item-special-font">
        Twoje publikacje:
    </div><br>
</div>
<div class="grid-container" id="main-container">
<?php
    require_once "db_conn.php";

    $sql = "SELECT blog.id as blog_id, user.id, username, content, is_public, author_id_fk, blog.creation_date FROM blog join user on user.id = blog.author_id_fk and author_id_fk = :user_id";

    if($stmt = $conn->prepare($sql)) {
        $p_user_id = $_SESSION['user_id'];
        $stmt->bindParam(":user_id", $p_user_id);

        if($stmt->execute()) {
            if($stmt->rowCount() > 0) {
                while($row = $stmt->fetch()) {

                    echo "<div class = 'grid-item'>
                            <div class = 'inside-content'>
                                <div class = 'blog_author_text'>
                                    Autor: " . $row['username'] . "
                                </div>
                                <div class = 'creation_date_text'>
                                Utworzono: " . $row['creation_date'] . "
                                </div>
                                <div>
                                " . truncate($row['content'], 1000) . "
                                <form method='post' action = 'blog_administrate_page.php'>
                                    <input type = 'hidden' name = 'admin_blog_id_input' value = $row[blog_id]>
                                    <input type = 'submit' name = submit id = 'submit-button' value = 'Kliknij aby przeczytać resztę!'>
                                </form>
                                </div>
                            </div>
                          </div>";
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
?>
</div>
<script type = 'text/javascript' src = 'js_script.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
