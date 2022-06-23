function redirectToLogin() {
    window.open("login.php", "_self");
}

function redirectToLoginDelay() {
    document.write("<h1>Za 3 sekundy zostaniesz przekierowany na stronę logowania.</h1>");
    window.setTimeout(function () {window.open("login.php", "_self")}, 3000);
}

function redirectToRegister() {
    window.open("register.php", "_self");
}

function redirectToRegisterDelay() {
    document.write("<h1>Za 3 sekundy zostaniesz przekierowany na stronę rejestracji.</h1>");
    window.setTimeout(function () {window.open("register.php", "_self")}, 3000);
}

function redirectToUserPanel() {
    window.open("user_panel.php", "_self");
}

function errorAlert(error) {
    alert(error);
}

