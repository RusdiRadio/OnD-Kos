<?php
$host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "ondkos";

// Koneksi ke database
$conn = new mysqli($host, $db_username, $db_password, $db_name);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nama_user = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat_user = $_POST['alamat'];
    $user_email = $_POST['email'];
    $password = $_POST['password'];


    // Query untuk memasukkan data ke tabel
    $sql = "INSERT INTO daftar_user (username, nama_user, no_hp, alamat_user, user_email, password, id_level) VALUES (?, ?, ?, ?, ?, ?, 2)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $nama_user, $no_hp, $alamat_user, $user_email, $password);

    if ($stmt->execute()) {
        echo "Pendaftaran berhasil!";
    } else {
        echo "Terjadi kesalahan, silakan coba lagi.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <style>
              /* Mengatur background biru di seluruh halaman */
       /* Mengatur background biru di seluruh halaman */

/* Efek hover untuk link */
.back-link:hover {
    color: #ff6666;
}

        /* Menambahkan hover effect untuk link */
        a {
            color: black; /* Warna link normal */
            text-decoration: none; /* Menghilangkan garis bawah */
        }
        a:hover {
            color: blue; /* Warna link saat hover */
            text-decoration: underline; /* Menambahkan garis bawah saat hover */
        }
    </style>
</head>
<body>
    <h2>Form Pendaftaran</h2>
    <form method="post" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br><br>
        <label>No HP:</label><br>
        <input type="text" name="no_hp" required><br><br>
        <label>Alamat:</label><br>
        <textarea name="alamat" required></textarea><br><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Daftar">
    </form>
    <br><br>
    <a href="/ondkos1/Login/login.php">Kembali ke Halaman Login</a>
    </a>
</body>
</html>
