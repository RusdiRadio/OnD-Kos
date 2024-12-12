<?php
include('koneksi.php');

$result = $mysqli->query("SELECT * FROM feedback");

while ($row = $result->fetch_assoc()) {
    echo "Feedback ID: " . $row['feedback_id'] . "<br>";
    echo "Customer ID: " . $row['customer_id'] . "<br>";
    echo "Feedback: " . $row['feedback_text'] . "<br>";
    echo "Status: " . $row['status'] . "<br>";
    echo "Tanggal Dibuat: " . $row['created_at'] . "<br><br>";
}
?>

