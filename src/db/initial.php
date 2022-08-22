<?php

namespace App\db\initial;

function initializeDb($db): void
{
    $usersTable = "CREATE TABLE IF NOT EXISTS users(
                  id INTEGER PRIMARY KEY AUTOINCREMENT,
                  email TEXT NOT NULL,
                  first_name TEXT NOT NULL,
                  last_name TEXT NOT NULL,
                  password TEXT NOT NULL,
                  created_at INTEGER NOT NULL
        )";
    $postTable = "CREATE TABLE IF NOT EXISTS post(
                  id INTEGER PRIMARY KEY AUTOINCREMENT,
                  title TEXT NOT NULL,
                  body TEXT NOT NULL,
                  creator_id INTEGER NOT NULL,
                  created_at INTEGER NOT NULL,
                  FOREIGN KEY (creator_id) REFERENCES users (id)                  
        )";
    $db->exec($usersTable);
    $db->exec($postTable);
}
