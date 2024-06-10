<?php
include_once 'models/PesananModel.php';
include_once 'services/PesananService.php';

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
        $pesanan = $this->pesananService->fetchAllPesanan();
        return json_encode($pesanan);
    }

    public function addPesanan()
    {
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
