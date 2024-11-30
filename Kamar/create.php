<?php
// Menghubungkan ke database
require_once "../koneksi.php";

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $ukuran = $_POST['ukuran'];
    $fasilitas = $_POST['fasilitas'];
    $harga = $_POST['harga'];
    $kamarmandi = $_POST['kamar_mandi'];
    $ketersediaan = $_POST['ketersediaan'];
   
    
    // Query untuk menambahkan data ke tabel kamar
    $sql = "INSERT INTO kamar (ukuran, fasilitas, harga_kamar, kamar_mandi, ketersediaan) VALUES ('$ukuran', '$fasilitas', '$harga', '$kamarmandi', '$ketersediaan')";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        // Jika berhasil, kembali ke index2.php
        header("Location: index2.php");
        exit();
    } else {
        // Jika terjadi error, tampilkan error
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// Menutup koneksi database
mysqli_close($koneksi);
?>
