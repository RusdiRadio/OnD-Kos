<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback_id = $_POST['feedback_id'];
    $status = $_POST['status'];

    // Query untuk memperbarui status feedback
    $stmt = $mysqli->prepare("UPDATE feedback SET status = ? WHERE feedback_id = ?");
    $stmt->bind_param("si", $status, $feedback_id);
    $stmt->execute();
    $stmt->close();

    echo "Status feedback berhasil diperbarui.";
}
?>

<form method="post">
    Feedback ID: <input type="text" name="feedback_id" required><br>
    Status: 
    <select name="status">
        <option value="pending">Pending</option>
        <option value="resolved">Resolved</option>
        <option value="closed">Closed</option>
    </select><br>
    <button type="submit">Perbarui Status</button>
</form>

