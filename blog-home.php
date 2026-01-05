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
	//$rollno=$row['rollno'];
	$last_login = $row['last_login'];
	$last_login = date('jS M Y H:i', strtotime($last_login));
	$total_members = get_all_status();
	$core_members = get_vip_status();
	
	
	starter($id,$name,$role,$pic,$last_login,$total_members,$core_members);

?>
<html>
	<head>
		<style>

body {
    
    color: #fff; 
    font-weight: bolder;
}
			.container {
   border: 1px solid gray;
    color: #fff; 
    padding: 20px;
    border-radius: 15px;
    
   
}

.page {
   
    color: black;
    padding-left: 15px;
    border-radius: 10px;
    font-weight: bolder;
    /* border-bottom: 2px solid #03a9f4;  */
}

.breadcrumb {
    background-color: #fff  ; 
    padding-left: 10px;
    border-radius: 5px;
	color: #000;
	font-weight: bolder;
    opacity: 0.8;
}

.breadcrumb li a {
    color: #03a9f4; 
}

.breadcrumb .active {
    color: #fff; 
}

.new-post-row {
	
   
    border-radius: 5px;
}

.new-post-link {
    color: blue;
    text-decoration: none;
}

.new-post-link:hover {
    color: black; 
}

.ribbon {
   font-size: 25px;
    padding: 10px;
    border-radius: 10px;
	color: #000;
    
}

 .footer {
   
    color: #000; 
}
/*
.footer span {
    color: #000; */
/* } */



.posts-row {
   
    padding: 20px; 
    border-radius: 10px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
}
.posts-row .panel {
    background: #fff;
    border: 1px solid #e0e0e0; 
    border-radius: 10px; 
    margin-bottom: 20px; 
    
}

.posts-row .panel-heading {
    background: #dbe9f5; 
    color: #000; 
    border-top-left-radius: 10px; 
    border-top-right-radius: 10px; 
    padding: 10px; 
	font-weight: bold;
}

.posts-row .panel-body {
    color: #000; 
    padding: 15px; 
}

.posts-row .panel-footer {
    background: #f0f8ff; 
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px; 
    padding: 10px; 
}


.posts-row .btn-primary {
    background-color: #007bff; 
    border-color: #007bff; 
    color: #fff; 
}

.posts-row .btn-primary:hover {
    background-color: #0056b3; 
    border-color: #004085; 
}

.posts-row .btn-danger {
    background-color: #dc3545;
    border-color: #dc3545; 
    color: #fff; 
}

.posts-row .btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130; 
}


		</style>
	</head>

    <div class="container">
    <div class="row">
        <ol class="breadcrumb">
            <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
            <li class="active-text-white">Back to Blog</li>
        </ol>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <h1 class="page">Recent Blog Posts</h1>
        </div>
        <?php if(isset($_SESSION['username'])) { ?>
        <div class="col-lg-4 text-right">
            <a href="new-post.php" class="new-post-link"title="To create new post">
                <h1 class="ribbon"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #000; font-weight: bolder;"></i> <b style="color: #000; font-weight: bolder;">New Post</b></h1>
            </a>
        </div>
        <?php } ?>
    </div>
    
    <div class="row posts-row">
        <?php show_posts($role, $session_name); ?>
    </div>

    <div class="text-center footer">
        <b><span>Copy@copy:&#10084;HZCL2024Project</span></b>
    </div>
</div>
