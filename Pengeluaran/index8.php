<?php
session_start(); // Memulai sesi
require('../koneksi.php');

// Cek apakah pengguna sudah login dan role-nya admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header("Location: /OnDKos/Login/login.php");
    exit;
}

// Menampilkan data pengeluaran
$query = "SELECT * FROM pengeluaran";
$result = mysqli_query($koneksi, $query);

// Ambil ID User dari sesi login
$id_user = $_SESSION['id_user']; // Asumsi id_user disimpan dalam sesi
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Pengeluaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            display: flex;
        }

        .content {
            margin-left: 280px;
            padding: 30px;
            flex-grow: 1;
            min-height: 100vh;
            background-color: #ffffff;
            box-shadow: -3px 0 6px rgba(0, 0, 0, 0.15);
        }

        .container {
            width: 96%;
            max-width: 1300px;
            margin: auto;
            padding: 30px;
        }

        .container h2 {
            color: #007bff;
            text-align: left;
            margin-bottom: 25px;
            font-size: 28px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background-color: #ffffff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px 20px;
            text-align: left;
            font-size: 16px;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        td a {
            text-decoration: none;
            color: #007bff;
            padding: 8px 12px;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        td a:hover {
            background-color: #0056b3;
            color: white;
        }

        .btn-tambah {
            padding: 12px 25px;
            text-decoration: none;
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
        }

        .btn-tambah:hover {
            background-color: #218838;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.4);
        }

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
<?php include '../Sidebar/admin.php'; ?> 
<body>
    <div class="content">
        <div class="container">
            <h2>PENGELUARAN</h2>
            <button class="btn-tambah" onclick="openForm()">Tambah Pengeluaran</button>

            <table>
                <thead>
                    <tr>
                        <th>ID Pengeluaran</th>
                        <th>ID User</th>
                        <th>Jumlah Keluar</th>
                        <th>Tujuan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id_pengeluaran']; ?></td>
                            <td><?php echo $row['id_user']; ?></td>
                            <td><?php echo $row['biaya_keluar']; ?></td>
                            <td><?php echo $row['tujuan']; ?></td>
                            <td><?php echo $row['tanggal']; ?></td>
                            <td>
                                <a href="javascript:void(0);" onclick="openEditForm(<?php echo $row['id_pengeluaran']; ?>)">Edit</a> | 
                                <a href="delete_pengeluaran.php?id=<?php echo $row['id_pengeluaran']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal untuk tambah dan edit -->
<div id="popupForm" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeForm()">&times;</span>
        <h3 id="formTitle">Tambah Pengeluaran</h3>
        <!-- Form edit pengeluaran -->
        <form id="editForm" action="edit_pengeluaran.php" method="POST">
            <input type="hidden" name="id_pengeluaran" id="id_pengeluaran">
            <label for="biaya_keluar">Jumlah Keluar:</label>
            <input type="text" name="biaya_keluar" id="biaya_keluar" required><br>

            <label for="tujuan">Tujuan:</label>
            <input type="text" name="tujuan" id="tujuan" required><br>

            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" id="tanggal" required><br>

            <input type="submit" value="Simpan">
            <button type="button" onclick="closeForm()">Batal</button>
        </form>
    </div>
</div>

<script>
    function openForm() {
        document.getElementById('formTitle').innerText = "Tambah Pengeluaran";
        document.getElementById('popupForm').style.display = 'flex';
        document.getElementById('id_pengeluaran').value = ''; // Reset ID Pengeluaran
        document.getElementById('biaya_keluar').value = '';
        document.getElementById('tujuan').value = '';
        document.getElementById('tanggal').value = '';
        // Mengatur action form untuk tambah
        document.getElementById('editForm').action = "save_pengeluaran.php";
    }

    function openEditForm(id) {
        document.getElementById('formTitle').innerText = "Edit Pengeluaran";
        document.getElementById('popupForm').style.display = 'flex';
        
        // Memuat data untuk form edit
        fetch('get_pengeluaran.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('id_pengeluaran').value = data.id_pengeluaran;
                document.getElementById('biaya_keluar').value = data.biaya_keluar;
                document.getElementById('tujuan').value = data.tujuan;
                document.getElementById('tanggal').value = data.tanggal;
                // Mengatur action form untuk edit
                document.getElementById('editForm').action = "update_pengeluaran.php";
            });
    }

    function closeForm() {
        document.getElementById('popupForm').style.display = 'none';
    }
</script>

    </script>
</body>
</html>
