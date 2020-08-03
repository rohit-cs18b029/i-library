<?php

$book_id=$_GET['book_id'];
$member_id=$_GET['member_id'];

$mysqli = new mysqli('127.0.0.1', 'root', '', 'elibrarydb', NULL);

$sql = "select * from book_inventory where book_id='$book_id'";
$result=$mysqli->query($sql);
$row1 = $result->fetch_assoc();

$sql = "select * from member_master_tbl where member_id='$member_id'";
$result=$mysqli->query($sql);
$row2 = $result->fetch_assoc();


$text=$row1['book_name'].'#'.$row2['fullname'];

echo $text;

$mysqli->close();

?>