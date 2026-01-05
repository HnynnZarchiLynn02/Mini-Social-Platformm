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


	if($role != 'President')
	{
		echo '<div class="text-center alert bg-warning col-md-offset-4 col-md-4"><p><b>Access Forbidden</b></p></div>';
		echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>';
		exit();
	}
?>
			<html>
				<head>
					<style>
						body{
			background-color: black;
		}
		
		.form-signin{
			padding: 30px;
			border-radius: 10px;
			border-color: 1px solid white;
			color: white;
			background-color: white;
			line-height:25px;
			box-shadow: 5px 5px white;
			opacity: 0.9;
		}

		.page_header{
			font-weight: bold;
		}
					</style>
				</head>
			<div class="row">
			<ol class="breadcrumb">
				<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
				<li><a href="notice.php">Back to Notice</a></li>
				<li class="active">Add Notice</li>
			</ol>
		</div>
	<div class="container">
	<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"style="color: #003366; font-weight: bolder;">Add New Notice</h1>
			</div>
		</div>

		<div class="row">
			<div class="error">
				<?php add_notice(); ?>
			</div>
			<div class="col-lg-offset-2 col-lg-6">
				<form class="form-signin" method="post" action="">
					<label for="name"style="color:black;">Notice Title</label>
					<input type="text" name="name" placeholder="max 150 char" id="name" class="form-control" require><br>
					<label for="name"style="color:black;">Notice Description</label>
					<textarea name="description" placeholder="Description max 250 char" id="email" class="form-control" require></textarea><br>
					<label for="name"style="color:black;">Notice Date</label>
					<input type="text"  placeholder="date" name="date" class="form-control" require>
					<div id="dtBox"></div><br>
					<button class="btn btn-primary" name="add_notice" type="submit"style="font-size:15px;">Add Notice</button>&nbsp;&nbsp;
					<a type="button" class="btn btn-default" href="notice.php" class="btn btn-default"style="font-size:15px;">Cancel</a>
				</form>
			</div>
		</div>
	</div>
		
	<div class="text-center" style="margin-top: 75px; color: #000;"><b>Copy@copy: <span style="color: red;">&#10084;</span>HZCL2024Project</div>
	
			</html>
		