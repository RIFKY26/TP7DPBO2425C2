<?php
// File: class/Menu.php

class Menu {
    private $conn;
    private $table_name = "menu";

    public $id_menu;
    public $nama_menu;
    public $harga;
    public $id_kategori;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE
    public function create($nama, $harga, $id_kategori) {
        $sql = "INSERT INTO " . $this->table_name . " (nama_menu, harga, id_kategori) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nama, $harga, $id_kategori]);
        return $stmt;
    }

    // READ all
    public function readAll() {
        $sql = "SELECT m.*, k.nama_kategori FROM " . $this->table_name . " m LEFT JOIN kategori k ON m.id_kategori = k.id_kategori ORDER BY m.id_menu DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    // READ single
    public function read($id) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_menu = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update($id, $nama, $harga, $id_kategori) {
        $sql = "UPDATE " . $this->table_name . " SET nama_menu = ?, harga = ?, id_kategori = ? WHERE id_menu = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nama, $harga, $id_kategori, $id]);
        return $stmt;
    }

    // DELETE
    public function delete($id) {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id_menu = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt;
    }
}
?>
