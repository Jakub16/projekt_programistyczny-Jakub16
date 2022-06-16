<?php
    $dsn = "mysql:host=localhost;dbname=test;charset=UTF8";
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        if($conn) {
            echo "<br><br><br><br>Pomyslnie polaczono z baza danych";
        }
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }