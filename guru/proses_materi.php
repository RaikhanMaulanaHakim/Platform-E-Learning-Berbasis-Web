<?php
include '../config/koneksi.php';
include '../config/session.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['simpan'])) {
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $kelas     = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $id_guru   = $_SESSION['id_user'];

    if (!isset($_FILES['file_materi']) || $_FILES['file_materi']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('Gagal upload: file tidak dipilih atau terlalu besar.'); window.location.href='materi.php';</script>";
        exit();
    }

    $nama_asli  = $_FILES['file_materi']['name'];
    $tmp        = $_FILES['file_materi']['tmp_name'];
    $ekstensi   = strtolower(pathinfo($nama_asli, PATHINFO_EXTENSION));
    $izin       = ['pdf', 'ppt', 'pptx', 'doc', 'docx'];

    if (!in_array($ekstensi, $izin)) {
        echo "<script>alert('Format file tidak didukung! Gunakan: PDF, PPT, PPTX, DOC, DOCX.'); window.location.href='materi.php';</script>";
        exit();
    }

    $folder      = '../uploads/materi/';
    if (!is_dir($folder)) mkdir($folder, 0777, true);

    $nama_file   = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $nama_asli);
    $tujuan      = $folder . $nama_file;

    if (move_uploaded_file($tmp, $tujuan)) {
        $query = "INSERT INTO materi (id_guru, judul, deskripsi, kelas, file, tgl_upload)
                  VALUES ('$id_guru', '$judul', '$deskripsi', '$kelas', '$nama_file', NOW())";

        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Materi berhasil diupload!'); window.location.href='materi.php';</script>";
        } else {

            unlink($tujuan);
            echo "<script>alert('Gagal simpan ke database: " . addslashes(mysqli_error($koneksi)) . "'); window.location.href='materi.php';</script>";
        }
    } else {
        echo "<script>alert('Gagal memindahkan file ke server.'); window.location.href='materi.php';</script>";
    }
    exit();
}

if (isset($_GET['hapus'])) {
    $id_materi = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    $id_guru   = $_SESSION['id_user'];

    $q    = mysqli_query($koneksi, "SELECT file FROM materi WHERE id_materi='$id_materi' AND id_guru='$id_guru'");
    $data = mysqli_fetch_assoc($q);

    if ($data) {

        $file_path = '../uploads/materi/' . $data['file'];
        if (file_exists($file_path)) unlink($file_path);

        mysqli_query($koneksi, "DELETE FROM materi WHERE id_materi='$id_materi' AND id_guru='$id_guru'");
        echo "<script>alert('Materi berhasil dihapus.'); window.location.href='materi.php';</script>";
    } else {
        echo "<script>alert('Data tidak ditemukan atau Anda tidak berhak menghapus ini.'); window.location.href='materi.php';</script>";
    }
    exit();
}

header("Location: materi.php");
exit();