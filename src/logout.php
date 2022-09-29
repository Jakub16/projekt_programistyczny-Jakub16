<?php

    echo "<script type = 'text/javascript' src = 'js_script.js'></script>";
    session_start();

    $_SESSION = array();

    session_destroy();

    echo "<script type = 'text/javascript'>redirectToLogin();</script>";