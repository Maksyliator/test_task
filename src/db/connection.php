<?php

namespace App\db\connection;

use PDO;

function createConnection(): object
{
    $dbPath = __DIR__ . '/../../db.sqlite';
    touch($dbPath);

    $db = null;

    //TODO: Create connection to Sqlite DB
    try {
        $db = new PDO('sqlite:' . $dbPath);
    } catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
    }

    return $db;
}
