<?php

namespace App\db\connection;

use SQLite3;

function createConnection()
{
    $dbPath = __DIR__ . '/../../db.sqlite';
    touch($dbPath);
    $db = null;

    //TODO: Create connection to Sqlite DB
    $db = new SQLite3($dbPath);

    return $db;
}
