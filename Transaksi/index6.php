<?php
require('../koneksi.php'); // Koneksi ke database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
        }
        .content {
            margin-left: 280px; /* Lebar sidebar sedikit diperbesar */
            padding: 30px; /* Padding lebih besar */
            flex-grow: 1;
            min-height: 100vh;
            background-color: #ffffff;
            box-shadow: -3px 0 6px rgba(0, 0, 0, 0.15);
        }
        .container {
            width: 96%; /* Lebih luas sedikit */
            max-width: 1300px; /* Lebar maksimum diperbesar */
            margin: auto;
            padding: 30px; /* Padding lebih besar */
        }
        .container h2 {
            color: #007bff;
            text-align: left;
            margin-bottom: 25px; /* Spasi bawah lebih besar */
            font-size: 28px; /* Ukuran font lebih besar */
            border-bottom: 3px solid #007bff; /* Garis bawah lebih tebal */
            padding-bottom: 15px; /* Padding bawah lebih besar */
        }
        .transaction {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 15px 20px; /* Padding lebih besar */
        }
        .transaction:last-child {
            border-bottom: none;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 25px; /* Padding lebih besar */
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 18px; /* Ukuran font lebih besar */
        }
        button:hover {
            background-color: #0056b3;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
    background-color: #ffffff;
    padding: 30px; /* Padding lebih besar */
    border-radius: 10px;
    width: 85%; /* Lebar modal diperbesar */
    max-width: 700px; /* Ukuran maksimum lebih besar */
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    position: relative; /* Posisi tetap relatif */
    max-height: 80vh; /* Membatasi tinggi maksimal modal */
    overflow-y: auto; /* Menambahkan scroll jika konten lebih tinggi dari modal */
}
.modal-content h3 {
    color: #007bff;
    margin-bottom: 25px; /* Jarak bawah heading diperbesar */
    font-size: 24px; /* Ukuran font diperbesar */
}
.modal-content img {
    max-width: 100%; /* Agar gambar tidak melampaui lebar modal */
    height: auto; /* Mempertahankan rasio aspek gambar */
    display: block; /* Memastikan gambar berada di dalam aliran dokumen */
    margin: 0 auto; /* Menempatkan gambar di tengah */
}

.close {
    position: absolute;
    top: 15px; /* Posisi top diperbesar */
    right: 20px; /* Posisi right diperbesar */
    font-size: 28px; /* Ukuran font lebih besar */
    font-weight: bold;
    color: #333;
    cursor: pointer;
    transition: color 0.3s ease;
}
.close:hover {
    color: #007bff;
}

form input, form textarea {
    display: block; /* Pastikan elemen berada dalam satu baris */
    width: 97%; /* Sesuaikan lebar */
    margin: 10px 0; /* Jarak atas dan bawah */
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
    background-color: #f9f9f9;
}

form textarea {
    resize: vertical;
    height: 120px; /* Tinggi textarea diperbesar */
}

form input[type="submit"] {
    background-color: #007bff;
    color: white;
    padding: 12px 25px; /* Padding lebih besar */
    border: none;
    border-radius: 6px;
    font-size: 18px; /* Ukuran font diperbesar */
    cursor: pointer;
    transition: all 0.3s ease;
}

form input[type="submit"]:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>

<?php include '../Sidebar/admin.php'; ?> <!-- Memuat Sidebar -->

<div class="content">
    <div class="container">
        <h2>DAFTAR TRANSAKSI</h2>
        <button onclick="window.location.href='jenis_pembayaran.php'">Atur Jenis Pembayaran</button>
    
        <?php
        // Query untuk mendapatkan data transaksi
        $query = "SELECT t.id_transaksi, t.id_user, d.nama_user, k.id_kamar, t.bukti_pembayaran, t.status_pembayaran
                  FROM transaksi t 
                  JOIN daftar_user d ON t.id_user = d.id_user
                  JOIN kamar k ON t.id_kamar = k.id_kamar"; // Pastikan ada kolom status_pembayaran
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Menentukan pesan berdasarkan status pembayaran
                $statusPesanan = ($row['status_pembayaran'] == 'sudah bayar') ? "<span style='color: green; font-weight: bold;'>Pesanan Selesai</span>" : "";
                echo "<div class='transaction'>";
                echo "<p><strong>{$row['nama_user']}</strong> melakukan pemesanan atas kamar <strong>{$row['id_kamar']}</strong> $statusPesanan</p>";
                echo "<button onclick='openModal({$row['id_transaksi']}, \"{$row['bukti_pembayaran']}\")'>Cek Pesanan</button>";
                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada transaksi ditemukan.</p>";
        }

        mysqli_close($koneksi);
        ?>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="modal">
    <div class="modal-content">
        <h3>Detail Pemesanan</h3>
        
        <form id="form-transaksi" action="konfirmasi.php" method="POST">
            <input type="hidden" name="id_transaksi" id="modal-id-transaksi">

            <label for="periode">Periode:</label>
            <input type="text" name="periode" id="periode" required>

            <label for="jumlah_bayar">Jumlah Bayar:</label>
            <input type="text" name="jumlah_bayar" id="jumlah_bayar" required>

            <label for="metode_pembayaran">Metode Pembayaran:</label>
            <input type="text" name="metode_pembayaran" id="metode_pembayaran" required>

            <input type="submit" value="Konfirmasi Pesanan">
            <button type="button" class="close" onclick="closeModal()">Tutup</button>
        </form>

        <div id="bukti-container" class="bukti-pembayaran"></div>
    </div>
</div>

<script>
    function openModal(idTransaksi, buktiPembayaran) {
        document.getElementById('modal-id-transaksi').value = idTransaksi;
        document.getElementById('modal').style.display = 'flex';

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
