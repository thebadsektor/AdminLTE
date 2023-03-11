<?php
include '../php/connect.php';
include "../jomar_assets/input_validator.php";

$id = $_POST["id"];

if ($id != "") {
    echo  '<option value="All" >Select All</option>';
    $q = mysqli_query($conn, "SELECT  tfo_nature_id, natureOfCollection_tbl.name as sub_account_title, geo_bpls_tfo_nature.sub_account_no from geo_bpls_tfo_nature
    inner JOIN natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no   where nature_id = '$id' and status_code = 'NEW' ");
 echo ' <optgroup label="New"  style="color:red; !important">';
       while($r = mysqli_fetch_assoc($q)){

            $sub_account_no = $r["sub_account_no"];
            if($sub_account_no == 1010 || $sub_account_no == 1011  || $sub_account_no == 1012  || $sub_account_no == 1013  || $sub_account_no == 1014  || $sub_account_no == 1015 || $sub_account_no == 1016 || $sub_account_no == 1017 || $sub_account_no == 1018 || $sub_account_no == 1019 || $sub_account_no == 1020 || $sub_account_no == 1021){
                  echo '<option value="'.$r["tfo_nature_id"].'" >';
                        echo substr(strtoupper($r["sub_account_title"]),0,15);
                  echo '</option>';
            }else{
                  echo '<option value="'.$r["tfo_nature_id"].'" >';
                         echo $r["sub_account_title"];
                  echo '</option>';
            }
             
       }
   echo '</optgroup>';


     $q = mysqli_query($conn, "SELECT  tfo_nature_id, natureOfCollection_tbl.name as sub_account_title, geo_bpls_tfo_nature.sub_account_no  from geo_bpls_tfo_nature
    inner JOIN natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no   where nature_id = '$id' and status_code = 'REN' ");
 echo ' <optgroup label="Renew"  style="color:red; !important">';
       while($r = mysqli_fetch_assoc($q)){
            $sub_account_no = $r["sub_account_no"];
            if($sub_account_no == 1010 || $sub_account_no == 1011  || $sub_account_no == 1012  || $sub_account_no == 1013  || $sub_account_no == 1014  || $sub_account_no == 1015 || $sub_account_no == 1016 || $sub_account_no == 1017 || $sub_account_no == 1018 || $sub_account_no == 1019 || $sub_account_no == 1020 || $sub_account_no == 1021){
                  echo '<option value="'.$r["tfo_nature_id"].'" >';
                        echo substr(strtoupper($r["sub_account_title"]),0,15);
                  echo '</option>';
            }else{
                  echo '<option value="'.$r["tfo_nature_id"].'" >';
                         echo $r["sub_account_title"];
                  echo '</option>';
            }
       }
   echo '</optgroup>';


} else {

}
