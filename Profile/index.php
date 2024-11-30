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

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kost</title>
    <link rel="stylesheet" href="http://localhost/OND-KOS/styles.css">


</head>
<body>
    <header>
        <h1>On D-Kost</h1>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#profile">Profil</a></li>
                <li><a href="#daftar-kamar">Daftar Kost</a></li>
                <li><a href="#tentang-kami">Tentang Kami</a></li>
                <li><a href="#fasilitas">Fasilitas</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
        </nav>
    </header>

    <section id="home" class="show">
        <h2>Selamat Datang di Aura Kost</h2>
        <p>Kami menyediakan berbagai pilihan kost yang nyaman dan terjangkau.</p>
        <img src="HomeKost.jpeg" alt="Kost" class="kost-image">
    </section>
    
    <section id="profile">
        <h2>Profil</h2>
        <!-- Konten profil disini -->
    </section>
    
    <section id="daftar-kamar">
        <h2>Daftar Kamar</h2>
        <!-- Konten daftar kamar disini -->
    </section>

    <section id="tentang-kami">
        <h2>Tentang Kami</h2>
        <!-- Konten tentang kami disini -->
    </section>

    <section id="kontak">
        <h2>Kontak Kami</h2>
        <!-- Konten kontak disini -->
    </section>

    <!-- Login Section -->
    <section id="login">
        <div class="login-box">
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

    <footer>
        <p>&copy; 2024 On D-Kost</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
