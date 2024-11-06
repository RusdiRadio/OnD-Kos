<?php
require_once '../koneksi.php';
$id = $_GET['id_user'];

$sql = "DELETE FROM daftar_user WHERE id_user = '$id'";
$query = mysqli_query($koneksi, $sql);
if($query){
    header("Location: index3.php");
}