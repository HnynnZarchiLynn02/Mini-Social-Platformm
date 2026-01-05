<?php
require_once('dbconfig.php');

global $con;

/* login into panel. */

function login()
{
    global $con;
    
    if (isset($_POST['submit'])) 
    {
        $username = $_POST['username'];
        $username = stripslashes($username);
        $password = $_POST['password'];
        $password = stripslashes($password);
        
        
        $password_pattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/"; 
        if (!preg_match($password_pattern, $password)) {
            echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4 mx-auto" role="alert"><span>Password must be at least 8 characters long and include both letters and numbers.</span></div>';
            return false;
        }

        $query = "SELECT * FROM userinfo WHERE username ='$username' AND password ='$password'";
        $result = mysqli_query($con, $query);
        $rows = mysqli_affected_rows($con);

        if ($rows == 1)
        {
            $_SESSION['username'] = $username;
            while ($row = mysqli_fetch_assoc($result))
            {
                $last_login = $row['currunt_login'];

                $query = "UPDATE userinfo SET last_login='$last_login', currunt_login=NOW() WHERE username='$username'";
                mysqli_query($con, $query);
            }

            echo '<div class="text-center alert bg-success col-md-offset-4 col-md-4 mx-auto" role="alert"><span>Welcome back, <b>'.$_SESSION['username'].'</b>!</span></div>';
            echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>';
        }
        else
        {
            echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4 mx-auto" role="alert"><span>Sorry <b>'.$username.'</b>, Try Again!</span></div>';
        }   
    }

    return false;
}



/* Check User */

function check_session()
{
	if( !isset($_SESSION["username"]) )
	{
    	header("location:index.php");
    	exit();
	}	
    return false;
}

/* all member data */

function get_member_data($session_name)
{
	global $con;
	$query = "SELECT * FROM userinfo WHERE username='$session_name'";
	$result = mysqli_query($con,$query);
	$rows = mysqli_affected_rows($con);
	
	if($rows == 1)
	{
		$row = mysqli_fetch_assoc($result);
	}
	else
		echo 'error while retriving data';
	return $row;
}

/* user data for user setting */

function user_setting($user_id)
{
	global $con;
	$user_id = $user_id;
	$query = "SELECT * FROM userinfo where id='$user_id'";
	$result = mysqli_query($con,$query);
	$rows = mysqli_affected_rows($con);
	
	if($rows == 1)
	{
		$row = mysqli_fetch_assoc($result);
	}
	else
		echo 'error while retriving data';
	return $row;	
}

	

/* Update setting. */

function update_settings($id)
{
	global $con;

	$query = "SELECT * FROM userinfo where id='$id'";
		$result = mysqli_query($con,$query);
		$rows = mysqli_affected_rows($con);
	
		if($rows == 1)
		{
			while($row = mysqli_fetch_assoc($result))
			{
				$table_pwd = $row['password'];
			}
		}
		else
		{
			echo 'error while retriving table_pwd';
		}
		

	if (isset($_POST['update_settings'])) 
	{
		$name = $_POST['name'];
		$name = stripslashes($name);
		$old_pwd = $_POST['old_pwd'];
		$old_pwd = stripslashes($old_pwd);
		$new_pwd = $_POST['new_pwd'];
		$new_pwd = stripslashes($new_pwd);

		if(!empty($_POST['old_pwd']) && !empty($_POST['new_pwd']))
		{
			if($old_pwd == $table_pwd)
			{
				$query = "UPDATE userinfo SET name='$name', password='$new_pwd' WHERE id='$id'";
				mysqli_query($con,$query);
				$rows = mysqli_affected_rows($con);
				if($rows == 1)
				{
					echo '<div class="text-center alert bg-success col-md-offset-4 col-md-4"><span>Details updated!</span></div>';
					echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>';
				}
				else
				{
					echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4"><span>problem while updating name and password</span></div>';
					
				}
			}
			else
			{
				echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4"><span>check your old password and try again</span></div>';
			}
			
		}
		else
		{
			$query = "UPDATE userinfo SET name='$name' WHERE id='$id'";
			mysqli_query($con,$query);
			$rows = mysqli_affected_rows($con);
			if($rows == 1)
			{
				echo '<div class="text-center alert bg-success col-md-offset-4 col-md-4"><span>Details updated!</span></div>';
				echo '<script>setTimeout(function () { window.location.href = "home.php";}, 1000);</script>';

			}
			else
			{
				echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4"><span>problem while updating details</span></div>';
				
			}
		}
		
	}

	return false;
}

/* count all members */

function get_all_status()
{
	global $con;
	$query = "SELECT * FROM userinfo";
	$result = mysqli_query($con,$query);
	$rows = mysqli_affected_rows($con);
	return $rows;
}

/* count all post */

function get_all_posts()
{
	global $con;
	$query = "SELECT * FROM blog_posts";
	$result = mysqli_query($con,$query);
	$rows = mysqli_affected_rows($con);
	return $rows;
}

/* core members */

function get_vip_status()
{
	global $con;
	$query = "SELECT * FROM userinfo where role LIKE 'President'";
	$result = mysqli_query($con,$query);
	$rows = mysqli_affected_rows($con);
	return $rows;
}

function update_pic($id)
{
    global $con;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0)
    {
        $errors = array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');

        if (!in_array($file_ext, $allowed_exts))
        {
            $errors[] = 'Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.';
        }

        if ($file_size > 2097152)
        {
            $errors[] = 'File size must be less than 2 MB.';
        }

        if (empty($errors))
        {
            $new_file_name = uniqid() . '.' . $file_ext; 
            if (move_uploaded_file($file_tmp, "imgs/" . $new_file_name))
            {
                $addr = 'imgs/' . $new_file_name;
                $query = "UPDATE userinfo SET pic='$addr' WHERE id='$id'";
                $result = mysqli_query($con, $query);
                $rows = mysqli_affected_rows($con);

                if ($rows == 1)
                {
                    echo '<div class="text-center alert alert-success" role="alert" style="margin-top: 10px;"><span>Success! Profile Pic updated</span></div>';
                    echo '<script>setTimeout(function () { window.location.href = "update_pic.php";}, 1000);</script>';
                }
                else
                {
                    echo '<div class="text-center alert alert-danger" role="alert" style="margin-top: 10px;"><span>Problem while updating profile pic</span></div>';    
                }
            }
            else
            {
                echo '<div class="text-center alert alert-danger" role="alert" style="margin-top: 10px;"><span>Failed to move uploaded file.</span></div>';
            }
        }
        else
        {
            foreach ($errors as $error) {
                echo '<div class="text-center alert alert-danger" role="alert" style="margin-top: 10px;"><span>' . $error . '</span></div>';
            }
        }
    }
    else if (isset($_FILES['image']) && $_FILES['image']['error'] != 0)
    {
        echo '<div class="text-center alert alert-danger" role="alert" style="margin-top: 10px;"><span>Error during file upload: ' . $_FILES['image']['error'] . '</span></div>';
    }
}

/* member table in table format */

function all_member_table($role)
{
	global $con;
	$role = $role;
	$query = "SELECT * FROM userinfo";
	$result = mysqli_query($con,$query);
	$rows = mysqli_affected_rows($con);
 	?>
	<div></div>
 	<table class="table table-responsive"style="margin-top:20px;background-color:white;opacity:0.8;border-radius:5px;margin-left:40px;color:black;font-weight:bolder;font-size:18px;
            text-shadow: -1px 1px 0 #fff,
                         1px 1px 0 #fff,
                         1px -1px 0 #fff,
                         -1px -1px 0 #fff;">
 			<tr class="alert-dark">
 				<th><h4>Id</h4></th>
 				<th><h4>Name</h4></th>
 				<th><h4>Username</h4></th>
 				<th><h4>Email</h4></th>
 				<th><h4>Role</h4></th>
 				<th><h4>Action</h4></th>
 			</tr>
 	<?php
	while ($row = mysqli_fetch_assoc($result))
		{
			if(empty($row['email']))
			{
				$row['email'] = '-';
			}

			// if(empty($row['dob']))
			// {
			// 	$row['dob'] = '-';
			// }
			echo '<tr>
				<td>'.$row['id'].'</td>
				<td>'.$row['name'].'</td>
				<td>'.$row['username'].'</td>
				<td>'.$row['email'].'</td>
				<td>'.$row['role'].'</td>
				<td>';
				
				if($role == "President"|| $role == "Member Management")
				{
					echo '<a href="edit_member.php?mem_id='.$row['id'].' "style="color:black">Edit</a> | <a href="delete_member.php?mem_id='.$row['id'].'"style="color:red">Remove</a>';
				}
				else
				{
					echo '-';
				}
			
			echo '</td></tr>';
		}
	echo '</table>';
	return false;
}

/* add new member */

function add_member($role)
{
	global $con;
	$role = $role;

	if (isset($_POST['add_member'])) 
	{
		$name = $_POST['name'];
		$name = stripslashes($name);
		$email = $_POST['email'];
		$email = stripslashes($email);
		$username = $_POST['username'];
		$username = stripslashes($username);
		$password = $_POST['password'];
		$password = stripslashes($password);
		$pic = 'imgs/user.png';

		if($role == 'President'||'Member Management')
		{
			$select_role = $_POST["role"];

		}
		else
		{
			$select_role = "-";
		}

		$query = "INSERT into userinfo (name,  email, username, password, role, pic) VALUES ('$name',  '$email', '$username', '$password', '$select_role', '$pic')";
		$result = mysqli_query($con,$query);
		$rows = mysqli_affected_rows($con);
		if($rows == 1)
		{
			echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b>Success! Member Added</b></p></div>';
			echo '<script>setTimeout(function () { window.location.href = "manage_members.php";}, 1000);</script>';
		}
		else
		{
			echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b>error while adding member, try again</b></p></div>';
		}
	}

	return false;
}

/* edit member */

function edit_member($role,$mem_id)
{
	global $con;
	$role = $role;
	$mem_id = $mem_id;

	if (isset($_POST['edit_member']))
	{
		$edit_name = $_POST['name'];
		$edit_name = stripslashes($edit_name);
		$edit_email = $_POST['email'];
		$edit_email = stripslashes($edit_email);
		$edit_username = $_POST['username'];
		$edit_username = stripslashes($edit_username);
		
		if($role = 'President'||$role='Member Management')
		{
			$edit_select_role = $_POST['role'];
		}
		else
		{
			$edit_select_role = "";
		}

		if(empty($edit_select_role))
		{
			$query = "UPDATE userinfo SET name='$edit_name', email='$edit_email', username='$edit_username' WHERE id='$mem_id'";
		}
		else
		{
			$query = "UPDATE userinfo SET name='$edit_name', email='$edit_email', username='$edit_username', role='$edit_select_role' WHERE id='$mem_id'";
		}
		
		$result = mysqli_query($con,$query);
		$rows = mysqli_affected_rows($con);
		if($rows == 1)
		{
			echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b>Success! info updated</b></p></div>';
			echo '<script>setTimeout(function () { window.location.href = "manage_members.php";}, 1000);</script>';
		}
		else
		{
			echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b>error while updating info, try again</b></p></div>';
		}
	}

	return false;
}

/* delete member */

function delete_member($mem_id,$role)
{
	global $con;
	$mem_id = $mem_id;
	$role = $role;

	if(isset($_POST['yes']))
	{
		$query = "DELETE from userinfo where id='$mem_id'";
		$result = mysqli_query($con,$query);
		$rows = mysqli_affected_rows($con);
		echo mysqli_error($con);
		if($rows == 1)
		{
			echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b>Success! Member removed</b></p></div>';
			echo '<script>setTimeout(function () { window.location.href = "manage_members.php";}, 1000);</script>';
		}
		else
		{
			echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b>error while removing member, try again</b></p></div>';
		}
	}
	
	return false;
}


/* display notices */

 function show_notice($role)
 {
	 global $con;
	 $query = "SELECT * FROM notice ORDER by date DESC";
	 $result = mysqli_query($con, $query);
	 $rows = mysqli_affected_rows($con);
 
	 if ($rows == 0) {
		 echo '<div class="text-center alert alert-info col-md-offset-4 col-md-4"><p><b>No notice posted yet!</b></p></div>';
		 exit();
	 }
 
	 $select = 1;
	 while ($row = mysqli_fetch_assoc($result)) {
		 
		 if ($select % 2 == 1) {
			 $panel_class = 'panel-light-blue';
			 $heading_class = 'heading-dark-blue';
		 } else {
			 $panel_class = 'panel-light-blue';
			 $heading_class = 'heading-dark-blue';
		 }
		 ?>
 
		 <div class="col-md-4">
			 <div class="panel <?php echo $panel_class; ?>" style="border-radius: 15px; border: 1px solid #b0bec5;">
				 <div class="panel-heading <?php echo $heading_class; ?>" style="border-bottom: 1px solid #b0bec5; border-top-left-radius: 15px; border-top-right-radius: 15px;">
					 <?php echo $row['title']; ?>
				 </div>
				 <div class="panel-body">
					 <p>
						 <b>Date:</b> <small><?php echo date('jS M Y H:i', strtotime($row['date'])); ?></small><br>
						 <?php echo $row['description']; ?>
					 </p>
				 </div>
				 <?php
				 if ($role == 'President') {
					 echo '<div class="panel-footer" style="border-top: 1px solid #b0bec5; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px; text-align: right;">';
					 echo '<a class="btn btn-primary btn-sm" href="edit_notice.php?notice_id=' . $row['notice_id'] . '">Edit</a> ';
					 echo '<a class="btn btn-danger btn-sm" href="delete_notice.php?notice_id=' . $row['notice_id'] . '">Delete</a>';
					 echo '</div>';
				 }
				 ?>
			 </div>
		 </div>
		 <?php
		 $select++;
	 }
 
	 return false;
 }
 

/* add notice */

function add_notice()
{
	global $con;
	if (isset($_POST['add_notice'])) 
	{
		$name = $_POST['name'];
		$name = stripslashes($name);
		$description = $_POST['description'];
		$description = stripslashes($description);
		$date = $_POST['date'];

		$query = "INSERT into notice (title,  description, date) VALUES ('$name',  '$description', '$date')";
		$result = mysqli_query($con,$query);
		$rows = mysqli_affected_rows($con);
		if($rows == 1)
		{
			echo '<div class="text-center alert alert-success bg-success col-md-offset-4 col-md-4" role="alert" style="color: #fff;"></b>Success! Notice Added</b></div>';
			echo '<script>setTimeout(function () { window.location.href = "notice.php";}, 1000);</script>';
		}
		else
		{
			echo '<div class="text-center alert alert-success bg-success col-md-offset-4 col-md-4" role="alert" style="color: #fff;"><b>error while adding notice</b></div>';
		}
	}

	return false;
}


/* delete notice */

function delete_notice($notice_id,$role)
{
	global $con;
	$notice_id = $notice_id;
	$role = $role;

	if(isset($_POST['yes']))
	{
		$query = "DELETE from notice where notice_id='$notice_id'";
		$result = mysqli_query($con,$query);
		$rows = mysqli_affected_rows($con);
		echo mysqli_error($con);
		if($rows == 1)
		{
			echo '<div class="text-center alert alert-success col-md-offset-4 col-md-4"><p><b>Success! Notice removed</b></p></div>';
			echo '<script>setTimeout(function () { window.location.href = "notice.php";}, 1000);</script>';
		}
		else
		{
			echo '<div class="text-center alert alert-danger col-md-offset-4 col-md-4"><p><b>error while removing notice, try again</b></p></div>';
		}
	}
	
	return false;
}

/* edit notice */

function edit_notice($notice_id,$role)
{
	global $con;
	$role = $role;

	if (isset($_POST['edit_notice']))
	{
		$name = $_POST['name'];
		$name = stripslashes($name);
		$description = $_POST['description'];
		$description = stripslashes($description);
		$date = $_POST['date'];
		
		$query = "UPDATE notice SET title='$name', description='$description', date='$date' WHERE notice_id='$notice_id'";
		$result = mysqli_query($con,$query);
		$rows = mysqli_affected_rows($con);
		if($rows == 1)
		{
			echo '<div class="text-center alert alert-success bg-success col-md-offset-4 col-md-4" role="alert" style="color: #fff;"></b>Success! Notice Edited</b></div>';
			echo '<script>setTimeout(function () { window.location.href = "notice.php";}, 1000);</script>';
		}
		else
		{
			echo '<div class="text-center alert alert-danger bg-danger col-md-offset-4 col-md-4" role="alert" style="color: #fff;"></b>error while editing notice</b></div>';
		}
	}

	return false;
}


function starter($id, $name, $role, $pic, $last_login, $total_members, $core_members)
{
	?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kudos CUMGY</title>
<link rel='shortcut icon' href='favicon.ico' type='image/x-icon'/>
<link href="css/pace-theme-corner-indicator.css" rel="stylesheet">
<script src="js/pace.min.js"></script>
<script>pace.start();</script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="css/styles.css" rel="stylesheet">
<script src="https://use.fontawesome.com/c250a4b18e.js"></script>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<style>
	body {
		background-color: #282a2b;
    }

.panel {
    background:#EBF4FA;
    color: black; 
    border:none; 
    border-radius: 8px; 
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3); 
	font-weight: bolder;
}

.home {
	
	border: 10px solid #61a3b0   ;
    padding: 20px;
	border-radius: 10px;
}

.panel-body {
	
    padding: 20px;
}

.media-heading {
    font-size: 18px;
    color: black; 
}

.text {
    color: black; 
}

h3 a {
    color: black; 
    text-decoration: none; 
}

h3 a:hover {
    text-decoration: underline;
}

.btn-primary {
    background-color: #333333;
    border-color: #333333;
}

.btn-primary:hover {
    background-color: #444444; 
    border-color: #444444; 
}

a {
    color: blue; 
}

a:hover {
    text-decoration: underline;
}

#navbar {
    margin-top: 50px;
    background-color: #f1f6f9;
    padding-left: 10px;
    padding-top: 10px;
    border: 1px groove white;

}

.nav-tabs .nav-item .nav-link {
    color: #000;
    padding: 10px 3px;
    font-size: large;
    border-radius: 10px;
}

.nav-tabs .nav-item .nav-link:hover {
    color: white;
    background-color: #000;
}

.nav-tabs .nav-item .nav-link.disabled {
   opacity: 0.6;
   cursor: not-allowed;
   color: #000;
   background-color: white;
}



.main {
    padding: 10px;
    background-color: #E2EAF4  	;
	background-image: #E2EAF4;

    border-radius: 10px;
    
    
     background-size: cover; 
    background-position: center; 
    
    padding: 20px;
    font-family: 'Times New Roman', Times, serif;
     font-size: 18px;
    position: relative;       
            
           
             
}


.navbar-brand .text-info {
    font-size: 24px; 
    font-weight: bold; 
}

.kudos-text {
    font-size: 28px;
    position: relative;
    z-index: 1; /* behind the icon */
    color: #158dc1 ; 
	margin-left: 50px;
	top: 5px;
}

.kudos-icon {
    width: 40px; 
    height: auto; 
    position: absolute;
    left: 10px; 
    top: 50%; 
    transform: translateY(-50%); /*vertical*/
    z-index: 2; /*in front of the text */
}

.red-dot {
            width: 10px;
            height: 10px;
            background-color: red;
            border-radius: 50%;
            display: inline-block;
            margin-left: 5px;
        }

</style>
</head>
<body>
<script>
function markCommentsAsViewed() {
    
    document.querySelector('.red-dot').style.display = 'none';
}
</script>

	<?php 
	
	include('dbconfig.php');
	
	
	$username = $_SESSION['username'];
	
	
	
$query = "
SELECT COUNT(c.cid) AS new_comments
FROM blog_posts p
LEFT JOIN comments c ON p.id = c.id
LEFT JOIN userinfo u ON u.username = p.auther
WHERE p.auther = '$username'
AND c.comment_date > u.last_viewed";

$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);


$new_comments = $row['new_comments'] ?? 0;


$update_query = "UPDATE userinfo SET last_viewed = NOW() WHERE username = '$username'";
mysqli_query($con, $update_query);

	?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
	<div class="collapse navbar-collapse" id="sidebar-collapse">
    <b>
        <p class="navbar-brand">
            <span class="text-info kudos-text"> Kudos(UCSMGY)</span>
            <img src="favicon.ico" alt="Icon" class="kudos-icon">
        </p>
    </b>


            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown pull-right">
                    <a class="dropdown-toggle" data-toggle="dropdown"title="your setting;">
                        <img src="<?php echo $pic; ?>" class="img-responsive img-circle img-thumbnail" height="35px" width="35px"> 
                        <b id="mobhide"><?php echo $name; ?></b> 
                        <div class="btn btn-xs btn-info" id="mobhide"><?php echo $role; ?></div>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
					<li>
					<a href="yourblog.php" onclick="markCommentsAsViewed()">
    <i class="fa fa-user" aria-hidden="true"></i> Your Blogs
    <?php if ($new_comments > 0) { ?>
        <span class="red-dot"></span>
    <?php } ?>
</a>


                            </li>
                        <li><a href="update_pic.php"><i class="fa fa-user" aria-hidden="true"></i> Change Profile Pic</a></li>
                        <li><a href="user_settings.php?user_id=<?php echo $id; ?>"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a></li>
						<li><a href="user_settings.php?user_id=<?php echo $id; ?>"><i class="fa fa-cog" aria-hidden="true"></i> YOur Group</a></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<br>

<div id="navbar" class="col-sm-12-h-75-mt-10">
    <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
            <a class="nav-link" href="home.php"><i class="fa fa-tachometer" aria-hidden="true"></i> <b>Dashboard</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="blog-home.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <b>Blog</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="notice.php"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> <b>Club Notice</b></a>
        </li>
        <?php if($role == 'President'||$role == 'Member Management'){ ?>
            <li class="nav-item">
                <a class="nav-link" href="manage_members.php"><i class="fa fa-users" aria-hidden="true"></i> <b>Members</b></a>
            </li>
        <?php } ?>
        <li role="presentation" class="divider"></li>
        <li class="nav-item">
            <a class="nav-link disabled" style="color: #000;"><i class="fa fa-clock-o" aria-hidden="true"></i> <b>Last Login</b><br><?php echo $last_login; ?></a>
        </li>
        <li role="presentation" class="divider"></li>
		        
    </ul>
</div>

<div class="col-sm-12 main">
	
    <?php
    
    return false;
}
?>
	
	</div>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="css/DateTimePicker.min.css" />
<script type="text/javascript" src="js/DateTimePicker.min.js"></script>

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
	<script>
		$(document).ready(function()
		{
		    $("#dtBox").DateTimePicker();
			$('.menu').on("click",".menu",function(e){ 
  			e.preventDefault(); 
  			var page = $(this).attr('href');   
  			$('.menu').load(page);
			});
			$('#content').summernote({
    			height: 270,
   			 });
		});
	</script>
	<script>
		
		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>
</body>
</html>
	<?php
	return false;


/* blog post */
function show_posts($role, $session_name) {
    global $con;
	
	include 'dbconfig.php';
	
    $query = "
        SELECT p.*, 
               u.pic,
               (SELECT COUNT(*) FROM comments c WHERE c.id = p.id) AS total_comments 
        FROM blog_posts p 
        LEFT JOIN userinfo u ON p.auther = u.username
        ORDER BY p.id DESC";

    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $select = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $css = ($select % 2 == 1) ? 'panel-teal' : 'panel-teal';
            $post_id = $row['id'];
            
            $profile_photo = !empty($row['pic']) ? $row['pic'] : 'user.png'; 
            $image_path = 'imgs/' . htmlspecialchars($profile_photo, ENT_QUOTES, 'UTF-8');
            
            ?>
            <div id="post-<?php echo $post_id; ?>" class="col-lg-12">
                <div class="panel" style="border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff; margin-bottom: 20px; padding: 15px;">
                    <div class="panel-heading" style="display: flex; align-items: center; background-color: white;">
					<a href="author_blogs.php?auther=<?php echo urlencode ($row['auther']); ?>">
					<img src="<?php echo $row['pic']; ?>" alt="<?php echo htmlspecialchars($row['auther'], ENT_QUOTES, 'UTF-8'); ?>" class="media-object img-circle" style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
					</a>
					<div>

                            <h3 style="font-size: 20px; font-weight: bold; margin: 0; padding-left: 10px; color: #34495e;"><?php echo htmlspecialchars($row['auther'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p style="margin: 5px 0; color: #888; font-size: 14px; padding-left: 10px;">
                                Posted on <b style="color: #34495e;"><?php echo date('jS M Y H:i:s', strtotime($row['post_date'])); ?></b> in 
                                <a href="viewbycat.php?cat=<?php echo htmlspecialchars($row['catinfo'], ENT_QUOTES, 'UTF-8'); ?>" style="color: #2980b9;"><?php echo htmlspecialchars($row['catinfo'], ENT_QUOTES, 'UTF-8'); ?> · <i class="fa fa-globe"></i></a>
                            </p>
                        </div>
                    </div>
                    <div class="panel-body" style="margin-top: 10px; padding: 10px;">
                        <p style="color: #2c3e50; font-size: 18px; margin-bottom: 10px;"><b><?php echo htmlspecialchars($row['postTitle'], ENT_QUOTES, 'UTF-8'); ?></b></p>
                        <p style="color: #555; font-size: 16px; line-height: 1.6;"><?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    <div class="panel-footer" style="background-color: #fff; padding: 10px; border-radius: 0 0 12px 12px;">
                        <?php if($session_name == $row['auther']) { ?>
                            <a class="btn btn-warning" href="edit-post.php?id=<?php echo $post_id; ?>&title=<?php echo htmlspecialchars($row['postTitle'], ENT_QUOTES, 'UTF-8'); ?>" style="background-color: #f39c12; border: none;">Edit</a>
                            <a class="btn btn-danger" href="delete-post.php?id=<?php echo $post_id; ?>&title=<?php echo htmlspecialchars($row['postTitle'], ENT_QUOTES, 'UTF-8'); ?>" style="background-color: #e74c3c; border: none;">Delete</a>
                        <?php } elseif ($role == 'President') { ?>
                            <a class="btn btn-danger" href="delete-post.php?id=<?php echo $post_id; ?>&title=<?php echo htmlspecialchars($row['postTitle'], ENT_QUOTES, 'UTF-8'); ?>" style="background-color: #e74c3c; border: none;">Delete</a>
                        <?php } ?>
                        <a href="comment.php?id=<?php echo $post_id; ?>&title=<?php echo htmlspecialchars($row['postTitle'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary btn-sm" style="background-color: #3498db; border: none; font-size: 14px;">
                            <i class="fa fa-comments"></i> Comment (<?php echo $row['total_comments']; ?>)
                        </a>
                        <a class="btn btn-primary" href="viewpost.php?id=<?php echo $post_id; ?>&title=<?php echo htmlspecialchars($row['postTitle'], ENT_QUOTES, 'UTF-8'); ?>" style="background-color: #3498db; border: none;">Read More</a>
                    </div>
                </div>
            </div>
            <?php
            $select++;
        } 
    } else {
        echo '<div class="alert bg-warning text-center col-md-offset-4 col-md-4 col-sm-12"><span><h4>No posts found, visit after sometime!</h4></span></div>';
    }
    return false;
}

/*	delete post  */
function delete_post($post_id)
{
	global $con;

	if(isset($_POST['yes']))
	{
		$query = "DELETE FROM blog_posts WHERE id='$post_id'";
		mysqli_query($con,$query);
		$rows = mysqli_affected_rows($con);
		if($rows == 1)
		{
			echo '<div class="text-center alert bg-success col-md-offset-4 col-md-4" role="alert"><span>Success! Post Deleted</span></div>';
				echo '<script>setTimeout(function () { window.location.href = "blog-home.php";}, 1000);</script>';
		}
		else
		{
			echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4" role="alert"><span>Error, post updating failed, try again</span></div>';
		}
	}
	return false;
}

/*	edit post  */

function edit_post($post_id)
{
	global $con;
	if (isset($_POST['update'])) 
	{
		$postTitle = $_POST['postTitle'];
		$postTitle = stripslashes($postTitle);
		$postTitle = mysqli_real_escape_string($con,$postTitle);

		$description = $_POST['description'];
		$description = stripslashes($description);
		$description = mysqli_real_escape_string($con,$description);

		$content = $_POST['content'];
		$content = stripslashes($content);
		$content = mysqli_real_escape_string($con,$content);

		$catvalue = $_POST['cats'];
		$catvalue = stripslashes($catvalue);

		$query = "UPDATE blog_posts SET postTitle='$postTitle',description='$description',content='$content',post_date=NOW() ,catinfo='$catvalue' WHERE id='$post_id'";

		mysqli_query($con,$query);

		$rows = mysqli_affected_rows($con);

			if($rows == 1)
			{
				echo '<div class="text-center alert bg-success col-md-offset-4 col-md-4" role="alert"><span>Success! Post Updated</span></div>';
				echo '<script>setTimeout(function () { window.location.href = "blog-home.php";}, 1000);</script>';
			}
			else
			{
				echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4" role="alert"><span>Error, post updating failed, try again</span></div>';
				
			}
	}
	return false;
}



/* show home post */

function show_home_posts($session_name, $role) {
    global $con;
	include 'dbconfig.php';
    
    $query = "
        SELECT p.*, 
               u.pic,
               (SELECT COUNT(*) FROM comments c WHERE c.id = p.id) AS total_comments 
        FROM blog_posts p 
        LEFT JOIN userinfo u ON p.auther = u.username
        ORDER BY p.id DESC limit 0,5";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $select = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $css = ($select % 2 == 1) ? 'panel-teal' : 'panel-teal';
            $post_id = $row['id'];

            
            
            

            ?>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body home">
                        
                        <div class="media">
                            <div class="media-left">
							<a href="author_blogs.php?auther=<?php echo urlencode ($row['auther']); ?>">
                                <img src="<?php echo $row['pic']; ?>" alt="<?php echo htmlspecialchars($row['auther'], ENT_QUOTES, 'UTF-8'); ?>" class="media-object img-circle" style="width: 50px; height: 50px;">
							</a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading" style="font-size:23px;font-weight:bolder;"><b><?php echo htmlspecialchars($row['auther'], ENT_QUOTES, 'UTF-8'); ?></b></h4>
                                <p class="text">
                                    <?php echo date('jS M Y H:i:s', strtotime($row['post_date'])); ?> · <i class="fa fa-globe"></i>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <h3><a href="viewpost.php?id=<?php echo $row['id']; ?>&title=<?php echo urlencode($row['postTitle']); ?>" style="color: #000;font-weight:bolder"><?php echo htmlspecialchars($row['postTitle'], ENT_QUOTES, 'UTF-8'); ?></a></h3>
                        <p><?php echo htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                        
                        <p>
                            <small class="text-muted" style="font-size: 15px;">
                                Posted in <a href="viewbycat.php?cat=<?php echo urlencode($row['catinfo']); ?>"><?php echo htmlspecialchars($row['catinfo'], ENT_QUOTES, 'UTF-8'); ?></a>
                            </small>
                        </p>
                        <hr>
                       
                        <div>
                            <a href="comment.php?id=<?php echo $row['id']; ?>&title=<?php echo urlencode($row['postTitle']); ?>" class="btn btn-primary btn-sm" style="font-size: 14px; margin-right: 10px;">
                                <i class="fa fa-comments"></i> Comment (<?php echo $row['total_comments']; ?>)
                            </a>
                            <a href="viewpost.php?id=<?php echo $row['id']; ?>&title=<?php echo urlencode($row['postTitle']); ?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-thumbs-up"></i> Read More
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $select++;
        } 

    } else {
        echo '<div class="alert bg-warning text-center col-md-offset-4 col-md-4 col-sm-12"><span><h4>No posts found, visit after sometime!</h4></span></div>';
    }

    return false;
}

/*  new post */

function new_post()
{
	global $con;

	$auther = $_SESSION['username'];

	if(isset($_POST['publish'])) 
	{

		$postTitle = $_POST['postTitle'];
		$postTitle = stripslashes($postTitle);
		$postTitle = mysqli_real_escape_string($con,$postTitle);

		$description = $_POST['description'];
		$description = stripslashes($description);
		$description = mysqli_real_escape_string($con,$description);

		$content = $_POST['content'];
		$content = stripslashes($content);
		$content = mysqli_real_escape_string($con,$content);

		$catvalue = $_POST['cats'];
		$catvalue = stripslashes($catvalue);

		$query = "INSERT INTO blog_posts (id, postTitle, description, content, post_date, auther, catinfo) VALUES (NULL, '$postTitle', '$description', '$content', NOW(), '$auther','$catvalue')";
		mysqli_query($con,$query);
		
		$rows = mysqli_affected_rows($con);

		if($rows == 1)
		{
			echo '<div class="text-center alert bg-success col-md-offset-4 col-md-4" role="alert"><span>Success! Post Published</span></div>';
			echo '<script>setTimeout(function () { window.location.href = "blog-home.php";}, 1000);</script>';
		}
		else
		{
			echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4" role="alert"><span>Sorry, error while publishing post, try again</span></div>';	
		}

	}

	return false;
}

// Define the get_group_details() function in funs.php
function get_group_details($group_id) {
    global $con;
    
    // Query to fetch group details
    $query = "SELECT * FROM groups WHERE id = ?";
    
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("i", $group_id); // 'i' is for integer
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Return the group details
        } else {
            return null; // Return null if no group found
        }
    } else {
        die("Error preparing query.");
    }
}

