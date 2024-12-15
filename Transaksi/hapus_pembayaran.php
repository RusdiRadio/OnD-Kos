<?php
require('../koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data pembayaran
    $delete_query = "DELETE FROM pembayaran WHERE id_pembayaran = $id";
    if (mysqli_query($koneksi, $delete_query)) {
        echo "<p>Jenis pembayaran berhasil dihapus!</p>";
        echo "<script>window.location.href = 'jenis_pembayaran.php';</script>";
    } else {
        echo "<p>Terjadi kesalahan: " . mysqli_error($koneksi) . "</p>";
    }
}
?>
