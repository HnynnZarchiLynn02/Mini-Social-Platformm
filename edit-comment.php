<?php
session_start();
include 'dbconfig.php';

if (isset($_GET['cid']) && isset($_SESSION['username'])) {
    $comment_id = intval($_GET['cid']);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $new_comment = $_POST['comment'];
        $post_id = intval($_POST['cid']);
        
        $update_query = "UPDATE comments SET comment = ? WHERE cid = ? AND auther = ?";
        if ($update_stmt = $con->prepare($update_query)) {
            $update_stmt->bind_param("sis", $new_comment, $comment_id, $_SESSION['username']);
            $update_stmt->execute();
            
            if ($update_stmt->affected_rows > 0) {
                echo "<script>alert('Comment updated successfully'); javascript:history.back();</script>";
            } else {
                echo "<script>alert('Failed to update comment'); javascript:history.back();</script>";
            }
            $update_stmt->close();
         
        }
    } else {
        $query = "SELECT comment FROM comments WHERE cid = ? AND auther = ?";
        if ($stmt = $con->prepare($query)) {
            $stmt->bind_param("is", $comment_id, $_SESSION['username']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>

                <form action="edit-comment.php?cid=<?php echo $comment_id; ?>" method="post">
                    <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($_GET['cid']); ?>">
                    <textarea name="comment" required><?php echo htmlspecialchars($row['comment']); ?></textarea>
                    <button type="submit" class="btn btn-primary btn-sm">Update Comment</button>
                    <a href='javascript:history.back()' class="btn btn-secondary btn-sm">Back</a>
                </form>

                <?php
            } else {
                echo "<script>alert('Comment not found'); window.location.href='index.php';</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Failed to prepare statement'); window.location.href='index.php';</script>";
        }
    }
}
?>

<style>
    body {
        background-image: url('u2.jpg');
        background-size: cover;
        background-position: center;
        font-family: 'Times New Roman', Times, serif;
        font-size: 18px;
        color: #fff;
        padding: 30px;
       
    }

    form {
        background-color: #3e3e3e;
        
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        max-width: 600px;
        margin: auto;
        
    }

    textarea {
        width: 100%;
        height: 150px;
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .btn-primary:hover {
        background-color: #333;
    }

    .btn-secondary {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 10px 10px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        font-size: 15px;
    }

    .btn-secondary:hover {
        background-color: #bbb;
    }
</style>
