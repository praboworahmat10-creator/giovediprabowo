<?php
include "../koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: aspek_penilaian.php");
    exit();
}

$id = intval($_GET['id']);
$query = "SELECT * FROM aspek_penilaian WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    echo "Data aspek penilaian tidak ditemukan.";
    exit();
}

$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_aspek = $_POST['nama_aspek'];
    $persentase = $_POST['persentase'];
    $core_factor = $_POST['core_factor'];
    $secondary_factor = $_POST['secondary_factor'];

    $update = "UPDATE aspek_penilaian 
               SET nama_aspek = '$nama_aspek', persentase = '$persentase', core_factor = '$core_factor', secondary_factor = '$secondary_factor'
               WHERE id = $id";

    if (mysqli_query($conn, $update)) {
        header("Location: aspek_penilaian.php?msg=update_sukses");
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
  <title>Edit Aspek Penilaian</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3>Edit Aspek Penilaian</h3>

    <?php if (!empty($msg)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $msg ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Aspek Penilaian</label>
        <input type="text" name="nama_aspek" class="form-control" value="<?= htmlspecialchars($data['nama_aspek']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Persentase</label>
        <input type="number" name="persentase" class="form-control" value="<?= htmlspecialchars($data['persentase']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Core Factor</label>
        <input type="number" name="core_factor" class="form-control" value="<?= htmlspecialchars($data['core_factor']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Secondary Factor</label>
        <input type="number" name="secondary_factor" class="form-control" value="<?= htmlspecialchars($data['secondary_factor']) ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="aspek_penilaian.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
