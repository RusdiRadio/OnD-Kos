<?php
$host = "localhost";
$pengguna = "root";
$sandi = "";
$dbname = "ondkos";

$koneksi = mysqli_connect($host, $pengguna, $sandi, $dbname);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
