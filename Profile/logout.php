<?php
// Menginisialisasi session
session_start();

// Menghapus semua session
session_destroy();

// Mengarahkan kembali ke halaman login
header('Location: login.php');
exit();
?>
