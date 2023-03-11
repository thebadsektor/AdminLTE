<?php
include 'php/connect.php';
include 'php/session2.php';
include "jomar_assets/myquery_function.php";

//BPLS Module
$qu = mysqli_query($conn, "SELECT * FROM permission_tbl WHERE uname = '$username' AND module ='BPLS Module' ORDER BY id DESC LIMIT 1 ");
$count_q = mysqli_num_rows($qu);
$d = mysqli_fetch_assoc($qu);
$access = $d['module'];

if ($access == 'BPLS Module' && $count_q > 0) {
    //  echo "welcome back!";
} else {
    header("location:../index.php");
}

   $target = $_GET["target"];
   delete_this($conn,"geo_bpls_business_permit","permit_id",$target);
        
?>