
<?php
        include("../../jomar_assets/myquery_function.php");
        include('../../php/connect.php');
       
    if(isset($_POST["ca_target"])){
        $ca_target = $_POST["ca_target"];
        $q = mysqli_query($conn,"DELETE FROM `geo_bpls_active_tfo` WHERE md5(active_tfo_if) = '$ca_target' ");
        if($q){
            echo 1;
        }else{
            echo 0;
        }
    }
        
?>
