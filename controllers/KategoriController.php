<?php
include_once 'models/KategoriModel.php';
include_once 'services/KategoriService.php';

class KategoriController
{
    private $kategoriService;

    public function __construct($conn)
    {
        $kategoriModel = new KategoriModel($conn);
        $this->kategoriService = new KategoriService($kategoriModel);
    }

    public function readKategori()
    {
        $kategori = $this->kategoriService->fetchAllKategori();
        return json_encode($kategori);
    }

    public function readKategoriById($id)
    {
        $user = $this->kategoriService->fetchKategoriById($id);
        if ($user) {
            return json_encode($user);
        } else {
            echo json_encode(array("message" => "User not found."));
        }
        exit();
    }

    public function addKategori()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $this->kategoriService->addKategori($data);
        if ($result) {
            echo json_encode(array("message" => "Kategori added successfully."));
        } else {
            echo json_encode(array("message" => "Failed to create kategori."));
        }
        exit();
    }

    public function updateKategori()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id_kategori'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }
        $id = $data['id_kategori'];
        $result = $this->kategoriService->updateKategori($id, $data);
        if ($result) {
            echo json_encode(array("message" => "Kategori updated successfully."));
        } else {
            echo json_encode(array("message" => "Failed to update kategori."));
        }
        exit();
    }

    public function deleteKategori()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id_kategori'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }
        $id = $data['id_kategori'];
        $result = $this->kategoriService->deleteKategori($id);
        if ($result) {
            echo json_encode(array("message" => "Kategori deleted successfully."));
        } else {
            echo json_encode(array("message" => "Failed to delete kategori."));
        }
        exit();
    }
}
?>
