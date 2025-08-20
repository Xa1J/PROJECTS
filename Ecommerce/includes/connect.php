<?php
$con = mysqli_connect('localhost', 'root', '', 'mystore');

// Check connection
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
