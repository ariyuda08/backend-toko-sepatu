<?php
class UsersModel
{
    private $conn;
    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $tables = include('config/table.php');
        $this->table_name = $tables['users'];
    }

    public function readAllUsers()
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

    public function getUserById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id_user = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getUserByUsername($username)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE username = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $username);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getUsersByRole($role)
    {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE role = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $role);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function addUsers($data)
    {
        try {
            $query = "INSERT INTO " . $this->table_name . " (username, nama_lengkap, email, password, role) VALUES (?,?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $data['username']);
            $stmt->bindParam(2, $data['nama_lengkap']);
            $stmt->bindParam(3, $data['email']);
            $stmt->bindParam(4, $data['password']);
            $stmt->bindParam(5, $data['role']);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateUsers($id, $data)
    {
        try {
            $query = "UPDATE " . $this->table_name . " SET username = ?, nama_lengkap = ?, email = ?, password = ?, role = ? WHERE id_user = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $data['username']);
            $stmt->bindParam(2, $data['nama_lengkap']);
            $stmt->bindParam(3, $data['email']);
            $stmt->bindParam(4, $data['password']);
            $stmt->bindParam(5, $data['role']);
            $stmt->bindParam(6, $id);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteUsers($id)
    {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id_user = ?";
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