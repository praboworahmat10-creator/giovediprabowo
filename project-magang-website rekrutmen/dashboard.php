<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
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
    .btn-primary {
      background-color: #007bff;
      border: none;
    }
    .btn-danger {
      background-color: #dc3545;
      border: none;
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
        <h5>Dashboard</h5>
        <a href="logout.php" class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right"></i> Sign out</a>
      </div>

      <div class="container py-4">
        <h2>Selamat Datang di Website SPK Perekrutan Karyawan Baru PT. Meissa Berkah Teknologi dengan Metode Profile Matching</h2>
        <p>Anda login sebagai <strong>HRD</strong>.</p>
        <p><strong>Profile matching</strong> merupakan suatu proses yang sangat penting dalam manajemen SDM dimana terlebih dahulu ditentukan kompetensi (kemampuan)
           yang diperlukan suatu jabatan. Kompetensi atau kemampuan tersebut haruslah dapat dipenuhi oleh pemegang atau calon pemegang jabatan. 
           Dalam proses profile matching secara garis besar merupakan proses membandingkan antara kompetensi individu kedalam kompetensi 
           jabatan sehingga dapat diketahui perbedaan kompetensinya (<strong>disebut juga Gap</strong>) semakin kecil gap yang dihasilkan maka bobot 
           nilainya semakin besar yang berarti memiliki peluang lebih besar untuk pegawai yang menempati posisi tersebut.</p>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
