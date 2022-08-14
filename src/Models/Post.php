<?php

namespace App\Models;

class Post {

    public $id;
    public $title;
    public $body;
    public $creator_id;

    public static function findOne(int | null $id = null) {

        $db = \App\db\DB::getInstance()->getConnection();

        if ($id){
            $post = $db->query("SELECT * FROM post WHERE id = $id")->fetchArray(SQLITE3_ASSOC);
            return (object) $post;
        }
        $post = $db->query("SELECT * FROM post ORDER BY created_at DESC LIMIT 1")->fetchArray(SQLITE3_ASSOC);
        return (object) $post;

    }
    public function title($title)
    {
        $this->title = $title;
    }
    public function body($body)
    {
        $this->body = $body;
    }

    public function creator_id($creator_id)
    {
        $this->creator_id = $creator_id;
    }

    public function save()
    {
        $db = \App\db\DB::getInstance()->getConnection();

        $sql = <<<HEREDOC
        INSERT INTO post 
        (title, body, creator_id) 
        VALUES (
            '{$this->title}',
            '{$this->body}',
            '{$this->creator_id}'
        );
        HEREDOC;

        $db->exec($sql);
        
        $post = $db->query("SELECT * FROM post ORDER BY created_at DESC LIMIT 1")->fetchArray(SQLITE3_ASSOC);
        $this->id = $post['id'];
    }
}

