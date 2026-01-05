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
			
		<div class="row">
			<ol class="breadcrumb bg-dark">
				<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
				<li><a href="manage_members.php">Back to Members</a></li>
				<li class="active" style="color:white";><b>Add New Member</b></li>
			</ol>
		</div>

		<div class="row">
			<div class="col-lg-12-border-end-text-white bg-dark">
				<h1 class="page-header"style="color: #003366; font-weight: bolder;">Add New Member</h1>
			</div>
		</div>

		<div class="row">
			<div class="error">
				<?php add_member($role); ?>
			</div>
			<div class="col-lg-offset-2 col-lg-6">
				<form class="form-signin" style="background-color: white;padding:25px;border-radius:5px;margin-left:40px;"method="post" action="">
					<label for="name"style="color:black">Name</label>
					<input type="text" name="name" placeholder="Name" id="name" class="form-control" require><br>
					<!-- <label for="rollno">RollNo</label>
					<input type="text" name="rollno" placeholder="rollno" id="rollno" class="form-control" require><br> -->
					<label for="name"style="color:black">Email</label>
					<input type="email" name="email" placeholder="Email@ucsmgy.edu.mm" id="email" class="form-control" require><br>
					<label for="name"style="color:black">Username</label>
					<input type="text" name="username" placeholder="username" id="username" class="form-control"><br>
					<label for="name"style="color:black">Password</label>
					<input type="password" name="password" placeholder="password" id="password" class="form-control"><br><br>
					<?php if($role == 'President')
					{
						echo '<label for="name"style="color:black">Role</label>
						<select class="form-control" name="role">
							<option>SELECT</option>
		    				<option name="first" value="first">1st yr</option>
						   	<option name="second" value="second "> 2nd yr</option>
						   	<option name="third" value="third">3rd yr</option>
							<option name="fourth" value="fourth">4th yr</option>
							<option name="final" value="final">Final</option>
							<option name="Master" value="Master">Master</option>
							<option name="President" value="President">President</option>
							<option name="MemberManagement" value="MemberManagement">MemberManagement</option>
		  				</select><br>';
					} ?>
					<button class="btn btn-primary" name="add_member" type="submit" id="login"style="background:white;color:black">Add</button>&nbsp;&nbsp;
					<a href="manage_members.php" class="btn btn-default" id="login">Cancel</a>
				</form>
			</div>
			
		</div>
		<div class="text-center" style="margin-top: 75px; color: #000;"><b>Copy@copy: <span style="color: red;">&#10084;</span>HZCL2024Project</div>
		<script>
		$(document).ready(function()
		{
		     $("#dtBox").DateTimePicker();
		});
 	</script>
<link rel="stylesheet" type="text/css" href="css/DateTimePicker.min.css" />
<script type="text/javascript" src="js/DateTimePicker.min.js"></script>
<?php
	