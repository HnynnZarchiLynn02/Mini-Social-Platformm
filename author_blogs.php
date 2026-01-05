<?php
require_once('funs.php');
session_start();
check_session();
$session_name = $_SESSION['username'];
$row = get_member_data($session_name);
$id = $row['id'];
$name = $row['name'];
$role = $row['role'];
$pic = $row['pic'];

$last_login = date('jS M Y H:i', strtotime($row['last_login']));
$total_members = get_all_status();
$core_members = get_vip_status();

global $con;
include 'dbconfig.php';

starter($id, $name, $role, $pic, $last_login, $total_members, $core_members);

if (!isset($_SESSION['username'])) {
    echo "<script>alert('You need to be logged in to view this page.'); window.location.href='index.php';</script>";
    exit();
}

$author = $_GET['auther'];


$author_pic_query = "SELECT pic FROM userinfo WHERE username = ?";
$author_pic_stmt = $con->prepare($author_pic_query);
$author_pic_stmt->bind_param("s", $author);
$author_pic_stmt->execute();
$author_pic_result = $author_pic_stmt->get_result();
$author_pic_row = $author_pic_result->fetch_assoc();
$author_pic = $author_pic_row['pic'];

$query = "SELECT * FROM blog_posts WHERE auther = ? ORDER BY id DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $author);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs by <?php echo htmlspecialchars($author); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            background-color: #49b4c3;
        }
        .btn-back {
            background-color: white;
            color: black;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-decoration: none;
        }
        .author-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .author-info img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            margin-right: 20px;
        }
        .author-info h1 {
            margin: 0;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <a href="javascript:history.back()" class="btn-back">&times; Back</a>
    <div class="container">
        <div class="author-info">
            <?php if ($author_pic): ?>
                <img src="<?php echo htmlspecialchars($author_pic); ?>" alt="<?php echo htmlspecialchars($author); ?>" />
            <?php endif; ?>
            <h1><?php echo htmlspecialchars($author); ?></h1>
        </div>
        <hr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $post_id = $row['id'];
                
                $count_query = "SELECT COUNT(*) as total_comments FROM comments WHERE id = ?";
                $count_stmt = $con->prepare($count_query);
                $count_stmt->bind_param("i", $post_id);
                $count_stmt->execute();
                $count_result = $count_stmt->get_result();
                $count_row = $count_result->fetch_assoc();
                $total_comments = $count_row['total_comments'];
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3><?php echo htmlspecialchars($row['postTitle']); ?></h3>
                    </div>
                    <div class="panel-body">
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                        <p><small>Posted on <?php echo date('jS M Y H:i:s', strtotime($row['post_date'])); ?></small></p>
                        <a href="comment.php?id=<?php echo $row['id']; ?>&title=<?php echo urlencode($row['postTitle']); ?>" class="btn btn-primary btn-sm">
                            <i class="fa fa-comments"></i> Comment (<?php echo $total_comments; ?>)
                        </a>
                        <a href="viewpost.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Read More</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No blogs found.</p>";
        }

        $stmt->close();
        $author_pic_stmt->close();
        ?>
    </div>
</body>
</html>
