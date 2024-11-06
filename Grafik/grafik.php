<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Pemasukan Kos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #444;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        canvas {
            margin: 20px 0;
            border-radius: 8px;
            background: #eaeaea;
            max-height: 400px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">
    <h2>Grafik Pemasukan Tahunan Kos</h2>
    <canvas id="incomeChart" width="600" height="300"></canvas>
</div>

<?php
require '../koneksi.php';

// Daftar bulan lengkap dari Januari hingga Juli
$bulanLengkap = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "Desember"];
$pemasukanData = array_fill(0, 7, 0); // Mengisi nilai awal 0 untuk setiap bulan

// Menyiapkan query untuk mengambil total pemasukan per bulan
$query = "SELECT MONTH(tanggal_transaksi) AS bulan, SUM(jumlah_bayar) AS total_pemasukan
          FROM transaksi
          WHERE status_pembayaran = 'sudah bayar' AND MONTH(tanggal_transaksi) <= 7
          GROUP BY bulan
          ORDER BY bulan";

// Menjalankan query
$result = mysqli_query($koneksi, $query);

// Memeriksa apakah query berhasil
if (!$result) {
    die("Query Error: " . mysqli_error($koneksi));
}

// Memasukkan hasil query ke array, memastikan setiap bulan memiliki data
while ($row = mysqli_fetch_assoc($result)) {
    $index = $row['bulan'] - 1; // Mengurangi 1 untuk indeks bulan
    $pemasukanData[$index] = $row['total_pemasukan'];
}

// Menutup koneksi database
mysqli_close($koneksi);
?>

<script>
// Mengambil data bulan dan pemasukan dari PHP
const bulan = <?php echo json_encode($bulanLengkap); ?>;
const pemasukan = <?php echo json_encode($pemasukanData); ?>;

// Membuat line chart menggunakan Chart.js
const ctx = document.getElementById('incomeChart').getContext('2d');
const incomeChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: bulan,
        datasets: [{
            label: 'Total Pemasukan (dalam Rp)',
            data: pemasukan,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 2,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Total Pemasukan (Rp)',
                    font: {
                        size: 14,
                    }
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Bulan',
                    font: {
                        size: 14,
                    }
                }
            }
        }
    }
});
</script>

<div class="footer">
    <p>&copy; 2024 Kos Management System. All rights reserved.</p>
</div>
<a href="/CRUD TEST/Login/dashboardadmin.php" >Kembali ke Dashboard</a>
</body>
</html>
