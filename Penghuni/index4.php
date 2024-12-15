<?php
session_start();

// Cek apakah pengguna sudah login dan role-nya admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header("Location: /OnDKos/Login/login.php");
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

        .btn-tambah {
            padding: 12px 25px; /* Padding lebih besar */
            text-decoration: none;
            font-size: 18px; /* Ukuran font lebih besar */
            border-radius: 6px;
            background-color: #28a745;
            color: white;
            margin-top: 25px; /* Jarak atas lebih besar */
            display: inline-block;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3); /* Shadow diperbesar */
            transition: all 0.3s ease;
        }

        .btn-tambah:hover {
            background-color: #218838;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.4);
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

        function openDeleteConfirmation(id_user) {
            var confirmation = confirm("Apakah Anda yakin ingin menghapus data penghuni ini?");
            if (confirmation) {
                window.location.href = "deletePenghuni.php?id_user=" + id_user;
            }
        }
    </script>
</head>
<body>
<?php include '../Sidebar/admin.php'; ?>

    <div class="content">
        <div class="container">
            <h2>DAFTAR PENGHUNI</h2>
            <a href="#" class="btn-tambah" onclick="openForm()">Tambah Data Penghuni Baru</a>
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
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $rowClass = $row['id_kamar'] == 0 ? 'inactive' : '';
                            echo "<tr class='$rowClass'>";
                            echo "<td>" . $row['id_penghuni'] . "</td>";
                            echo "<td>" . $row['nama'] . "</td>";
                            echo "<td>" . $row['pekerjaan'] . "</td>";
                            echo "<td>Kamar " . $row['id_kamar'] . "</td>";
                            echo "<td>" . $row['id_user'] . "</td>";
                            echo "<td>
                                <a href='editPenghuni.php?id_user=" . $row['id_user'] . "'>Edit</a> | 
                                <a href='javascript:void(0);' onclick='openDeleteConfirmation(" . $row['id_user'] . ")'>Delete</a> | 
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
                        echo "<tr><td colspan='6'>Tidak ada data penghuni</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pop-up form -->
    <div id="popupForm">
        <h3>Tambah Penghuni Baru</h3>
        <form action="tambahPenghuni.php" method="POST">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" required>
            <label for="pekerjaan">Pekerjaan</label>
            <input type="text" id="pekerjaan" name="pekerjaan" required>
            <label for="kamar">ID Kamar</label>
            <input type="text" id="kamar" name="kamar" required>
            <label for="user_id">ID User</label>
            <input type="text" id="user_id" name="user_id" required>
            <button type="submit">Simpan</button>
            <button type="button" onclick="closeForm()">Batal</button>
        </form>
    </div>

    <!-- Overlay -->
    <div id="overlay"></div>
</body>
</html>
