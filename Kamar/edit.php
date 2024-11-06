<?php
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kamar</title>
</head>
<body>
    <h1>Edit Data Kamar</h1>

    <!-- Form untuk mengedit data kamar -->
    <form action="" method="POST">
        <label>Ukuran:</label>
        <input type="text" name="ukuran" value="<?php echo $kamar['ukuran']; ?>" required><br><br>

        <label>Fasilitas:</label>
        <textarea name="fasilitas" required><?php echo $kamar['fasilitas']; ?></textarea><br><br>

        <label>Harga:</label>
        <input type="number" name="harga" value="<?php echo $kamar['harga_kamar']; ?>" required><br><br>

        <label>Kamar Mandi:</label>
        <input type="text" name="kamar_mandi" value="<?php echo $kamar['kamar_mandi']; ?>" required><br><br>

        <label>Ketersediaan:</label>
        <input type="text" name="ketersediaan" value="<?php echo $kamar['ketersediaan']; ?>" required><br><br>

        <input type="submit" value="Update Kamar">
    </form>
</body>
</html>