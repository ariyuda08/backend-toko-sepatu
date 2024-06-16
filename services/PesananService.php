<?php
include_once 'models/PesananModel.php';

class PesananService
{
    private $pesananModel;

    public function __construct(PesananModel $pesananModel)
    {
        $this->pesananModel = $pesananModel;
    }

    public function fetchAllPesanan()
    {
        $pesanan = $this->pesananModel->readAllPesanan();
        $pesanan_array = array();
        $pesanan_array["records"] = array();
        while ($rows = $pesanan->fetch(PDO::FETCH_ASSOC))
        {
            extract($rows);
            $pesanan_item = array (
                "id_pesanan" => $id_pesanan,
                "id_user" => $id_user,
                "id_produk" => $id_produk,
                "nama_pelanggan" => $nama_pelanggan,
                "kontak" => $kontak,
                "status" => $status,
                "jumlah" => $jumlah,
                "total_harga" => $total_harga,
                "tanggal_pesanan" => $tanggal_pesanan
            );
            array_push($pesanan_array["records"], $pesanan_item);
        }
        
        return $pesanan_array;
    }

    public function fetchPesananById($id)
    {
        $pesanan = $this->pesananModel->getPesananById($id);
        if ($pesanan) {
            return array(
                "id_pesanan" => $pesanan['id_pesanan'],
                "tanggal_pesanan" => $pesanan['tanggal_pesanan'],
                "id_user" => $pesanan['id_user'],
                "id_produk" => $pesanan['id_produk'],
                "nama_pelanggan" => $pesanan['nama_pelanggan'],
                "kontak" => $pesanan['kontak'],
                "status" => $pesanan['status'],
                "jumlah" => $pesanan['jumlah'],
                "total_harga" => $pesanan['total_harga']
            );
        }
        return null;
    }

    public function addPesanan($data)
    {
        return $this->pesananModel->addPesanan($data);
    }

    public function updatePesanan($id, $data)
    {
        return $this->pesananModel->updatePesanan($id, $data);
    }

    public function deletePesanan($id)
    {
        return $this->pesananModel->deletePesanan($id);
    }
}
?>
