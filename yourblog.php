<?php
session_start();
include 'dbconfig.php';


if (!isset($_SESSION['username'])) {
    echo "<script>alert('You need to be logged in to view this page.'); window.location.href='index.php';</script>";
    exit();
}

$username = $_SESSION['username'];

$query = "
    SELECT p.*, 
           u.pic,
           (SELECT COUNT(*) FROM comments c WHERE c.id = p.id) AS total_comments 
    FROM blog_posts p 
    LEFT JOIN userinfo u ON p.auther = u.username
    WHERE p.auther = ? 
    ORDER BY p.id DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Blogs</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 18px;
            padding: 20px;
            background-color: #E2EAF4;
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        .container {
            color: #000;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .panel {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .panel-heading {
            background-color: #007bff;
            color: white;
            border-radius: 8px 8px 0 0;
            padding: 15px;
        }

        .panel-body {
            padding: 20px;
        }

        h2 {
            color: #333;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            font-size: 15px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: black;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-back {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #fff;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .btn-back:hover {
            background-color: #5a6268;
            border-color: #545b62;
            color: white;
        }
    </style>
</head>
<body>
<a href="javascript:history.back()" class="btn-back">&times; Back</a>
<div class="container">
    <h1 style="font-weight: bold;">My Blogs</h1>
    <hr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <img src="<?php echo htmlspecialchars($row['pic']); ?>" alt="<?php echo htmlspecialchars($row['auther'], ENT_QUOTES, 'UTF-8'); ?>" class="media-object img-circle" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px; display: inline-block;">
                    <h3 style="font-size:28px;font-weight:bolder;"><?php echo htmlspecialchars($row['postTitle']); ?></h3>
                </div>
                <div class="panel-body">
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p><small>Posted on <?php echo date('jS M Y H:i:s', strtotime($row['post_date'])); ?></small></p>
                    <a class="btn btn-warning" href="edit-post.php?id=<?php echo $row['id']; ?>&title=<?php echo $row['postTitle']; ?>">Edit</a>
                    <a class="btn btn-danger" href="delete-post.php?id=<?php echo $row['id']; ?>&title=<?php echo $row['postTitle']; ?>">Delete</a>
                    <a href="comment.php?id=<?php echo $row['id']; ?>&title=<?php echo $row['postTitle']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-thumbs-up"></i> Comment (<?php echo $row['total_comments']; ?>)</a>
                    <a href="viewpost.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Read More</a>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No blogs found.</p>";
    }

    $stmt->close();
    ?>
</div>

</body>
</html>
