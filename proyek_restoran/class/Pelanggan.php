<?php
// File: class/Pelanggan.php

class Pelanggan {
    private $conn;
    private $table_name = "pelanggan";

    public $id_pelanggan;
    public $nama_pelanggan;
    public $email;
    public $no_hp;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($nama, $email, $no_hp) {
        $sql = "INSERT INTO " . $this->table_name . " (nama_pelanggan, email, no_hp) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nama, $email, $no_hp]);
        return $stmt;
    }    

    public function readAll() {
        $sql = "SELECT * FROM " . $this->table_name . " ORDER BY id_pelanggan DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function read($id) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id_pelanggan = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nama, $email, $no_hp) {
        $sql = "UPDATE " . $this->table_name . " SET nama_pelanggan = ?, email = ?, no_hp = ? WHERE id_pelanggan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nama, $email, $no_hp, $id]);
        return $stmt;
    }
    

    public function delete($id) {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id_pelanggan = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt;
    }
}
?>
