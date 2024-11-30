<?php
require('../koneksi.php'); // Pastikan file koneksi sudah ada dan terkoneksi dengan database.
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
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #007bff;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: white;
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
            text-align: center;
            margin-bottom: 30px;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
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

    <!-- Sidebar -->
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

    <!-- Logout Button -->
    <a href="/OnDKos/Login/logout.php" class="logout">Logout</a>

    <!-- Main Content -->
    <div class="container">
        <h2>Pesanan Kamar</h2>
        
        <!-- Form untuk memilih id_user -->
        <form method="GET">
            <label for="id_user">Pilih User:</label>
            <select name="id_user" id="id_user" required>
                <option value="">-- Pilih ID User --</option>
                <?php
                // Query untuk mendapatkan daftar user
                $query = "SELECT id_user, nama_user FROM daftar_user";
                $result = mysqli_query($koneksi, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['id_user']}'>{$row['id_user']} - {$row['nama_user']}</option>";
                }
                ?>
            </select>
            <button type="submit">Tampilkan Pesanan</button>
        </form>

        <?php
        if (isset($_GET['id_user'])) {
            $id_user = $_GET['id_user'];

            // Query untuk mendapatkan pesanan berdasarkan id_user
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
                echo "<p>Tidak ada pesanan ditemukan untuk ID User ini.</p>";
            }
        }

        mysqli_close($koneksi);
        ?>
    </div>

</body>
</html>
