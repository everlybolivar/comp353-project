<?php
include 'DB.php';

$con = DB::getConnection();
$admin= $_COOKIE['admin'];

// Redirect to login if no admin cookie
if (!$admin) {
    header('Location:../Login.php');
}

if($con->connect_errno > 0) {
    die('Connection failed [' . $con->connect_error . ']');
}

$id = (int)$_GET['id'];

$update = $con->prepare("DELETE FROM contract WHERE contract_id = ?");
$update->bind_param('i', $id);
$update->execute();
$update->close();
$con->close();

header("Location:AdminDashboard.php");
