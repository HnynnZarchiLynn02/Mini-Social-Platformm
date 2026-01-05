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
$getcategory = $_GET['cat'];
$last_login = date('jS M Y H:i', strtotime($row['last_login']));
$total_members = get_all_status();
$core_members = get_vip_status();

starter($id, $name, $role, $pic, $last_login, $total_members, $core_members);
?>
<div class="row">
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
        <li><a href="blog-home.php">Back to Blog</a></li>
        <li class="active"><?php echo htmlspecialchars($getcategory); ?></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header" style="color:black;font-weight:bolder;">Posts in <?php echo htmlspecialchars($getcategory); ?></h1>
    </div>
</div>

<div class="row">
<?php
$query = "SELECT * FROM blog_posts WHERE catinfo=? ORDER BY id DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $getcategory);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $select = 1;
    while ($row = $result->fetch_assoc()) {
        
        $author_pic_query = "SELECT pic FROM userinfo WHERE username = ?";
        $author_pic_stmt = $con->prepare($author_pic_query);
        $author_pic_stmt->bind_param("s", $row['auther']);
        $author_pic_stmt->execute();
        $author_pic_result = $author_pic_stmt->get_result();
        $author_pic_row = $author_pic_result->fetch_assoc();
        $author_pic = $author_pic_row['pic'];
        
        $css = ($select % 2 == 1) ? 'panel-info' : 'panel-info';
?>
        <div class="col-lg-5">
            <div class="panel <?php echo $css; ?>">
                <div class="panel-heading">
                    <?php echo htmlspecialchars($row['postTitle']); ?>
                </div>
                <div class="panel-body">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <?php if ($author_pic): ?>
                            <a href="author_blogs.php?auther=<?php echo urlencode($row['auther']); ?>">
                                <img src="<?php echo htmlspecialchars($author_pic); ?>" alt="<?php echo htmlspecialchars($row['auther'], ENT_QUOTES, 'UTF-8'); ?>" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px; vertical-align: middle;">
                            </a>
                        <?php endif; ?>
                        <strong><?php echo htmlspecialchars($row['auther']); ?></strong>
                    </div>
                    <p><b><?php echo date('jS M Y H:i:s', strtotime($row['post_date'])); ?></b> in 
                        <a href="viewbycat.php?cat=<?php echo urlencode($row['catinfo']); ?>"><?php echo htmlspecialchars($row['catinfo']); ?></a>
                    </p>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                </div>                  
                <div class="panel-footer">
                    <?php if ($session_name == $row['auther'] || $role == 'President'): ?>
                        <a class="btn btn-warning" href="edit-post.php?id=<?php echo $row['id']; ?>&title=<?php echo urlencode($row['postTitle']); ?>">Edit</a>
                        <a class="btn btn-danger" href="delete-post.php?id=<?php echo $row['id']; ?>&title=<?php echo urlencode($row['postTitle']); ?>">Delete</a> 
                    <?php endif; ?>
                    <a href="comment.php?id=<?php echo $row['id']; ?>&title=<?php echo urlencode($row['postTitle']); ?>" class="btn btn-primary btn-sm" style="font-size: 14px; margin-right: 10px;">
                        <i class="fa fa-comments"></i> Comment
                    </a>
                    <a class="btn btn-primary" href="viewpost.php?id=<?php echo $row['id']; ?>&title=<?php echo urlencode($row['postTitle']); ?>">Read More</a>      
                </div>
            </div>
        </div>
<?php
        $select++;
    }
} else {
    echo '<div class="text-center alert bg-warning col-md-offset-4 col-md-4" role="alert"><span>No posts found, try again</span></div>';
}

$stmt->close();
?>
</div>
