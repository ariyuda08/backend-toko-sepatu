<?php
include_once 'models/UsersModel.php';
include_once 'services/UsersService.php';

class UsersController
{
    private $usersService;

    public function __construct($conn)
    {
        $usersModel = new UsersModel($conn);
        $this->usersService = new UsersService($usersModel);
    }

    public function readUsers()
    {
        $users = $this->usersService->fetchAllUsers();
        return json_encode($users);
    }

    public function readUserById($id)
    {
        $user = $this->usersService->fetchUserById($id);
        if ($user) {
            return json_encode($user);
        } else {
            echo json_encode(array("message" => "User not found."));
        }
        exit();
    }

    public function readUserByUsername($username)
    {
        $user = $this->usersService->fetchUserByUsername($username);
        if ($user) {
            return json_encode($user);
        } else {
            echo json_encode(array("message" => "User not found."));
        }
        exit();
    }
    
    public function readUsersByRole($role)
    {
        $users = $this->usersService->fetchUserByRole($role);
        if ($users) {
            return json_encode($users);
        } else {
            echo json_encode(array("message" => "Users not found for role: " . $role));
        }
        exit();
    }

    public function addUsers()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->usersService->addUsers($data);
        if ($result) {
            echo json_encode(array("message" => "User added successfully."));
        } else {
            echo json_encode(array("message" => "Failed to create user."));
        }
        exit();
    }

    public function updateUsers()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id_user'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }
        $id = $data['id_user'];
        $result = $this->usersService->updateUsers($id, $data);
        if ($result) {
            echo json_encode(array("message" => "User updated successfully."));
        } else {
            echo json_encode(array("message" => "Failed to update user."));
        }
        exit();
    }

    public function deleteUsers()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id_user'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }
        $id = $data['id_user'];
        $result = $this->usersService->deleteUsers($id);
        if ($result) {
            echo json_encode(array("message" => "User deleted successfully."));
        } else {
            echo json_encode(array("message" => "Failed to delete user."));
        }
        exit();
    }
}
?>