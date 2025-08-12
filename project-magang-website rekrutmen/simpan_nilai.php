<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['nilai'] as $id_pelamar => $kriteria) {
        foreach ($kriteria as $id_kriteria => $nilai) {
            $cek = mysqli_query($conn, "SELECT * FROM nilai WHERE id_pelamar='$id_pelamar' AND id_kriteria='$id_kriteria'");
            if (mysqli_num_rows($cek) > 0) {
                mysqli_query($conn, "UPDATE nilai SET nilai='$nilai' WHERE id_pelamar='$id_pelamar' AND id_kriteria='$id_kriteria'");
            } else {
                mysqli_query($conn, "INSERT INTO nilai (id_pelamar, id_kriteria, nilai) VALUES ('$id_pelamar', '$id_kriteria', '$nilai')");
            }
        }
    }

    // Redirect ke hasil perhitungan
    header("Location: hasil_perhitungan.php?msg=sukses");
    exit();
} else {
    header("Location: profile_matching.php");
    exit();
}
?>
