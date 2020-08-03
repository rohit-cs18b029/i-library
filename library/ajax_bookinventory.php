<?php

$book_id=$_GET['book_id'];

$mysqli = new mysqli('127.0.0.1', 'root', '', 'elibrarydb', NULL);

$sql = "select * from book_inventory where book_id='$book_id'";
$result=$mysqli->query($sql);

if ( $result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $text=$row['book_name'].'#'.$row['language'].'#'.$row['publisher_name'].'#'.$row['author_name'].'#'.$row['publish_date'].'#'.$row['genre'].'#'.$row['edition'].'#'.$row['book_cost'].'#'.$row['pages'].'#'.$row['actual_stock'].'#'.$row['current_stock'].'#'.$row['book_description'].'#'.$row['img_link'];
    echo $text;
}
else{
    echo "000";
}

$mysqli->close();

?>