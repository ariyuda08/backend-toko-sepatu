<?php
include_once 'models/PesananModel.php';
include_once 'services/PesananService.php';
include_once 'middleware/Authentication.php';

class PesananController
{
    private $pesananService;

    public function __construct($conn)
    {
        $pesananModel = new PesananModel($conn);
        $this->pesananService = new PesananService($pesananModel);
    }

    public function readPesanan()
    {
        Authentication::authenticate(['admin', 'pemilik']);
        $pesanan = $this->pesananService->fetchAllPesanan();
        return json_encode($pesanan);
    }

    public function readPesananById($id)
    {
        Authentication::authenticate(['admin', 'pemilik']);
        $user = $this->pesananService->fetchPesananById($id);
        if ($user) {
            return json_encode($user);
        } else {
            echo json_encode(array("message" => "User not found."));
        }
        exit();
    }

    public function addPesanan()
    {
        Authentication::authenticate(['admin', 'pemilik']);
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->pesananService->addPesanan($data);
        if ($result) {
            echo json_encode(array("message" => "Pesanan added successfully."));
        } else {
            echo json_encode(array("message" => "Failed to create pesanan."));
        }
        exit();
    }

    public function updatePesanan()
    {
        Authentication::authenticate(['admin', 'pemilik']);
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id_pesanan'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }
        $id = $data['id_pesanan'];
        $result = $this->pesananService->updatePesanan($id, $data);
        if ($result) {
            echo json_encode(array("message" => "Pesanan updated successfully."));
        } else {
            echo json_encode(array("message" => "Failed to update pesanan."));
        }
        exit();
    }

    public function deletePesanan()
    {
        Authentication::authenticate(['admin', 'pemilik']);
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id_pesanan'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }
        $id = $data['id_pesanan'];
        $result = $this->pesananService->deletePesanan($id);
        if ($result) {
            echo json_encode(array("message" => "Pesanan deleted successfully."));
        } else {
            echo json_encode(array("message" => "Failed to delete pesanan."));
        }
        exit();
    }
}
?>
