<?php
session_start();

// Cek apakah pengguna sudah login dan role-nya admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke database
require_once "../koneksi.php";

// Mendapatkan id_kamar dari parameter URL
$id_kamar = $_GET['id_kamar'];

// Query untuk mendapatkan data kamar berdasarkan id_kamar
$sql = "SELECT * FROM kamar WHERE id_kamar = $id_kamar";
$result = mysqli_query($koneksi, $sql);

// Memeriksa apakah data ditemukan
if (mysqli_num_rows($result) > 0) {
    $kamar = mysqli_fetch_assoc($result);
} else {
    echo "Data tidak ditemukan!";
    exit();
}

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $ukuran = $_POST['ukuran'];
    $fasilitas = $_POST['fasilitas'];
    $harga = $_POST['harga'];
    $kamarmandi = $_POST['kamar_mandi'];
    $ketersediaan = $_POST['ketersediaan'];
   
    // Query untuk mengupdate data
    $sql = "UPDATE kamar SET ukuran = '$ukuran', fasilitas = '$fasilitas', harga_kamar = '$harga', kamar_mandi = '$kamarmandi', ketersediaan = '$ketersediaan' WHERE id_kamar = $id_kamar";

    if (mysqli_query($koneksi, $sql)) {
        // Redirect kembali ke index2.php setelah berhasil update
        header("Location: index2.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Menutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kamar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f7ff;
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
            width: 90%;
            margin: auto;
            padding-top: 50px;
            text-align: center;
            margin-bottom: 30px;
        }
        h2 {
            color: #007bff;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 50%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label, input, textarea {
            width: 100%;
            margin-bottom: 10px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .btn-kembali {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    font-size: 16px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.btn-kembali:hover {
    background-color:#0056b3;
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
        <h2>Edit Data Kamar</h2>

        <!-- Form untuk mengedit data kamar -->
        <form action="" method="POST">
            <label>Ukuran:</label>
            <input type="text" name="ukuran" value="<?php echo $kamar['ukuran']; ?>" required>

            <label>Fasilitas:</label>
            <textarea name="fasilitas" required><?php echo $kamar['fasilitas']; ?></textarea>

            <label>Harga:</label>
            <input type="number" name="harga" value="<?php echo $kamar['harga_kamar']; ?>" required>

            <label>Kamar Mandi:</label>
            <input type="text" name="kamar_mandi" value="<?php echo $kamar['kamar_mandi']; ?>" required>

            <label>Ketersediaan:</label>
            <input type="text" name="ketersediaan" value="<?php echo $kamar['ketersediaan']; ?>" required>

            <input type="submit" value="Update Kamar">
            <br><br>
<a href="/CRUD TEST/Kamar/index2.php" class="btn-kembali">Kembali ke Data Kamar</a>

        </form>
    </div>
    
</body>
</html>
