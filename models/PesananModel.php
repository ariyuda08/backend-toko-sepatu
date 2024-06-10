<?php
class PesananModel
{
    private $conn;
    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $tables = include('config/table.php');
        $this->table_name = $tables['pesanan'];
    }

    public function readAllPesanan()
    {
        try {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function addPesanan($data)
    {
        try {
            $query = "INSERT INTO " . $this->table_name . " (tanggal_pesanan, id_user, id_produk, nama_pelanggan, kontak, status, jumlah, total_harga) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $data['tanggal_pesanan']);
            $stmt->bindParam(2, $data['id_user']);
            $stmt->bindParam(3, $data['id_produk']);
            $stmt->bindParam(4, $data['nama_pelanggan']);
            $stmt->bindParam(5, $data['kontak']);
            $stmt->bindParam(6, $data['status']);
            $stmt->bindParam(7, $data['jumlah']);
            $stmt->bindParam(8, $data['total_harga']);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updatePesanan($id, $data)
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET tanggal_pesanan = ?, id_user = ?, id_produk = ?, nama_pelanggan = ?, kontak = ?, status = ?, jumlah = ?, total_harga = ? WHERE id_pesanan = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $data['tanggal_pesanan']);
            $stmt->bindParam(2, $data['id_user']);
            $stmt->bindParam(3, $data['id_produk']);
            $stmt->bindParam(4, $data['nama_pelanggan']);
            $stmt->bindParam(5, $data['kontak']);
            $stmt->bindParam(6, $data['status']);
            $stmt->bindParam(7, $data['jumlah']);
            $stmt->bindParam(8, $data['total_harga']);
            $stmt->bindParam(9, $id);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deletePesanan($id)
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_pesanan = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}