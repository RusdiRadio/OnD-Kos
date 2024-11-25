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
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='index3.php';</script>";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f7ff;
        }
        .navbar {
            background-color: #007bff;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }
        .menu-bar {
            display: flex;
            gap: 15px;
        }
        .menu-bar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .menu-bar a:hover {
            background-color: #0056b3;
        }
        .logout {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .logout:hover {
            background-color: #c82333;
        }
        .container {
            width: 90%;
            margin: auto;
            padding-top: 50px;
            text-align: center;
            margin-bottom: 30px;
        }
        .container h2 {
            color: #007bff;
        }
        form {
            width: 50%;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-size: 16px;
            display: block;
            margin-bottom: 5px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            font-size: 16px;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .btn-dashboard {
            background-color: #17a2b8;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-dashboard:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>OnD-Kos</h1>
    <div class="menu-bar">
            <a href="/OnDKos/Kamar/index2.php">Kelola Kamar</a>
            <a href="/OnDKos/User/index3.php">Kelola User</a>
            <a href="/OnDKos/Penghuni/index4.php">Kelola Penghuni</a>
            <a href="/OnDKos/Grafik/grafik.php">Pemasukan</a>
            <a href="/OnDKos/Riwayat/index5.php">Riwayat Penghuni</a>
    </div>
    <a href="/OnDKos/Login/logout.php" class="logout">Logout</a>
</div>

<div class="container">
    <h2>Tambah Data User</h2>

    <!-- Form untuk menambahkan user baru -->
    <form action="createUser.php" method="POST">
        <label for="user_email">Email:</label>
        <input type="email" id="user_email" name="user_email" required>

        <label for="nama_user">Nama:</label>
        <input type="text" id="nama_user" name="nama_user" required>

        <label for="alamat_user">Alamat:</label>
        <textarea id="alamat_user" name="alamat_user" required></textarea>

        <label for="no_hp">No HP:</label>
        <input type="text" id="no_hp" name="no_hp" required>

        <label for="id_level">ID Level:</label>
        <input type="number" id="id_level" name="id_level" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Tambah User">
    </form>

    <!-- Tombol Kembali ke Dashboard -->
    <a href="/OnDKos/Login/dashboardadmin.php" class="btn-dashboard">Kembali ke Dashboard</a>
</div>

</body>
</html>
