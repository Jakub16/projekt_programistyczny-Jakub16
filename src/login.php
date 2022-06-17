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
                <a class="nav-link" aria-current="page" href="home_page.php">Home</a>
                <a class="nav-link active" href="login.php">Log-in</a>
                <a class="nav-link" href="admin_panel.php">Panel administratora</a>
            </div>
        </div>
    </div>
</nav>
<form class = login_form_centre>
    <div id = login_form_inner>
    <div class="mb-3">
        <label for="username" class="form-label">Nazwa użytkownika:</label>
        <input type="text" class="form-control" id="username" aria-describedby="usernameHelp">
        <div id="usernameHelp" class="form-text"></div>
    </div><br/>
    <div class="mb-3">
        <label for="password" class="form-label">Hasło:</label>
        <input type="password" class="form-control" id="password">
    </div><br>
        <button type="submit" class="btn btn-primary">Zaloguj</button>
        <button class="btn btn-primary" onclick = "redirectToRegister();">Nie masz jeszcze konta? Zarejestruj się!</button>
    </div>
</form>
<script type="text/javascript" src="js_script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>