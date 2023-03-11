<?php
   include('../php/connect.php');
   include("../jomar_assets/input_validator.php");

   $ca_id = $_POST["ca_id"];
   
//    update ng business permit
$err =0;
$q = mysqli_query($conn,"UPDATE geo_bpls_business_permit set step_code = 'APPLI', permit_approved = '0' where md5(permit_id) = '$ca_id'  ");
if(!$q){
    $err++;
}
$q = mysqli_query($conn,"DELETE FROM `geo_bpls_business_permit_nature` where md5(permit_id) = '$ca_id'  ");
if(!$q){
    $err++;
}
 ?>