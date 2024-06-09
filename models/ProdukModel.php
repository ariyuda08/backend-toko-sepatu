<?php
class ProdukModel
{
    private $conn;
    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $tables = include('config/table.php');
        $this->table_name = $tables['produk'];
    }

    public function readAllProduk()
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

    public function addProduk($data)
    {
        try {
            $query = "INSERT INTO " . $this->table_name . " (nama_produk, deskripsi, harga, gambar, id_kategori) VALUES (?,?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $data['nama_produk']);
            $stmt->bindParam(2, $data['deskripsi']);
            $stmt->bindParam(3, $data['harga']);
            $stmt->bindParam(4, $data['gambar']);
            $stmt->bindParam(5, $data['id_kategori']);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateProduk($id, $data)
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET nama_produk = ?, deskripsi = ?, harga = ?, gambar = ?, id_kategori = ? WHERE id_produk = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $data['nama_produk']);
            $stmt->bindParam(2, $data['deskripsi']);
            $stmt->bindParam(3, $data['harga']);
            $stmt->bindParam(4, $data['gambar']);
            $stmt->bindParam(5, $data['id_kategori']);
            $stmt->bindParam(6, $id);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteProduk($id)
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_produk = ?";
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