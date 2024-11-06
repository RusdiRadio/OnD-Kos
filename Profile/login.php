<?php
// Menginisialisasi session
session_start();

// Contoh data pengguna (seharusnya disimpan dalam database)
$users = [
    ['username' => 'admin1', 'password' => '1234567'],
    ['username' => 'user', 'password' => '12345'],
];

// Mengecek apakah form telah dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mencari pengguna di dalam array
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            // Jika login berhasil, simpan username di session
            $_SESSION['username'] = $username;
            header('Location: welcome.php'); // Redirect ke halaman welcome
            exit();
        }
    }

    // Jika login gagal
    $error = "Username atau Password salah.";
}
?>