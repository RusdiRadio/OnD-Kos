<?php
session_start();
require('../koneksi.php');

// Pastikan ID User diambil dari sesi
$id_user = $_SESSION['id_user'];
$biaya_keluar = $_POST['biaya_keluar'];
$tujuan = $_POST['tujuan'];
$tanggal = $_POST['tanggal'];

// Query untuk menyimpan pengeluaran ke database
$query = "INSERT INTO pengeluaran (id_user, biaya_keluar, tujuan, tanggal) VALUES ('$id_user', '$biaya_keluar', '$tujuan', '$tanggal')";

if (mysqli_query($koneksi, $query)) {
    header("Location: index8.php"); // Redirect ke halaman pengeluaran setelah berhasil
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}
?>
