<?php
session_start();
include "koneksi.php";

// Cek login
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}

// Perhitungan dengan IFNULL agar NULL tidak menyebabkan skor kecil
$query = "SELECT 
            p.nama, 
            IFNULL(AVG(CASE WHEN k.aspek = 'Kecerdasan' THEN n.nilai END), 0) AS aspek_kecerdasan,
            IFNULL(AVG(CASE WHEN k.aspek = 'Pengalaman' THEN n.nilai END), 0) AS aspek_pengalaman,
            IFNULL(AVG(CASE WHEN k.aspek = 'Wawancara' THEN n.nilai END), 0) AS aspek_wawancara
          FROM pelamar p
          LEFT JOIN nilai n ON p.id = n.id_pelamar
          LEFT JOIN kriteria_penilaian k ON n.id_kriteria = k.id
          GROUP BY p.id";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Perhitungan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .sidebar {
      height: 100vh;
      background-color: #b71217;
      color: white;
      padding-top: 1rem;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 10px 20px;
    }
    .sidebar a:hover {
      background-color: #800000;
    }
    .header {
      background-color: #800000;
      color: white;
      padding: 10px 20px;
    }
    @media print {
      .sidebar, .header, .btn, form {
        display: none !important;
      }
      body {
        background: white !important;
      }
    }
  </style>
</head>
<body>
<div class="d-flex">
  <div class="sidebar">
    <h4 class="text-center mb-4">Halo, <?= htmlspecialchars($_SESSION['username']) ?></h4>
    <a href="dashboard.php"><i class="bi bi-house"></i> Home</a>
    <a href="./pelamar/data_pelamar.php"><i class="bi bi-people"></i> Data Pelamar</a>
    <a href="./aspek/aspek_penilaian.php"><i class="bi bi-list-check"></i> Aspek Penilaian</a>
    <a href="./kriteria/kriteria_penilaian.php"><i class="bi bi-sliders"></i> Kriteria Penilaian</a>
    <a href="profile_matching.php"><i class="bi bi-diagram-3"></i> Proses Profile Matching</a>
    <a href="hasil_perhitungan.php"><i class="bi bi-bar-chart"></i> Hasil Perhitungan</a>
  </div>

  <div class="flex-grow-1">
    <div class="header d-flex justify-content-between align-items-center">
      <h5>Hasil Akhir</h5>
      <a href="logout.php" class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right"></i> Sign out</a>
    </div>

    <div class="container py-4">
      <?php if (isset($_GET['msg']) && $_GET['msg'] === 'sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Nilai berhasil disimpan dan dihitung.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
              <th>Nama Pelamar</th>
              <th>Kecerdasan</th>
              <th>Pengalaman</th>
              <th>Wawancara</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): 
              $kecerdasan = round($row['aspek_kecerdasan'], 2);
              $pengalaman = round($row['aspek_pengalaman'], 2);
              $wawancara = round($row['aspek_wawancara'], 1);
              $total = round(($kecerdasan * 0.5) + ($pengalaman * 0.4) + ($wawancara * 0.1), 2);
            ?>
            <tr>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= $kecerdasan ?></td>
              <td><?= $pengalaman ?></td>
              <td><?= $wawancara ?></td>
              <td><strong><?= $total ?></strong></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>

      <div class="d-flex gap-2 mt-3">
        <button onclick="window.print()" class="btn btn-secondary"><i class="bi bi-printer"></i> Cetak</button>
        <form method="post" action="simpan_riwayat.php" onsubmit="return confirm('Yakin ingin menyimpan riwayat?');">
          <button type="submit" class="btn btn-success"><i class="bi bi-clock-history"></i> Simpan Riwayat</button>
        </form>
        <a href="riwayat_perhitungan.php" class="btn btn-info text-white"><i class="bi bi-archive"></i> Lihat Riwayat</a>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
