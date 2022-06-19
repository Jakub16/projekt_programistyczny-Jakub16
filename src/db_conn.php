<?php
    $dsn = "mysql:host=localhost;dbname=test;charset=UTF8";
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        if($conn) {
            $info = "Pomyslnie polaczono z baza danych";
        }
    }
    catch(PDOException $error) {
        echo $error->getMessage();
    }