<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kamar</title>
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
        .container h2 {
            color: #007bff;
        }
        .room-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .room-card {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            width: 250px;
            margin-top: 20px;
        }
        .room-card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .room-card button {
            background-color: #17a2b8;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.3s;
            margin-top: 10px;
        }
        .room-card button:hover {
            background-color: #138496;
        }
        .details-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .details-modal .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            text-align: left;
        }
        .details-modal .modal-content h3 {
            text-align: center;
        }
        .details-modal .modal-content p {
            margin: 10px 0;
        }
        .close-modal {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .details-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 9999; /* Menambahkan z-index tinggi agar modal di atas konten lainnya */
}


.details-modal .modal-content {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    width: 400px;
    text-align: left;
}

.details-modal .modal-content h3 {
    text-align: center;
    margin-bottom: 20px;
}

.details-modal .modal-content form input,
.details-modal .modal-content form button {
    width: 100%;
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
}

.details-modal .modal-content .close-modal {
    background-color: #dc3545;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
    width: 100%;
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