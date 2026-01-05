
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

starter($id, $name, $role, $pic, $last_login, $total_members, $core_members);
?>

<div class="container">
    <div class="row">
        <ol class="breadcrumb" style="background-color: #e9ecef; border-radius: 8px; padding: 10px;">
            <li><a href="home.php"><i class="fa fa-home" aria-hidden="true"></i></a></li>
            <li class="active" style="color: #333;">Change Profile</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" style="color: #0056b3; font-weight: 700; border-bottom: 2px solid #e9ecef; padding-bottom: 10px;">Change Profile</h1>
        </div>
    </div>

    <div class="row">
        <div class="error">
            <?php update_pic($id); ?>
        </div>
        <div class="col-lg-offset-2 col-lg-4 text-center">
            <img src="<?php echo htmlspecialchars($pic, ENT_QUOTES, 'UTF-8'); ?>" height="200px" width="200px" class="img-responsive img-circle" style="border: 4px solid #007bff; border-radius: 50%;"><br>
            <h4 style="font-weight: 700; color: #000;margin-right:140px;font-size:25px;"><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></h4>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); background-color: #ffffff;">
                <div class="panel-heading" style="background-color: #007bff; color: white; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 15px; font-size: 18px;">
                    Upload New Pic
                </div>
                <div class="panel-body" style="padding: 20px;">
                    <form action="" role="form" method="POST" class="form-signin" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="file" style="font-weight: 600; color: #333;">Select Image</label><br>
                            <input type="file" name="image" class="form-control-file" style="border: 1px solid #ced4da; border-radius: 8px; padding: 10px;">
                        </div>
                        <div class="panel-footer" style="background-color: #f8f9fa; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; padding: 15px;">
                            <button class="btn btn-primary" name="update_pic" type="submit" style="padding: 10px 20px; border-radius: 8px;">Change</button>&nbsp;&nbsp;
                            <a href="home.php" class="btn btn-secondary" style="padding: 10px 20px; border-radius: 8px;">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

?>
