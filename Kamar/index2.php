<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kamar</title>
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
            margin-bottom: 30px;
        }
        .container h2 {
            color: #007bff;
        }
        form {
            width: 50%;
            margin: auto;
            text-align: left;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form label {
            font-size: 16px;
            color: #333;
        }
        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        form textarea {
            resize: vertical;
            height: 80px;
        }
        form input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #218838;
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
        .btn-tambah, .btn-dashboard {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-tambah {
            background-color: #28a745;
            color: white;
        }
        .btn-dashboard {
            background-color: #17a2b8;
            color: white;
        }
        .btn-tambah:hover {
            background-color: #218838;
        }
        .btn-dashboard:hover {
            background-color: #138496;
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
        <h2>Data Kamar</h2>

        <!-- Form untuk menambah data kamar -->
        <form action="create.php" method="POST">
            <label>Ukuran:</label>
            <input type="text" name="ukuran" required><br>

            <label>Fasilitas:</label>
            <textarea name="fasilitas" required></textarea><br>

            <label>Harga:</label>
            <input type="number" name="harga" required><br>

            <label>Kamar Mandi:</label>
            <input type="text" name="kamar_mandi" required><br>

            <label>Ketersediaan:</label>
            <input type="text" name="ketersediaan" required><br>

            <input type="submit" value="Tambah Kamar">
        </form>

        <br><br>

        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ukuran</th>
                    <th>Fasilitas</th>
                    <th>Harga</th>
                    <th>Kamar Mandi</th>
                    <th>Ketersediaan</th>
                    <th>Menu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menghubungkan ke database
                require_once "../koneksi.php";

                // Query untuk mendapatkan data kamar
                $sql = "SELECT * FROM kamar";
                $result = mysqli_query($koneksi, $sql);

                // Jika data tersedia, tampilkan dalam tabel
                if (mysqli_num_rows($result) > 0) {
                    while ($kamar = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $kamar['id_kamar'] . "</td>";
                        echo "<td>" . $kamar['ukuran'] . "</td>";
                        echo "<td>" . $kamar['fasilitas'] . "</td>";
                        echo "<td>" . $kamar['harga_kamar'] . "</td>";
                        echo "<td>" . $kamar['kamar_mandi'] . "</td>";
                        echo "<td>" . $kamar['ketersediaan'] . "</td>";
                        echo "<td>
                            <a href='edit.php?id_kamar=" . $kamar['id_kamar'] . "'>Edit</a> | 
                            <a href='delete.php?id_kamar=" . $kamar['id_kamar'] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Hapus</a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
                }

                // Menutup koneksi database
                mysqli_close($koneksi);
                ?>
            </tbody>
        </table>

        <!-- Tombol Kembali ke Dashboard -->
        <a href="/CRUD TEST/Login/dashboardadmin.php" class="btn-dashboard">Kembali ke Dashboard</a>
    </div>
    
</body>
</html>
