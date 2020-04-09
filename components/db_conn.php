<?php

$params = require_once '../config/db.php';

try {
    $db_conn = new PDO(
        'mysql:host='.$params['host'].';dbname='.$params['dbname'], $params['username'], $params['password']
    );
    $db_conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    // set the PDO error mode to exception
    $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
