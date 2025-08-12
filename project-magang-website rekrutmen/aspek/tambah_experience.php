<?php
session_start();
include "../koneksi.php";

// Cek login
if (!isset($_SESSION['username'])) {
  header("Location: ../index.php");
  exit();
}

// Ambil data pelamar untuk dropdown
$query_pelamar = "SELECT id, nama FROM pelamar ORDER BY nama ASC";
$result_pelamar = mysqli_query($conn, $query_pelamar);

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pelamar_id = (int)$_POST['pelamar_id'];
  $pendidikan = mysqli_real_escape_string($conn, $_POST['pendidikan']);
  $posisi = mysqli_real_escape_string($conn, $_POST['posisi']);
  $lama_pengalaman = (int)$_POST['lama_pengalaman'];
  $perusahaan_sebelumnya = mysqli_real_escape_string($conn, $_POST['perusahaan_sebelumnya']);

  $insert = "INSERT INTO experience (pelamar_id, pendidikan, posisi, lama_pengalaman, perusahaan_sebelumnya) 
             VALUES ($pelamar_id, '$pendidikan', '$posisi', $lama_pengalaman, '$perusahaan_sebelumnya')";

  if (mysqli_query($conn, $insert)) {
    header("Location: experience.php?msg=sukses");
    exit();
  } else {
    $msg = "Gagal menyimpan data: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Tambah Experience</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  <div class="container mt-4">
    <h3>Tambah Experience</h3>

    <?php if ($msg): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <form action="" method="POST">
      <div class="mb-3">
        <label for="pelamar_id" class="form-label">Nama Pelamar</label>
        <select name="pelamar_id" id="pelamar_id" class="form-select" required>
          <option value="" disabled selected>-- Pilih Pelamar --</option>
          <?php while ($pelamar = mysqli_fetch_assoc($result_pelamar)) : ?>
            <option value="<?= $pelamar['id'] ?>"><?= htmlspecialchars($pelamar['nama']) ?></option>
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
        <label for="posisi" class="form-label">Posisi</label>
        <input type="text" name="posisi" id="posisi" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="lama_pengalaman" class="form-label">Lama Pengalaman (Tahun)</label>
        <input type="number" name="lama_pengalaman" id="lama_pengalaman" min="0" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="perusahaan_sebelumnya" class="form-label">Perusahaan Sebelumnya</label>
        <input type="text" name="perusahaan_sebelumnya" id="perusahaan_sebelumnya" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="experience.php" class="btn btn-secondary">Batal</a>
    </form>
  </div>
  <script src="https://cadn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
