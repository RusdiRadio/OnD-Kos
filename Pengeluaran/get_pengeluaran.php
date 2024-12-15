<?php
require('../koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM pengeluaran WHERE id_pengeluaran = $id";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
    echo json_encode($data);
}
?>
