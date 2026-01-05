<?php
session_start();
include('dbconfig.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $comment = $con->real_escape_string($_POST['comment']);
    $auther = $con->real_escape_string($_SESSION['username']);

    $query = "INSERT INTO comments (auther, id, comment, comment_date) VALUES ('$auther', $post_id, '$comment', NOW())";
    if ($con->query($query)) {
        header("Location: comment.php?id=$post_id");
        exit;
    } else {
        echo "Error: " . $con->error;
    }
}
?>
