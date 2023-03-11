<?php
session_start();
include('../php/connect.php');
include("../jomar_assets/input_validator.php");

// check sync settings
$q = mysqli_query($conn, "SELECT `status` from geo_bpls_sync_status_ol where 1");
$r = mysqli_fetch_assoc($q);
$status = $r["status"];
if($status == "ON"){
include '../php/web_connection.php';
}

$serializeData = $_POST["obj_data"];
parse_str($serializeData, $arr);
    
    $basis = $arr["basis"];
    $indicator = $arr["indicator"];
    $charges = $arr["charges"];
    $transaction = $arr["transaction"];
    $tfo_nature_id = $arr["tfo_nature_id"];
    $nature_id = $arr["nature_id"];
    $username = $_SESSION['uname'];

    $err_counter = 0;
    if($indicator == "F" || $indicator == "C"){
        $formula = $arr["formula"];
        $q =  mysqli_query($conn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code` = '$basis', `indicator_code` = '$indicator', `nature_id` = '$nature_id', `sub_account_no` = '$charges', `status_code` = '$transaction', `amount_formula_range` = '$formula' , `updated_by` = '$username' where `tfo_nature_id` = '$tfo_nature_id'");
            if(!$q){
                $err_counter++;
            }
         if($status == "ON"){
             mysqli_query($wconn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code` = '$basis', `indicator_code` = '$indicator', `nature_id` = '$nature_id', `sub_account_no` = '$charges', `status_code` = '$transaction', `amount_formula_range` = '$formula' , `updated_by` = '$username' where `tfo_nature_id` = '$tfo_nature_id'");   
         }
    }

    if($indicator == "R" ){
       $count = count($arr["range_low"]);
        mysqli_query($conn, "DELETE FROM geo_bpls_tfo_range where tfo_nature_id = '$tfo_nature_id' ");
       for($a=0; $a<$count; $a++ ){
            $r_low = $arr["range_low"][$a];
            $r_high = $arr["range_high"][$a];
            $r_amount = $arr["range_amount"][$a];
           
         mysqli_query($conn, "INSERT INTO `geo_bpls_tfo_range`(`tfo_nature_id`, `range_amount`, `range_high`, `range_low`, `updated_by`) VALUES ('$tfo_nature_id','$r_amount','$r_high','$r_low','$username')");
       }
       $q = mysqli_query($conn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code`= '$basis', `indicator_code` = '$indicator', `nature_id` ='$nature_id', `sub_account_no` = '$charges', `status_code` = '$transaction',  `updated_by`='$username' where `tfo_nature_id` = '$tfo_nature_id' ");
       if(!$q){
            $err_counter++;
        }
        if($status == "ON"){
            mysqli_query($wconn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code`= '$basis', `indicator_code` = '$indicator', `nature_id` ='$nature_id', `sub_account_no` = '$charges', `status_code` = '$transaction',  `updated_by`='$username' where `tfo_nature_id` = '$tfo_nature_id' ");
        }
        //    count tfo in db tfo range
        $q0 = mysqli_query($conn, "SELECT count(`tfo_range_id`) as count_1 FROM `geo_bpls_tfo_range` WHERE `tfo_nature_id` = '$tfo_nature_id' ");
        $r0 = mysqli_fetch_assoc($q0);
        $aaaaa = $r0["count_1"];
        if ($aaaaa > 0) {
            $q = mysqli_query($conn, "UPDATE geo_bpls_tfo_nature SET amount_formula_range = '$aaaaa'  WHERE `tfo_nature_id` = '$tfo_nature_id' ");
            if(!$q){
                $err_counter++;
            }
            if($status == "ON"){
                mysqli_query($conn, "UPDATE geo_bpls_tfo_nature SET amount_formula_range = '$aaaaa'  WHERE `tfo_nature_id` = '$tfo_nature_id' ");
            }
        }
        // echo "r".$range_charges_count."="."<br>";

    }
   
    if($err_counter >0){
        echo 1;
        // error detected
    }else{
        echo 0;
        // no err detected
    }



?>