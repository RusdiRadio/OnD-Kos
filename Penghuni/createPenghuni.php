<?php
require_once "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $pekerjaan = $_POST['pekerjaan'];
    $id_kamar = $_POST['id_kamar'];
    $id_laporan_p = $_POST['id_laporan_p'];
    $id_transaksi = $_POST['id_transaksi'];
    $id_riwayat = $_POST['id_riwayat'];
    $id_user = $_POST['id_user'];

    // Query untuk insert data ke database
    $sql = "INSERT INTO penghuni (nama, pekerjaan, id_kamar, id_laporan_p, id_transaksi, id_riwayat, id_user) 
            VALUES ('$nama', '$pekerjaan', '$id_kamar', '$id_laporan_p', '$id_transaksi', '$id_riwayat', '$id_user')";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil ditambahkan!";
        header("Location: index4.php"); // Redirect ke halaman index setelah berhasil menambah data
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penghuni</title>
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
        <h2>Tambah Penghuni</h2>

        <!-- Form untuk menambahkan penghuni baru -->
        <form action="createPenghuni.php" method="POST">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="pekerjaan">Pekerjaan:</label>
            <input type="text" id="pekerjaan" name="pekerjaan" required>

            <label for="id_kamar">ID Kamar:</label>
            <input type="number" id="id_kamar" name="id_kamar" required>

            <label for="id_laporan_p">ID Laporan:</label>
            <input type="number" id="id_laporan_p" name="id_laporan_p" required>

            <label for="id_transaksi">ID Transaksi:</label>
            <input type="number" id="id_transaksi" name="id_transaksi" required>

            <label for="id_riwayat">ID Riwayat:</label>
            <input type="number" id="id_riwayat" name="id_riwayat" required>

            <label for="id_user">ID User:</label>
            <input type="number" id="id_user" name="id_user" required>

            <input type="submit" value="Tambah Penghuni">
        </form>

        <a href="index4.php" class="btn-dashboard">Kembali ke Daftar Penghuni</a>
    </div>

</body>
</html>
