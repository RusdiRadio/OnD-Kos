<?php
require_once "../koneksi.php";

// Mengecek apakah ID user sudah dikirim melalui URL
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Query untuk mengambil data user berdasarkan ID
    $sql = "SELECT * FROM daftar_user WHERE id_user = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Jika data ditemukan
    if ($row = mysqli_fetch_assoc($result)) {
        $user_email = $row['user_email'];
        $nama_user = $row['nama_user'];
        $alamat_user = $row['alamat_user'];
        $no_hp = $row['no_hp'];
        $id_level = $row['id_level'];
    } else {
        echo "User tidak ditemukan!";
        exit;
    }
} else {
    echo "ID user tidak ditemukan!";
    exit;
}

// Mengecek apakah form telah disubmit
if (isset($_POST['update'])) {
    $user_email = $_POST['user_email'];
    $nama_user = $_POST['nama_user'];
    $alamat_user = $_POST['alamat_user'];
    $no_hp = $_POST['no_hp'];
    $id_level = $_POST['id_level'];

    // Query untuk update data user
    $sql = "UPDATE daftar_user SET user_email = ?, nama_user = ?, alamat_user = ?, no_hp = ?, id_level = ? WHERE id_user = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ssssii", $user_email, $nama_user, $alamat_user, $no_hp, $id_level, $id_user);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "Data berhasil diperbarui!";
        header("Location: index3.php");
        exit;
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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
            width: 50%; /* Lebih kecil */
            margin: auto;
            padding-top: 50px;
            text-align: center;
        }
        .container h2 {
            color: #007bff;
        }
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color:  #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        button {
            background-color:  #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>OnD-Kos</h1>
        <div class="menu-bar">
            <a href="/CRUD TEST/Kamar/index2.php">Kelola Kamar</a>
            <a href="/CRUD TEST/User/index3.php">Kelola User</a>
            <a href="/CRUD TEST/Penghuni/index4.php">Kelola Penghuni</a>
            <a href="/CRUD TEST/Grafik/grafik.php">Pemasukan</a>
            <a href="/CRUD TEST/Riwayat/index5.php">Riwayat Penghuni</a>
        </div>
        <a href="/CRUD TEST/Login/logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
        <h2>Edit User</h2>
        
        <form action="" method="POST">
            <label for="user_email">Email:</label>
            <input type="email" name="user_email" value="<?php echo $user_email; ?>" required>

            <label for="nama_user">Nama:</label>
            <input type="text" name="nama_user" value="<?php echo $nama_user; ?>" required>

            <label for="alamat_user">Alamat:</label>
            <input type="text" name="alamat_user" value="<?php echo $alamat_user; ?>" required>

            <label for="no_hp">No HP:</label>
            <input type="text" name="no_hp" value="<?php echo $no_hp; ?>" required>

            <label for="id_level">ID Level:</label>
            <input type="number" name="id_level" value="<?php echo $id_level; ?>" required>

            <input type="submit" name="update" value="Update">
        </form>

        <form action="index3.php">
            <button type="submit">Kembali ke Daftar User</button>
        </form>
    </div>
</body>
</html>
