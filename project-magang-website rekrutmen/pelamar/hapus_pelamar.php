<?php
include "../koneksi.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Hindari SQL injection

    $query = "DELETE FROM pelamar WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: data_pelamar.php?msg=hapus_sukses");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
