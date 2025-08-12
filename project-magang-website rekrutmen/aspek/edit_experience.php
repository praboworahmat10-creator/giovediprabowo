<?php
include "../koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: experience.php");
    exit();
}

$id = intval($_GET['id']);

// Ambil data pengalaman dan nama pelamar terkait
$query = "SELECT e.*, p.nama AS nama_pelamar 
          FROM experience e 
          LEFT JOIN pelamar p ON e.pelamar_id = p.id 
          WHERE e.id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    echo "Data pengalaman tidak ditemukan.";
    exit();
}

$data = mysqli_fetch_assoc($result);
$pendidikan = $data['pendidikan'];
$msg = "";

// Ambil daftar pelamar untuk dropdown
$pelamarQuery = mysqli_query($conn, "SELECT * FROM pelamar");

// Proses update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pelamar_id = intval($_POST['pelamar_id']);
    $pendidikan = mysqli_real_escape_string($conn, $_POST['pendidikan']);
    $posisi = mysqli_real_escape_string($conn, $_POST['posisi']);
    $lama_pengalaman = intval($_POST['lama_pengalaman']);
    $perusahaan_sebelumnya = mysqli_real_escape_string($conn, $_POST['perusahaan_sebelumnya']);

    $update = "UPDATE experience 
               SET pelamar_id = $pelamar_id, 
                   pendidikan = '$pendidikan',
                   posisi = '$posisi',
                   lama_pengalaman = $lama_pengalaman,
                   perusahaan_sebelumnya = '$perusahaan_sebelumnya'
               WHERE id = $id";

    if (mysqli_query($conn, $update)) {
        header("Location: experience.php?msg=update_sukses");
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
  <title>Edit Experience</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h3>Edit Data Pengalaman</h3>

    <?php if (!empty($msg)): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Pelamar</label>
        <select name="pelamar_id" class="form-select" required>
          <option value="">-- Pilih Pelamar --</option>
          <?php while ($row = mysqli_fetch_assoc($pelamarQuery)) : ?>
            <option value="<?= $row['id'] ?>" <?= ($row['id'] == $data['pelamar_id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($row['nama']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-3">
  <label class="form-label">Pendidikan Terakhir</label>
  <select name="pendidikan" class="form-select" required>
    <?php
      $pendidikan_options = ['D3', 'S1', 'S2', 'S3'];
      foreach ($pendidikan_options as $option) {
          $selected = ($option == $data['pendidikan']) ? 'selected' : '';
          echo "<option value=\"$option\" $selected>$option</option>";
      }
        ?>
      </select>
        </div>
      <div class="mb-3">
        <label class="form-label">Posisi</label>
        <input type="text" name="posisi" class="form-control" value="<?= htmlspecialchars($data['posisi']) ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Lama Pengalaman (Tahun)</label>
        <input type="number" name="lama_pengalaman" class="form-control" value="<?= htmlspecialchars($data['lama_pengalaman']) ?>" min="0" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Perusahaan Sebelumnya</label>
        <input type="text" name="perusahaan_sebelumnya" class="form-control" value="<?= htmlspecialchars($data['perusahaan_sebelumnya']) ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
      <a href="experience.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
