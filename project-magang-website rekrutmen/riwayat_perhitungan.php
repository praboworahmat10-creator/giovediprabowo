<?php
session_start();
include "koneksi.php";

// Cek login (jika login digunakan)
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Hapus batch jika diminta
if (isset($_GET['hapus_batch']) && is_numeric($_GET['hapus_batch'])) {
    $hapus_batch_id = $_GET['hapus_batch'];
    $stmt = $conn->prepare("DELETE FROM riwayat_perhitungan WHERE batch_id = ?");
    $stmt->bind_param("i", $hapus_batch_id);
    $stmt->execute();
    $stmt->close();
    header("Location: riwayat_perhitungan.php");
    exit;
}

// Ambil semua batch
$batch_result = $conn->query("
    SELECT DISTINCT batch_id, MAX(tanggal) AS tanggal 
    FROM riwayat_perhitungan 
    GROUP BY batch_id 
    ORDER BY tanggal DESC
");

// Ambil data berdasarkan batch_id jika dipilih
$batch_id = $_GET['batch_id'] ?? '';
$data_result = null;

if ($batch_id && is_numeric($batch_id)) {
    $stmt = $conn->prepare("SELECT * FROM riwayat_perhitungan WHERE batch_id = ?");
    $stmt->bind_param("i", $batch_id);
    $stmt->execute();
    $data_result = $stmt->get_result();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Perhitungan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h2>Riwayat Perhitungan</h2>

  <a href="hasil_perhitungan.php" class="btn btn-secondary mb-3">&larr; Kembali</a>

  <h5>Pilih Riwayat</h5>
  <ul class="list-group mb-4">
    <?php while ($batch = $batch_result->fetch_assoc()): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <a href="?batch_id=<?= htmlspecialchars($batch['batch_id']) ?>">
            Batch <?= htmlspecialchars($batch['batch_id']) ?> (<?= htmlspecialchars($batch['tanggal']) ?>)
          </a>
        </div>
        <div>
          <a href="?hapus_batch=<?= htmlspecialchars($batch['batch_id']) ?>"
             class="btn btn-danger btn-sm"
             onclick="return confirm('Yakin ingin menghapus batch ini?');">
            Hapus
          </a>
        </div>
      </li>
    <?php endwhile; ?>
  </ul>

  <?php if ($data_result && $data_result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>Tanggal</th>
            <th>Nama Pelamar</th>
            <th>Kecerdasan</th>
            <th>Pengalaman</th>
            <th>Wawancara</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $data_result->fetch_assoc()):
            // Tangani array key yang mungkin tidak ada
            $kecerdasan = round($row['aspek_kecerdasan'] ?? 0, 2);
            $pengalaman = round($row['aspek_pengalaman'] ?? 0, 2);
            $wawancara = round($row['aspek_wawancara'] ?? 0, 1);
            $total = round(($kecerdasan * 0.5) + ($pengalaman * 0.4) + ($wawancara * 0.1), 2);
          ?>
          <tr>
            <td><?= htmlspecialchars($row['tanggal']) ?></td>
            <td><?= htmlspecialchars($row['nama_pelamar']) ?></td>
            <td><?= $kecerdasan ?></td>
            <td><?= $pengalaman ?></td>
            <td><?= $wawancara ?></td>
            <td><strong><?= $total ?></strong></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php elseif ($batch_id): ?>
    <div class="alert alert-warning">Data untuk batch ID <?= htmlspecialchars($batch_id) ?> tidak ditemukan.</div>
  <?php endif; ?>

</body>
</html>
