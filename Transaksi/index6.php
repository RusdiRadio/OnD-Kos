<?php
require('../koneksi.php'); // Koneksi ke database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .transaction {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .transaction:last-child {
            border-bottom: none;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            text-align: left;
        }
        .modal-content label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .modal-content input {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .close-btn {
            background-color: #dc3545;
            color: white;
        }
        .bukti-pembayaran img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Daftar Transaksi</h2>
        <?php
        // Query untuk mendapatkan data transaksi
        $query = "SELECT t.id_transaksi, t.id_user, d.nama_user, k.id_kamar, t.bukti_pembayaran
                  FROM transaksi t 
                  JOIN daftar_user d ON t.id_user = d.id_user
                  JOIN kamar k ON t.id_kamar = k.id_kamar"; // Pastikan `bukti_pembayaran` ada di tabel transaksi
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='transaction'>";
                echo "<p><strong>{$row['nama_user']}</strong> melakukan pemesanan atas kamar <strong>{$row['id_kamar']}</strong></p>";
                echo "<button onclick='openModal({$row['id_transaksi']}, \"{$row['bukti_pembayaran']}\")'>Cek Pesanan</button>";
                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada transaksi ditemukan.</p>";
        }

        mysqli_close($koneksi);
        ?>
    </div>

    <!-- Modal -->
    <div class="modal" id="modal">
        <div class="modal-content">
            <h3>Detail Pemesanan</h3>
            <form id="form-transaksi" action="konfirmasi.php" method="POST">
                <!-- ID Transaksi (Hidden) -->
                <input type="hidden" name="id_transaksi" id="modal-id-transaksi">

                <!-- Periode -->
                <label for="periode">Periode:</label>
                <input type="text" name="periode" id="periode" required>

                <!-- Jumlah Bayar -->
                <label for="jumlah_bayar">Jumlah Bayar:</label>
                <input type="text" name="jumlah_bayar" id="jumlah_bayar" required>

                <!-- Metode Pembayaran -->
                <label for="metode_pembayaran">Metode Pembayaran:</label>
                <input type="text" name="metode_pembayaran" id="metode_pembayaran" required>

                <button type="submit">Konfirmasi Pesanan</button>
                <button type="button" class="close-btn" onclick="closeModal()">Tutup</button>
            </form>

            <!-- Lihat Bukti Pembayaran -->
            <div id="bukti-container" class="bukti-pembayaran">
                <!-- Gambar bukti pembayaran akan muncul di sini -->
            </div>
        </div>
    </div>

    <script>
        function openModal(idTransaksi, buktiPembayaran) {
            document.getElementById('modal-id-transaksi').value = idTransaksi;
            document.getElementById('modal').style.display = 'flex';

            // Tampilkan bukti pembayaran jika ada
            if (buktiPembayaran) {
                document.getElementById('bukti-container').innerHTML = 
                    `<h4>Bukti Pembayaran:</h4><img src='../uploads/bukti_pembayaran/${buktiPembayaran}' alt='Bukti Pembayaran'>`;
            } else {
                document.getElementById('bukti-container').innerHTML = "<p>Bukti pembayaran belum diunggah.</p>";
            }
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
</body>
</html>
