<?php
require_once "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $user_email = $_POST['user_email'];
    $nama_user = $_POST['nama_user'];
    $alamat_user = $_POST['alamat_user'];
    $no_hp = $_POST['no_hp'];
    $id_level = $_POST['id_level'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Query untuk insert data ke database, termasuk username dan password
    $sql = "INSERT INTO daftar_user (user_email, nama_user, alamat_user, no_hp, id_level, username, password) 
            VALUES ('$user_email', '$nama_user', '$alamat_user', '$no_hp', '$id_level', '$username', '$password')";

    // Eksekusi query
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='index3.php';</script>";
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}
?>