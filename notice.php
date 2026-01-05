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
    $last_login = $row['last_login'];
	$last_login = date('jS M Y H:i', strtotime($last_login));
	$total_members = get_all_status();
	$core_members = get_vip_status();
	
	starter($id,$name,$role,$pic,$last_login,$total_members,$core_members);
?>

<div class="container" style=" opacity:0.9; border-radius: 5px;font-weight:bolder;">
    <div class="row">
        <ol class="breadcrumb" style="background-color: white; color: black;">
            <li><a href="home.php" style="color: black;"><i class="fa fa-home" aria-hidden="true"></i></a></li>
            <li class="active" style="color: black;">Back to Notice</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" style="background-color:white;padding:10px;border-radius:5px;color: #000; font-weight: bolder;">Notice Board</h1><hr>
        </div>
    </div>

    <?php 
    if($role == "President")
    {
        echo '<div class="row">
                <div class="col-lg-12" style="padding-bottom: 15px;">
                    <a style="color: black;" href="add_notice.php"title="To add a new notice">
                        <h1 class="ribbon" style="border: 1px solid #ccc;
            box-shadow: 10px 30px 30px rgba(0,0,0,0.1);
            border-radius: 8px; padding: 10px; border-radius: 10px;color:black;width:30%;background-color:white;">
                            <i class="fa fa-plus-circle" aria-hidden="true" style="color: black; padding-right: 10px;"></i> 
                            <b>Add Notice</b>
                        </h1>
                    </a>
                </div>
              </div>';
    }
    ?>

    <div class="row" style="margin: 5px; padding-bottom: 5px;">
        <?php show_notice($role); ?>
    </div>
    <div class="text-center footer">
        <b> <span style="color: black;">Copy@copy:HZCL&#10084;2024Project</span></b>
    </div>
</div>
