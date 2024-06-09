<?php
include_once 'models/UsersModel.php';

class UsersService
{
    private $usersModel;

    public function __construct(UsersModel $usersmodel)
    {
        $this->usersModel = $usersmodel;
    }

    public function fetchAllUsers()
    {
        $users = $this->usersModel->readAllUsers();
        $users_array = array();
        $users_array["records"] = array();
        while ($rows = $users->fetch(PDO::FETCH_ASSOC))
        {
            extract($rows);
            $user_item = array (
                "id_user" => $id_user,
                "username" => $username,
                "nama_lengkap" => $nama_lengkap,
                "email" => $email,
                "password" => $password,
                "role" => $role
            );
            array_push($users_array["records"], $user_item);
        }
        
        return $users_array;
    }

    public function addUsers($data)
    {
        return $this->usersModel->addUsers($data);
    }

    public function updateUsers($id, $data)
    {
        return $this->usersModel->updateUsers($id, $data);
    }

    public function deleteUsers($id)
    {
        return $this->usersModel->deleteUsers($id);
    }
}
?>