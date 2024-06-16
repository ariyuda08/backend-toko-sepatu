<?php
include_once 'models/ProdukModel.php';
include_once 'services/ProdukService.php';

class ProdukController
{
    private $produkService;

    public function __construct($conn)
    {
        $produkModel = new ProdukModel($conn);
        $this->produkService = new ProdukService($produkModel);
    }

    public function readProduk()
    {
        $produk = $this->produkService->fetchAllProduk();
        return json_encode($produk);
    }

    public function readProdukById($id)
    {
        $user = $this->produkService->fetchProdukById($id);
        if ($user) {
            return json_encode($user);
        } else {
            echo json_encode(array("message" => "User not found."));
        }
        exit();
    }

    public function addProduk()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->produkService->addProduk($data);
        if ($result) {
            echo json_encode(array("message" => "Produk added successfully."));
        } else {
            echo json_encode(array("message" => "Failed to create produk."));
        }
        exit();
    }

    public function updateProduk()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id_produk'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }
        $id = $data['id_produk'];
        $result = $this->produkService->updateProduk($id, $data);
        if ($result) {
            echo json_encode(array("message" => "Produk updated successfully."));
        } else {
            echo json_encode(array("message" => "Failed to update produk."));
        }
        exit();
    }

    public function deleteProduk()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id_produk'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }
        $id = $data['id_produk'];
        $result = $this->produkService->deleteProduk($id);
        if ($result) {
            echo json_encode(array("message" => "Produk deleted successfully."));
        } else {
            echo json_encode(array("message" => "Failed to delete produk."));
        }
        exit();
    }
}