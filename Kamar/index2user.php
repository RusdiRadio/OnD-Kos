<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kamar</title>
</head>
<body>
    <h1>Daftar Kamar</h1>

    <br><br>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ukuran</th>
                <th>Fasilitas</th>
                <th>Harga</th>
                <th>Kamar Mandi</th> <!-- Kolom baru -->
                <th>Ketersediaan</th> <!-- Kolom baru -->
                
                
                
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
                    echo "<td>" . $kamar['kamar_mandi'] . "</td>"; // Menampilkan data kamar_mandi
                    echo "<td>" . $kamar['ketersediaan'] . "</td>"; // Menampilkan data id_daftar_kamar
                    
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
            }

            // Menutup koneksi database
            mysqli_close($koneksi);
            ?>
        </tbody>
    </table>
    <a href="/CRUD TEST/Login/dashboarduser.php" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Kembali ke Dashboard</a>

</body>
</html>
