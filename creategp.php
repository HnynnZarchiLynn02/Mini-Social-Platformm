<?php
require_once('funs.php');
session_start();
check_session();

// Fetch member and session data
$session_name = $_SESSION['username'];
$row = get_member_data($session_name);
$id = $row['id'];
$name = $row['name'];
$role = $row['role'];
$pic = $row['pic'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $group_name = $_POST['group_name'];
    $group_description = $_POST['group_description'];

    // Check for valid input
    if (empty($group_name) || empty($group_description)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        // Insert group details into the database
        $query = "INSERT INTO groups (name, description, created_by) VALUES (?, ?, ?)";
        
        if ($stmt = $con->prepare($query)) {
            $stmt->bind_param("sss", $group_name, $group_description, $session_name);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Group created successfully.</div>";
                // Redirect to group page or dashboard
                header("Location: group.php?group_id=" . $con->insert_id); // Redirect to the newly created group page
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error creating group. Please try again.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Database error.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Group</title>
    <!-- Add your CSS or Bootstrap link -->
</head>
<body>
    <div class="container">
        <h2>Create a New Group</h2>
        <form action="create-group.php" method="POST">
            <div class="form-group">
                <label for="group_name">Group Name</label>
                <input type="text" class="form-control" id="group_name" name="group_name" required>
            </div>
            <div class="form-group">
                <label for="group_description">Group Description</label>
                <textarea class="form-control" id="group_description" name="group_description" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Group</button>
        </form>
    </div>
</body>
</html>
