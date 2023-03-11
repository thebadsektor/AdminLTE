<?php
    session_start();

// ======================================================================================== assessment
    include('../php/connect.php');
    include("../jomar_assets/input_validator.php");

    $permit_id = $_POST["permit_id"];
    $val = $_POST["val"];
    $target = $_POST["target"];

    if($target == "application_status"){

    $q = mysqli_query($conn,"UPDATE `geo_bpls_business_permit` SET permit_approved = '$val' where permit_id = '$permit_id'  ");

            if($q){
                if($val == 1){
                    // set assessment active to 1
                    mysqli_query($conn,"UPDATE `geo_bpls_assessment` SET assessment_active = '1' where permit_id = '$permit_id'  ");

                    mysqli_query($conn,"UPDATE `geo_bpls_business_permit` SET step_code = 'PAYME' where permit_id = '$permit_id'     ");
                include '../php/web_connection.php';
                 //  EMAIL NOTIFICATION================
            
                // get uniq ID using permit_id
                $q6544 = mysqli_query($conn,"SELECT uniqID from geo_bpls_ol_application where permit_id = '$permit_id' ");
                $r6544 = mysqli_fetch_assoc($q6544);
                $uniqID = $r6544["uniqID"];

                $q433 = mysqli_query($wconn,"SELECT email from usersacc_tbl inner join geo_bpls_ol_application on geo_bpls_ol_application.customer_id =  usersacc_tbl.usersacc_id where uniqID = '$uniqID' ");
                $r433 = mysqli_fetch_assoc($q433);
                $to = $r433["email"];

                        
                // Update Online Application in web and localserver STEP
                mysqli_query($wconn, "UPDATE `geo_bpls_ol_application` SET `step` = 'PAYMENTS' where permit_id = '$permit_id' ");
                
                mysqli_query($conn, "UPDATE `geo_bpls_ol_application` SET `step` = 'PAYMENTS' where permit_id = '$permit_id' ");



                }else{
                    mysqli_query($conn,"UPDATE `geo_bpls_business_permit` SET step_code = 'APPRO' where permit_id = '$permit_id'  ");
                }
            }else{
                echo "failed";
        }
            }

    if($target == "application_remarks"){
        $q = mysqli_query($conn,"UPDATE `geo_bpls_business_permit` SET permit_approved_remark = '$val' where permit_id = '$permit_id'  ");
    }
?>