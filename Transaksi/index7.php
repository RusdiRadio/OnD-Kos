<?php
session_start();

// Cek apakah pengguna sudah login dan role-nya User
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'User') {
    header("Location: /OnDKos/Login/login.php");
    exit;
}

require('../koneksi.php'); // Pastikan file koneksi sudah ada dan terkoneksi dengan database.

// Ambil ID user berdasarkan username dari sesi login
$username = $_SESSION['username'];
$query_user = "SELECT id_user FROM daftar_user WHERE username = '$username'";
$result_user = mysqli_query($koneksi, $query_user);
$row_user = mysqli_fetch_assoc($result_user);
$id_user = $row_user['id_user']; // ID user berdasarkan sesi login
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Kamar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f7ff;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .menu-bar {
            flex-grow: 1;
        }
        .menu-bar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }
        .menu-bar a:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .logout {
            position: fixed;
            top: 10px;
            right: 20px;
            padding: 10px 20px;
            background-color: #d3d3d3;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logout:hover {
            background-color: #bfbfbf;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .container {
            margin-left: 270px;
            width: 80%;
            padding-top: 50px;
            
            margin-bottom: 30px;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        .order {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .upload-btn {
            background-color: #28a745;
            color: white;
        }
        .upload-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Logout Button -->
    <a href="/OnDKos/Login/logout.php" class="logout">Logout</a>

    <!-- Main Content -->
    <div class="container">
        <h2>Pesanan Kamar</h2>

        <?php
        include '../Sidebar/user.php';

        // Query untuk mendapatkan data pembayaran
        echo "<h3>Metode Pembayaran Tersedia:</h3>";
        $query_pembayaran = "SELECT jenis, nomor FROM pembayaran";
        $result_pembayaran = mysqli_query($koneksi, $query_pembayaran);

        if (mysqli_num_rows($result_pembayaran) > 0) {
            echo "<table border='1' cellpadding='10' cellspacing='0'>";
            echo "<tr><th>Jenis Pembayaran</th><th>Nomor</th></tr>";
            while ($row = mysqli_fetch_assoc($result_pembayaran)) {
                echo "<tr><td>{$row['jenis']}</td><td>{$row['nomor']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tidak ada metode pembayaran tersedia.</p>";
        }

        // Query untuk mendapatkan pesanan berdasarkan id_user dari sesi login
        $query = "SELECT t.id_transaksi, t.id_kamar, t.bukti_pembayaran 
                  FROM transaksi t 
                  JOIN kamar k ON t.id_kamar = k.id_kamar 
                  WHERE t.id_user = '$id_user'";
        $result = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<h3>Pesanan Anda:</h3>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='order'>Kamu telah memesan kamar <strong>{$row['id_kamar']}</strong>.</div>";
                // Tampilkan bukti pembayaran jika ada
                if ($row['bukti_pembayaran']) {
                    echo "<p>Bukti pembayaran: <br><img src='../uploads/bukti_pembayaran/{$row['bukti_pembayaran']}' alt='Bukti Pembayaran' style='max-width: 100%; height: auto;'></p>";
                } else {
                    echo "<p><i>Bukti pembayaran belum diunggah.</i></p>";
                }
                // Tombol upload bukti pembayaran
                echo "<a href='upload_bukti.php?id_transaksi={$row['id_transaksi']}' class='upload-btn'>Unggah Bukti Pembayaran</a>";
            }
        } else {
            echo "<p>Tidak ada pesanan ditemukan untuk akun Anda.</p>";
        }

        mysqli_close($koneksi);
        ?>
    </div>

</body>
</html>
