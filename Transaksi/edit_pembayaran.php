<?php
require('../koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data pembayaran
    $query = "SELECT * FROM pembayaran WHERE id_pembayaran = $id";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        die("Data tidak ditemukan!");
    }
}

if (isset($_POST['update'])) {
    $jenis = $_POST['jenis'];
    $nomor = $_POST['nomor'];

    // Update data
    $update_query = "UPDATE pembayaran SET jenis = '$jenis', nomor = '$nomor' WHERE id_pembayaran = $id";
    if (mysqli_query($koneksi, $update_query)) {
        echo "<p>Jenis pembayaran berhasil diperbarui!</p>";
        echo "<script>window.location.href = 'jenis_pembayaran.php';</script>";
    } else {
        echo "<p>Terjadi kesalahan: " . mysqli_error($koneksi) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jenis Pembayaran</title>
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
        <h2>Edit Jenis Pembayaran</h2>
        
        <form action="edit_pembayaran.php?id=<?php echo $id; ?>" method="POST">
            <label for="jenis">Jenis Pembayaran:</label>
            <input type="text" name="jenis" value="<?php echo $row['jenis']; ?>" required>

            <label for="nomor">Nomor Pembayaran:</label>
            <input type="text" name="nomor" value="<?php echo $row['nomor']; ?>" required>

            <input type="submit" name="update" value="Update">
        </form>
    </div>
</div>

</body>
</html>
