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

<div class="container">
	<div class="row">
		<ol class="breadcrumb" style="background-color: white; color: black;opacity:0.9;">
			<li><a href="home.php" style="color: black;"><i class="fa fa-home" aria-hidden="true"></i></a></li>
			<li><a href="blog-home.php" style="color: black;"> Back to Blog</a></li>
			<li class="active">New Post</li>
		</ol>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header" style="color: #003366; font-weight: bolder;">New Blog Post</h1>
		</div>
	</div>
	
	<div class="row">
		<div class="error">
			<?php new_post(); ?>
		</div>
		<div class="col-lg-12">
			<form class="form-signin" method="post" action="">
				<div class="col-lg-4" style="background-color: black; opacity:0.8;padding: 20px; border-radius: 5px;">
					<label for="postTitle" style="color: white;">Post Title</label>
					<input type="text" name="postTitle" placeholder="Post Title" class="form-control" required autofocus>
					<br>
					<label for="description" style="color: white;">Post Description</label>
					<textarea name="description" rows="7" cols="60" maxlength="250" placeholder="Post Description" id="description" class="form-control space" required></textarea>
					<br>
					<label for="content" style="color: white;">Select Post Category</label><br>
					<select class="form-control" name="cats">
    					<option name="Uncategorised" value="Uncategorised">Uncategorised</option>
					    <option name="Technology" value="Technology">Technology</option>
					  	<option name="Jobs Sharing" value="Jobs Sharing">Jobs Sharing</option>
					    <option name="News" value="News">News</option>
					   	<option name="Programming" value="Programming">Programming</option>
  					</select>
				</div>
				<div class="col-lg-8" style=" padding: 20px; border-radius: 5px;">
					<label for="content" style="color: #003366;text-shadow:black;font-weight:bolder;font-size:20px;">Post Content</label>
					<textarea name="content" placeholder="Post Content" id="content" class="form-control space" required></textarea>
					<div class="text-center" style="margin-top: 20px;">
						<button class="btn btn-lg btn-primary" name="publish" type="submit" id="publish">Publish Post</button>
					</div>
				</div>			
			</form>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#content').summernote({
		height: 450,   
		onImageUpload: function(files, editor, welEditable) {
			sendFile(files[0], editor, welEditable);
		}
	});
	
	function sendFile(file, editor, welEditable) {
		data = new FormData();
		data.append("file", file);
		$.ajax({
			data: data,
			type: "POST",
			url: 'summer-upload.php',
			cache: false,
			contentType: false,
			processData: false,
			success: function(url) {
				$('#content').summernote('editor.insertImage', url);
			}
		});
	} 
});
</script>


<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
