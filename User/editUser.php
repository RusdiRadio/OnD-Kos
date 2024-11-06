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
        header("Location: index3.php"); // Redirect ke halaman daftar user setelah update berhasil
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
</head>
<body>
    <h1>Edit User</h1>
    
    <form action="" method="POST">
        <label for="user_email">Email:</label><br>
        <input type="email" name="user_email" value="<?php echo $user_email; ?>" required><br><br>

        <label for="nama_user">Nama:</label><br>
        <input type="text" name="nama_user" value="<?php echo $nama_user; ?>" required><br><br>

        <label for="alamat_user">Alamat:</label><br>
        <input type="text" name="alamat_user" value="<?php echo $alamat_user; ?>" required><br><br>

        <label for="no_hp">No HP:</label><br>
        <input type="text" name="no_hp" value="<?php echo $no_hp; ?>" required><br><br>

        <label for="id_level">ID Level:</label><br>
        <input type="number" name="id_level" value="<?php echo $id_level; ?>" required><br><br>

        <input type="submit" name="update" value="Update">
    </form>

    <a href="daftarUser.php">Kembali ke Daftar User</a>
</body>
</html>
