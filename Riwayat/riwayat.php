<?php
require '../koneksi.php'; // File koneksi Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['keluarkan_penghuni'])) {
    // Ambil data dari form
    $id_penghuni = $_POST['id_penghuni'];
    $id_kamar = $_POST['id_kamar'];
    $nama = $_POST['nama'];
    $pekerjaan = $_POST['pekerjaan'];
    $tanggal_masuk = date('Y-m-d'); // Sesuaikan jika ada logik tanggal masuk sebelumnya
    $tanggal_keluar = date('Y-m-d'); // Set tanggal keluar saat ini
    $status_keluar = "Keluar"; // Status keluar default, bisa disesuaikan

    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    try {
        // Tambahkan data ke tabel riwayat_penghuni
        $query_riwayat = "INSERT INTO riwayat_penghuni (id_penghuni, id_kamar, nama, pekerjaan, tanggal_masuk, tanggal_keluar, status_keluar) 
                          VALUES ('$id_penghuni', '$id_kamar', '$nama', '$pekerjaan', '$tanggal_masuk', '$tanggal_keluar', '$status_keluar')";
        if (!mysqli_query($koneksi, $query_riwayat)) {
            throw new Exception("Gagal menambahkan data ke riwayat_penghuni: " . mysqli_error($koneksi));
        }

        // Update status penghuni di tabel penghuni
        $query_update = "UPDATE penghuni SET id_kamar = NULL WHERE id_penghuni = '$id_penghuni'";
        if (!mysqli_query($koneksi, $query_update)) {
            throw new Exception("Gagal memperbarui data penghuni: " . mysqli_error($koneksi));
        }

        // Commit transaksi
        mysqli_commit($koneksi);
        echo "Penghuni berhasil dikeluarkan dan data disimpan di riwayat.";
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        mysqli_rollback($koneksi);
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>
