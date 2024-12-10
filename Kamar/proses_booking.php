<?php
require('../koneksi.php');
session_start();

// Ambil ID User dari session
if (!isset($_SESSION['id_user'])) {
    die("Anda harus login untuk melakukan booking.");
}
$id_user = intval($_SESSION['id_user']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan validasi data dari form
    $id_kamar = mysqli_real_escape_string($koneksi, $_POST['id_kamar']);
    $nama_pemesan = mysqli_real_escape_string($koneksi, $_POST['nama_pemesan']);
    $email_pemesan = mysqli_real_escape_string($koneksi, $_POST['email_pemesan']);
    $nomor_telpon = mysqli_real_escape_string($koneksi, $_POST['nomor_telpon']);
    $tanggal_transaksi = mysqli_real_escape_string($koneksi, $_POST['tanggal_transaksi']);

    // Default values untuk kolom lainnya
    $jumlah_bayar = 0;
    $status_pembayaran = "belum bayar";
    $metode_pembayaran = "belum bayar";

    // Debugging: Cek data
    echo "<pre>";
    print_r(compact('id_kamar', 'id_user', 'nama_pemesan', 'email_pemesan', 'nomor_telpon', 'tanggal_transaksi'));
    echo "</pre>";

    // Query untuk memasukkan data ke tabel transaksi
    $query = "INSERT INTO transaksi (id_kamar, id_user, nama_pemesan, email_pemesan, nomor_telpon, tanggal_transaksi, jumlah_bayar, status_pembayaran, metode_pembayaran) 
              VALUES ('$id_kamar', $id_user, '$nama_pemesan', '$email_pemesan', '$nomor_telpon', '$tanggal_transaksi', $jumlah_bayar, '$status_pembayaran', '$metode_pembayaran')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
            alert('Booking berhasil!');
            window.location.href = '/OnDKos/Kamar/index2user.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal melakukan booking: " . mysqli_error($koneksi) . "');
            window.history.back();
        </script>";
    }
    mysqli_close($koneksi);
} else {
    header("Location: /OnDKos/Kamar/index2user.php");
    exit();
}
?>
