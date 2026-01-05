<?php
	require_once('funs.php');
	$post_id = $_GET['id'];
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
<?php	

	$query = "SELECT * FROM blog_posts WHERE id = '$post_id'";
	$result = mysqli_query($con,$query);

	if (mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
            $postTitle = $row['postTitle'];
            $description = $row['description'];
            $content = $row['content'];
            $catinfo = $row['catinfo'];                    
		}
	}
	else
	{
		echo '<div class="text-center alert bg-danger col-md-offset-4 col-md-4" role="alert"><span>Error, post info retrive failed, try again</span></div>';
		die();
	}
?>
	
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			<li><a href="blog-home.php">Back to Blog</a></li>
			<li class="active">Edit Post</li>
		</ol>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"style="color: #003366; font-weight: bolder;">Edit Post</h1>
		</div>
	</div>

	<div class="row">
		<div class="error">
			<?php edit_post($post_id); ?>
		</div>
		<div class="col-lg-12">
			<form class="form-signin"style="background-color:black;" method="post" action="">
			<div class="col-lg-4">
				<label for="postTitle"">Post Title</label>
				<input type="text" value="<?php echo $postTitle; ?>" name="postTitle" placeholder="Post Title" class="form-control" required autofocus>
				<br>
				<label for="description"style="color:black;">Post Description</label>
				<textarea name="description" rows="7" cols="60" maxlength="250" placeholder="Post Description" id="description" class="form-control space" required><?php echo $description; ?></textarea>
				<br>
				<label for="content"style="color:black;">Select Post Category</label><br>
				<select class="form-control" name="cats">
					<option name="<?php echo $catinfo; ?>" value="<?php echo $catinfo; ?>"><?php echo $catinfo; ?></option>
    				
				   
				  	<option name="News" value="News">News</option>
				   	<option name="Jobs Sharing" value="Jobs Sharing">Jobs Sharing</option>
				   	<option name="Technology" value="Technology">Technology</option>
				   	<option name="Programming" value="Programming">Programming</option>
  				</select>
			</div>
			<div class="col-lg-8">
					<label for="content">Post Content</label>
					<textarea name="content" placeholder="Post Content" id="content" class="form-control space" required><?php echo $content; ?></textarea>
					<div class="text-center">
				<button class="btn btn-lg btn-primary" name="update" type="submit" id="update">Update Post</button>
			</div>
			</div>
					
			</form>
	</div>
</div>
<div class="text-center" style="margin-top: 75px; color: #000;"><b>Copy@copy: <span style="color: red;">&#10084;</span>HZCL2024Project</div>
<?php
	