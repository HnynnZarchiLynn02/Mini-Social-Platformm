<?php

session_start();


include('dbconfig.php');

if (isset($_GET['cid']) && is_numeric($_GET['cid'])) {
    $comment_id = $_GET['cid']; 
    $post_id = $_GET['id']; 

    
    $query = "DELETE FROM comments WHERE cid = ? AND (auther = ? OR ? = 'President')";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iss", $comment_id, $_SESSION['username'], $_SESSION['role']);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Comment deleted successfully'); window.location.href='comment.php?id=$post_id';</script>";
    } else {
        echo "<script>alert('Failed to delete comment'); window.location.href='comment.php?id=$post_id';</script>";
    }
} else {
    echo "<script>alert('Invalid comment ID'); window.location.href='index.php';</script>";
}
?>
