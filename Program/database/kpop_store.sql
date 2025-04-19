CREATE DATABASE kpop_store;
USE kpop_store;

-- tabel customer / pembeli
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(15)
);

-- tabel merchandise / barang
CREATE TABLE merchandise (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(50), -- contoh: album, lightstick, photocard, dll
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0
);

-- tabel transaksi pembelian
CREATE TABLE purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    merchandise_id INT NOT NULL,
    purchase_date DATE NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (merchandise_id) REFERENCES merchandise(id)
);

-- isi data untuk customers
INSERT INTO customers (name, email, phone) VALUES
('Coco', 'coco123@gmail.com', '081234567890'),
('Ruby', 'ruby@gmail.com', '082345678901'),
('Nene', 'nene05@gmail.com', '083456789012');

-- insert merchandise dari grup EXO, Red Velvet, TWICE, SEVENTEEN, BLACKPINK
INSERT INTO merchandise (name, category, price, stock) VALUES
-- EXO
('EXO Album - Obsession', 'Album', 250000.00, 10),
('EXO Lightstick Ver.3', 'Lightstick', 400000.00, 5),
-- Red Velvet
('Red Velvet Album - Feel My Rhythm', 'Album', 230000.00, 8),
('Red Velvet Lightstick', 'Lightstick', 350000.00, 6),
('Red Velvet Photocard Set', 'Photocard', 70000.00, 10),
-- TWICE
('TWICE Album - Formula of Love', 'Album', 240000.00, 9),
('TWICE Lightstick Candybong Z', 'Lightstick', 360000.00, 7),
('TWICE Photocard - Nayeon', 'Photocard', 85000.00, 12),
-- SEVENTEEN
('SEVENTEEN Album - Face the Sun', 'Album', 260000.00, 11),
('SEVENTEEN Lightstick Ver.3', 'Lightstick', 370000.00, 6),
('SEVENTEEN Photocard - Mingyu', 'Photocard', 80000.00, 14),
-- BLACKPINK
('BLACKPINK Album - Born Pink', 'Album', 270000.00, 10),
('BLACKPINK Lightstick Ver.2', 'Lightstick', 380000.00, 5),
('BLACKPINK Photocard - Lisa', 'Photocard', 90000.00, 13);

-- isi data untuk purchases
INSERT INTO purchases (customer_id, merchandise_id, purchase_date, quantity) VALUES
(1, 13, '2025-04-10', 1),
(2, 4, '2025-04-11', 1),
(3, 9, '2025-04-12', 3),  
(1, 5, '2025-04-15', 1),
(2, 5, '2025-04-18', 2);