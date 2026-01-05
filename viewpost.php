<?php
	require_once('funs.php');
	session_start();
	check_session();
	$session_name = $_SESSION['username'];
	$row = array();
	$row = get_member_data($session_name);
	$id = $row['id'];
	$name = $row['name'];
	$role = $row['role'];
	$pic = $row['pic'];
	$post_id = $_GET['id'];
	$last_login = $row['last_login'];
	$last_login = date('jS M Y H:i', strtotime($last_login));
	$total_members = get_all_status();
	$core_members = get_vip_status();
    $count_query = "SELECT COUNT(*) as total_comments FROM comments WHERE id = ?";
    $count_stmt = $con->prepare($count_query);
    $count_stmt->bind_param("i", $post_id);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $count_row = $count_result->fetch_assoc();
    $total_comments = $count_row['total_comments'];
   
    include 'dbconfig.php';
    
	
	starter($id,$name,$role,$pic,$last_login,$total_members,$core_members);
?>

<?php
	$query = "SELECT p.*, u.pic AS author_pic FROM blog_posts p 
	          LEFT JOIN userinfo u ON p.auther = u.username
	          WHERE p.id = ?";
	$stmt = $con->prepare($query);
	$stmt->bind_param("i", $post_id);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
            $postTitle = $row['postTitle'];
            $postDate = date('jS M Y H:i:s', strtotime($row['post_date']));
            $auther = $row['auther'];
            $description = $row['description'];
            $content = $row['content'];
            $catinfo = $row['catinfo'];
            $author_pic = $row['author_pic']; 
		}
	} else {
		echo '<div class="alert alert-warning text-center"><h3>error while retrieving post!</h3></div>';
	}
?>
<html>
<head>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            margin: 30px 0;
            padding: 20px;
            opacity: 1;
            font-weight: bold;
            color: #333;
        }

        .card-header {
            border-bottom: 2px solid #e1e1e1;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f0f0f0;
            color: #333;
        }

        .page-header {
            margin: 0;
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }

        .card-body {
            font-size: 18px;
            color: #555;
        }

        .card-footer {
            background: #f7f7f7;
            border-top: 2px solid #e1e1e1;
            padding: 15px;
            font-size: 16px;
            color: #666;
        }

        .card-footer b {
            color: #333;
        }

        
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                <li><a href="blog-home.php">Back to Blog</a></li>
                <li class="active"><?php echo $postTitle; ?></li>
            </ol>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                <div class="card-header">
                <h1 class="page-header"><?php echo $postTitle; ?></h1>
                <p>
                
                <img src="<?php echo htmlspecialchars( $author_pic ); ?>" alt="<?php echo htmlspecialchars($row['auther'], ENT_QUOTES, 'UTF-8'); ?>" class="media-object img-circle" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px; display: inline-block;">
                <a href="author_blogs.php?auther=<?php echo urlencode ($auther); ?>">
                <b><i><?php echo $auther; ?></a></i></b> on <b><?php echo $postDate; ?></b> in 
                    <a href="viewbycat.php?cat=<?php echo $catinfo; ?>"><?php echo $catinfo; ?></a>
                </p>
                </div>

                    <div class="card-body">
                        <h3><i><b><?php echo $description; ?></b></i></h3><br>
                        <p><h3><?php echo $content; ?></h3></p>
                    </div>
                    <div class="card-footer">
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="text-center footer">
        <b><span>Copy@copy:&#10084;HZCL2024Project</span></b>
    </div>
</body>
</html>
