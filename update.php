<?php
session_start();
include 'DB.php';

$con = DB::getConnection();
$admin= $_COOKIE['admin'];

// Redirect to login if no admin cookie
if (!$admin) {
    header('Location:Login.php');
}

if($con->connect_errno > 0) {
    die('Connection failed [' . $con->connect_error . ']');
}
$contract_id=(int)$_POST['contract_id'];
$company_name=$_POST['company_name'];
$service_type=$_POST['service_type'];
$contract_type=$_POST['contract_type'];
$service_start_date=date('Y-m-d',strtotime($_POST['service_start_date']));
$acv=(double)$_POST['acv'];
$initial_cost=(double)$_POST['initial_cost'];
$contact_number=$_POST['contact_number'];
$email_id=$_POST['email_id'];
$address=$_POST['address'];
$city=$_POST['city'];
$province=$_POST['province'];
$postal_code=$_POST['postal_code'];
$new_manager=(int)$_POST['new_manager'];

$update = $con->prepare(" 
 UPDATE contract SET 
 company_name='$company_name',
 service_type='$service_type',
 contract_type='$contract_type',
 service_start_date='$service_start_date',
 acv=$acv,
 initial_cost=$initial_cost,
 contact_number='$contact_number',
 email_id='$email_id',
 address='$address',
 city='$city', 
 province='$province',
 postal_code='$postal_code',
 responsible_person_id=$new_manager
 WHERE contract_id = $contract_id");

$update->execute();
$update->close();
$con->close();

header( "Location:AdminDashboard.php");

