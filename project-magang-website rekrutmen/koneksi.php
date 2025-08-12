<?php
$host = "localhost";
$user = "root";  // Ganti jika user database kamu beda
$pass = "";
$db = "kkp_db";  // Sesuaikan dengan nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
