<?php
include('../php/connect.php');
$bname = $_POST['business_name'];

$q = mysqli_query($conn, "SELECT business_name from geo_bpls_business where business_name = '$bname'");
$c = mysqli_num_rows($q);

if($c >= 1){
    $status = 1;
}else{
    $status = 0;
}
echo $status;

?>