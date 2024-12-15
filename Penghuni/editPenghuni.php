<?php
// Koneksi ke database
require_once "../koneksi.php";

// Ambil ID pengguna dari URL
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Query untuk mengambil data penghuni berdasarkan ID
    $sql = "SELECT * FROM penghuni WHERE id_user = '$id_user'";
    $result = mysqli_query($koneksi, $sql);

    // Cek apakah data ditemukan
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID pengguna tidak valid.";
    exit;
}

// Proses form jika dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $pekerjaan = $_POST['pekerjaan'];
    $id_kamar = $_POST['id_kamar'];

    // Query untuk memperbarui data penghuni
    $sql = "UPDATE penghuni SET nama='$nama', pekerjaan='$pekerjaan', id_kamar='$id_kamar' WHERE id_user='$id_user'";
    
    if (mysqli_query($koneksi, $sql)) {
        // Setelah data berhasil diperbarui, arahkan ke index4.php
        header("Location: index4.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penghuni</title>
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

        form {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
            margin: auto;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            text-align: left;
            display: block;
        }

        input[type="text"], input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        .btn-dashboard {
            background-color: #17a2b8;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 6px;
            transition: background-color 0.3s, transform 0.3s;
            display: inline-block;
            margin-top: 20px;
            text-align: center;
        }

        .btn-dashboard:hover {
            background-color: #138496;
            transform: translateY(-3px);
        }

        /* Untuk memusatkan tombol "Kembali ke Daftar Penghuni" */
        .btn-center {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php include '../Sidebar/admin.php'; ?>
    <div class="content">
        <div class="container">
            <h2>EDIT DATA PENGHUNI</h2>

            <!-- Form untuk mengedit data penghuni -->
            <form method="post" action="">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>

                <label for="pekerjaan">Pekerjaan:</label>
                <input type="text" id="pekerjaan" name="pekerjaan" value="<?php echo htmlspecialchars($row['pekerjaan']); ?>" required>

                <label for="id_kamar">ID Kamar:</label>
                <input type="text" id="id_kamar" name="id_kamar" value="<?php echo htmlspecialchars($row['id_kamar']); ?>" required>

                <input type="submit" value="Simpan Perubahan">
            </form>

            <div class="btn-center">
                <a href="index4.php" class="btn-dashboard">Kembali ke Daftar Penghuni</a>
            </div>
        </div>
    </div>

</body>
</html>
