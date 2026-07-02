<?php
include '../config/koneksi.php';
include '../config/session.php';

/** @var mysqli $koneksi */

if (isset($_POST['simpan_tugas'])) {
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $deadline  = mysqli_real_escape_string($koneksi, $_POST['deadline']);
    $kelas     = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $id_guru   = $_SESSION['id_user'];

    $query = "INSERT INTO tugas (judul, deskripsi, deadline, kelas, id_guru) 
              VALUES ('$judul', '$deskripsi', '$deadline', '$kelas', '$id_guru')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                alert('Berhasil! Tugas baru telah diterbitkan.');
                window.location.href = 'tugas.php'; 
              </script>";
    } else {
        $error_sistem = mysqli_error($koneksi);
        echo "<script>
                alert('Gagal menyimpan tugas! Sistem Eror: " . addslashes($error_sistem) . "'); 
                window.location.href = 'tugas.php';
              </script>";
    }
}

if (isset($_GET['hapus'])) {
    $id_tugas = mysqli_real_escape_string($koneksi, $_GET['hapus']);

    $query_hapus = mysqli_query($koneksi, "DELETE FROM tugas WHERE id_tugas = '$id_tugas'");

    if ($query_hapus) {
        echo "<script>
                alert('Tugas berhasil dihapus!');
                window.location.href = 'tugas.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menghapus tugas.'); window.location.href = 'tugas.php';</script>";
    }
}
