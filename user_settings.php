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
	$user_id = $_GET['user_id'];
	$last_login = $row['last_login'];
	$last_login = date('jS M Y H:i', strtotime($last_login));
	$total_members = get_all_status();
	$core_members = get_vip_status();

	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members);
?>

<div class="row">
	<ol class="breadcrumb">
		<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
		<li class="active">User Settings</li>
	</ol>
</div>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header" style="color: #003366; font-weight: bolder;">User Settings</h1>
	</div>
</div>

<div class="row">
	<div class="error">
		<?php update_settings($id); ?>
	</div>
	<div class="col-lg-offset-2 col-lg-8" style="opacity: 0.9;">
		<div class="panel panel-default" style="border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
			<div class="panel-heading" style="background-color: #00509e; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px;">
				Profile Details
			</div>
			<div class="panel-body" style="padding: 20px;">
				<form class="form-signin" method="post" action="">
					<div class="form-group">
						<label for="name" style="font-weight: bold;">Name</label>
						<input type="text" value="<?php echo $name; ?>" name="name" placeholder="Username" id="username" class="form-control" required>
					</div>
			</div>
		</div>

		<div class="panel panel-default" style="margin-top: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
			<div class="panel-heading" style="background-color: #d9534f; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px;">
				Security
			</div>
			<div class="panel-body" style="padding: 20px;">
				<div class="form-group">
					<label for="old_pwd" style="font-weight: bold;">Old Password</label>
					<input type="password" name="old_pwd" placeholder="Old Password" id="password" class="form-control">
				</div>
				<div class="form-group">
					<label for="new_pwd" style="font-weight: bold;">New Password</label>
					<input type="password" name="new_pwd" placeholder="New Password" id="password" class="form-control">
				</div>
			</div>
			<div class="panel-footer" style="background-color: #f7f7f7; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
				<button class="btn btn-primary" name="update_settings" type="submit" id="login">Save</button>&nbsp;&nbsp;
				<a href="home.php" class="btn btn-default" id="login">Cancel</a>
			</div>
		</div>
	</form>
</div>
