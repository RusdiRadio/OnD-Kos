<?php
session_start();
require '../koneksi.php'; // Memanggil koneksi database

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query untuk cek username di daftar_user dan ambil data level_user
    $query = "SELECT daftar_user.*, level_user.keterangan 
              FROM daftar_user 
              JOIN level_user ON daftar_user.id_level = level_user.id_level 
              WHERE daftar_user.username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password (tanpa hashing)
        if ($password === $row['password']) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['keterangan']; // role diambil dari 'keterangan' di level_user

            // Redirect sesuai role
            if ($row['keterangan'] === 'Admin') {
                header("Location: dashboardadmin.php");
                exit;
            } else {
                header("Location: dashboarduser.php");
                exit;
            }
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>