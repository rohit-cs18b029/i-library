<?php

$author_id=$_GET['author_id'];

$mysqli = new mysqli('127.0.0.1', 'root', '', 'elibrarydb', NULL);

$sql = "select * from author_master_tbl where author_id='$author_id'";
$result=$mysqli->query($sql);
$row = $result->fetch_assoc();
echo $row['author_name'];

$mysqli->close();

?>