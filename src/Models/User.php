<?php

namespace App\Models;

class User
{
    public $id;
    public $email;
    public $first_name;
    public $last_name;
    public $password;

    public static function findOne(int | null $id = null) {

        $db = \App\db\DB::getInstance()->getConnection();

        if ($id){
            $user = $db->query("SELECT * FROM users WHERE id = $id")->fetchArray(SQLITE3_ASSOC);
            return (object) $user;
        }
        $user = $db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 1")->fetchArray(SQLITE3_ASSOC);
        return (object) $user;
    }

    public function getAll() {

        $db = \App\db\DB::getInstance()->getConnection();
        $getUsers = $db->query('SELECT * FROM users');
        $users = [];
        
        while ($user = $getUsers->fetchArray(SQLITE3_ASSOC)) {
        $users[] = $user;
        }

        return json_encode($users);
    }

    public function email($email)
    {
        $this->email = $email;
    }
    public function first_name($first_name)
    {
        $this->first_name = $first_name;
    }

    public function last_name($last_name)
    {
        $this->last_name = $last_name;
    }

    public function password($password)
    {
        $this->password = $password;
    }

    public function save()
    {
        $db = \App\db\DB::getInstance()->getConnection();

        $sql = <<<HEREDOC
        INSERT INTO users 
        (email, first_name, last_name, password) 
        VALUES (
            '{$this->email}',
            '{$this->first_name}',
            '{$this->last_name}',
            '{$this->password}'
        );
        HEREDOC;


        $errors = $this->validate();

        if(count($errors) !== 0){
            print_r(json_encode($errors));
            return json_encode($errors);
        }
        $db->exec($sql);

        $savedUser = $db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 1")->fetchArray(SQLITE3_ASSOC);
        $this->id = $savedUser['id'];
    }

    public function delete($id) 
    {
        if (!$id){
            return "user not found";
        }
        $db = \App\db\DB::getInstance()->getConnection();
        $user = $db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 1")->fetchArray(SQLITE3_ASSOC);
        $user = $db->exec("DELETE FROM users WHERE id = $id");
        return;
    }

    public function validate()
    {
        $errors = [];
        if ($this->email == ''){
          $errors['email'] = "Заполните поле email";
        }
        if ($this->first_name == '') {
          $errors['first_name'] = "Заполните поле first_name";
        }
        if ($this->last_name == '') {
          $errors['last_name'] = "Заполните поле last_name";
        }
        if ($this->password == '') {
          $errors['password'] = "Заполните поле password";
        }
        return $errors;
    }
}