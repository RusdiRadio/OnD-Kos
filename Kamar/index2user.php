<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kamar</title>
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
    font-family: 'Quicksand', 'Arial', sans-serif;
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
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.2), transparent);
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

.room-section {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

.room-card {
    background-color: white;
    box-shadow: 0 10px 30px var(--card-shadow);
    padding: 25px;
    text-align: center;
    border-radius: 15px;
    width: 300px;
    transform: translateY(0);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.room-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.room-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 15px;
}

.room-card button {
    background-color: var(--accent-color);
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    margin: 0 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.room-card button:hover {
    background-color: var(--primary-color);
    transform: scale(1.05);
}

.details-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.details-modal .modal-content {
    background-color: white;
    padding: px;
    border-radius: 20px;
    width: 500px;
    max-width: 90%;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
    position: relative;
}

.details-modal .modal-content h3 {
    color: var(--primary-color);
    margin-bottom: 25px;
    text-align: center;
    font-size: 24px;
}

.details-modal .modal-content p {
    margin: 15px 0;
    color: var(--text-dark);
}

.details-modal .modal-content form {
    display: flex;
    flex-direction: column;
}

.details-modal .modal-content form label {
    margin-top: 10px;
    color: var(--text-dark);
    font-weight: 600;
}

.details-modal .modal-content form input,
.details-modal .modal-content form select {
    padding: 12px;
    margin: 8px 0 15px;
    border: 1px solid #d1d8e0;
    border-radius: 8px;
    font-size: 16px;
}

.details-modal .modal-content .close-modal,
.details-modal .modal-content form button[type="submit"] {
    background-color: var(--accent-color);
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    margin-top: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.details-modal .modal-content .close-modal:hover,
.details-modal .modal-content form button[type="submit"]:hover {
    background-color: var(--primary-color);
}

/* Responsive Design */
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

    .room-card {
        width: 100%;
        max-width: 400px;
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

    <a href="/OnDKos/Login/logout.php" class="logout">Logout</a>

    <div class="container">
        <h2>Daftar Kamar</h2>

        <div class="room-section">
        <?php
require('../koneksi.php');  // Menyertakan file koneksi
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Kamar</title>
</head>
<body>

    <div class="room-section">
    <?php
// Query untuk mengambil data kamar
$query = "SELECT * FROM kamar";  // Query untuk mengambil 6 kamar
$result = mysqli_query($koneksi, $query);

// Cek apakah ada data kamar
if ($result && mysqli_num_rows($result) > 0) {
    while ($kamar = mysqli_fetch_assoc($result)) {
        echo "<div class='room-card'>";
        echo "<img src='/OnDKos/Login/ngelu.jpg' alt='Kamar'>";
        echo "<button onclick='showDetails(" . $kamar['id_kamar'] . ", \"" . $kamar['ukuran'] . "\", \"" . $kamar['fasilitas'] . "\", \"" . $kamar['harga_kamar'] . "\", \"" . $kamar['kamar_mandi'] . "\", \"" . $kamar['ketersediaan'] . "\")'>Lihat Detail</button>";
        echo "<button onclick='openBookingModal(" . $kamar['id_kamar'] . ")'>Booking</button>";
        echo "</div>";
    }
} else {
    echo "<p>Tidak ada data kamar tersedia.</p>";
}

mysqli_close($koneksi);  // Menutup koneksi
?>


    </div>

    <!-- Modal Detail Kamar -->
    <div class="details-modal" id="details-modal">
        <div class="modal-content">
            <h3>Detail Kamar</h3>
            <p><strong>ID:</strong> <span id="detail-id"></span></p>
            <p><strong>Ukuran:</strong> <span id="detail-ukuran"></span></p>
            <p><strong>Fasilitas:</strong> <span id="detail-fasilitas"></span></p>
            <p><strong>Harga:</strong> <span id="detail-harga"></span></p>
            <p><strong>Kamar Mandi:</strong> <span id="detail-mandi"></span></p>
            <p><strong>Ketersediaan:</strong> <span id="detail-tersedia"></span></p>
            <button class="close-modal" onclick="closeDetails()">Tutup</button>
        </div>
    </div>

    <!-- Modal Booking -->
    <div class="details-modal" id="booking-modal">
    <div class="modal-content">
        <h3>Form Booking</h3>
        <form id="booking-form" action="proses_booking.php" method="POST" enctype="multipart/form-data">
            <!-- ID Kamar (Hidden) -->
            <input type="hidden" name="id_kamar" id="booking-id-kamar">

            <!-- Pilih ID User -->
            <label for="id-user">Pilih ID User:</label>
            <select name="id_user" id="id-user" required>
                <option value="">Pilih ID User</option>
                <?php
                require('../koneksi.php');
                $query_users = "SELECT id_user, nama_user FROM daftar_user";
                $result_users = mysqli_query($koneksi, $query_users);
                while ($user = mysqli_fetch_assoc($result_users)) {
                    echo "<option value='{$user['id_user']}'>{$user['nama_user']} (ID: {$user['id_user']})</option>";
                }
                mysqli_close($koneksi);
                ?>
            </select>

            <!-- Input Password -->
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <!-- Nama Pemesan -->
            <label for="nama-pemesan">Nama Pemesan:</label>
            <input type="text" name="nama_pemesan" id="nama-pemesan" required>

            <!-- Email Pemesan -->
            <label for="email-pemesan">Email Pemesan:</label>
            <input type="email" name="email_pemesan" id="email-pemesan" required>

            <!-- Nomor Telepon -->
            <label for="telp-pemesan">Nomor Telepon:</label>
            <input type="tel" name="nomor_telpon" id="telp-pemesan" required>

            <!-- Tanggal Pemesanan -->
            <label for="tanggal-pemesanan">Tanggal Pemesanan:</label>
            <input type="date" name="tanggal_transaksi" id="tanggal-pemesanan" required>

            <!-- Submit -->
            <button type="submit" class="submit-btn">Booking</button>
        </form>

        <button class="close-modal" onclick="closeBookingModal()">Tutup</button>
    </div>
</div>



    <script>
        // Fungsi untuk menampilkan detail kamar
        function showDetails(id, ukuran, fasilitas, harga, mandi, tersedia) {
            document.getElementById("detail-id").innerText = id;
            document.getElementById("detail-ukuran").innerText = ukuran;
            document.getElementById("detail-fasilitas").innerText = fasilitas;
            document.getElementById("detail-harga").innerText = harga;
            document.getElementById("detail-mandi").innerText = mandi;
            document.getElementById("detail-tersedia").innerText = tersedia;

            document.getElementById("details-modal").style.display = "flex";
        }

        function closeDetails() {
            document.getElementById("details-modal").style.display = "none";
        }

        // Fungsi untuk membuka modal booking
        function openBookingModal(idKamar) {
            document.getElementById("booking-id-kamar").value = idKamar;
            document.getElementById("booking-modal").style.display = "flex";
        }

        function closeBookingModal() {
            document.getElementById("booking-modal").style.display = "none";
        }
    </script>
</body>
</html>