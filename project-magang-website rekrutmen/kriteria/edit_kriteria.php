<?php
include "../koneksi.php";

if (!isset($_GET['id'])) {
  echo "ID tidak ditemukan.";
  exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM kriteria_penilaian WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
  echo "Data tidak ditemukan.";
  exit;
}

$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $aspek = $_POST['aspek'];
  $kriteria = $_POST['kriteria'];
  $target = intval($_POST['target']);
  $type = $_POST['type'];

  $updateQuery = "UPDATE kriteria_penilaian 
                  SET aspek='$aspek', kriteria='$kriteria', target=$target, type='$type' 
                  WHERE id=$id";

  if (mysqli_query($conn, $updateQuery)) {
    header("Location: kriteria_penilaian.php?msg=update_sukses");
    exit();
  } else {
    $msg = "Gagal memperbarui data: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Kriteria Penilaian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3>Edit Kriteria Penilaian</h3>

    <?php if (!empty($msg)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $msg ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="mb-3">
        <label class="form-label">Aspek</label>
        <input type="text" name="aspek" class="form-control" value="<?= htmlspecialchars($data['aspek']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Kriteria</label>
        <input type="text" name="kriteria" class="form-control" value="<?= htmlspecialchars($data['kriteria']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Target</label>
        <input type="number" name="target" class="form-control" min="1" max="5" value="<?= $data['target'] ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Type</label>
        <select name="type" class="form-select" required>
          <option value="core" <?= $data['type']=='core' ? 'selected' : '' ?>>Core</option>
          <option value="secondary" <?= $data['type']=='secondary' ? 'selected' : '' ?>>Secondary</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="kriteria_penilaian.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
