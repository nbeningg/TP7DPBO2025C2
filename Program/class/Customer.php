<?php
require_once 'config/db.php';

class Customer {
    private $db;

    public function __construct() {
        // koneksi ke database
        $this->db = (new Database())->conn;
    }

    // ambil semua data customer / pelanggan
    public function getAllCustomers() {
        $stmt = $this->db->query("SELECT * FROM customers");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ambil data customer berdasarkan ID
    public function getCustomerById($id) {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // tambah data customer baru
    public function addCustomer($name, $email, $phone) {
        $stmt = $this->db->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $phone]);
    }

    // perbarui data customer
    public function updateCustomer($id, $name, $email, $phone) {
        $stmt = $this->db->prepare("UPDATE customers SET name = ?, email = ?, phone = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $phone, $id]);
    }

    // hapus data customer
    public function deleteCustomer($id) {
        $stmt = $this->db->prepare("DELETE FROM customers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>