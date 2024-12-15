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
    display: flex;
}

.menu-bar {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.menu-bar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
    transition: all 0.3s ease-in-out; /* Animasi transisi */
}

.menu-bar a:hover {
    background-color: #0056b3; /* Biru lebih gelap */
}


/* Kontainer Dashboard */
.container {
    margin-left: 250px; /* Memberikan ruang untuk sidebar */
    width: calc(100% - 250px); /* Sisa ruang setelah sidebar */
    padding-top: 50px;
    text-align: center;
}

.container h2 {
    color: #007bff; /* Biru */
}

/* Power BI Dashboard */
.chart-container {
    width: 100%;
    height: 90vh; /* Mengatur tinggi kontainer menjadi 90% dari tinggi layar */
    display: flex;
    justify-content: center;
}

iframe {
    margin-left: auto;
    width: 100%; /* Memastikan iframe memenuhi lebar kontainer */
    height: 100%; /* Memastikan iframe memenuhi tinggi kontainer */
    border: none;
}

@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }

    .container {
        margin-left: 200px;
        width: calc(100% - 200px);
    }

    .chart-container {
        height: 70vh; /* Sesuaikan tinggi pada layar kecil */
    }
}

@media (max-width: 480px) {
    .sidebar {
        width: 150px;
    }

    .container {
        margin-left: 150px;
        width: calc(100% - 150px);
    }

    .chart-container {
        height: 60vh; /* Sesuaikan tinggi pada layar lebih kecil */
    }
}

    </style>
</head>
<body>
<?php include '../Sidebar/admin.php'; ?> <!-- Memuat Sidebar -->
    <div class="container">
        
        <!-- Menampilkan Power BI Dashboard -->
        <div class="chart-container">
            <iframe title="tugas akhir" 
                    width="100%" 
                    height="800px" 
                    src="https://app.powerbi.com/reportEmbed?reportId=73a90120-5ee0-4efd-8ff1-c355b3e5ffb6&autoAuth=true&ctid=5263cc81-5912-42c4-abc1-d0f1b668b530" 
                    frameborder="0" 
                    allowFullScreen="true">
            </iframe>
        </div>

    </div>
</body>
</html>
