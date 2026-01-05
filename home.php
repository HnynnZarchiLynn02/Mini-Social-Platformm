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
    //$rollno=['rollno'];
	$pic = $row['pic'];
	$last_login = $row['last_login'];
	$last_login = date('jS M Y H:i', strtotime($last_login));
	$total_members = get_all_status();
	$core_members = get_vip_status();

	$all_posts = get_all_posts();
	
	starter($id,$name,$role,$pic,$last_login,$total_members,$core_members);

?>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>

        /* Floating plus button */
.create-group-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #007bff;  /* Blue background color */
    color: white;  /* White color for the icon */
    padding: 15px;
    border-radius: 50%;
    font-size: 24px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    z-index: 1000;  /* Ensure the button stays on top of other content */
    transition: background-color 0.3s ease;
}

.create-group-btn:hover {
    background-color: #0056b3;  /* Darker blue when hovered */
    cursor: pointer;
}

/* Make sure the button is visible above the content */
body {
    position: relative;
}


        

        .container {
            border-radius: 15px;
            color: #fff;
            font-weight: bolder;
        }

        .page-header {
            margin-top: -3px;
            padding-bottom: 3px; 
            margin-bottom: 20px; /* Adjusted to move elements upwards */
            color: #000;
            font-style: oblique;
            font-size: 40px;
            text-shadow: -1px 1px #458aaa,
                         1px 1px 0 #458aaa,
                         1px -1px 0 #458aaa,
                         -1px -1px 0 #458aaa;
        }
        .page{
            /* border-bottom: 2px solid #03a9f4; */
            padding-bottom: 3px;
            margin-bottom: 20px; /* Adjusted to move elements upwards */
            color: #000;
            font-size: 35px;
            padding-top: 10px;
            text-shadow: -1px 1px #458aaa,
                         1px 1px 0 #458aaa,
                         1px -1px 0 #458aaa,
                         -1px -1px 0 #458aaa;
        }

        .panel {
            background-color: white;
            border: 1px solid black;
            border-radius: 10px;
            margin-bottom: 20px; 
            color: #000;
            padding: 10px; 
        }

        .panel-heading {
            background-color: #03a9f4;
            color: #fff;
            padding: 10px;
            font-size: 14px; 
        }

        .panel-body {
            padding: 10px;
            color: #000;
            font-size: 14px; 
        }

        .panel-footer {
            background-color: #000;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            padding: 10px;
            text-align: right;
        }

        .btn-primary {
            background-color: #03a9f4;
            border: none;
            border-radius: 5px;
            font-size: 14px; 
        }

        .btn-primary:hover {
            background-color: #0288d1;
        }

        .btn-danger {
            background-color: #f44336;
            border: none;
            border-radius: 5px;
            font-size: 14px; 
        }

        .btn-danger:hover {
            background-color: #c62828;
        }

        .panel-widget {
            width: 80%; 
            margin: 0 auto; 
            padding: 10px;
        }

        .widget-left i {
            font-size: 3em; 
        }

        .widget-right .large {
            font-size: 24px; 
        }

        .widget-right .text-muted {
            font-size: 12px;
        }

        .footer {
            color: black;
            margin-top: 20px; 
        }

        
        .dashboard-heading {
            display: flex;
            align-items: center;
            color: #000;
            font-weight: bolder;
        }

        .dashboard-icon {
            margin-right: 10px; 
            position: relative;
            top: -5px; /* Move the icon slightly upward */
            font-size: 1.2em;
        }
        .modal-content {
            border-radius: 15px;
        }
        
        .modal-footer {
            border-top: none;
        }
        #rulesModal{
            color: #000;
        }
    </style>
</head>

<body>
    <div class="col-md-12">
        <div class="row bg-secondary">
            <ol class="breadcrumb bg-secondary">
                <li><a href="#"><i class="fa fa-home" aria-hidden="true"></i></a></li>
                <li class="active">Dashboard</li>
            </ol>
        </div>

        <div class="row">
    <div class="col-lg-12">
       
                
            </span>
            <div class="row">
            <div class="col-md-12 text-right">
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#rulesModal"style="color:white;">View Rules and Policies</a>
            </div>
        </div>
           
        </h1>
    </div>
</div>

        <?php if ($role == 'President') { ?>
            <div class="row">
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-widget" style=" box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.3);">
            <div class="row no-padding">
                <div class="col-sm-3 col-lg-5 widget-left">
                    <i class="fa fa-user fa-3x" aria-hidden="true" style="color: #003366;"></i>
                </div>
                <div class="col-sm-9 col-lg-7 widget-right">
                    <div class="large"><?php echo $total_members; ?></div>
                    <div class="text-muted" style="font-size:17px; color: #003366;">All Members</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-widget" style="box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.3);">
            <div class="row no-padding">
                <div class="col-sm-3 col-lg-5 widget-left">
                    <i class="fa fa-user-secret fa-3x" aria-hidden="true" style="color: #003366;"></i>
                </div>
                <div class="col-sm-9 col-lg-7 widget-right">
                    <div class="large"><?php echo $core_members; ?></div>
                    <div class="text-muted" style="font-size:17px; color: #003366;">Core Members</div>
                </div>
            </div>
        </div>
    </div>

    <a href="blog-home.php">
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-widget" style="box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.3);">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <i class="fa fa-pencil fa-3x" aria-hidden="true" style="color: #003366;"></i>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><?php echo $all_posts; ?></div>
                        <div class="text-muted" style="font-size:17px; color: #003366;">Blogs</div>
                    </div>
                </div>
            </div>
        </div>
    </a>
    <?php }?>
</div>


        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page text-black"style="color: #000; font-weight: bolder;"id="page"><i class="fa fa-comment"style="padding:5px;"></i>Latest Blog Posts</h1>
                </div>
            </div>

            <div class="row" style="padding-top: 15px;">
                <div class="col-lg-12">
                    <?php show_home_posts($session_name, $role); ?>
                </div>
            </div>
            <div class="modal fade" id="rulesModal" tabindex="-1" role="dialog" aria-labelledby="rulesModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="color: #000;font-size:30px;">
                        <h5 class="modal-title" id="rulesModalLabel"style="font-weight:bold;">Rules and Policies</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"style="color: #000;font-style:italic;font-size:15px;">
                        <p>I follow the rules and I never post to attack other people.</p>
                        <p>I don’t post negative content or attack others' reputations.</p>
                        <p>I follow the admin's rules and never violate the group members.</p>
                        <p>I accept the rules and policies.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

            <div class="text-center footer">
                <b>Copy@copy: <span>&#10084;</span>HZCL2024Project</b>
            </div>
        </div>
    </div>
    <!-- Floating Plus Button -->
<a href="creategp.php" class="create-group-btn">
    <i class="fa fa-plus"></i>
</a>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
