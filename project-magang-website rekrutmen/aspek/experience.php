<?php
session_start();
include "../koneksi.php";

// Cek login
if (!isset($_SESSION['username'])) {
  header("Location: ../index.php");
  exit();
}

// Ambil data experience + pelamar
$query = "SELECT e.*, p.nama AS nama_pelamar 
          FROM experience e
          LEFT JOIN pelamar p ON e.pelamar_id = p.id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Experience</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
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
  </style>
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
      <h4 class="text-center mb-4">Halo, <?= htmlspecialchars($_SESSION['username']) ?></h4>
      <a href="../dashboard.php"><i class="bi bi-house"></i> Home</a>
      <a href="../pelamar/data_pelamar.php"><i class="bi bi-people"></i> Data Pelamar</a>
      <a href="../aspek/aspek_penilaian.php"><i class="bi bi-list-check"></i> Aspek Penilaian</a>
      <a href="experience.php"><i class="bi bi-briefcase"></i> Experience</a>
      <a href="../kriteria/kriteria_penilaian.php"><i class="bi bi-sliders"></i> Kriteria Penilaian</a>
      <a href="../profile_matching.php"><i class="bi bi-diagram-3"></i> Proses Profile Matching</a>
      <a href="../hasil_perhitungan.php"><i class="bi bi-bar-chart"></i> Hasil Perhitungan</a>
    </div>

    <!-- Content -->
    <div class="flex-grow-1">
      <div class="header d-flex justify-content-between align-items-center">
        <h5>Experience</h5>
        <a href="../logout.php" class="btn btn-sm btn-outline-light"><i class="bi bi-box-arrow-right"></i> Sign out</a>
      </div>

      <div class="container py-4">
        <?php if (isset($_GET['msg'])): ?>
          <?php if ($_GET['msg'] === 'sukses'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Data pengalaman berhasil disimpan.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php elseif ($_GET['msg'] === 'update_sukses'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Data pengalaman berhasil diperbarui.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php elseif ($_GET['msg'] === 'hapus_sukses'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Data pengalaman berhasil dihapus.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>
        <?php endif; ?>

        <a href="tambah_experience.php" class="btn btn-primary mb-3">
          <i class="bi bi-plus-circle"></i> Tambah Experience
        </a>

        <div class="table-responsive">
          <table id="dataTable" class="table table-bordered table-striped">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Nama Pelamar</th>
                <th>Pendidikan Terakhir</th>
                <th>Posisi</th>
                <th>Lama Pengalaman (Tahun)</th>
                <th>Perusahaan Sebelumnya</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                  <td>{$no}</td>
                  <td>" . htmlspecialchars($row['nama_pelamar']) . "</td>
                  <td>" . htmlspecialchars($row['pendidikan']) . "</td>
                  <td>" . htmlspecialchars($row['posisi']) . "</td>
                  <td>" . htmlspecialchars($row['lama_pengalaman']) . "</td>
                  <td>" . htmlspecialchars($row['perusahaan_sebelumnya']) . "</td>
                  <td>
                    <a href='edit_experience.php?id={$row['id']}' class='btn btn-success btn-sm'><i class='bi bi-pencil-square'></i> Edit</a>
                    <a href='hapus_experience.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'><i class='bi bi-trash'></i> Hapus</a>
                  </td>
                </tr>";
                $no++;
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable();
    });
  </script>
</body>
</html>
