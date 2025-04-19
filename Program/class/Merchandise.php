<?php
require_once 'config/db.php';

class Merchandise {
    private $db;

    public function __construct() {
        // koneksi ke database
        $this->db = (new Database())->conn;
    }

    // ambil semua data merchandise atau barang
    public function getAllMerchandise() {
        $stmt = $this->db->query("SELECT * FROM merchandise");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ambil satu data merchandise berdasarkan ID
    public function getMerchandiseById($id) {
        $stmt = $this->db->prepare("SELECT * FROM merchandise WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ambil data berdasarkan keyword pencarian
    public function searchMerchandise($keyword) {
        $stmt = $this->db->prepare("SELECT * FROM merchandise WHERE name LIKE ?");
        $stmt->execute(["%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // tambah data merchandise baru
    public function addMerchandise($name, $category, $price, $stock) {
        $stmt = $this->db->prepare("INSERT INTO merchandise (name, category, price, stock) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $category, $price, $stock]);
    }

    // perbarui data merchandise
    public function updateMerchandise($id, $name, $category, $price, $stock) {
        $stmt = $this->db->prepare("UPDATE merchandise SET name = ?, category = ?, price = ?, stock = ? WHERE id = ?");
        return $stmt->execute([$name, $category, $price, $stock, $id]);
    }

    // hapus data merchandise
    public function deleteMerchandise($id) {
        $stmt = $this->db->prepare("DELETE FROM merchandise WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // perbarui stok jika ada yang beli
    public function updateStock($id, $quantity) {
        $merch = $this->getMerchandiseById($id);
        $newStock = $merch['stock'] - $quantity;
        $stmt = $this->db->prepare("UPDATE merchandise SET stock = ? WHERE id = ?");
        return $stmt->execute([$newStock, $id]);
    }
}
?>