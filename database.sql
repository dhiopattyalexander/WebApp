CREATE DATABASE IF NOT EXISTS db_tugas1
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_tugas1;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS studies;
DROP TABLE IF EXISTS level;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(30) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE level (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE studies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    idlevel INT NOT NULL,
    keterangan TEXT,
    tahun_lulus YEAR NOT NULL,
    CONSTRAINT fk_studies_level
        FOREIGN KEY (idlevel) REFERENCES level(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (username, password, role) VALUES
('admin', 'admin123', 'admin'),
('dhio', 'dhio123', 'programmer');

INSERT INTO level (nama) VALUES
('TK'),
('SD'),
('SMP'),
('SMA'),
('Kuliah');

INSERT INTO studies (nama, idlevel, keterangan, tahun_lulus) VALUES
('BIMBA AIUEO', 1, 'Pendidikan usia dini dengan dasar disiplin dan kebiasaan belajar.', 2010),
('SD Negeri Sukamaju 7', 2, 'Membangun fondasi akademik dan karakter.', 2016),
('SMP IC Bakti Jaya', 3, 'Mulai aktif mengenal teknologi dan logika dasar pemrograman.', 2019),
('SMK Prestasi Prima', 4, 'Fokus pada eksplorasi IT, komputer, dan project mandiri.', 2022),
('STT Nurul Fikri', 5, 'Fokus pada Teknik Informatika, network, server, dan pengembangan web.', 2026);
