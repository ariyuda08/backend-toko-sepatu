<?php
include_once 'models/UsersModel.php';
include_once 'services/UsersService.php';

class UsersController {
    private $usersService;

    public function __construct($conn) {
        $usersModel = new UsersModel($conn);
        $this->usersService = new UsersService($usersModel);
    }

    public function readUsers() {
        $users = $this->usersService->fetchAllUsers();
        echo json_encode($users);
    }

    public function addUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->usersService->addUser($data);
        echo json_encode(["message" => $result]);
    }

    public function updateUser($params) {
        $id = $params['id'];
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->usersService->updateUser($id, $data);
        echo json_encode(["message" => $result]);
    }

    public function deleteUser($params) {
        $id = $params['id'];
        $result = $this->usersService->deleteUser($id);
        echo json_encode(["message" => $result]);
    }
}
?>
