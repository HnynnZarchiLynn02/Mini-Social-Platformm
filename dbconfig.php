<?php
$hostname = 'localhost';
$user = 'root';
$password = '';
$dbname = 'db';

$con = new mysqli($hostname, $user, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
