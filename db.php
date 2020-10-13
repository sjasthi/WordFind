<?php

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'word_find';

    // Set DSN - data source name
    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

    // Create PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    