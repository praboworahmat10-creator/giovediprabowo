<?php
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama_aspek = $_POST['nama_aspek'];
  $persentase = $_POST['persentase'];
  $core_factor = $_POST['core_factor'];
  $secondary_factor = $_POST['secondary_factor'];

  $query = "INSERT INTO aspek_penilaian (nama_aspek, persentase, core_factor, secondary_factor) 
            VALUES ('$nama_aspek', '$persentase', '$core_factor', '$secondary_factor')";

  if (mysqli_query($conn, $query)) {
    header("Location: aspek_penilaian.php?msg=sukses");
    exit();
  } else {
    $msg = "Gagal menyimpan data: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Aspek Penilaian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3>Tambah Aspek Penilaian</h3>

    <?php if (!empty($msg)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $msg ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Aspek</label>
        <input type="text" name="nama_aspek" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Persentase</label>
        <input type="number" name="persentase" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Core Factor</label>
        <input type="number" name="core_factor" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Secondary Factor</label>
        <input type="number" name="secondary_factor" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="aspek_penilaian.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
