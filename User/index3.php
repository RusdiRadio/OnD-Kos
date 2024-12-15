<?php
session_start();

// Cek apakah pengguna sudah login dan role-nya admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header("Location: /OnDKos/Login/login.php");
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
        }

        td a:hover {
            background-color: #0056b3;
            color: white;
        }

        .btn-tambah, .btn-dashboard {
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 6px;
            background-color: #28a745;
            color: white;
            margin-top: 25px;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-tambah:hover, .btn-dashboard:hover {
            background-color: #218838;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.4);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            width: 85%;
            max-width: 700px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .modal-content h3 {
            color: #007bff;
            margin-bottom: 25px;
            font-size: 24px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #007bff;
        }

        form input, form textarea {
            display: block;
            width: 97%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: #f9f9f9;
        }

        form textarea {
            resize: vertical;
            height: 120px;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
<?php include '../Sidebar/admin.php'; ?> <!-- Memuat Sidebar -->
<div class="content">
    <div class="container">
        <h2>DAFTAR USER</h2>
        <!-- Tombol Tambah Data User Baru -->
        <a href="javascript:void(0);" class="btn-tambah" onclick="openModal()">Tambah Data User Baru</a>
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
                    echo "<td>";

                    // Hanya tampilkan opsi Edit dan Delete jika id_level bukan 1
                    if ($row['id_level'] != 1) {
                        echo "<a href='editUser.php?id_user=" . $row['id_user'] . "'>Edit</a> | ";
                        echo "<a href='deleteUser.php?id_user=" . $row['id_user'] . "'>Delete</a>";
                    } else {
                        echo "Tidak dapat diubah atau dihapus"; // Tidak ada aksi untuk id_level 1
                    }

                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada data</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal untuk form CRUD -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Tambah Data User Baru</h3>
        <form method="POST" action="createUser.php">
            <label for="user_email">Email:</label><br>
            <input type="email" id="user_email" name="user_email" required><br><br>
            
            <label for="nama_user">Nama:</label><br>
            <input type="text" id="nama_user" name="nama_user" required><br><br>
            
            <label for="alamat_user">Alamat:</label><br>
            <textarea id="alamat_user" name="alamat_user" required></textarea><br><br>
            
            <label for="no_hp">Nomor HP:</label><br>
            <input type="text" id="no_hp" name="no_hp" required><br><br>
            
            <label for="id_level">ID Level:</label><br>
            <input type="number" id="id_level" name="id_level" required><br><br>
            
            <input type="submit" value="Tambah User">
        </form>
    </div>
</div>

<script>
    // Fungsi untuk membuka modal
    function openModal() {
        document.getElementById("userModal").style.display = "flex";
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById("userModal").style.display = "none";
    }

    // Menutup modal jika klik di luar modal
    window.onclick = function(event) {
        if (event.target === document.getElementById("userModal")) {
            closeModal();
        }
    }
</script>
</body>
</html>
