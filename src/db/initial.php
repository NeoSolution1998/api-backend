<?php

namespace App\db\initial;

use App\Models;

function initializeDb($db)
{
    //TODO: Create initial tables
    $createUsers = <<<HEREDOC
    CREATE TABLE users (
        id integer primary key autoincrement,
        email varchar(255),
        first_name varchar(255),
        last_name varchar(255),
        password varchar(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
    );
    HEREDOC;

    $createPost = <<<HEREDOC
    CREATE TABLE post (
        id integer primary key autoincrement,
        title varchar(255),
        body varchar(255),
        creator_id integer,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
        FOREIGN KEY (creator_id) REFERENCES users(id)
    );
    HEREDOC;

    $db->exec($createUsers);
    $db->exec($createPost);
    
}
