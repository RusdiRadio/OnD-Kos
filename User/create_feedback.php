<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $feedback_text = $_POST['feedback_text'];

    // Query untuk menyimpan feedback ke database
    $stmt = $mysqli->prepare("INSERT INTO feedback (customer_id, feedback_text) VALUES (?, ?)");
    $stmt->bind_param("is", $customer_id, $feedback_text);
    $stmt->execute();
    $stmt->close();

    echo "Feedback berhasil ditambahkan.";
}
?>

<form method="post">
    Customer ID: <input type="text" name="customer_id" required><br>
    Feedback: <textarea name="feedback_text" required></textarea><br>
    <button type="submit">Kirim Feedback</button>
</form>
