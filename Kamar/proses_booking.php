<?php
// Include file koneksi ke database
require('../koneksi.php');

// Periksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_kamar = $_POST['id_kamar'];
    $id_user = $_POST['id_user'];
    $nama_pemesan = $_POST['nama_pemesan'];
    $email_pemesan = $_POST['email_pemesan'];
    $nomor_telpon = $_POST['nomor_telpon'];
    $tanggal_transaksi = $_POST['tanggal_transaksi'];

    // Default values untuk kolom lainnya
    $jumlah_bayar = 0;
    $status_pembayaran = "belum bayar";
    $metode_pembayaran = "belum bayar";

    // Query untuk memasukkan data ke tabel transaksi
    $query = "INSERT INTO transaksi (id_kamar, id_user, nama_pemesan, email_pemesan, nomor_telpon, tanggal_transaksi, jumlah_bayar, status_pembayaran, metode_pembayaran) 
              VALUES ('$id_kamar', '$id_user', '$nama_pemesan', '$email_pemesan', '$nomor_telpon', '$tanggal_transaksi', '$jumlah_bayar', '$status_pembayaran', '$metode_pembayaran')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Redirect ke halaman sukses atau tampilkan pesan berhasil
        echo "<script>
            alert('Booking berhasil!');
            window.location.href = '/OnDKos/Kamar/index2user.php'; // Sesuaikan path dengan halaman yang diinginkan
        </script>";
    } else {
        // Tampilkan pesan error jika query gagal
        echo "<script>
            alert('Gagal melakukan booking: " . mysqli_error($koneksi) . "');
            window.history.back();
        </script>";
    }

    var_dump($id_user);


    // Tutup koneksi
    mysqli_close($koneksi);
} else {
    // Jika file diakses langsung, redirect ke halaman utama
    header("Location: /OnDKos/Kamar/index2user.php");
    exit();
}
?>
