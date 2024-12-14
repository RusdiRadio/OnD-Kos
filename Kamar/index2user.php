<?php
session_start();
require '../koneksi.php'; // Jalur sesuaikan dengan lokasi file koneksi.php

// Debug untuk memastikan koneksi terhubung
if ($koneksi) {
    echo "Koneksi ke database berhasil.";
}

// Cek apakah pengguna sudah login dan memiliki role 'User'
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'User') {
    // Arahkan ke halaman login jika belum login
    header("Location: login.php");
    exit;
}

// Ambil ID user dari sesi
$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
    // Jika ID user tidak ditemukan di sesi, arahkan ke login
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

// Ambil data pengguna berdasarkan ID pengguna dari database
$query = $koneksi->query("SELECT * FROM daftar_user WHERE id_user = '" . $koneksi->real_escape_string($id_user) . "'");

if (!$query || $query->num_rows == 0) {
    // Jika data pengguna tidak ditemukan, tampilkan pesan kesalahan
    die("Data pengguna tidak ditemukan. Pastikan tabel dan ID user sesuai.");
}

// Data pengguna disimpan dalam variabel $user
$user = $query->fetch_assoc();
?>

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
}

/* Layout Flexbox */
#room-page {
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 100vh;
}

#room-page .sidebar {
    width: 250px;
    background-color: #007bff;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
}

#room-page .main-content {
    margin-left: 250px;
    padding: 20px;
    flex: 1;
    background-color: #e6f7ff;
    min-height: 100vh;
}

.logout {
    position: fixed;
    top: 10px;
    right: 20px;
    padding: 10px 20px;
    background-color: #d3d3d3;
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

#room-page .container {
    width: 100%;
    margin: 0 auto;
    padding-top: 50px;
    padding-bottom: 30px;
    text-align: center;
}

#room-page .container h2 {
    color: #007bff;
}

#room-page .room-section {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

#room-page .room-card {
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    border-radius: 10px;
    width: 250px;
}

#room-page .room-card img {
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

        .details-modal .close-modal {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Modal Booking */
        #booking-modal .modal-content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            width: 500px;
            text-align: left;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        #booking-modal .modal-content h3 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        #booking-modal .modal-content form label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        #booking-modal .modal-content form input,
        #booking-modal .modal-content form button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }

        #booking-modal .modal-content .close-modal {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<body>
    <div id="room-page">
        <div class="layout">
            <!-- Sidebar -->
            <div class="sidebar">
                <?php include '../Sidebar/user.php'; ?>
            </div>

    <div class="main-content">
    <a href="/OnDKos/Login/logout.php" class="logout">Logout</a>
        <h2>Daftar Kamar</h2>
        <div class="room-section">
        <?php
        require('../koneksi.php');
        $query = "SELECT * FROM kamar";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($kamar = mysqli_fetch_assoc($result)) {
                // Cek apakah kamar tersedia atau tidak
                $isAvailable = ($kamar['ketersediaan'] !== 'kosong'); // Jika ketersediaan tidak kosong
                
                echo "<div class='room-card'>";
                echo "<img src='/OnDKos/Login/ngelu.jpg' alt='Kamar'>";
                echo "<button onclick='showDetails(" . $kamar['id_kamar'] . ", \"" . $kamar['ukuran'] . "\", \"" . $kamar['fasilitas'] . "\", \"" . $kamar['harga_kamar'] . "\", \"" . $kamar['kamar_mandi'] . "\", \"" . $kamar['ketersediaan'] . "\")'>Lihat Detail</button>";
                
                // Jika kamar tidak tersedia, ubah warna tombol dan nonaktifkan
                if (!$isAvailable) {
                    echo "<button class='disabled' style='background-color: #d3d3d3;' disabled>Booking</button>";
                } else {
                    echo "<button onclick='openBookingModal(" . $kamar['id_kamar'] . ")'>Booking</button>";
                }
                
                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada data kamar tersedia.</p>";
        }

        mysqli_close($koneksi);
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
                    <input type="hidden" name="id_kamar" id="booking-id-kamar">
                    <label for="nama-pemesan">Nama Pemesan:</label>
                    <input type="text" name="nama_pemesan" id="nama-pemesan" required>
                    <label for="email-pemesan">Email Pemesan:</label>
                    <input type="email" name="email_pemesan" id="email-pemesan" required>
                    <label for="telp-pemesan">Nomor Telepon:</label>
                    <input type="tel" name="nomor_telpon" id="telp-pemesan" required>
                    <label for="tanggal-pemesanan">Tanggal Pemesanan:</label>
                    <input type="date" name="tanggal_transaksi" id="tanggal-pemesanan" required>
                    <button type="submit" class="submit-btn">Booking</button>
                </form>
                <button class="close-modal" onclick="closeBookingModal()">Tutup</button>
            </div>
        </div>
    </div>

    <script>
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
