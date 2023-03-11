<?php
    session_start();

// ======================================================================================== assessment
    include('../php/connect.php');
    include("../jomar_assets/input_validator.php");

    $permit_id = $_POST["permit_id"];
    $val = $_POST["val"];
    $target = $_POST["target"];
            // get business id
            $q222 = mysqli_query($conn,"SELECT business_name FROM `geo_bpls_business_permit` inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id  where  permit_id = '$permit_id' ");
            $r222 = mysqli_fetch_assoc($q222);
            $business_name = $r222["business_name"];

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


                
                // Audit Trail =====================================================================================
                // Audit Trail =====================================================================================
                // Audit Trail =====================================================================================
                    $au_username = $_SESSION["uname"];
                    $au_action = "Business Approval & Disapproval";
                    $au_desc = "Approval of ".$business_name." Business";
                    mysqli_query($conn,"INSERT INTO `geo_bpls_audit_trail`(`username`, `action`, `description`) VALUES ('$au_username','$au_action','$au_desc') ");
                // Audit Trail =====================================================================================
                // Audit Trail =====================================================================================
                // Audit Trail ===================================================================================== 



                }else{

                // Audit Trail =====================================================================================
                // Audit Trail =====================================================================================
                // Audit Trail =====================================================================================
                    $au_username = $_SESSION["uname"];
                    $au_action = "Business Approval & Disapproval";
                    $au_desc = "Disapproval of ".$business_name." Business";
                    mysqli_query($conn,"INSERT INTO `geo_bpls_audit_trail`(`username`, `action`, `description`) VALUES ('$au_username','$au_action','$au_desc') ");
                // Audit Trail =====================================================================================
                // Audit Trail =====================================================================================
                // Audit Trail ===================================================================================== 


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