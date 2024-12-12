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

.container {
    margin-left: 300px;
    padding: 40px 30px;
}

.container h2 {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 30px;
    text-align: center;
}

form {
    max-width: 500px;
    margin: 0 auto;
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 10px 30px var(--card-shadow);
}

form label {
    display: block;
    margin-bottom: 10px;
    color: var(--text-dark);
    font-weight: 500;
}

form select, form button {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid var(--accent-color);
    border-radius: 6px;
    font-size: 16px;
}

form button {
    background-color: var(--primary-color);
    color: var(--text-light);
    cursor: pointer;
    transition: all 0.3s ease;
}

form button:hover {
    background-color: var(--accent-color);
    transform: translateY(-3px);
}

.order {
    background-color: white;
    margin: 20px auto;
    padding: 20px;
    max-width: 600px;
    border-radius: 10px;
    box-shadow: 0 6px 20px var(--card-shadow);
}

.upload-btn {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    background-color: var(--accent-color);
    color: var(--text-light);
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.upload-btn:hover {
    background-color: var(--primary-color);
    transform: translateY(-3px);
}

/* Responsive Adjustments */
@media screen and (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding: 20px;
    }

    .container {
        margin-left: 0;
        padding: 20px;
    }
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
