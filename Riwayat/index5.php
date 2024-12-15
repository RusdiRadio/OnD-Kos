<?php
// Sambungkan ke file koneksi menggunakan require
require '../koneksi.php';

// Query untuk mengambil data dari tabel riwayat_penghuni
$query = "SELECT * FROM riwayat_penghuni";
$result = mysqli_query($koneksi, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penghuni</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
        }

        .content {
            margin-left: 280px; /* Lebar sidebar sedikit diperbesar */
            padding: 30px; /* Padding lebih besar */
            flex-grow: 1;
            min-height: 100vh;
            background-color: #ffffff;
            box-shadow: -3px 0 6px rgba(0, 0, 0, 0.15);
        }

        .container {
            width: 96%; /* Lebih luas sedikit */
            max-width: 1300px; /* Lebar maksimum diperbesar */
            margin: auto;
            padding: 30px; /* Padding lebih besar */
        }

        .container h2 {
            color: #007bff;
            text-align: left;
            margin-bottom: 25px; /* Spasi bawah lebih besar */
            font-size: 28px; /* Ukuran font lebih besar */
            border-bottom: 3px solid #007bff; /* Garis bawah lebih tebal */
            padding-bottom: 15px; /* Padding bawah lebih besar */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px; /* Jarak atas tabel diperbesar */
            background-color: #ffffff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15); /* Efek elevasi lebih kuat */
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px 20px; /* Padding lebih luas */
            text-align: left;
            font-size: 16px; /* Ukuran font lebih besar */
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        td a {
            text-decoration: none;
            color: #007bff;
            padding: 8px 12px; /* Padding lebih besar */
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 15px; /* Ukuran font diperbesar */
        }

        td a:hover {
            background-color: #0056b3;
            color: white;
        }

        /* Pop-up form styling */
        #popupForm {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid #ccc;
            padding: 20px;
            z-index: 1000;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
        }

        #popupForm h3 {
            margin-bottom: 15px;
            color: #007bff;
            text-align: center;
        }

        #popupForm label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        #popupForm input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        #popupForm button {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #popupForm button[type="button"] {
            background-color: #dc3545;
        }

        #popupForm button:hover {
            background-color: #218838;
        }

        #popupForm button[type="button"]:hover {
            background-color: #c82333;
        }

        .inactive {
            color: rgb(147, 147, 147);
        }

        /* Overlay styling */
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Menampilkan overlay dan popup saat form aktif */
        #popupForm.show, #overlay.show {
            display: block;
        }

    </style>
    <script>
        function confirmKeluarkan(form) {
            return confirm("Apakah Anda yakin ingin mengeluarkan penghuni ini?");
        }

        function openForm() {
            document.getElementById('popupForm').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closeForm() {
            document.getElementById('popupForm').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</head>
<body>
<?php include '../Sidebar/admin.php'; ?>

    <div class="content">
        <div class="container">
            <h2>RIWAYAT</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Riwayat</th>
                        <th>ID Penghuni</th>
                        <th>ID Kamar</th>
                        <th>Nama</th>
                        <th>Pekerjaan</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                        <th>Status Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_riwayat'] . "</td>";
                            echo "<td>" . $row['id_penghuni'] . "</td>";
                            echo "<td>" . $row['id_kamar'] . "</td>";
                            echo "<td>" . $row['nama'] . "</td>";
                            echo "<td>" . $row['pekerjaan'] . "</td>";
                            echo "<td>" . $row['tanggal_masuk'] . "</td>";
                            echo "<td>" . $row['tanggal_keluar'] . "</td>";
                            echo "<td>" . $row['status_keluar'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Tidak ada data tersedia</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
