<?php
include_once 'models/UsersModel.php';
include_once 'services/UsersService.php';
include_once 'middleware/Authentication.php';

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
        Authentication::authenticate(['pemilik', 'admin']);
        $users = $this->usersService->fetchAllUsers();
        return json_encode($users);
    }

    public function readUserById($id)
    {
        Authentication::authenticate(['pemilik', 'admin']);
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
        Authentication::authenticate(['pemilik', 'admin']);
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
        Authentication::authenticate(['pemilik', 'admin']);
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
        Authentication::authenticate(['pemilik', 'admin']);
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
        Authentication::authenticate(['pemilik', 'admin']);
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
        Authentication::authenticate(['pemilik', 'admin']);
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

    public function login($username, $password)
    {
        return $this->usersService->login($username, $password);
    }

    public function logout()
    {
        return $this->usersService->logout();
    }
}
?>
