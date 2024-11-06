<?php
// Koneksi ke database
require_once "../koneksi.php";

// Query untuk mengambil data dari tabel penghuni
$sql = "SELECT id_penghuni, nama, pekerjaan, id_kamar, id_laporan_p, id_transaksi, id_riwayat, id_user FROM penghuni";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penghuni</title>
</head>
<body>

<h1>Daftar Penghuni</h1>

<!-- Tabel untuk menampilkan daftar penghuni -->
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID Penghuni</th>
            <th>Nama</th>
            <th>Pekerjaan</th>
            <th>Kamar</th>
            <th>User ID</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
        <?php
        // Periksa apakah ada data penghuni
        if (mysqli_num_rows($result) > 0) {
            // Looping untuk menampilkan setiap baris data
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id_penghuni'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td>" . $row['pekerjaan'] . "</td>";
                echo "<td>Kamar " . $row['id_kamar'] . "</td>";
                echo "<td>" . $row['id_user'] . "</td>";
                echo "<td>
                <a href='editPenghuni.php?id_user=" . $row['id_user'] . "'>Edit</a>
                <a href='deletePenghuni.php?id_user=" . $row['id_user'] . "'>Delete</a>
                </<td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada data ditemukan</td></tr>";
        }
        ?>
    </tbody>
</table>
<a href="createPenghuni.php">Tambah Data Penghuni Baru</a>  <a href="/CRUD TEST/Login/dashboardadmin.php" >Kembali ke Dashboard</a>
</body>
</html>
