<?php
include('koneksi.php');  // Menghubungkan dengan koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback_id = $_POST['feedback_id'];

    // Query untuk menghapus feedback berdasarkan ID
    $stmt = $koneksi->prepare("DELETE FROM feedback WHERE feedback_id = ?");
    $stmt->bind_param("i", $feedback_id);
    $stmt->execute();
    $stmt->close();

    echo "Feedback berhasil dihapus.";
}
?>

<form method="post">
    Feedback ID: <input type="text" name="feedback_id" required><br>
    <button type="submit">Hapus Feedback</button>
</form>