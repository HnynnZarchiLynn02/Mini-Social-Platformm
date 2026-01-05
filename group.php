<?php
    require_once('funs.php');
    session_start();
    check_session();

    // Ensure 'group_id' is passed via URL
    if (isset($_GET['group_id'])) {
        $group_id = $_GET['group_id'];
    } else {
        die("Group ID not found.");
    }



    // Fetch member and session data
    $session_name = $_SESSION['username'];
    $row = get_member_data($session_name);
    $id = $row['id'];
    $name = $row['name'];
    $role = $row['role'];
    $pic = $row['pic'];

    // Get group details
    $group_details = get_group_details($group_id);
    if (!$group_details) {
        die("Group not found.");
    }

    // Fetch posts, notifications, and comments for the group
    $group_posts = get_group_posts($group_id);
    $group_notifications = get_group_notifications($group_id);
    $group_comments = get_group_comments($group_id);

    // Start the page
    starter($id, $name, $role, $pic, $last_login, $total_members, $core_members);
?>

<html>
<head>
    <title>Group Dashboard</title>
    <style>
        body {
            background-image: url('background.jpg');
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            color: #fff;
            padding: 20px;
        }
        .navbar {
            background-color: #333;
            padding: 10px;
            margin-bottom: 20px;
        }
        .navbar a {
            color: white;
            padding: 12px;
            text-decoration: none;
            text-align: center;
        }
        .navbar a:hover {
            background-color: #ddd;
        }
        .content-header {
            text-align: center;
            font-size: 32px;
            color: #03a9f4;
            margin-bottom: 30px;
        }
        .panel {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .panel-heading {
            background-color: #03a9f4;
            padding: 10px;
            color: white;
        }
        .panel-body {
            font-size: 14px;
        }
        .panel-footer {
            background-color: #000;
            color: white;
            text-align: right;
            padding: 10px;
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
    </style>
</head>

<body>
    <div class="navbar">
        <a href="group.php?group_id=<?php echo $group_id; ?>">Posts</a>
        <a href="notifications.php?group_id=<?php echo $group_id; ?>">Notifications</a>
        <a href="messages.php?group_id=<?php echo $group_id; ?>">Messages</a>
    </div>

    <div class="container">
        <h2 class="content-header"><?php echo $group_details['name']; ?> - Group Dashboard</h2>

        <!-- Group Posts Section -->
        <div class="panel">
            <div class="panel-heading">
                <h3>Posts in the Group</h3>
            </div>
            <div class="panel-body">
                <?php
                    foreach ($group_posts as $post) {
                        echo '<div class="post">';
                        echo '<h4>' . $post['title'] . '</h4>';
                        echo '<p>' . $post['content'] . '</p>';
                        echo '<p>Posted by ' . $post['author'] . ' on ' . $post['date'] . '</p>';
                        
                        if ($post['author'] == $session_name || $role == 'President') {
                            echo '<a href="edit-post.php?post_id=' . $post['id'] . '" class="btn-primary">Edit</a>';
                            echo '<a href="delete-post.php?post_id=' . $post['id'] . '" class="btn-danger">Delete</a>';
                        }

                        echo '<div class="comments">';
                        echo '<h5>Comments</h5>';
                        foreach ($group_comments[$post['id']] as $comment) {
                            echo '<p>' . $comment['content'] . ' - ' . $comment['author'] . '</p>';
                            if ($comment['author'] == $session_name) {
                                echo '<a href="edit-comment.php?comment_id=' . $comment['id'] . '" class="btn-primary">Edit</a>';
                                echo '<a href="delete-comment.php?comment_id=' . $comment['id'] . '" class="btn-danger">Delete</a>';
                            }
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>

        <!-- Group Notifications Section -->
        <div class="panel">
            <div class="panel-heading">
                <h3>Group Notifications</h3>
            </div>
            <div class="panel-body">
                <?php
                    foreach ($group_notifications as $notification) {
                        echo '<p>' . $notification['message'] . ' - <i>' . $notification['sender'] . '</i></p>';
                    }
                ?>
            </div>
        </div>

        <!-- Private Messages Section -->
        <div class="panel">
            <div class="panel-heading">
                <h3>Private Messages</h3>
            </div>
            <div class="panel-body">
                <p>Send private messages to other group members.</p>
                <form action="send-message.php" method="post">
                    <textarea name="message" placeholder="Type your message..." required></textarea>
                    <button type="submit" class="btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
