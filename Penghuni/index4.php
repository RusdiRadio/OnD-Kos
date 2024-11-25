<?php
    session_start();

    // Cek apakah pengguna sudah login dan role-nya admin
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
        header("Location: login.php");
        exit;
    }

    // Koneksi ke database
    require_once "../koneksi.php";

    // Query untuk mengambil data dari tabel penghuni
    $sql = "SELECT id_penghuni, nama, pekerjaan, id_kamar, id_user FROM penghuni";
    $result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penghuni</title>
    <style>
        /* Pertahankan semua style Anda */
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
            margin-bottom: 30px;
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
            margin-top: 20px;
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
            margin-top: 20px;
        }
        /* Tambahkan style untuk baris yang sudah kosong */
        .inactive {
            color: grey;
        }
    </style>
    <script>
    function confirmKeluarkan(form) {
        return confirm("Apakah Anda yakin ingin mengeluarkan penghuni ini?");
    }
</script>

</head>
<body>

    <div class="navbar">
        <h1>OnD-Kos</h1>
        <div class="menu-bar">
        <a href="/OnDKos/Kamar/index2.php">Kelola Kamar</a>
            <a href="/OnDKos/User/index3.php">Kelola User</a>
            <a href="/OnDKos/Penghuni/index4.php">Kelola Penghuni</a>
            <a href="/OnDKos/Grafik/grafik.php">Pemasukan</a>
            <a href="/OnDKos/Riwayat/index5.php">Riwayat Penghuni</a>
        </div>
        <a href="/OnDKos/Login/logout.php" class="logout">Logout</a>
    </div>

    <div class="container">
        <h2>Daftar Penghuni</h2>

        <!-- Tabel untuk menampilkan daftar penghuni -->
        <table>
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
            <tbody>
                <?php
                // Periksa apakah ada data penghuni
                if (mysqli_num_rows($result) > 0) {
                    // Looping untuk menampilkan setiap baris data
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rowClass = $row['id_kamar'] == 0 ? 'inactive' : ''; // Kondisi untuk mengatur kelas
                        echo "<tr class='$rowClass'>";
                        echo "<td>" . $row['id_penghuni'] . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td>" . $row['pekerjaan'] . "</td>";
                        echo "<td>Kamar " . $row['id_kamar'] . "</td>";
                        echo "<td>" . $row['id_user'] . "</td>";
                        echo "<td>
                            <a href='editPenghuni.php?id_user=" . $row['id_user'] . "'>Edit</a> | 
                            <a href='deletePenghuni.php?id_user=" . $row['id_user'] . "'>Delete</a> | 
                            <form action='/OnDKos/Riwayat/riwayat.php' method='POST' style='display:inline;' onsubmit='return confirmKeluarkan(this);'>
                                <input type='hidden' name='id_penghuni' value='" . $row['id_penghuni'] . "'>
                                <input type='hidden' name='id_kamar' value='" . $row['id_kamar'] . "'>
                                <input type='hidden' name='nama' value='" . $row['nama'] . "'>
                                <input type='hidden' name='pekerjaan' value='" . $row['pekerjaan'] . "'>
                                <button type='submit' name='keluarkan_penghuni' style='color:red; border:none; background:none; cursor:pointer;'>Keluarkan</button>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada data ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Tombol Tambah Data Penghuni Baru -->
        <a href="createPenghuni.php" class="btn-tambah">Tambah Data Penghuni Baru</a>

        <!-- Tombol Kembali ke Dashboard -->
        <a href="/OnDKos/Login/dashboardadmin.php" class="btn-dashboard">Kembali ke Dashboard</a>
    </div>

</body>
</html>
