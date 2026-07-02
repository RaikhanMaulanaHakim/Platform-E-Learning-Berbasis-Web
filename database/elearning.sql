-- Buat Database
CREATE DATABASE IF NOT EXISTS elearning;
USE elearning;

-- Tabel Users
CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('murid', 'guru') DEFAULT 'murid',
    kelas VARCHAR(10) DEFAULT '-',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Tugas
CREATE TABLE IF NOT EXISTS tugas (
    id_tugas INT AUTO_INCREMENT PRIMARY KEY,
    id_guru INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    kelas VARCHAR(10),
    deadline DATETIME,
    file_soal VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Pengumpulan
CREATE TABLE IF NOT EXISTS pengumpulan (
    id_pengumpulan INT AUTO_INCREMENT PRIMARY KEY,
    id_tugas INT NOT NULL,
    id_murid INT NOT NULL,
    file_tugas VARCHAR(255),
    nilai INT DEFAULT NULL,
    waktu_kumpul DATETIME,
    status ENUM('dikumpul', 'dinilai') DEFAULT 'dikumpul',
    FOREIGN KEY (id_tugas) REFERENCES tugas(id_tugas) ON DELETE CASCADE,
    FOREIGN KEY (id_murid) REFERENCES users(id_user) ON DELETE CASCADE
);

-- Tabel Materi
CREATE TABLE IF NOT EXISTS materi (
    id_materi INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    file VARCHAR(255) NOT NULL,
    kelas VARCHAR(10) NOT NULL,
    id_guru INT NOT NULL,
    tgl_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, nama, email, password, role, kelas) VALUES
-- Data Guru
('guru1', 'Guru Utama', 'guru@gmail.com', '$2y$10$dUkAtPEHfuk0wZUOpKMvT.mgiAL525xZksk09mACAJ2y8QTagGs0u', 'guru', '-'), -- Email: guru@gmail.com | Password: [guru123]

-- Data Murid
('dani01', 'Dani', 'kelas1@gmail.com', '$2y$10$0x6PT2uc5th7Os1kHcC5GewH33Q/F9KVff2LkuFEKrs3bQ2oZ1X32', 'murid', '1'), -- Email: kelas1@gmail.com | Password: [kelas1]
('jono02', 'Jono', 'kelas2@gmail.com', '$2y$10$sUTtwHoKG4Iw5VTflgkjT3uiuZXOYHEuRhKCcG31RbesZ3OQG5zR6', 'murid', '2'), -- Email: kelas2@gmail.com | Password: [kelas2]
('budi03', 'Budi', 'kelas3@gmail.com', '$2y$10$vpInE8R7QvuEtvmdR.JB.OO8Lqz7bEivDwei.9vjQcwB3V/V2/vHy', 'murid', '3'), -- Email: kelas3@gmail.com | Password: [kelas3]
('yanto04', 'Yanto', 'kelas4@gmail.com', '$2y$10$SYABvFaS2O2x18ZOHTJPAZepBTsJXVPlxJNAZ6X.kdkQ4jD2YF/Lq', 'murid', '4'), -- Email: kelas4@gmail.com | Password: [kelas4]
('yunus05', 'Yunus', 'kelas5@gmail.com', '$2y$10$SCEDqgAIdn2qRk/bjrK/.6epd.Y4DB19.U9OgKIgualVv.b9Z7v5O', 'murid', '5'), -- Email: kelas5@gmail.com | Password: [kelas5]
('kevin06', 'Kevin Adhiyasa', 'kelas6@gmail.com', '$2y$10$fs7f0pL0rbw1o/W6ElF4Huzz//TQVhi4uQ4NCV45Bcm1N/q5yG7mC', 'murid', '6'); -- Email: kelas6@gmail.com | Password: [kelas6]