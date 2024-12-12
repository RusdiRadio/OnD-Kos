<?php
session_start();

// Cek apakah pengguna sudah login dan role-nya User
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

// Tutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
      :root {
    /* Elegant Color Palette */
    --primary-color: #1a5f7a;     /* Deep teal-blue */
    --secondary-color: #e6f1f7;   /* Soft, pale blue */
    --accent-color: #6b8e9f;      /* Muted slate blue */
    --text-dark: #2c3e50;         /* Deep charcoal */
    --text-light: #f4f9ff;        /* Soft off-white */
    --card-shadow: rgba(0, 0, 0, 0.12);
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    transition: all 0.3s ease-in-out;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: var(--secondary-color);
    line-height: 1.6;
    color: var(--text-dark);
}

.sidebar {
    width: 280px;
    height: 100vh;
    background: linear-gradient(135deg, var(--primary-color), #133b5c);
    color: var(--text-light);
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    padding: 30px 20px;
    box-shadow: 8px 0 20px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.sidebar h1 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 40px;
    text-align: center;
    letter-spacing: 1.5px;
    background: linear-gradient(to right, var(--text-light), #e0e0e0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.menu-bar a {
    display: block;
    color: var(--text-light);
    text-decoration: none;
    padding: 12px 15px;
    margin: 8px 0;
    border-radius: 8px;
    font-weight: 500;
    position: relative;
    overflow: hidden;
}

.menu-bar a::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: 0.5s;
}

.menu-bar a:hover::before {
    left: 100%;
}

.menu-bar a:hover {
    background-color: rgba(255, 255, 255, 0.1);
    transform: translateX(10px);
}

.logout {
    position: fixed;
    top: 20px;
    right: 30px;
    padding: 10px 20px;
    background-color: var(--accent-color);
    color: var(--text-light);
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.logout:hover {
    background-color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

main {
    margin-left: 300px;
    padding: 40px 30px;
}

.container h2 {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 30px;
    text-align: center;
}

.card-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.card {
    background-color: white;
    box-shadow: 0 10px 30px var(--card-shadow);
    padding: 30px;
    text-align: center;
    border-radius: 15px;
    width: 300px;
    transform: translateY(0);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.card:hover {
    transform: translateY(-15px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.card h3 {
    margin: 0 0 15px;
    color: var(--primary-color);
    font-size: 22px;
    font-weight: 600;
}

.card p {
    color: var(--accent-color);
    font-size: 18px;
}

.chart-container {
    margin-top: 20px;
    width: 100%;
    height: 250px;
}

/* Responsive Adjustments */
@media screen and (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding: 20px;
    }

    main {
        margin-left: 0;
        padding: 20px;
    }
}
    </style>
</head>
<body>

<div class="sidebar">
    <h1>OnD-Kos</h1>
    <div class="menu-bar">
        <a href="/OnDKos/Login/dashboarduser.php">Dashboard</a>
        <a href="/OnDKos/Kamar/index2user.php">Booking Kamar</a>
        <a href="/OnDKos/Transaksi/index7.php">Pemesanan dan pembayaran online</a>
        <a href="/OnDKos/User/index3user.php">Feedback atau Komplain</a>
        <a href="/OnDKos/User/index5.php">Pengaturan Profil</a>
    </div>
</div>

<a href="logout.php" class="logout">Logout</a>

<main>
    <div class="container">
        <h2>Selamat datang, <?= htmlspecialchars($nama_user); ?>!</h2>

        <!-- Card-container untuk menampilkan total kamar dan penghuni -->
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
        </div>
    </div>
</main>

<script>
    const ctx = document.getElementById('kamarChart').getContext('2d');
    const kamarChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Tersedia', 'Kosong'],
            datasets: [{
                label: 'Ketersediaan Kamar',
                data: [<?= $kamar_tersedia; ?>, <?= $kamar_kosong; ?>],
                backgroundColor: ['#36a2eb', '#ff6384'], /* Biru dan merah muda */
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
