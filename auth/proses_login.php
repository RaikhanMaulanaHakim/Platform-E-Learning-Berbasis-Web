<?php
include '../config/koneksi.php';
include '../config/session.php';

/** @var mysqli $koneksi */

if (isset($_POST['login'])) {
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    $query  = "SELECT * FROM users WHERE email = '$email'";
    $hasil  = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($hasil) === 1) {
        $user = mysqli_fetch_assoc($hasil);

        if (password_verify($password, $user['password'])) {

            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['role']    = $user['role'];
            $_SESSION['kelas']   = $user['kelas'];

            if ($user['role'] == 'guru') {
                echo "<script>
                        alert('Login Berhasil! Selamat datang Guru.');
                        window.location.href = '../guru/dashboard.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Login Berhasil! Selamat datang Murid.');
                        window.location.href = '../murid/dashboard.php';
                      </script>";
            }
            exit();
        } else {

            echo "<script>
                    alert('Password salah! Silakan coba lagi.');
                    window.location.href = 'login.php';
                  </script>";
        }
    } else {

        echo "<script>
                alert('Email tidak terdaftar!');
                window.location.href = 'login.php';
              </script>";
    }
} else {
    header("Location: login.php");
    exit();
}
