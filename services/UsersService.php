<?php
include_once 'models/UsersModel.php';

class UsersService
{
    private $usersModel;

    public function __construct(UsersModel $usersModel)
    {
        $this->usersModel = $usersModel;
    }

    public function fetchAllUsers()
    {
        $users = $this->usersModel->readAllUsers();
        $users_array = array();
        $users_array["records"] = array();

        while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user_item = array(
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

    public function fetchUserById($id)
    {
        $user = $this->usersModel->getUserById($id);
        if ($user) {
            return array(
                "id_user" => $user['id_user'],
                "username" => $user['username'],
                "nama_lengkap" => $user['nama_lengkap'],
                "email" => $user['email'],
                "password" => $user['password'],
                "role" => $user['role']
            );
        }
        return null;
    }

    public function fetchUserByUsername($username)
    {
        $user = $this->usersModel->getUserByUsername($username);
        if ($user) {
            return array(
                "id_user" => $user['id_user'],
                "username" => $user['username'],
                "nama_lengkap" => $user['nama_lengkap'],
                "email" => $user['email'],
                "password" => $user['password'],
                "role" => $user['role']
            );
        }
        return null;
    }

    public function fetchUserByRole($role)
    {
        $users = $this->usersModel->getUsersByRole($role);
        $users_array = array();
        $users_array["records"] = array();

        foreach ($users as $user) {
            $user_item = array(
                "id_user" => $user['id_user'],
                "username" => $user['username'],
                "nama_lengkap" => $user['nama_lengkap'],
                "email" => $user['email'],
                "password" => $user['password'],
                "role" => $user['role']
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

    public function login($username, $password)
    {
        $user = $this->usersModel->getUserByUsername($username);
        if ($user && $user['password'] == $password) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    public function logout()
    {
        // Clear the session
        session_unset();
        session_destroy();
        return true;
    }
}
?>
