<?php
// File: class/Kategori.php

class Kategori {
    private $conn;
    private $table_name = "kategori";

    public $id_kategori;
    public $nama_kategori;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($nama) {
        $sql = "INSERT INTO " . $this->table_name . " (nama_kategori) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nama]);
        return $stmt;
    }

    public function readAll() {
        $sql = "SELECT * FROM " . $this->table_name . " ORDER BY id_kategori DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function read($id) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_kategori = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nama) {
        $sql = "UPDATE " . $this->table_name . " SET nama_kategori = ? WHERE id_kategori = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nama, $id]);
        return $stmt;
    }

    public function delete($id) {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id_kategori = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt;
    }
}
?>
