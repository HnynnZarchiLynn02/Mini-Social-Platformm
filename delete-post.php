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
	$post_id = $_GET['id'];
	$total_members = get_all_status();
	$core_members = get_vip_status();
	

	starter($id,$name,$role,$pic,$last_login,$total_members,$core_members);

?>

	<div class="row">
			<ol class="breadcrumb">
				<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
				<li><a href="blog-home.php">Blog</a></li>
				<li class="active">Delete Post</li>
			</ol>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Delete Post</h1>
			</div>
		</div>

		<div class="row">
			<div class="error">
				<?php delete_post($post_id); ?>
			</div>
			<div class="col-lg-offset-2 col-lg-6">
				<div class="panel panel-danger">
					<div class="panel-heading">
						Warning
					</div>
					<div class="panel-body">
						<form class="" method="post" action="">
							<label for="ask">Are you really want to remove this Post?</label>
							<br>
					<div class="panel-footer">
						<div class="pull-right">
							<button class="btn btn-danger" name="yes" type="submit" id="login">Yes</button>&nbsp;&nbsp;
							<a href="blog-home.php" class="btn btn-default" id="login">No, go back!</a>
						</div>
					</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="text-center" style="margin-top: 75px; color: #000;"><b>Copy@copy: <span style="color: red;">&#10084;</span>HZCL2024Project</div>
<?php
	