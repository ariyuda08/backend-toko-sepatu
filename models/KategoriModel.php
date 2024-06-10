<?php
class KategoriModel
{
    private $conn;
    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $tables = include('config/table.php');
        $this->table_name = $tables['kategori'];
    }

    public function readAllKategori()
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

    public function addKategori($data)
    {
        try {
            $query = "INSERT INTO " . $this->table_name . " (nama_kategori) VALUES (?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $data['nama_kategori']);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateKategori($id, $data)
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET nama_kategori = ? WHERE id_kategori = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $data['nama_kategori']);
            $stmt->bindParam(2, $id);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteKategori($id)
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_kategori = ?";
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
?>
