# Janji
Saya Nuansa Bening Aura Jelita dengan NIM 2301410 mengerjakan Tugas Praktikum 7 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek 
untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

# Desain Program
Program ini adalah sebuah sistem manajemen toko K-pop.
Sistem ini memungkinkan pengelola toko untuk mengelola data pelanggan, merchandise, dan transaksi pembelian. Berikut adalah penjelasan desain programnya:
## DATABASE (kpop_store)
![image](https://github.com/user-attachments/assets/d8561403-eb45-4787-905b-b1f718b3526e)
* **Tabel customers**
  * Menyimpan data customer/pelanggan dengan atribut id (primary key), name, email, dan phone
  * Kolom email bersifat unik untuk menghindari duplikasi data pelanggan
    
* **Tabel merchandise**
  * Menyimpan data merchandise/barang dengan atribut id (primary key), name, category, price, dan stock
  * Category menentukan jenis barang (Album, Lightstick, Photocard, dll.)
  * Stock digunakan untuk melacak ketersediaan barang

* **Tabel purchases**
  * Menyimpan data transaksi pembelian dengan relasi ke dua tabel lainnya
  * Memiliki foreign key ke customer_id dan merchandise_id
  * Mencatat tanggal pembelian dan kuantitas barang yang dibel

## STRUKTUR DIREKTORI
![image](https://github.com/user-attachments/assets/98346b3e-11a2-4c10-8fbe-a90226529c7c)
* **class/**
  * Customer.php : Class untuk manipulasi data customer/pelanggan
  * Merchandise.php : Class untuk manipulasi data merchandise/barang
  * Purchase.php : Class untuk manipulasi data transaksi pembelian
 
* **config/**
  * db.php - Konfigurasi koneksi database menggunakan PDO

* **view/**
   * customers.php :Tampilan untuk halaman pengelolaan pelanggan
   * merchandise.php : Tampilan untuk halaman pengelolaan barang
   * purchases.php : Tampilan untuk halaman pengelolaan pembelian
   * header.php dan footer.php : Tampilan untuk bagian atas dan bawah setiap halaman

* **index.php**
   * File utama yang menjadi entry point sistem
   * Menangani routing dan kontrol alur program

* **style.css**
   * Membuat tampilan lebih menarik

# Alur Program
## 1. Inisialisasi Sistem
  * Aplikasi dimulai di index.php yang memuat kelas-kelas yang diperlukan dan membuat objek
  * Koneksi database dibuat melalui kelas Database di config/db.php
  * Halaman default diatur ke 'merchandise' jika tidak ada halaman spesifik yang diminta

## 2. Navigasi
* Pengguna dapat bernavigasi di antara tiga bagian utama:
  * Customer / Pelanggan (Customers)
  * Merchandise / Barang (Merchandise)
  * Purchase / Transaksi Pembelian (Purchases)
* Setiap bagian merender file view terkait dari folder view

## 3. Operasi Data (Alur CRUD)
### Untuk Pelanggan:
  1. Lihat Pelanggan: Menampilkan daftar semua pelanggan dalam tabel
  2. Tambah Pelanggan:
     * Pengguna mengklik tombol "Add New Customer"
     * Form muncul untuk memasukkan detail pelanggan
     * Saat dikirim, metode addCustomer() dipanggil
     * Halaman diperbarui untuk menampilkan daftar terbaru
  3. Edit Pelanggan:
     * Pengguna mengklik tombol "Edit" untuk pelanggan tertentu
     * Form diisi dengan data pelanggan yang ada
     * Saat dikirim, metode updateCustomer() dipanggil
  4. Hapus Pelanggan:
     * Pengguna mengklik tombol "Delete" dan mengkonfirmasi
     * Metode deleteCustomer() dipanggil

### Untuk Merchandise:
  * Lihat/Cari Merchandise: Menampilkan semua merchandise atau hasil filter
  * Tambah Merchandise:
    * Alur serupa dengan menambahkan pelanggan
    * Termasuk opsi pemilihan kategori
  * Edit Merchandise:
    * Form diisi dengan data merchandise yang ada
  * Hapus Merchandise:
    * Menghapus catatan merchandise

### Untuk Pembelian:
  * Lihat Pembelian: Menampilkan semua transaksi pembelian dengan nama pelanggan, merch yang dipilih, dan total harga
  * Tambah Pembelian:
    * Pengguna memilih pelanggan dan merchandise dari dropdown
    * Jumlah ditentukan
    * Saat dikirim, sistem:
      * Memeriksa apakah stok mencukupi
      * Membuat catatan pembelian
      * Memperbarui tingkat stok merchandise
  * Edit Pembelian:
    * Memungkinkan modifikasi pelanggan, merchandise, tanggal, dan jumlah
    * Menghitung ulang tingkat stok berdasarkan perubahan
  * Hapus Pembelian:
    * Menghapus catatan pembelian
    * Mengembalikan tingkat stok merchandise

# Dokumentasi
### Customer
![Deskripsi Gambar](Screenshot-Customer/RECORD.gif)

### Merchandise
![Deskripsi Gambar](Screenshot-Merchandise/RECORD.gif)

### Purchase
![Deskripsi Gambar](Screenshot-Purchase/RECORD.gif)
