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