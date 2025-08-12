<?php
session_start();
include "koneksi.php";

// Query data pelamar dan kriteria
$pelamarQuery = mysqli_query($conn, "SELECT * FROM pelamar");
$kriteriaQuery = mysqli_query($conn, "SELECT * FROM kriteria_penilaian ORDER BY id ASC");

// Ambil kriteria ke array
$kriteriaList = [];
while ($kr = mysqli_fetch_assoc($kriteriaQuery)) {
  $kriteriaList[] = $kr;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Proses Profile Matching</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
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
  </style>
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
      <h4 class="text-center mb-4">Halo, <?= htmlspecialchars($_SESSION['username']) ?></h4>
      <a href="dashboard.php"><i class="bi bi-house"></i> Home</a>
      <a href="./pelamar/data_pelamar.php"><i class="bi bi-people"></i> Data Pelamar</a>
      <a href="./aspek/aspek_penilaian.php"><i class="bi bi-list-check"></i> Aspek Penilaian</a>
      <a href="./kriteria/kriteria_penilaian.php"><i class="bi bi-sliders"></i> Kriteria Penilaian</a>
      <a href="profile_matching.php"><i class="bi bi-diagram-3"></i> Proses Profile Matching</a>
      <a href="hasil_perhitungan.php"><i class="bi bi-bar-chart"></i> Hasil Perhitungan</a>
    </div>

    <!-- Content -->
    <div class="flex-grow-1">
      <div class="header d-flex justify-content-between align-items-center">
        <h5>Proses Profile Matching</h5>
        <a href="../logout.php" class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right"></i> Sign out</a>
      </div>

      <div class="container py-4">
        <form action="simpan_nilai.php" method="post">
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead class="table-dark">
                <tr>
                  <th>Nama Pelamar</th>
                  <?php foreach ($kriteriaList as $kriteria): ?>
                    <th><?= htmlspecialchars($kriteria['kriteria']) ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php while ($p = mysqli_fetch_assoc($pelamarQuery)): ?>
                  <tr>
                    <td><?= htmlspecialchars($p['nama']) ?></td>
                    <?php foreach ($kriteriaList as $kriteria): ?>
                      <td>
                        <select name="nilai[<?= $p['id'] ?>][<?= $kriteria['id'] ?>]" class="form-select">
                          <option value="1">1 - Kurang</option>
                          <option value="2">2 - Cukup</option>
                          <option value="3">3 - Baik</option>
                          <option value="4">4 - Sangat Baik</option>
                        </select>
                      </td>
                    <?php endforeach; ?>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
          <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
