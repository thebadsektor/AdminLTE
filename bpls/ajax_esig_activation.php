<?php
    session_start();
// ======================================================================================== assessment
if(isset($_POST["ca_id"])){
    if($_POST["type"] == "business_permit"){
    include('../php/connect.php');
    include("../jomar_assets/input_validator.php");
    $ca_id = $_POST["ca_id"];
    $q = mysqli_query($conn,"UPDATE `geo_bpls_signatory` SET esig_status ='$ca_id' where target_file = 'business_permit' ");
}
}
?>