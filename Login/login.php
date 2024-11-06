<?php
session_start();
require '../koneksi.php'; // Memanggil koneksi database

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query untuk cek username di daftar_user dan ambil data level_user
    $query = "SELECT daftar_user.*, level_user.keterangan 
              FROM daftar_user 
              JOIN level_user ON daftar_user.id_level = level_user.id_level 
              WHERE daftar_user.username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Verifikasi password (tanpa hashing)
        if ($password === $row['password']) { // Ganti password_verify dengan pembandingan biasa
            // Set session untuk user
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['keterangan']; // role diambil dari 'keterangan' di level_user

            // Redirect sesuai role
            if ($row['keterangan'] === 'Admin') {
                echo "Redirecting to admin dashboard...";
                header("Location: dashboardadmin.php");
                exit;
            } else {
                echo "Redirecting to user dashboard...";
                header("Location: dashboarduser.php");
                exit;
            }
            
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Gaya tampilan */
        .login-box {
            width: 300px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.2);
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?= $error; ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" name="login" value="Login">
        </form>
    </div>
</body>
</html>
