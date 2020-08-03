<?php

$publisher_id=$_GET['publisher_id'];

$mysqli = new mysqli('127.0.0.1', 'root', '', 'elibrarydb', NULL);

$sql = "select * from publisher_master_tbl where publisher_id='$publisher_id'";
$result=$mysqli->query($sql);
$row = $result->fetch_assoc();
echo $row['publisher_name'];

$mysqli->close();

?>