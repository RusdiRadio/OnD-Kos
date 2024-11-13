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
            background-color: #e6f7ff;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Navbar */
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

        /* Container dan konten utama */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #444;
        }

        /* Gaya grafik */
        .chart-container {
            position: relative;
            margin: 20px auto;
            width: 100%;
            max-width: 700px;
            max-height: 400px;
            background: #eaeaea;
            border-radius: 8px;
            padding: 15px;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        /* Tombol */
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <h1>OnD-Kos</h1>
        <div class="menu-bar">
            <a href="/CRUD TEST/Kamar/index2.php">Kelola Kamar</a>
            <a href="/CRUD TEST/User/index3.php">Kelola User</a>
            <a href="/CRUD TEST/Penghuni/index4.php">Kelola Penghuni</a>
            <a href="/CRUD TEST/Grafik/grafik.php">Pemasukan</a>
        </div>
        <a href="/CRUD TEST/Login/logout.php" class="logout">Logout</a>
    </div>

    <!-- Container grafik -->
    <div class="container">
        <h2>Grafik Pemasukan Tahunan Kos</h2>
        <div class="chart-container">
            <canvas id="incomeChart" width="600" height="500"></canvas>
        </div>
        <a href="/CRUD TEST/Login/dashboardadmin.php" class="btn-dashboard">Kembali ke Dashboard</a>
    </div>

    <?php
    require '../koneksi.php';

    $bulanLengkap = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "Desember"];
    $pemasukanData = array_fill(0, 7, 0);

    $query = "SELECT MONTH(tanggal_transaksi) AS bulan, SUM(jumlah_bayar) AS total_pemasukan
              FROM transaksi
              WHERE status_pembayaran = 'sudah bayar' AND MONTH(tanggal_transaksi) <= 7
              GROUP BY bulan
              ORDER BY bulan";

    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Query Error: " . mysqli_error($koneksi));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $index = $row['bulan'] - 1;
        $pemasukanData[$index] = $row['total_pemasukan'];
    }

    mysqli_close($koneksi);
    ?>

    <script>
    const bulan = <?php echo json_encode($bulanLengkap); ?>;
    const pemasukan = <?php echo json_encode($pemasukanData); ?>;

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

</body>
</html>
