<?php
session_start(); // Memulai session
require '../koneksi.php'; // Memanggil koneksi database

// Cek apakah form login sudah disubmit
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

        // Verifikasi password (pastikan Anda menggunakan hashing di password untuk keamanan)
        if ($password === $row['password']) {
            // Set session untuk login
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['keterangan']; // role diambil dari 'keterangan' di level_user
            $_SESSION['id_user'] = $row['id_user']; // Tambahkan id_user ke session

            // Redirect sesuai role
            if ($row['keterangan'] === 'Admin') {
                header("Location: dashboardadmin.php"); // Halaman Admin
                exit;
            } else {
                header("Location: dashboarduser.php"); // Halaman User
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


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kost</title>
    <link rel="stylesheet" href="login.css">
    
</head>
<body>

    <!-- Login Section -->
    <section id="login">
        <div class="login-box">
        <img src="HomeKost.jpeg" alt="Kost" class="kost-image">
            <h2>Login</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?= $error; ?></p>
            <?php endif; ?>
            <form action="" method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <input type="submit" name="login" value="Login">
            </form>
        </div>
    </section>
</head>
    <footer>
        <p>&copy; 2024 On D-Kost</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
