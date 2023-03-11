<?php
    session_start();
    include('../php/connect.php');
    include("../jomar_assets/input_validator.php");
    
    $val = $_POST["val"];
    $target = $_POST["target"];

    if(isset($_POST["target"])){
        $q = mysqli_query($conn,"UPDATE geo_bpls_discount_name set discount_status = '$val' where md5(discount_name_id) = '$target' ");
        if($q){
            echo "ok";
        }else{
            echo "not";
        }
    }

  

?>