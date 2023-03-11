<?php
include('../php/connect.php');

$or_num = $_POST['or_num'];
$cashier = $_POST['cashier'];

$qqtreasury_tbl = mysqli_query($conn, "SELECT or_num from treasury_tbl where or_num = '$or_num'");

$or_check = mysqli_num_rows($qqtreasury_tbl);

$checkRange = mysqli_query($conn,"SELECT `start_or`,`end_or`,`cashier_name` FROM `treasury_or_assign` WHERE CAST(`start_or` AS SIGNED) <= '$or_num' AND CAST(`end_or`AS SIGNED) >= '$or_num' and `cashier_name` = '$cashier'");

$countRange = mysqli_num_rows($checkRange);

if($or_check >= 1){
    $status = 2;
}else{
    if($countRange == 1){
        $status = 0;
    }else{
        $status = 1;
    }
}

echo $status;

?>