<?php
session_start();
include('dbconfig.php');

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = $_GET['id'];

    
    $count_query = "SELECT COUNT(*) as total_comments FROM comments WHERE id = ?";
    $count_stmt = $con->prepare($count_query);
    $count_stmt->bind_param("i", $post_id);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $count_row = $count_result->fetch_assoc();
    $total_comments = $count_row['total_comments'];

    
    $query = "SELECT * FROM comments WHERE id = ? ORDER BY comment_date DESC";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comments</title>
    <style>
    /* Real-World App Layout */
    body {
        background-color: #f0f2f5; /* Standard background for modern social/dev apps */
        background-image: none; /* Removed for a cleaner professional look */
        color: #1c1e21;
        margin: 0;
        padding: 0;
        font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    /* Fixed Top Badge */
    .comment-count {
        position: sticky;
        top: 0;
        width: 100%;
        max-width: 650px;
        background-color: #fff;
        padding: 12px 20px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: flex-start;
        font-weight: 600;
        font-size: 15px;
        color: #65676b;
        z-index: 100;
        margin-bottom: 20px;
        box-sizing: border-box;
    }

    /* Comment Section Container */
    .comments-section {
        width: 95%;
        max-width: 650px;
        padding: 0 10px;
    }

    /* Clean Card Design */
    .comment {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        border: 1px solid #dddfe2;
    }

    .comment p {
        margin: 0 0 8px 0;
        font-size: 15px;
        line-height: 1.4;
    }

    /* Author Name Blue */
    .comment p b {
        color: #1877f2;
        font-weight: 700;
    }

    /* Timestamp style */
    .comment small {
        color: #65676b;
        font-size: 12px;
        display: block;
        margin-bottom: 12px;
    }

    /* Professional Button Group */
    .btn {
        font-weight: 600;
        font-size: 13px;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        transition: background 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-warning {
        background-color: #e4e6eb;
        color: #050505;
        margin-right: 5px;
    }

    .btn-warning:hover {
        background-color: #d8dadf;
    }

    .btn-danger {
        background-color: #fee7e9;
        color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #fbd5d8;
    }

    .btn-primary {
        background-color: #1877f2;
        color: #fff;
        font-size: 14px;
        padding: 8px 20px;
        margin-right: 8px;
    }

    .btn-primary:hover {
        background-color: #166fe5;
    }

    /* Bottom Input Box */
    form {
        width: 95%;
        max-width: 650px;
        background-color: #ffffff;
        padding: 20px;
        margin: 20px 0 40px 0;
        border-radius: 8px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        border: 1px solid #dddfe2;
        box-sizing: border-box;
    }

    textarea {
        width: 100%;
        min-height: 80px;
        border: 1px solid #ccd0d5;
        background-color: #f0f2f5;
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 12px;
        font-family: inherit;
        font-size: 15px;
        box-sizing: border-box;
        resize: vertical;
        outline: none;
    }

    textarea:focus {
        border-color: #1877f2;
        background-color: #fff;
    }
</style>
</head>
<body>

    
    <div class="comment-count">
    <img src="m2.png" alt="Comments Icon" style="width: 20px; height: 20px; margin-right: 5px;">

        <?php echo $total_comments. "-comments"; ?>
    </div>

    
    <div class="comments-section">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="comment">
                    <p><b><?php echo htmlspecialchars($row['auther']); ?>:</b> <?php echo htmlspecialchars($row['comment']); ?></p>
                    <p><small><?php echo date('jS M Y H:i:s', strtotime($row['comment_date'])); ?></small></p>

                    <?php 
                    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : null; 
                    if ($_SESSION['username'] == $row['auther'] || $user_role == 'President') { ?>
                        <a href="edit-comment.php?cid=<?php echo $row['cid']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete-comment.php?cid=<?php echo $row['cid']; ?>&id=<?php echo $post_id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?');">Delete</a>
                    <?php } ?>
                </div>
                <?php
            }
        } else {
            echo '<p style="color:black;">No comments yet.</p>';
        }
        ?>
    </div>

    
    <form action="add-comment.php" method="post">
        <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($post_id); ?>">
        <textarea name="comment" placeholder="Comment here.." required></textarea><br>
        <button type="submit" class="btn btn-primary btn-sm">Submit Comment</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="window.history.back();">Cancel</button>
    </form>

</body>
</html>
