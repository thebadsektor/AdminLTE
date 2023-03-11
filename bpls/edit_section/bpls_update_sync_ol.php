<?php
    session_start();
    include '../../php/connect.php';
    if(!empty($_SESSION["uname"])){
        $status = $_POST["aa"];

        $q = mysqli_query($conn,"UPDATE `geo_bpls_sync_status_ol` SET `status`= '$status' ") or die(mysqli_error($conn));

        if($q){
            echo "1";
        }else{
            echo "2";
        }

    }
    $status = $_POST["aa"];

?>