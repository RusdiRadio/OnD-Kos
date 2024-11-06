<?php
require_once "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $user_email = $_POST['user_email'];
    $nama_user = $_POST['nama_user'];
    $alamat_user = $_POST['alamat_user'];
    $no_hp = $_POST['no_hp'];
    $id_level = $_POST['id_level'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Query untuk insert data ke database, termasuk username dan password
    $sql = "INSERT INTO daftar_user (user_email, nama_user, alamat_user, no_hp, id_level, username, password) 
            VALUES ('$user_email', '$nama_user', '$alamat_user', '$no_hp', '$id_level', '$username', '$password')";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil ditambahkan!";
        header("Location: index3.php"); // Redirect ke halaman index setelah berhasil menambah data
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data User</title>
</head>
<body>
    <h1>Tambah Data User</h1>

    <!-- Form untuk menambahkan user baru -->
    <form action="createUser.php" method="POST">
        <label for="user_email">Email:</label><br>
        <input type="email" id="user_email" name="user_email" required><br><br>

        <label for="nama_user">Nama:</label><br>
        <input type="text" id="nama_user" name="nama_user" required><br><br>

        <label for="alamat_user">Alamat:</label><br>
        <textarea id="alamat_user" name="alamat_user" required></textarea><br><br>

        <label for="no_hp">No HP:</label><br>
        <input type="text" id="no_hp" name="no_hp" required><br><br>

        <label for="id_level">ID Level:</label><br>
        <input type="number" id="id_level" name="id_level" required><br><br>

            <!-- Tambahkan input untuk username -->
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <!-- Tambahkan input untuk password -->
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>


        <input type="submit" value="Tambah User">
    </form>

    <br>
    <a href="index3.php">Kembali ke Daftar User</a>
</body>
</html>
