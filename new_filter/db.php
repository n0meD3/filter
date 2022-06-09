<?php
$conn = mysqli_connect('host', 'user', 'pass', 'db');
mysqli_query($conn,"set names utf8");
$conn1 = mysqli_connect('host', 'user', 'pass', 'db');
mysqli_query($conn1,"set names utf8");
if(!$conn1){
	die("Connection failed: " . mysqli_connect_error());
}
