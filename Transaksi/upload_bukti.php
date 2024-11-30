<?php
require('../koneksi.php'); // Pastikan file koneksi sudah ada dan terkoneksi dengan database.

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['bukti_pembayaran'])) {
        $target_dir = "../uploads/bukti_pembayaran/";
        $target_file = $target_dir . basename($_FILES["bukti_pembayaran"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Periksa apakah file gambar
        if (getimagesize($_FILES["bukti_pembayaran"]["tmp_name"]) !== false) {
            echo "File is an image - " . $_FILES["bukti_pembayaran"]["type"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Cek apakah file sudah ada
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Batas ukuran file (5MB)
        if ($_FILES["bukti_pembayaran"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Hanya izinkan format file gambar tertentu
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Periksa apakah $uploadOk sudah diatur ke 0 karena kesalahan
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["bukti_pembayaran"]["name"])) . " has been uploaded.";

                // Simpan nama file gambar ke database
                $filename = basename($_FILES["bukti_pembayaran"]["name"]);
                $query = "UPDATE transaksi SET bukti_pembayaran = '$filename' WHERE id_transaksi = $id_transaksi";
                if (mysqli_query($koneksi, $query)) {
                    echo "Bukti pembayaran berhasil disimpan!";
                } else {
                    echo "Gagal menyimpan bukti pembayaran ke database: " . mysqli_error($koneksi);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Pembayaran</title>
</head>
<body>
    <div>
        <h2>Unggah Bukti Pembayaran</h2>
        <form action="upload_bukti.php?id_transaksi=<?php echo $id_transaksi; ?>" method="post" enctype="multipart/form-data">
            <label for="bukti_pembayaran">Pilih file bukti pembayaran:</label>
            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" required>
            <button type="submit">Unggah Bukti Pembayaran</button>
        </form>
    </div>
</body>
</html>
