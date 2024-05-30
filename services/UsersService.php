<?php
include_once 'models/UsersModel.php';

class UsersService {
    private $usersModel;

    public function __construct(UsersModel $usersModel) {
        $this->usersModel = $usersModel;
    }

    public function fetchAllUsers() {
        $users = $this->usersModel->readAllUsers();
        $users_array = array();
        $users_array["records"] = array();
        while ($row = $users->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user_item = array(
                "id" => $id_user,
                "username" => $username,
                "nama_lengkap" => $nama_lengkap,
                "email" => $email,
                "role" => $role
            );
            array_push($users_array["records"], $user_item);
        }
        return $users_array;
    }

    public function addUser($data) {
        $stmt = $this->usersModel->insertUser($data);
        return $stmt;
    }

    public function updateUser($id, $data) {
        $stmt = $this->usersModel->updateUser($id, $data);
        return $stmt;
    }

    public function deleteUser($id) {
        $stmt = $this->usersModel->deleteUser($id);
        return $stmt;
    }
}
