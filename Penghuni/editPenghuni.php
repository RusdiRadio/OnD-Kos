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
        echo "Data berhasil diperbarui. <a href='index4.php'>Kembali ke Daftar Penghuni</a>";
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
            background-color: #f0f8ff;
        }
        .navbar {
            background-color: #007bff;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }
        .menu-bar {
            display: flex;
            gap: 15px;
        }
        .menu-bar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .menu-bar a:hover {
            background-color: #0056b3;
        }
        .logout {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .logout:hover {
            background-color: #c82333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding-top: 50px;
            text-align: center;
        }
        .container h2 {
            color: #007bff;
            font-size: 28px;
            margin-bottom: 30px;
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
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-dashboard:hover {
            background-color: #138496;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>OnD-Kos</h1>
        <div class="menu-bar">
            <a href="/OnDKos/Kamar/index2.php">Kelola Kamar</a>
            <a href="/OnDKos/User/index3.php">Kelola User</a>
            <a href="/OnDKos/Penghuni/index4.php">Kelola Penghuni</a>
            <a href="/OnDKos/Grafik/grafik.php">Pemasukan</a>
            <a href="/OnDKos/Riwayat/index5.php">Riwayat Penghuni</a>
        </div>
        <a href="/OnDKos/Login/logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
        <h2>Edit Data Penghuni</h2>

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

        <a href="index4.php" class="btn-dashboard">Kembali ke Daftar Penghuni</a>
    </div>

</body>
</html>
