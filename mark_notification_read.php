<?php
include 'dbconfig.php';

if (isset($_POST['notification_id'])) {
    $notification_id = $_POST['notification_id'];

    
    $stmt = $con->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();
}
?>
