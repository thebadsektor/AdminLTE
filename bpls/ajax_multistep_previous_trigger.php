<?php
    include('../php/connect.php');
    include("../jomar_assets/input_validator.php");
    $b_id = $_POST["business_id"];
    
    $checkquery = mysqli_query($conn,"SELECT count(*) as check_count FROM `geo_bpls_business` WHERE `business_id` = '$b_id' ");
        $checkrow = mysqli_fetch_assoc($checkquery);
            if($checkrow["check_count"] == 0){
                echo "failed";
            }else{
                echo "ok";
            }
?>