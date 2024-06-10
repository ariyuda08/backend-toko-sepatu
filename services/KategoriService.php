<?php
include_once 'models/KategoriModel.php';

class KategoriService
{
    private $kategoriModel;

    public function __construct(KategoriModel $kategoriModel)
    {
        $this->kategoriModel = $kategoriModel;
    }

    public function fetchAllKategori()
    {
        $kategori = $this->kategoriModel->readAllKategori();
        $kategori_array = array();
        $kategori_array["records"] = array();
        while ($rows = $kategori->fetch(PDO::FETCH_ASSOC))
        {
            extract($rows);
            $kategori_item = array (
                "id_kategori" => $id_kategori,
                "nama_kategori" => $nama_kategori
            );
            array_push($kategori_array["records"], $kategori_item);
        }
        
        return $kategori_array;
    }

    public function addKategori($data)
    {
        return $this->kategoriModel->addKategori($data);
    }

    public function updateKategori($id, $data)
    {
        return $this->kategoriModel->updateKategori($id, $data);
    }

    public function deleteKategori($id)
    {
        return $this->kategoriModel->deleteKategori($id);
    }
}
?>
