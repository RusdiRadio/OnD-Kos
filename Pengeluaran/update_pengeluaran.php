<?php
require('../koneksi.php');

// Mendapatkan data dari form
$id_pengeluaran = $_POST['id_pengeluaran'];
$biaya_keluar = $_POST['biaya_keluar'];
$tujuan = $_POST['tujuan'];
$tanggal = $_POST['tanggal'];

// Query untuk memperbarui data pengeluaran
$query = "UPDATE pengeluaran SET biaya_keluar = '$biaya_keluar', tujuan = '$tujuan', tanggal = '$tanggal' WHERE id_pengeluaran = '$id_pengeluaran'";

// Menjalankan query
if (mysqli_query($koneksi, $query)) {
    // Redirect ke halaman pengeluaran setelah berhasil update
    header("Location: index8.php");
    exit();
} else {
    // Jika ada error
    echo "Error: " . mysqli_error($koneksi);
}
?>
