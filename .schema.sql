-- Schema Query

-- Create Database
CREATE DATABASE IF NOT EXISTS tokokita_2551;

-- Use Database
USE tokokita_2551;

-- Create tables
CREATE TABLE tbl_admin (
    idAdmin INT(2) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    userName VARCHAR(100),
    password VARCHAR(100)
);


CREATE TABLE tbl_member (
    idKonsumen INT(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100),
    password VARCHAR(100),
    namaKonsumen VARCHAR(50),
    alamat VARCHAR(200),
    idKota INT(4),
    email VARCHAR(100),
    tlpn VARCHAR(20),
    statusAktif ENUM('Y', 'N')
);


CREATE TABLE tbl_kategori (
    idKat INT(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    namaKat VARCHAR(30)
);

CREATE TABLE tbl_toko (
    idToko INT(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idKonsumen INT(5),
    namaToko VARCHAR(100),
    logo VARCHAR(100),
    deskripsi TEXT,
    statusAktif ENUM('Y', 'N'),
    CONSTRAINT FK_Toko_Konsumen
        FOREIGN KEY (idKonsumen) REFERENCES tbl_member(idKonsumen)
);


CREATE TABLE tbl_produk (
    idProduk INT(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idKat INT(5),
    idToko INT(5),
    namaProduk VARCHAR(200),
    foto VARCHAR(100),
    harga INT(10),
    stok INT(5),
    berat INT(5),
    deskripsiProduk TEXT,
    CONSTRAINT FK_Produk_Kategori
        FOREIGN KEY (idKat) REFERENCES tbl_kategori(idKat),
    CONSTRAINT FK_Produk_Toko
        FOREIGN KEY (idToko) REFERENCES tbl_toko(idToko)
);


DROP TABLE IF EXISTS tbl_cart;
CREATE TABLE tbl_cart (
    id INT(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idProduk INT(5) NOT NULL,
    idKonsumen INT(5) NOT NULL,
    qty INT NOT NULL,
    -- price INT(10) NOT NULL,
    -- name VARCHAR(200), 
    -- image VARCHAR(100),
    CONSTRAINT FK_Cart_User
        FOREIGN KEY (idKonsumen) REFERENCES tbl_member(idKonsumen),
    CONSTRAINT FK_Cart_Produk
        FOREIGN KEY (idProduk) REFERENCES tbl_produk(idProduk)
);


CREATE TABLE tbl_order (
    idOrder INT(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idKonsumen INT(5),
    idToko INT(10) NOT NULL,
    tglOrder DATE,
    statusOrder ENUM('Belum Bayar', 'Dikemas', 'Dikirim', 'Diterima'),
    kurir VARCHAR(50) NOT NULL,
    ongkir INT(10) NOT NULL,
    CONSTRAINT FK_Order_Konsumen
        FOREIGN KEY (idKonsumen) REFERENCES tbl_member(idKonsumen),
    CONSTRAINT FK_Order_Toko
        FOREIGN KEY (idToko) REFERENCES tbl_toko(idToko)
);


CREATE TABLE tbl_detail_order (
    idKat INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idOrder INT(5),
    idProduk INT(5),
    jumlah INT(5),
    harga INT(10),
    CONSTRAINT FK_DetailOrder_Order
        FOREIGN KEY (idOrder) REFERENCES tbl_order(idOrder),
    CONSTRAINT FK_DetailOrder_Produk
        FOREIGN KEY (idProduk) REFERENCES tbl_produk(idProduk)
);


-- INSERTION DATA

-- Pass: default
INSERT INTO tbl_member 
    (idKonsumen, username, password, namaKonsumen, alamat, idKota, email, tlpn, statusAktif) 
VALUES
 (1, "fiki", "$2y$10$y/AdP5MYKr1.CQr4u4cUC.1K.uNqDMWuXUfrQxT2HtNPfPZn0jJDe", "Fiki Pratama", "Kab. Sleman, DI Yogyakarta, Indonesia (55513)", 419, "fikipratama@students.amikom.ac.id", 22122551, "Y"),
 (2, "member2", "$2y$10$0I5HC8i9R47.3w8taCYTie3uWLUjOTg7gdloHe9rVVrYKjq/7oFdK", "Member 2", "Bandung, Jawa Barat, Indonesia (40311)", 22, "member2@gmail.com", 22122551, "Y"),
 (3, "member3", "$2y$10$KlZXUemH/0mmWBxZgMc85.GI1nbGQEriFIn6wFl43BMH6Ky5F35Ke", "Member 3", "Kab. Pekalongan, Jawa Tengah, Indonesia (51161)", 348, "member3@gmail.com", 22122551, "Y"),
 (4, "member4", "$2y$10$WcUUacoLa4WcimAWt5mSvuZLYQlPYjmJaNn40xlvPeds3J9WmxcDS", "Member 4", "Kab. Way Kanan, Lampung, Indonesia (34711)", 496, "member4@gmail.com", 22122551, "Y"),
 (5, "member5", "$2y$10$xqRKIMwmC5nTWHwPWFr4vOLPqtuWs/HVH58jYA7GlGkTGKjeDBEWq", "Member 5", "Jakarta Timur, DKI Jakarta, Indonesia (13330)", 154, "member5@gmail.com", 22122551, "Y"),
 (6, "member6", "$2y$10$q/4a5dYhxPaeo0vQ/mRz.OZt7SbgsNp.gqLypdVTWnc7i.OSHfsee", "Member 6", "Kab. Tangerang, Banten, Indonesia (15914)", 455, "member6@gmail.com", 22122551, "Y");


INSERT INTO tbl_toko
    (idToko, idKonsumen, namaToko, logo, deskripsi, statusAktif)
VALUES
    (1, 5, "Philips Home Appliances", "igoods.png", "Philips, inovasi dan teknologi yang membantu Anda hidup lebih sehat, bahagia dan bermakna. Jam Operational: Senin - Jumat (9-17)", "Y"),
    (2, 6, "Digimap Official Shop", "digimap.jpg", "One of the fastest growing Apple Authorized Resellers in Indonesia", "Y");



INSERT ito