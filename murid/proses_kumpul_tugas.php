<?php
require_once '../config/koneksi.php';
require_once '../config/session.php';

global $koneksi;

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'murid') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['kumpul_tugas'])) {
    $id_tugas  = mysqli_real_escape_string($koneksi, $_POST['id_tugas']);
    $id_murid  = $_SESSION['id_user'];
    $waktu_sekarang = date('Y-m-d H:i:s');

    $q_tugas = mysqli_query($koneksi, "SELECT deadline FROM tugas WHERE id_tugas = '$id_tugas'");
    $data_tugas = mysqli_fetch_assoc($q_tugas);

    if (strtotime($waktu_sekarang) > strtotime($data_tugas['deadline'])) {
        echo "<script>alert('Gagal! Batas waktu pengumpulan sudah berakhir.'); window.location.href = 'tugas.php';</script>";
        exit();
    }

    if (!isset($_FILES['file_jawaban']) || $_FILES['file_jawaban']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Gagal upload file, pastikan file sudah dipilih!'); window.location.href = 'tugas.php';</script>";
        exit();
    }

    $nama_file = $_FILES['file_jawaban']['name'];
    $tmp_file  = $_FILES['file_jawaban']['tmp_name'];
    $ekstensi  = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $ekstensi_oke = ['pdf', 'doc', 'docx', 'zip', 'rar'];

    if (in_array($ekstensi, $ekstensi_oke)) {
        $folder_tujuan = '../uploads/pengumpulan/';
        if (!is_dir($folder_tujuan)) mkdir($folder_tujuan, 0777, true);

        $nama_file_baru = 'tugas_' . $id_tugas . '_murid_' . $id_murid . '_' . time() . '.' . $ekstensi;
        
        if (move_uploaded_file($tmp_file, $folder_tujuan . $nama_file_baru)) {
            $query = "INSERT INTO pengumpulan (id_tugas, id_murid, file_tugas, waktu_kumpul, status) 
                      VALUES ('$id_tugas', '$id_murid', '$nama_file_baru', '$waktu_sekarang', 'Sudah Dikumpulkan')";

            if (mysqli_query($koneksi, $query)) {
                echo "<script>alert('Tugas berhasil dikumpulkan!'); window.location.href = 'tugas.php';</script>";
            } else {
                echo "<script>alert('Error Database'); window.location.href = 'tugas.php';</script>";
            }
        }
    }
}
?>