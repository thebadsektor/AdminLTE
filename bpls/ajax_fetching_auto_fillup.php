<?php
      include('../php/connect.php');
      include("../jomar_assets/input_validator.php");

    $target = $_POST["target"];
    $id = $_POST["id"];

    if($target == "owners"){
        $q = mysqli_query($conn, "SELECT * from geo_bpls_owner where owner_id = '$id' ");
        $r = mysqli_fetch_assoc($q);
        // array
        // echo is_array($r);

        // array to json
        $someJSON = json_encode($r);
        echo $someJSON;

    }else{
        $q = mysqli_query($conn, "SELECT * from geo_bpls_business where business_id = '$id' ");
        $r = mysqli_fetch_assoc($q);
        // array
        // echo is_array($r);

        // array to json
        $someJSON = json_encode($r);
        echo $someJSON;

    }
?>