<?php
include_once 'models/ProdukModel.php';

class ProdukService
{
    private $produkModel;

    public function __construct(ProdukModel $produkModel)
    {
        $this->produkModel = $produkModel;
    }

    public function fetchAllProduk()
    {
        $produk = $this->produkModel->readAllProduk();
        $produk_array = array();
        $produk_array["records"] = array();
        while ($rows = $produk->fetch(PDO::FETCH_ASSOC))
        {
            extract($rows);
            $produk_item = array (
                "id_produk" => $id_produk,
                "nama_produk" => $nama_produk,
                "deskripsi" => $deskripsi,
                "harga" => $harga,
                "gambar" => $gambar,
                "id_kategori" => $id_kategori
            );
            array_push($produk_array["records"], $produk_item);
        }
        
        return $produk_array;
    }

    public function fetchProdukById($id)
    {
        $produk = $this->produkModel->getProdukById($id);
        if ($produk) {
            return array(
                "id_produk" => $produk['id_produk'],
                "nama_produk" => $produk['nama_produk'],
                "deskripsi" => $produk['deskripsi'],
                "harga" => $produk['harga'],
                "gambar" => $produk['gambar'],
                "id_kategori" => $produk['id_kategori']
            );
        }
        return null;
    }

    public function addProduk($data)
    {
        return $this->produkModel->addProduk($data);
    }

    public function updateProduk($id, $data)
    {
        return $this->produkModel->updateProduk($id, $data);
    }

    public function deleteProduk($id)
    {
        return $this->produkModel->deleteProduk($id);
    }
}
?>