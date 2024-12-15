<?php
include('../koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM pengeluaran WHERE id_pengeluaran = $id";

    if (mysqli_query($koneksi, $query)) {
        header('Location: index8.php');
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
