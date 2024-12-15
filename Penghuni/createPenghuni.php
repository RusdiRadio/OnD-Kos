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

