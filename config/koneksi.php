<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "db_elearning";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (mysqli_connect_errno()) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
