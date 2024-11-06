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
</head>
<body>

<h1>Edit Data Penghuni</h1>

<!-- Form untuk mengedit data penghuni -->
<form method="post" action="">
    <label for="nama">Nama:</label><br>
    <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required><br><br>
    
    <label for="pekerjaan">Pekerjaan:</label><br>
    <input type="text" id="pekerjaan" name="pekerjaan" value="<?php echo htmlspecialchars($row['pekerjaan']); ?>" required><br><br>
    
    <label for="id_kamar">ID Kamar:</label><br>
    <input type="text" id="id_kamar" name="id_kamar" value="<?php echo htmlspecialchars($row['id_kamar']); ?>" required><br><br>
    
    <input type="submit" value="Simpan Perubahan">
</form>

<a href="index4.php">Kembali ke Daftar Penghuni</a>

</body>
</html>
