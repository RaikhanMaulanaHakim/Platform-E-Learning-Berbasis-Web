<?php
include '../config/koneksi.php';
include '../config/session.php';

/** @var mysqli $koneksi */

if (isset($_POST['register'])) {
    // Validasi kolom utama (Nama, Email, Password wajib diisi)
    if (empty($_POST['nama']) || empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('Nama, Email, dan Password wajib diisi!'); window.location.href = 'register.php';</script>";
        exit();
    }

    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];
    
    $role     = isset($_POST['role']) ? mysqli_real_escape_string($koneksi, $_POST['role']) : 'murid';
    
    $kelas    = !empty($_POST['kelas']) ? mysqli_real_escape_string($koneksi, $_POST['kelas']) : '-';

    $cek_email  = "SELECT email FROM users WHERE email = '$email'";
    $hasil_cek  = mysqli_query($koneksi, $cek_email);

    if (mysqli_num_rows($hasil_cek) > 0) {
        echo "<script>alert('Email sudah terdaftar! Silakan gunakan email lain.'); window.location.href = 'register.php';</script>";
    } else {

        $password_enkripsi = password_hash($password, PASSWORD_BCRYPT);

        $query_input = "INSERT INTO users (nama, email, password, role, kelas, username) 
                        VALUES ('$nama', '$email', '$password_enkripsi', '$role', '$kelas', '$email')";
        
        if (mysqli_query($koneksi, $query_input)) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Gagal Registrasi: " . mysqli_error($koneksi) . "'); window.location.href = 'register.php';</script>";
        }
    }
} else {
    header("Location: register.php");
    exit();
}