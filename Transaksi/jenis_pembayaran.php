<?php
require('../koneksi.php'); // Koneksi ke database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Jenis Pembayaran</title>
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
        .payment-type {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 15px 20px; /* Padding lebih besar */
        }
        .payment-type:last-child {
            border-bottom: none;
        }
        input[type="text"] {
            display: block;
            width: 97%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: #f9f9f9;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<?php include '../Sidebar/admin.php'; ?> <!-- Memuat Sidebar -->

<div class="content">
    <div class="container">
        <h2>Atur Jenis Pembayaran</h2>

        <!-- Form untuk menambah jenis pembayaran -->
        <form action="jenis_pembayaran.php" method="POST">
            <input type="text" name="jenis" placeholder="Jenis Pembayaran" required>
            <input type="text" name="nomor" placeholder="Nomor Pembayaran" required>
            <input type="submit" name="submit" value="Tambah Jenis Pembayaran">
        </form>

        <h3>Daftar Jenis Pembayaran</h3>
        <?php
        // Query untuk menampilkan data jenis pembayaran
        $query = "SELECT * FROM pembayaran";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='payment-type'>";
                echo "<p><strong>ID Pembayaran:</strong> {$row['id_pembayaran']} | <strong>Jenis:</strong> {$row['jenis']} | <strong>Nomor:</strong> {$row['nomor']}</p>";
                echo "<a href='edit_pembayaran.php?id={$row['id_pembayaran']}'>Edit</a> | <a href='hapus_pembayaran.php?id={$row['id_pembayaran']}'>Hapus</a>";
                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada jenis pembayaran.</p>";
        }

        // Menangani form untuk menambah jenis pembayaran
        if (isset($_POST['submit'])) {
            $jenis = $_POST['jenis'];
            $nomor = $_POST['nomor'];

            $insert_query = "INSERT INTO pembayaran (jenis, nomor) VALUES ('$jenis', '$nomor')";
            if (mysqli_query($koneksi, $insert_query)) {
                echo "<p>Jenis pembayaran berhasil ditambahkan!</p>";
                echo "<script>window.location.href = 'jenis_pembayaran.php';</script>"; // Refresh halaman
            } else {
                echo "<p>Terjadi kesalahan: " . mysqli_error($koneksi) . "</p>";
            }
        }

        // Menutup koneksi setelah semua query selesai
        mysqli_close($koneksi);
        ?>

</body>
</html>
