<?php
session_start();

// Cek apakah pengguna sudah login dan role-nya User
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'User') {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke database
require_once "../koneksi.php";
$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
    // Jika belum login, arahkan ke halaman login
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

// Ambil data pengguna berdasarkan ID pengguna dari session
$query = $koneksi->query("SELECT * FROM daftar_user WHERE id_user = '" . $koneksi->real_escape_string($id_user) . "'");

if (!$query || $query->num_rows == 0) {
    // Jika data pengguna tidak ditemukan
    die("Data pengguna tidak ditemukan. Pastikan tabel dan ID user sesuai.");
}

// Data pengguna disimpan dalam variabel $user
$user = $query->fetch_assoc();
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f7ff; /* Biru muda */
        }

        .logout {
            position: fixed;
            top: 10px;
            right: 20px;
            padding: 10px 20px;
            background-color: #d3d3d3; /* Abu-abu */
            color: black;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease-in-out; /* Animasi transisi */
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logout:hover {
            background-color: #bfbfbf; /* Abu-abu lebih gelap */
            transform: translateY(-2px); /* Efek mengangkat tombol */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan tombol */
        }

        .logout:active {
            transform: scale(0.95); /* Efek mengecil saat diklik */
        }

        .container {
            text-align: center;
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
            width: 250px;
        }

        .card h3 {
            margin: 0 0 10px;
            color: #333;
            font-size: 20px;
        }

        .card p {
            color: #555; /* Abu-abu */
            font-size: 16px;
        }

        .chart-container {
            margin-top: 15px;
            width: 100%;
            height: 200px; /* Tinggi chart */
        }
    </style>
</head>
<body>

<?php include '../Sidebar/user.php'; ?> <!-- Memuat Sidebar -->

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
