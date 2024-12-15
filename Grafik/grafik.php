<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Pemasukan Kos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Gaya umum */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
        }

        canvas {
            display: block;
            margin: 0 auto; /* Pusatkan grafik secara horizontal */
            max-width: 90%; /* Perbesar ukuran grafik */
            max-height: 90%; /* Sesuaikan proporsi tinggi */
        }

        .content {
            margin-left: 280px; /* Menyesuaikan lebar sidebar */
            padding: 30px;
            flex-grow: 1;
            min-height: 100vh;
            background-color: #ffffff;
            box-shadow: -3px 0 6px rgba(0, 0, 0, 0.15);
        }

        .container {
            width: 96%;
            max-width: 1300px;
            margin: auto;
            padding: 30px;
        }

        .container h2 {
            color: #007bff;
            text-align: left;
            margin-bottom: 25px;
            font-size: 28px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
        }

        .chart-container {
            position: relative;
            margin: 25px auto;
            background-color: #ffffff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            padding: 20px;
            width: 95%; /* Sesuaikan lebar kontainer */
            max-width: 1200px; /* Perbesar lebar maksimum */
            height: 600px; /* Tambahkan tinggi tetap */
        }

        .chart-container canvas {
            width: 100%;
            max-width: 100%;
            max-height: 100%;
        }

        .btn-dashboard {
            padding: 12px 25px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 6px;
            background-color: #007bff;
            color: white;
            margin-top: 25px;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .btn-dashboard:hover {
            background-color: #0056b3;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.4);
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

<?php include '../Sidebar/admin.php'; ?> <!-- Memuat Sidebar -->

<div class="content">
    <div class="container">
        <h2>KEUANGAN</h2>
        <div class="chart-container">
            <canvas id="incomeChart"></canvas>
        </div>
        <a href="/OnDKos/Login/dashboardadmin.php" class="btn-dashboard">Kembali ke Dashboard</a>
    </div>

    <?php
    require '../koneksi.php';

    // Data bulan
    $bulanLengkap = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    $pemasukanData = array_fill(0, 12, 0);
    $pengeluaranData = array_fill(0, 12, 0);

    // Query untuk data pemasukan
    
    // Query untuk mendapatkan pemasukan
    $queryPemasukan = "SELECT MONTH(tanggal_transaksi) AS bulan, SUM(jumlah_bayar) AS total_pemasukan
                       FROM transaksi
                       WHERE status_pembayaran = 'sudah bayar'
                       GROUP BY bulan
                       ORDER BY bulan";
    
    // Query untuk mendapatkan pengeluaran
    $queryPengeluaran = "SELECT MONTH(tanggal) AS bulan, SUM(biaya_keluar) AS total_pengeluaran
                         FROM pengeluaran
                         GROUP BY bulan
                         ORDER BY bulan";
    
    // Eksekusi query untuk pemasukan
    $resultPemasukan = mysqli_query($koneksi, $queryPemasukan);
    if (!$resultPemasukan) {
        die("Query Error: " . mysqli_error($koneksi));
    }
    
    // Eksekusi query untuk pengeluaran
    $resultPengeluaran = mysqli_query($koneksi, $queryPengeluaran);
    if (!$resultPengeluaran) {
        die("Query Error: " . mysqli_error($koneksi));
    }
    
    // Inisialisasi array untuk menyimpan data pemasukan dan pengeluaran
    $pemasukanData = array_fill(0, 12, 0);
    $pengeluaranData = array_fill(0, 12, 0);
    
    // Ambil data pemasukan
    while ($row = mysqli_fetch_assoc($resultPemasukan)) {
        $index = $row['bulan'] - 1;
        $pemasukanData[$index] = $row['total_pemasukan'];
    }
    
    // Ambil data pengeluaran
    while ($row = mysqli_fetch_assoc($resultPengeluaran)) {
        $index = $row['bulan'] - 1;
        $pengeluaranData[$index] = $row['total_pengeluaran'];
    }
    
    mysqli_close($koneksi);
    ?>
    
    <script>
        const bulan = <?php echo json_encode($bulanLengkap); ?>;
        const pemasukan = <?php echo json_encode($pemasukanData); ?>;
        const pengeluaran = <?php echo json_encode($pengeluaranData); ?>;
    
        const ctx = document.getElementById('incomeChart').getContext('2d');
        const incomeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Total Pemasukan (dalam Rp)',
                    data: pemasukan,
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna biru untuk pemasukan
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true
                },
                {
                    label: 'Total Pengeluaran (dalam Rp)',
                    data: pengeluaran,
                    borderColor: 'rgba(255, 99, 132, 1)', // Warna merah untuk pengeluaran
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
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
                            text: 'Total (Rp)',
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
</div>

</body>
</html>
