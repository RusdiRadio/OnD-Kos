<?php
session_start();

// Cek apakah pengguna sudah login dan role-nya admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke database
require_once "../koneksi.php";

// Ambil username dari sesi
$username = $_SESSION['username'];

// Query untuk mendapatkan nama_user berdasarkan username
$sql = "SELECT nama_user FROM daftar_user WHERE username = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $nama_user = $row['nama_user'];
} else {
    $nama_user = $username;
}

// Tutup statement untuk username
mysqli_stmt_close($stmt);

// Query untuk mengambil semua data dari tabel daftar_user
$sql_users = "SELECT id_user, user_email, nama_user, alamat_user, no_hp, id_level FROM daftar_user";
$query_users = mysqli_query($koneksi, $sql_users);

if (!$query_users) {
    die("Query gagal: " . mysqli_error($koneksi));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f7ff;
        }
        .navbar {
            background-color: #007bff;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }
        .menu-bar {
            display: flex;
            gap: 15px;
        }
        .menu-bar a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .menu-bar a:hover {
            background-color: #0056b3;
        }
        .logout {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .logout:hover {
            background-color: #c82333;
        }
        .container {
            width: 90%;
            margin: auto;
            padding-top: 50px;
            text-align: center;
        }
        .container h2 {
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        td a {
            text-decoration: none;
            color: #007bff;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        td a:hover {
            background-color: #0056b3;
            color: white;
        }
        .container {
    width: 90%;
    margin: auto;
    padding-top: 50px;
    text-align: center;
    margin-bottom: 30px; /* Menambahkan jarak bawah pada container */
}

.btn-tambah {
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    font-size: 16px;
    border-radius: 5px;
    transition: background-color 0.3s, transform 0.3s;
    display: inline-block;
    margin-right: 20px;
    margin-top: 20px; /* Menambahkan jarak atas */
}

.btn-dashboard {
    background-color: #17a2b8;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    font-size: 16px;
    border-radius: 5px;
    transition: background-color 0.3s, transform 0.3s;
    display: inline-block;
    margin-top: 20px; /* Menambahkan jarak atas */
}

    </style>
</head>
<body>

    <div class="navbar">
        <h1>OnD-Kos</h1>
        <div class="menu-bar">
            <a href="/CRUD TEST/Kamar/index2.php">Kelola Kamar</a>
            <a href="/CRUD TEST/User/index3.php">Kelola User</a>
            <a href="/CRUD TEST/Penghuni/index4.php">Kelola Penghuni</a>
            <a href="/CRUD TEST/Grafik/grafik.php">Pemasukan</a>
        </div>
        <a href="/CRUD TEST/Login/logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
        <h2>Daftar User</h2>

        <table>
            <thead>
                <tr>
                    <th>ID User</th>
                    <th>Email</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>ID Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop melalui hasil query dan tampilkan di tabel
                if (mysqli_num_rows($query_users) > 0) {
                    while ($row = mysqli_fetch_assoc($query_users)) {
                        echo "<tr>";
                        echo "<td>" . $row['id_user'] . "</td>";
                        echo "<td>" . $row['user_email'] . "</td>";
                        echo "<td>" . $row['nama_user'] . "</td>";
                        echo "<td>" . $row['alamat_user'] . "</td>";
                        echo "<td>" . $row['no_hp'] . "</td>";
                        echo "<td>" . $row['id_level'] . "</td>";
                        echo "<td>
                            <a href='editUser.php?id_user=" . $row['id_user'] . "'>Edit</a> |
                            <a href='deleteUser.php?id_user=" . $row['id_user'] . "'>Delete</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- Tombol Tambah Data User Baru -->
<a href="createUser.php" class="btn-tambah">Tambah Data User Baru</a>

<!-- Tombol Kembali ke Dashboard -->
<a href="/CRUD TEST/Login/dashboardadmin.php" class="btn-dashboard">Kembali ke Dashboard</a>

    </div>
    
</body>
</html>
