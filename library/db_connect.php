<?php

$user = 'root';
$pass = '';
$database = 'elibrarydb';
$port = NULL;
$mysqli = new mysqli('127.0.0.1', $user, $pass, $database, $port);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

?>