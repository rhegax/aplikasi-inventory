-- =====================================================
-- Aplikasi Inventory - Skema Database
-- Import file ini via phpMyAdmin:
--   1. Buka http://localhost/phpmyadmin
--   2. Menu "Import" -> pilih file ini -> Go
-- =====================================================

CREATE DATABASE IF NOT EXISTS aplikasi_inventory
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE aplikasi_inventory;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    role ENUM('admin', 'petugas') NOT NULL DEFAULT 'petugas',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS kategori (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS barang (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(50) NOT NULL UNIQUE,
    nama VARCHAR(150) NOT NULL,
    kategori_id INT UNSIGNED NULL,
    satuan VARCHAR(20) NOT NULL DEFAULT 'pcs',
    stok INT NOT NULL DEFAULT 0,
    stok_minimum INT NOT NULL DEFAULT 0,
    harga_beli DECIMAL(14, 2) NOT NULL DEFAULT 0,
    harga_jual DECIMAL(14, 2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_barang_kategori FOREIGN KEY (kategori_id) REFERENCES kategori (id) ON DELETE SET NULL,
    INDEX idx_barang_nama (nama)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS transaksi (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jenis ENUM('masuk', 'keluar') NOT NULL,
    barang_id INT UNSIGNED NOT NULL,
    jumlah INT NOT NULL,
    keterangan VARCHAR(255) NULL,
    user_id INT UNSIGNED NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_transaksi_barang FOREIGN KEY (barang_id) REFERENCES barang (id) ON DELETE CASCADE,
    CONSTRAINT fk_transaksi_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL,
    INDEX idx_transaksi_jenis (jenis),
    INDEX idx_transaksi_created (created_at)
) ENGINE=InnoDB;

-- Akun default: username "admin", password "admin123"
-- Segera ganti password ini setelah login pertama!
INSERT INTO users (username, password, nama, role)
VALUES ('admin', '$2y$12$DOUuoQRIN/Wpi54mDdFecuLrir8Z6IsteCdLTHx6PRrJ08YEMpIaS', 'Administrator', 'admin');

-- Contoh kategori awal
INSERT INTO kategori (nama) VALUES ('Elektronik'), ('Alat Tulis'), ('Makanan');
