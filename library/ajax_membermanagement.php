<?php

$member_id=$_GET['member_id'];

$mysqli = new mysqli('127.0.0.1', 'root', '', 'elibrarydb', NULL);

$sql = "select * from member_master_tbl where member_id='$member_id'";
$result=$mysqli->query($sql);
$row = $result->fetch_assoc();

$text=$row['fullname'].'#'.$row['account_status'].'#'.$row['dob'].'#'.$row['contact_no'].'#'.$row['email'].'#'.$row['state'].'#'.$row['city'].'#'.$row['pincode'].'#'.$row['full_address'];

echo $text;

$mysqli->close();

?>