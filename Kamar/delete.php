<?php
require_once '../koneksi.php';
$id = $_GET['id_kamar'];

$sql = "DELETE FROM kamar WHERE id_kamar = '$id'";
$query = mysqli_query($koneksi, $sql);
if($query){
    header("Location: index2.php");
}