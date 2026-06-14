CREATE DATABASE IF NOT EXISTS db_bukutamu
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE db_bukutamu;

CREATE TABLE IF NOT EXISTS buku_tamu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    instansi VARCHAR(100) NOT NULL,
    tujuan TEXT NOT NULL,
    tanggal DATE NOT NULL,
    waktu TIME NOT NULL
);

