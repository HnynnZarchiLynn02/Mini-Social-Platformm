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
	
	starter($id, $name, $role, $pic, $last_login, $total_members, $core_members);


	
	if ($role != 'President'&& $role != 'Member Management') {
		echo '<div class="text-center alert bg-warning col-md-offset-4 col-md-4"><p><b>Access Forbidden</b></p></div>';
		echo '<script>setTimeout(function () { window.location.href = "manage_member.php";}, 1000);</script>';
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<style>
			/* body {
    			background-image: url('z1.jpg');
    			background-size: cover;
    			background-position: center;
    			background-repeat: no-repeat;
} */
h2 {
            color: white;
            font-size: 50px;
            
        }	
		
			</style>
	</head>
	<body>
		
	
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			<li class="active"style="color:black"> Back to Members</li>
		</ol>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"style="color: #003366;font-weight:bolder;text-align:center;">Members Section</h1>
		</div>
	</div>

	<?php 
	
	if ($role == "President") {
		echo '<div class="row">
				<div class="col-lg-12">
					<a style="color: black;" href="add_member.php"title="To add a new member">
						<h2 class="ribbon"style="color: #003366;font-weight:bolder;padding-left:10px;border-radius:5px;font-size:32px;margin-left:40px;"><i class="fa fa-user-plus" aria-hidden="true"></i> <b>Add Member</b></h1>
					</a>
				</div>
			</div>';
	}
	?>

	<div class="row">
		<div class="col-lg-11">
			<?php all_member_table($role); ?>
		</div>	
		<div class="text-center footer">
        <b> <span style="color: black;">Copy@copy;HZCL2024Project</span></b>
    </div>
	</div>
	</body></html>
