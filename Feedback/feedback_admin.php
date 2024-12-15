<?php
session_start(); // Start session
require_once "../koneksi.php"; // Database connection

// Process if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $id_feedback = $_POST['id_feedback'] ?? null;

        if ($_POST['action'] == 'update_status') {
            // Update feedback status
            $status = $_POST['status'] ?? null;
            if ($id_feedback && $status) {
                $stmt = $koneksi->prepare("UPDATE feedback SET status = ? WHERE id_feedback = ?");
                if ($stmt) {
                    $stmt->bind_param("si", $status, $id_feedback);
                    $stmt->execute();
                    $stmt->close();
                    $_SESSION['message'] = "Status successfully updated.";
                } else {
                    $_SESSION['message'] = "Failed to update status: " . $koneksi->error;
                }
            }
        } elseif ($_POST['action'] == 'delete_feedback') {
            // Delete feedback
            if ($id_feedback) {
                $stmt = $koneksi->prepare("DELETE FROM feedback WHERE id_feedback = ?");
                if ($stmt) {
                    $stmt->bind_param("i", $id_feedback);
                    $stmt->execute();
                    $stmt->close();
                    $_SESSION['message'] = "Feedback successfully deleted.";
                } else {
                    $_SESSION['message'] = "Failed to delete feedback: " . $koneksi->error;
                }
            }
        }
    }

    // Redirect back to this page
    header("Location: feedback_admin.php");
    exit();
}

// Query to fetch feedback data with user name
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

// Check query result
if (!$result) {
    die("Query failed: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Feedback</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        button {
            padding: 12px 25px;
            font-size: 18px;
            text-decoration: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.3);
        }

        button.update {
            background-color: #007bff;
            color: white;
        }

        button.update:hover {
            background-color: #0056b3;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.4);
        }

        button.danger {
            background-color: #dc3545;
            color: white;
        }

        button.danger:hover {
            background-color: #c82333;
            box-shadow: 0 5px 8px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>
<?php include '../Sidebar/admin.php'; ?> <!-- Memuat Sidebar -->

<body>
    <div class="content">
        <div class="container">
            <h2>KELOLA FEEDBACK </h2>

            <!-- Show success message -->
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
                    <th>User Name</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
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
                                    <button type="button" class="danger" onclick="confirmDelete('delete-form-<?= $row['id_feedback']; ?>')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No feedback data found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <script>
        function confirmUpdate(formId) {
            Swal.fire({
                title: 'Confirm Update',
                text: "Are you sure you want to update the feedback status?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Update',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function confirmDelete(formId) {
            Swal.fire({
                title: 'Confirm Deletion',
                text: "Are you sure you want to delete this feedback?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
</body>
</html>
