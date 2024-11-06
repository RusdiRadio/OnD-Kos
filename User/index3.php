<?php
require_once "../koneksi.php";

// Query untuk mengambil semua data dari tabel daftar_user
$sql = "SELECT id_user, user_email, nama_user, alamat_user, no_hp, id_level FROM daftar_user";
$query = mysqli_query($koneksi, $sql);

// Jika query gagal, tampilkan pesan error
if (!$query) {
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Daftar User</h1>

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
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $row['id_user'] . "</td>";
                    echo "<td>" . $row['user_email'] . "</td>";
                    echo "<td>" . $row['nama_user'] . "</td>";
                    echo "<td>" . $row['alamat_user'] . "</td>";
                    echo "<td>" . $row['no_hp'] . "</td>";
                    echo "<td>" . $row['id_level'] . "</td>";
                    echo "<td>
                    <a href='editUser.php?id_user=" . $row['id_user'] . "'>Edit</a>
                    <a href='deleteUser.php?id_user=" . $row['id_user'] . "'>Delete</a>
                    </<td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="createUser.php">Tambah Data User Baru</a>
    <a href="/CRUD TEST/Login/dashboardadmin.php" >Kembali ke Dashboard</a>
    
</body>
</html>
