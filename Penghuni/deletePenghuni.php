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

// Proses penghapusan jika dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Query untuk menghapus data penghuni
    $sql = "DELETE FROM penghuni WHERE id_user='$id_user'";
    
    if (mysqli_query($koneksi, $sql)) {
        echo "Data berhasil dihapus. <a href='index4.php'>Kembali ke Daftar Penghuni</a>";
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
    <title>Hapus Penghuni</title>
</head>
<body>

<h1>Hapus Penghuni</h1>

<p>Apakah Anda yakin ingin menghapus data penghuni berikut?</p>
<p><strong>Nama:</strong> <?php echo htmlspecialchars($row['nama']); ?></p>
<p><strong>Pekerjaan:</strong> <?php echo htmlspecialchars($row['pekerjaan']); ?></p>
<p><strong>Kamar:</strong> Kamar <?php echo htmlspecialchars($row['id_kamar']); ?></p>

<!-- Form konfirmasi hapus -->
<form method="post" action="">
    <input type="submit" value="Hapus Data">
</form>

<a href="index4.php">Kembali ke Daftar Penghuni</a>

</body>
</html>
