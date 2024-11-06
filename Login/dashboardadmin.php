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

// Query untuk menghitung total kamar
$sql_total_kamar = "SELECT COUNT(id_kamar) AS total_kamar, 
                            SUM(CASE WHEN ketersediaan = 'tersedia' THEN 1 ELSE 0 END) AS kamar_tersedia, 
                            SUM(CASE WHEN ketersediaan = 'kosong' THEN 1 ELSE 0 END) AS kamar_kosong 
                    FROM kamar";
$result_kamar = mysqli_query($koneksi, $sql_total_kamar);
$total_kamar = 0;
$kamar_tersedia = 0;
$kamar_kosong = 0;

if ($row_kamar = mysqli_fetch_assoc($result_kamar)) {
    $total_kamar = $row_kamar['total_kamar'];
    $kamar_tersedia = $row_kamar['kamar_tersedia'];
    $kamar_kosong = $row_kamar['kamar_kosong'];
}

// Query untuk menghitung total penghuni
$sql_total_penghuni = "SELECT COUNT(id_penghuni) AS total_penghuni FROM penghuni";
$result_penghuni = mysqli_query($koneksi, $sql_total_penghuni);
$total_penghuni = 0;

if ($row_penghuni = mysqli_fetch_assoc($result_penghuni)) {
    $total_penghuni = $row_penghuni['total_penghuni'];
}

// Query untuk menghitung total pemasukan
$sql_total_pemasukan = "SELECT SUM(CAST(jumlah_bayar AS DECIMAL(10, 2))) AS total_pemasukan 
                        FROM transaksi 
                        WHERE status_pembayaran != 'Belum Bayar'";
$result_pemasukan = mysqli_query($koneksi, $sql_total_pemasukan);
$total_pemasukan = 0;

if ($row_pemasukan = mysqli_fetch_assoc($result_pemasukan)) {
    $total_pemasukan = $row_pemasukan['total_pemasukan'];
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .card-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .card {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            width: 200px;
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
        .chart-container {
            width: 100%;
            height: 200px; /* Tinggi chart */
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>OnD-Kos</h1>
        <div class="menu-bar">
            <a href="/CRUD TEST/Kamar/index2.php">Kelola Kamar</a>
            <a href="/CRUD TEST/User/index3.php">Kelola User</a>
            <a href="/CRUD TEST/Penghuni/index4.php">Kelola Penghuni</a>
            <a href="/CRUD TEST/Grafik/grafik.php">Pemasukan</a>
        </div>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
        <h2>Selamat datang, Admin <?= htmlspecialchars($nama_user); ?>!</h2>

        <!-- Card-container untuk menampilkan total kamar, penghuni, dan pemasukan -->
        <div class="card-container">
            <div class="card">
                <h3>Total Kamar</h3>
                <p><?= $total_kamar; ?> kamar</p>
                <div class="chart-container">
                    <canvas id="kamarChart"></canvas>
                </div>
            </div>
            <div class="card">
                <h3>Total Penghuni</h3>
                <p><?= $total_penghuni; ?> penghuni</p>
            </div>
            <div class="card">
                <h3>Total Pemasukan</h3>
                <p>Rp <?= number_format($total_pemasukan, 2, ',', '.'); ?></p>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('kamarChart').getContext('2d');
        const kamarChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Tersedia', 'Kosong'],
                datasets: [{
                    label: 'Ketersediaan Kamar',
                    data: [<?= $kamar_tersedia; ?>, <?= $kamar_kosong; ?>],
                    backgroundColor: ['#36a2eb', '#ff6384'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                },
            }
        });
    </script>

</body>
</html>
