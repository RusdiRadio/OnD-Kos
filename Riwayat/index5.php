    <?php
    // Sambungkan ke file koneksi menggunakan require
    require '../koneksi.php';

    // Query untuk mengambil data dari tabel riwayat_penghuni
    $query = "SELECT * FROM riwayat_penghuni";
    $result = mysqli_query($koneksi, $query);

    // Cek apakah query berhasil
    if (!$result) {
        die("Query gagal: " . mysqli_error($koneksi));
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Riwayat Penghuni</title>
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
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #007bff;
                color: white;
            }
            td a {
                text-decoration: none;
                color: #007bff;
                padding: 5px 10px;
                border-radius: 5px;
                transition: background-color 0.3s;
            }
            td a:hover {
                background-color: #0056b3;
                color: white;
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
                <a href="/CRUD TEST/Riwayat/index5.php">Riwayat Penghuni</a>
            </div>
            <a href="/CRUD TEST/Login/logout.php" class="logout">Logout</a>
        </div>

        <div class="container">
            <h2>Riwayat Penghuni</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Riwayat</th>
                        <th>ID Penghuni</th>
                        <th>ID Kamar</th>
                        <th>Nama</th>
                        <th>Pekerjaan</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                        <th>Status Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Periksa apakah ada data dalam hasil query
                    if (mysqli_num_rows($result) > 0) {
                        // Looping untuk menampilkan data ke dalam tabel
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_riwayat']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['id_penghuni']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['id_kamar']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['pekerjaan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tanggal_masuk']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tanggal_keluar']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status_keluar']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // Jika tidak ada data, tampilkan pesan
                        echo "<tr><td colspan='8'>Tidak ada data tersedia</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </body>
    </html>
