-- Membuat Tabel Kategori
CREATE TABLE Kategori (
    id_kategori INT PRIMARY KEY AUTO_INCREMENT,
    nama_kategori VARCHAR(100)
);

-- Menambahkan data ke Tabel Kategori
INSERT INTO Kategori (nama_kategori) VALUES
('Sneakers'),
('Sepatu Formal'),
('Sepatu Olahraga'),
('Sepatu Boots'),
('Sandal');

-- Membuat Tabel Produk
CREATE TABLE Produk (
    id_produk INT PRIMARY KEY AUTO_INCREMENT,
    nama_produk VARCHAR(100),
    deskripsi TEXT,
    harga DECIMAL(10,2),
    gambar VARCHAR(255), 
    id_kategori INT,
    FOREIGN KEY (id_kategori) REFERENCES Kategori(id_kategori) ON DELETE CASCADE
);

-- Menambahkan data ke Tabel Produk
INSERT INTO Produk (nama_produk, deskripsi, harga, gambar, id_kategori) VALUES
('Nike Air Force', 'Sneakers klasik Keren', 1200.00, 'nike_air_force.jpg', 1),
('Nike Air Jordan', 'Sneakers klasik Keren', 1200.00, 'nike_air_jordan.jpg', 1),
('Adidas Stan Smith', 'Sneakers vintage', 1000.00, 'adidas_stan_smith.jpg', 1),
('Sepatu Slip-on', 'Sepatu slip-on casual', 700.00, 'sepatu_slip_on.jpg', 1),
('Sepatu Pantofel', 'Sepatu formal pria', 500.00, 'sepatu_pantofel.jpg', 2),
('Sepatu Running', 'Sepatu olahraga untuk lari', 800.00, 'sepatu_running.jpg', 3),
('Sepatu Basket', 'Sepatu olahraga untuk basket', 900.00, 'sepatu_basket.jpg', 3),
('Sepatu Boots Kulit', 'Sepatu boots kulit pria', 1200.00, 'sepatu_boots_kulit.jpg', 4),
('Sepatu Boots Hiking', 'Sepatu boots untuk hiking Unisex', 1100.00, 'sepatu_boots_hiking.jpg', 4),
('Sandal Jepit', 'Sandal jepit pria', 100.00, 'sandal_jepit.jpg', 5),
('Sandal Slop New Balance', 'Sandal slop pria yang memberikan kesan sporty', 300.00, 'sandal_NB.jpg', 5),
('Sandal Gunung', 'Sandal untuk mendaki gunung', 300.00, 'sandal_gunung.jpg', 5);

-- Membuat Tabel Users
CREATE TABLE Users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100), 
    nama_lengkap VARCHAR(100), 
    email VARCHAR(100) UNIQUE,
    password VARCHAR(100),
    role ENUM('admin', 'pemilik')
);

-- Menambahkan data ke Tabel Users 
INSERT INTO Users (username, nama_lengkap, email, password, role) VALUES
('yuda_diva', 'Yuda Diva', 'yudadiva@email.com', 'password1', 'pemilik'),
('wayan_patric', 'Wayan Patric', 'yanpatric@email.com', 'password2', 'admin'),
('made_dana', 'Made Dana', 'madedana@email.com', 'password3', 'admin');

-- Membuat Tabel Pesanan
CREATE TABLE Pesanan (
    id_pesanan INT PRIMARY KEY AUTO_INCREMENT,
    tanggal_pesanan DATETIME,
    id_user INT,
    id_produk INT,
    nama_pelanggan VARCHAR(100),
    kontak VARCHAR(20),
    status ENUM('pending', 'diproses', 'dikirim', 'selesai'),
    jumlah INT, 
    total_harga DECIMAL(10,2), 
    FOREIGN KEY (id_user) REFERENCES Users(id_user),
    FOREIGN KEY (id_produk) REFERENCES Produk(id_produk) ON DELETE CASCADE
);

-- Menambahkan data ke Tabel Pesanan
INSERT INTO Pesanan (tanggal_pesanan, id_user, id_produk, nama_pelanggan, kontak, status, jumlah, total_harga) VALUES
('2023-05-01 09:30:00', 2, 1, 'Mada Dwipa', '081234567890', 'selesai', 2, 2400.00),
('2023-05-05 14:45:00', 2, 3, 'Jana Smith', '089876543210', 'dikirim', 1, 1000.00),
('2023-05-10 11:15:00', 3, 4, 'Boby Johnson', '085678901234', 'diproses', 3, 2100.00),
('2023-05-15 18:20:00', 2, 6, 'Ketut Williams', '087890123456', 'pending', 1, 800.00),
('2023-05-20 07:00:00', 2, 2, 'Made Brown', '081234509876', 'selesai', 2, 2400.00),
('2023-05-25 10:30:00', 2, 5, 'Yan Davis', '089876543212', 'dikirim', 1, 500.00),
('2023-05-30 16:00:00', 3, 7, 'Gede Wilson', '085678902234', 'diproses', 2, 1800.00),
('2023-06-03 13:45:00', 3, 8, 'Sarah Kuntoaji', '087890123426', 'pending', 3, 3600.00),
('2023-06-07 09:15:00', 3, 9, 'Taylor Swift', '081234567899', 'selesai', 1, 1100.00),
('2023-06-10 17:30:00', 2, 10, 'Jessica Genta', '089876543220', 'dikirim', 1, 100.00),
('2023-06-15 12:00:00', 2, 11, 'Boby Laksmana', '081234567810', 'diproses', 1, 300.00),
('2023-06-25 08:45:00', 2, 2, 'Kevin Junior', '081234567820', 'dikirim', 1, 1200.00);
