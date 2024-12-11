<?php
session_start(); // Memulai sesi

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header('Location: login.php'); // Redirect ke halaman login jika belum login
    exit();
}

require_once "../koneksi.php";

// Tangkap data dari form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['id_user']; // ID pengguna dari sesi
    $subjek = $_POST['subjek'];
    $pesan = $_POST['pesan'];

    // Query untuk menyimpan feedback
    $query = "INSERT INTO feedback (id_user, subjek, pesan) 
              VALUES ('$id_user', '$subjek', '$pesan')";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['feedback_success'] = true; // Set sesi untuk notifikasi sukses
        header('Location: feedback.php'); // Redirect ke halaman feedback
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
