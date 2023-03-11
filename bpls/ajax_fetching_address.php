<?php
  include('../php/connect.php');
  include("../jomar_assets/input_validator.php");

  $id = $_POST["id"];
  $target = $_POST["target"];
  
//   onchange region fetch province
  if($target == "region"){
    $query = mysqli_query($conn,"SELECT * FROM `geo_bpls_province` WHERE `region_code` = '$id' ");
    $count_row = mysqli_num_rows($query);
    if($count_row>0){
        echo "<option value='' > --Select Province--</option>";
        while($row = mysqli_fetch_assoc($query)){
            echo "<option value='".$row["province_code"]."' >".$row["province_desc"]."</option>";
        }
    }
  }

  if($target == "province"){
    $query = mysqli_query($conn,"SELECT * FROM `geo_bpls_lgu` WHERE `province_code` = '$id' ");
    $count_row = mysqli_num_rows($query);
    if($count_row>0){
        echo "<option value='' > --Select Municipality--</option>";
        while($row = mysqli_fetch_assoc($query)){
            echo "<option value='".$row["lgu_code"]."' >".$row["lgu_desc"]."</option>";
        }
    }
  }

  
  if($target == "municipality"){
    $query = mysqli_query($conn,"SELECT * FROM `geo_bpls_barangay` WHERE `lgu_code` = '$id' ");
    $count_row = mysqli_num_rows($query);
    if($count_row>0){
        echo "<option value='' > --Select Barangay--</option>";
        while($row = mysqli_fetch_assoc($query)){
            echo "<option value='".$row["barangay_id"]."' >".$row["barangay_desc"]."</option>";
        }
    }
  }
?>