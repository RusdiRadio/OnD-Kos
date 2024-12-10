<?php
session_start();
include '../koneksi.php'; // Pastikan file koneksi dimasukkan dengan benar

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

// Ambil data dari form
$id_user = $_SESSION['id_user'];
$subjek = mysqli_real_escape_string($koneksi, $_POST['subjek']);
$pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);

// Masukkan data ke tabel feedback
$query = "INSERT INTO feedback (id_user, subjek, pesan) VALUES ('$id_user', '$subjek', '$pesan')";
if (mysqli_query($koneksi, $query)) {
    // Redirect ke halaman sukses
    header("Location:index3user.php");
    exit;
} else {
    echo "Gagal menyimpan feedback: " . mysqli_error($koneksi);
}

// Tutup koneksi
mysqli_close($koneksi);
?>
