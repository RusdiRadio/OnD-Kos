<?php
session_start();

// Cek apakah pengguna sudah login dan role-nya admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
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
            background-color: #e6f7ff; /* Biru muda */
        }
        .navbar {
            background-color: #007bff; /* Biru */
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
            background-color: #0056b3; /* Biru lebih gelap */
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
            background-color: #c82333; /* Merah lebih gelap */
        }
        .container {
            width: 90%;
            margin: auto;
            padding-top: 50px;
            text-align: center;
        }
        .container h2 {
            color: #007bff; /* Biru */
        }
        .chart-container {
            width: 100%;
            height: 500px; /* Sesuaikan tinggi iframe */
            display: flex;
            justify-content: center;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
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
            <a href="/OnDKos/Transaksi/index6.php">Transaksi</a>
        </div>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
        <h2>Selamat datang, Admin <?= htmlspecialchars($nama_user); ?>!</h2>

        <!-- Menampilkan Power BI Dashboard -->
        <div class="chart-container">
            <iframe title="tugas akhir" src="https://app.powerbi.com/reportEmbed?reportId=f452416b-2885-4eb5-a354-26fa429ec3cd&autoAuth=true&ctid=5263cc81-5912-42c4-abc1-d0f1b668b530" allowFullScreen="true"></iframe>
        </div>
    </div>

</body>
</html>
