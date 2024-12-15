<?php
require_once "../koneksi.php";

// Pastikan ada data yang dikirim dan ID user valid
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Query untuk menghapus data penghuni berdasarkan ID user
    $sql = "DELETE FROM penghuni WHERE id_user='$id_user'";

    if (mysqli_query($koneksi, $sql)) {
        // Redirect ke index4.php setelah berhasil menghapus data
        header("Location: index4.php");
        exit; // Pastikan eksekusi script dihentikan setelah redirect
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "ID User tidak ditemukan!";
}
?>
