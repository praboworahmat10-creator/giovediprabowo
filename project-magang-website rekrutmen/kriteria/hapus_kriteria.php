<?php
include "../koneksi.php";

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  $query = "DELETE FROM kriteria_penilaian WHERE id = $id";
  if (mysqli_query($conn, $query)) {
    header("Location: kriteria_penilaian.php?msg=hapus_sukses");
    exit();
  } else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
  }
} else {
  echo "ID tidak ditemukan.";
}
?>
