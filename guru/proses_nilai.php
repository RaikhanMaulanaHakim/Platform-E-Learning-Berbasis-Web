<?php

include '../config/koneksi.php';
include '../config/session.php';

/** @var mysqli $koneksi */
if (!isset($koneksi)) {
    die("Koneksi database tidak ditemukan. Periksa file config/koneksi.php");
}

$id_p  = mysqli_real_escape_string($koneksi, $_POST['id_pengumpulan']);
$nilai = mysqli_real_escape_string($koneksi, $_POST['nilai']);

$query = "UPDATE pengumpulan SET nilai = '$nilai' WHERE id_pengumpulan = '$id_p'";

if (mysqli_query($koneksi, $query)) {
    echo "<script>
            alert('Nilai berhasil disimpan!'); 
            window.history.back();
          </script>";
} else {

    echo "Error Database: " . mysqli_error($koneksi);
}
