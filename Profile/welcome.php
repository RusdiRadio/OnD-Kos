<?php
// Menginisialisasi session
session_start();

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect ke halaman login jika belum login
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
