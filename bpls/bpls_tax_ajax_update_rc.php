<?php
 include '../php/connect.php';
 include "../jomar_assets/input_validator.php";
  // check sync settings
        $q = mysqli_query($conn, "SELECT `status` from geo_bpls_sync_status_ol where 1");
        $r = mysqli_fetch_assoc($q);
        $status = $r["status"];
        if($status == "ON"){
        include '../php/web_connection.php';
        }
 $ca_rc = $_POST["ca_rc"];
 $val = $_POST["val"];
 
  mysqli_query($conn,"UPDATE `geo_bpls_revenue_code` SET `revenue_code_status`= '$val' WHERE `revenue_code` = '$ca_rc' ");

  if($status == "ON"){
      mysqli_query($wconn,"UPDATE `geo_bpls_revenue_code` SET `revenue_code_status`= '$val' WHERE `revenue_code` = '$ca_rc' ");
  }
?>