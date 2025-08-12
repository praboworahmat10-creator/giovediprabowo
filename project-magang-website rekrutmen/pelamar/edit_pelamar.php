<?php
include "../koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: data_pelamar.php");
    exit();
}

$id = intval($_GET['id']);
$query = "SELECT * FROM pelamar WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    echo "Data pelamar tidak ditemukan.";
    exit();
}

$data = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $email = $_POST['email'];

    $update = "UPDATE pelamar 
               SET nama = '$nama', no_hp = '$no_hp', email = '$email' 
               WHERE id = $id";

    if (mysqli_query($conn, $update)) {
        header("Location: data_pelamar.php?msg=update_sukses");
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
  <title>Edit Pelamar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3>Edit Data Pelamar</h3>

    <?php if (!empty($msg)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $msg ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Pelamar</label>
        <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">No Handphone</label>
        <input type="text" name="no_hp" class="form-control" value="<?= $data['no_hp'] ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="data_pelamar.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
