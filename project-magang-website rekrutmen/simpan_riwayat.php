<?php
session_start();
include "koneksi.php";

$batch_id = date('YmdHis'); // contoh batch ID: 20250614050612

$query = "SELECT p.nama, 
            AVG(CASE WHEN k.aspek = 'Kecerdasan' THEN n.nilai ELSE NULL END) AS aspek_kecerdasan,
            AVG(CASE WHEN k.aspek = 'Pengalaman' THEN n.nilai ELSE NULL END) AS aspek_pengalaman,
            AVG(CASE WHEN k.aspek = 'Wawancara' THEN n.nilai ELSE NULL END) AS aspek_wawancara
          FROM pelamar p
          LEFT JOIN nilai n ON p.id = n.id_pelamar
          LEFT JOIN kriteria_penilaian k ON n.id_kriteria = k.id
          GROUP BY p.id";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
  $total = round(($row['aspek_kecerdasan'] * 0.5) + ($row['aspek_pengalaman'] * 0.4) + ($row['aspek_wawancara'] * 0.1), 2);
  mysqli_query($conn, "INSERT INTO riwayat_perhitungan 
    (batch_id, nama_pelamar, aspek_kecerdasan, aspek_pengalaman, aspek_wawancara, total) 
    VALUES 
    ('$batch_id',
     '".mysqli_real_escape_string($conn, $row['nama'])."', 
     '".round($row['aspek_kecerdasan'],2)."', 
     '".round($row['aspek_pengalaman'],2)."', 
     '".round($row['aspek_wawancara'],1)."', 
     '$total')");
}

header("Location: hasil_perhitungan.php?msg=sukses");
exit;
?>
