<?php
// kelas untuk mengatur koneksi ke database menggunakan PDO
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "kpop_store";
    public $conn;

    public function __construct() {
        try {
            // membuat koneksi ke database
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            // mengatur agar error ditangani sebagai exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // menampilkan pesan error jika koneksi gagal
            echo "Koneksi gagal: " . $e->getMessage();
        }
    }
}
?>
