<?php
session_start();

// Cek apakah pengguna sudah login dan role-nya admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'User') {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke database
require_once "../koneksi.php";

// Ambil username dari sesi
$username = $_SESSION['username'];

// Query untuk mendapatkan nama_user berdasarkan username
$sql = "SELECT nama_user FROM daftar_user WHERE username = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $nama_user = $row['nama_user'];
} else {
    $nama_user = $username;
}

// Tutup statement untuk username
mysqli_stmt_close($stmt);

// Query untuk menghitung total kamar
$sql_total_kamar = "SELECT COUNT(id_kamar) AS total_kamar FROM kamar";
$result_kamar = mysqli_query($koneksi, $sql_total_kamar);
$total_kamar = 0;

if ($row_kamar = mysqli_fetch_assoc($result_kamar)) {
    $total_kamar = $row_kamar['total_kamar'];
}

$sql_total_penghuni = "SELECT COUNT(id_penghuni) AS total_penghuni FROM penghuni";
$result_penghuni = mysqli_query($koneksi, $sql_total_penghuni);
$total_penghuni = 0;

if ($row_penghuni = mysqli_fetch_assoc($result_penghuni)) {
    $total_penghuni = $row_penghuni['total_penghuni'];
}


// Tutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #333;
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
            background-color: #555;
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
        }
        .container h2 {
            color: #333;
        }
        .card {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin-top: 20px;
            border-radius: 10px;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        .card h3 {
            margin: 0;
            color: #333;
            font-size: 20px;
        }
        .card p {
            color: #777;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>OnD-Kos</h1>
        <div class="menu-bar">
            <a href="/CRUD TEST/Kamar/index2user.php">Cek Kamar</a>
            <a href="/CRUD TEST/Penghuni/index4user.php">Cek Penghuni</a>
        </div>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
        <h2>Selamat datang, <?= htmlspecialchars($nama_user); ?>!</h2>

        <!-- Card untuk menampilkan total kamar -->
        <div class="card">
            <h3>Total Kamar</h3>
            <p><?= $total_kamar; ?> kamar</p>
        </div>
        <div class="card">
            <h3>Total Penghuni</h3>
            <p><?= $total_penghuni; ?> penghuni</p>
        </div>
    </div>

</body>
</html>
