<?php
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $aspek = $_POST['aspek'];
  $kriteria = $_POST['kriteria'];
  $target = intval($_POST['target']);
  $type = $_POST['type'];

  $query = "INSERT INTO kriteria_penilaian (aspek, kriteria, target, type)
            VALUES ('$aspek', '$kriteria', '$target', '$type')";

  if (mysqli_query($conn, $query)) {
    header("Location: kriteria_penilaian.php?msg=sukses");
    exit();
  } else {
    $msg = "Gagal menyimpan data: " . mysqli_error($conn);
  }
}

// Ambil data aspek
$aspekQuery = "SELECT id, nama_aspek FROM aspek_penilaian";
$aspekResult = mysqli_query($conn, $aspekQuery);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Kriteria Penilaian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3>Tambah Kriteria Penilaian</h3>

    <?php if (!empty($msg)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $msg ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="mb-3">
        <label class="form-label">Aspek</label>
        <select name="aspek" class="form-select" required>
          <option value="">-- Pilih Aspek --</option>
          <?php while ($row = mysqli_fetch_assoc($aspekResult)) : ?>
            <option value="<?= htmlspecialchars($row['nama_aspek']) ?>">
              <?= htmlspecialchars($row['nama_aspek']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Kriteria</label>
        <input type="text" name="kriteria" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Target</label>
        <input type="number" name="target" class="form-control" min="1" max="5" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Type</label>
        <select name="type" class="form-select" required>
          <option value="">-- Pilih Type --</option>
          <option value="core">Core</option>
          <option value="secondary">Secondary</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
      <a href="kriteria_penilaian.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
