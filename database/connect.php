<?php
$user = "root";
$pass = "";
$server = "localhost:3307";
$db = "majayjay_dbs";
$conn = mysqli_connect($server, $user, $pass);
$select_db = mysqli_select_db($conn, $db);


$timezone = "Asia/Singapore";
date_default_timezone_set($timezone);