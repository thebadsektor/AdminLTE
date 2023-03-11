<?php
include('php/connect.php');
if(isset($_GET["target"])){
    $id = $_GET["target"];
    $q = mysqli_query($conn,"UPDATE `treasury_tbl` SET status = 'bpls_cancel' where md5(id) = '$id' ");

    // delete existing data in geo_bpls payments and details
    $select_q = mysqli_query($conn,"SELECT or_num FROM `treasury_tbl` where md5(id) = '$id' ");
    $select_r = mysqli_fetch_assoc($select_q);
    $or = $select_r["or_num"];

    // get payment id in payments tbl

    $select_q = mysqli_query($conn,"SELECT payment_id,permit_id FROM `geo_bpls_payment` where or_no = '$or' ");
    $select_r = mysqli_fetch_assoc($select_q);
    $payment_id = $select_r["payment_id"];
    $permit_id = $select_r["permit_id"];

    // removing data
    mysqli_query($conn,"DELETE FROM `geo_bpls_payment` WHERE or_no = '$or' ");
    mysqli_query($conn,"DELETE FROM `geo_bpls_payment_detail` WHERE payment_id = '$payment_id' ");
    mysqli_query($conn,"DELETE FROM `geo_bpls_payment_check` WHERE payment_id = '$payment_id' ");

    // updating business to PAYME
      mysqli_query($conn,"UPDATE geo_bpls_business_permit SET step_code = 'APPLI', permit_approved = '0' WHERE permit_id = '$permit_id' "); 
?>
 <script>
    myalert_success_af(" OR Successfully cancelled","bplsmodule.php?redirect=bpls_or_list&status=active_or");
 </script>
 <?php
   }
 ?>