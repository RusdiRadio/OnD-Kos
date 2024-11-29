<?php
require('../koneksi.php'); // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transaksi = $_POST['id_transaksi'];
    $periode = $_POST['periode'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $metode_pembayaran = $_POST['metode_pembayaran'];

    // Query untuk mengupdate transaksi
    $query = "UPDATE transaksi 
              SET periode = '$periode', 
                  jumlah_bayar = '$jumlah_bayar', 
                  metode_pembayaran = '$metode_pembayaran', 
                  status_pembayaran = 'sudah bayar' 
              WHERE id_transaksi = $id_transaksi";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Pesanan berhasil dikonfirmasi!'); window.location.href='index6.php';</script>";
    } else {
        echo "<script>alert('Gagal mengonfirmasi pesanan!'); window.location.href='index6.php';</script>";
    }
}

mysqli_close($koneksi);
?>
