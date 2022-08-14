<?php

namespace App;

use App\Models\User;
use App\Models\Post;
use App\db\DB;

class Api
{
    public function connection()
    {
        //TODO: Implement api: get user by id, create user
        if ($_SERVER["REQUEST_URI"] == '/') {
            return $this->index();
        }

        if (strpos($_SERVER["REQUEST_URI"], "api/users/") && $_SERVER['REQUEST_METHOD'] == 'GET') {
            return $this->show();
        }

        if ($_SERVER["REQUEST_URI"] == "/api/users" && $_SERVER['REQUEST_METHOD'] == 'PUT') {

            return $this->store();
        }

        if (strpos($_SERVER["REQUEST_URI"], "api/users/") && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            
            return $this->destroy();
        }
        
    }

    public function index()
    {
        $db = \App\db\DB::getInstance()->getConnection();
        $getUsers = $db->query('SELECT * FROM users');
        $users = [];
        
        while ($user = $getUsers->fetchArray(SQLITE3_ASSOC)) {
        $users[] = $user;
        }
        echo json_encode($users);
        return json_encode($users);
    }

    public function show()
    {   
        $url = $_SERVER["REQUEST_URI"];
        $explode = explode("/", $url);
        $id = array_pop($explode);
        $user = new User();
        
        echo $user->findOne($id);
    }

    public function store()
    {   
        $user = new User();  
        $putdata = file_get_contents('php://input');                                    
        $decode = json_decode($putdata, true);
        $_PUT = $decode;

        $user->email = $_PUT['email'];
        $user->first_name = $_PUT['first_name'];
        $user->last_name = $_PUT['last_name'];
        $user->password = $_PUT['password'];
        $user->save();


        if ($user->id == null){
            return;
        }

        $data = [
            "status" => "пользователь успешно добавлен",
            "user_id" => $user->id
        ];

        
        echo json_encode($user);
        return json_encode($user);
    }

    public function destroy()
    {   
        $url = $_SERVER["REQUEST_URI"];
        $explode = explode("/", $url);
        $id = array_pop($explode);
        $user = new User();  
        $user->delete($id);
        return;
    }
}
