<?php
session_start(); // Memulai sesi
require_once "../koneksi.php"; // Koneksi ke database

// Proses jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $id_feedback = $_POST['id_feedback'] ?? null;

        if ($_POST['action'] == 'update_status') {
            // Update status feedback
            $status = $_POST['status'] ?? null;
            if ($id_feedback && $status) {
                $stmt = $koneksi->prepare("UPDATE feedback SET status = ? WHERE id_feedback = ?");
                if ($stmt) {
                    $stmt->bind_param("si", $status, $id_feedback);
                    $stmt->execute();
                    $stmt->close();
                    $_SESSION['message'] = "Status berhasil diperbarui.";
                } else {
                    $_SESSION['message'] = "Gagal memperbarui status: " . $koneksi->error;
                }
            }
        } elseif ($_POST['action'] == 'delete_feedback') {
            // Hapus feedback
            if ($id_feedback) {
                $stmt = $koneksi->prepare("DELETE FROM feedback WHERE id_feedback = ?");
                if ($stmt) {
                    $stmt->bind_param("i", $id_feedback);
                    $stmt->execute();
                    $stmt->close();
                    $_SESSION['message'] = "Feedback berhasil dihapus.";
                } else {
                    $_SESSION['message'] = "Gagal menghapus feedback: " . $koneksi->error;
                }
            }
        }
    }

    // Redirect kembali ke halaman ini
    header("Location: admin_feedback.php");
    exit();
}

// Query untuk mengambil data feedback dengan nama pengguna
$query = "
    SELECT 
        feedback.id_feedback, 
        daftar_user.user_email AS nama_user, 
        feedback.subjek, 
        feedback.pesan, 
        feedback.tanggal, 
        feedback.status 
    FROM feedback
    JOIN daftar_user ON feedback.id_user = daftar_user.id_user
    WHERE daftar_user.id_level = 2;
";
$result = mysqli_query($koneksi, $query);

// Periksa hasil query
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Feedback</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f7ff;
            display: flex;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #007bff;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: white;
        }

        .menu-bar {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu-bar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .menu-bar a:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .menu-bar a:active {
            transform: scale(0.95);
        }

        .content {
            margin-left: 260px;
            padding: 20px;
            flex-grow: 1;
            width: calc(100% - 260px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button.update {
            background-color: #007bff;
        }

        button.danger {
            background-color: #dc3545;
        }/* Tambahkan style yang sama */
    </style>
</head>
<body>
    <div class="sidebar">
        <?php include '../Sidebar/admin.php'; ?>
    </div>
    <div class="content">
        <h2>Daftar Feedback dan Komplain</h2>

        <!-- Tampilkan pesan sukses -->
        <?php if (isset($_SESSION['message'])): ?>
            <script>
                Swal.fire({
                    title: 'Info',
                    text: "<?= $_SESSION['message']; ?>",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID Feedback</th>
                <th>Nama Pengguna</th>
                <th>Subjek</th>
                <th>Pesan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['id_feedback']; ?></td>
                        <td><?= $row['nama_user']; ?></td>
                        <td><?= $row['subjek']; ?></td>
                        <td><?= $row['pesan']; ?></td>
                        <td><?= $row['tanggal']; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td>
                            <form method="POST" id="update-form-<?= $row['id_feedback']; ?>" style="display:inline-block;">
                                <input type="hidden" name="id_feedback" value="<?= $row['id_feedback']; ?>">
                                <input type="hidden" name="action" value="update_status">
                                <select name="status">
                                    <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="resolved" <?= $row['status'] === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                    <option value="closed" <?= $row['status'] === 'closed' ? 'selected' : ''; ?>>Closed</option>
                                </select>
                                <button type="button" class="update" onclick="confirmUpdate('update-form-<?= $row['id_feedback']; ?>')">Update</button>
                            </form>

                            <form method="POST" id="delete-form-<?= $row['id_feedback']; ?>" style="display:inline-block;">
                                <input type="hidden" name="id_feedback" value="<?= $row['id_feedback']; ?>">
                                <input type="hidden" name="action" value="delete_feedback">
                                <button type="button" class="danger" onclick="confirmDelete('delete-form-<?= $row['id_feedback']; ?>')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Tidak ada data feedback ditemukan.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <script>
        function confirmUpdate(formId) {
            Swal.fire({
                title: 'Konfirmasi Update',
                text: "Apakah Anda yakin ingin memperbarui status feedback ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Update',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function confirmDelete(formId) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus feedback ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
</body>
</html>
