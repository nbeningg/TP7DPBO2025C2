<?php
require_once 'config/db.php';
require_once 'class/Merchandise.php';

class Purchase {
    private $db;

    public function __construct() {
        // koneksi ke database
        $this->db = (new Database())->conn;
    }

    // ambil semua data purchases atau pembelian dengan info customer dan merchandise
    public function getAllPurchases() {
        $stmt = $this->db->query("SELECT purchases.*, customers.name as customer_name, merchandise.name as merchandise_name, merchandise.price 
                                FROM purchases 
                                JOIN customers ON purchases.customer_id = customers.id 
                                JOIN merchandise ON purchases.merchandise_id = merchandise.id
                                ORDER BY purchases.id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ambil satu data pembelian berdasarkan ID
    public function getPurchaseById($id) {
        $stmt = $this->db->prepare("SELECT purchases.*, customers.name as customer_name, merchandise.name as merchandise_name, merchandise.price 
                                    FROM purchases 
                                    JOIN customers ON purchases.customer_id = customers.id 
                                    JOIN merchandise ON purchases.merchandise_id = merchandise.id 
                                    WHERE purchases.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // tambah pembelian baru (dapat melihat stok barang)
    public function addPurchase($customer_id, $merchandise_id, $quantity) {
        $stmt = $this->db->prepare("INSERT INTO purchases (customer_id, merchandise_id, purchase_date, quantity) VALUES (?, ?, CURDATE(), ?)");
        $merchandise = new Merchandise();
        $merch = $merchandise->getMerchandiseById($merchandise_id);
        if ($merch['stock'] >= $quantity) {
            $merchandise->updateStock($merchandise_id, $quantity);
            return $stmt->execute([$customer_id, $merchandise_id, $quantity]);
        }
        return false;
    }

    // perbarui data pembelian dan sesuaikan stok
    public function updatePurchase($id, $customer_id, $merchandise_id, $purchase_date, $quantity) {
        // mendapatkan data pembelian lama
        $oldPurchase = $this->getPurchaseById($id);
        $merchandise = new Merchandise();
        
        // hitung selisih kuantitas
        $qDifference = $quantity - $oldPurchase['quantity'];
        
        // memeriksa ketersediaan stok jika ada penambahan jumlah
        if ($qDifference > 0) {
            $merch = $merchandise->getMerchandiseById($merchandise_id);
            if ($merch['stock'] < $qDifference) {
                return false; // stok tidak mencukupi
            }
        }
        
        // update stok barang
        $merch = $merchandise->getMerchandiseById($merchandise_id);
        $newStock = $merch['stock'] - $qDifference;
        $updateStock = $this->db->prepare("UPDATE merchandise SET stock = ? WHERE id = ?");
        $updateStock->execute([$newStock, $merchandise_id]);
        
        // update data pembelian
        $stmt = $this->db->prepare("UPDATE purchases SET customer_id = ?, merchandise_id = ?, purchase_date = ?, quantity = ? WHERE id = ?");
        return $stmt->execute([$customer_id, $merchandise_id, $purchase_date, $quantity, $id]);
    }

    // hapus pembelian barang dan kembalikan stok
    public function deletePurchase($id) {
        // mendapatkan data pembelian
        $purchase = $this->getPurchaseById($id);
        
        // mengembalikan stok barang
        $merchandise = new Merchandise();
        $merch = $merchandise->getMerchandiseById($purchase['merchandise_id']);
        $newStock = $merch['stock'] + $purchase['quantity'];
        $updateStock = $this->db->prepare("UPDATE merchandise SET stock = ? WHERE id = ?");
        $updateStock->execute([$newStock, $purchase['merchandise_id']]);
        
        // menghapus data pembelian
        $stmt = $this->db->prepare("DELETE FROM purchases WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>