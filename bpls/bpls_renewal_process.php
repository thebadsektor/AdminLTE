<?php
    $permit_id = $_GET["target"];
    $count = strlen($permit_id) - 4;
    $good_id = substr($permit_id, 4, $count);
    $target_status_code = substr($permit_id, 0, 4);
    $apn_no = strtoupper(date("Y-mdHis")."-".uniqid());

    if($target_status_code == "ren_"){
        
    $q = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_permit` where md5(permit_id) = '$good_id' ");
    $r = mysqli_fetch_assoc($q);

    $owner_id = $r["owner_id"];
    $business_id = $r["business_id"];
    $payment_frequency_code = $r["payment_frequency_code"];
    $status_code = "REN";
    $permit_application_date = date("Y-m-d");
    $permit_for_year = date("Y");
    $updated_by = $_SESSION['uname'];

    $error = 0;

    // checking if this business is trying to renew this year
    $check_q = mysqli_query($conn, "SELECT permit_id FROM `geo_bpls_business_permit` where  business_id = '$business_id' and owner_id = '$owner_id' and  permit_for_year = '$permit_for_year' ");
    // count of exist
    $count_check = mysqli_num_rows($check_q);

    if ($count_check > 0) {
    $check_r = mysqli_fetch_assoc($check_q);

    $newpermit_id = $check_r["permit_id"];
    ?>
                    <script>
                     $(document).ready(function(){
                         myalert_success_af("Please complete renewal application!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($newpermit_id); ?>");
                     });
                    </script>
               <?php
    } else {

    // Audit Trail =====================================================================================
    // Audit Trail =====================================================================================
    // Audit Trail =====================================================================================

        $q2232 = mysqli_query($conn,"SELECT business_name FROM `geo_bpls_business` where business_id = '$business_id' ");
        $r2232 = mysqli_fetch_assoc($q2232);
        $business_name = $r2232["business_name"];
        $au_username = $_SESSION["uname"];
        $au_action = "Renew Business";
        $au_desc = "Renew this Business >".$business_name;
        mysqli_query($conn,"INSERT INTO `geo_bpls_audit_trail`(`username`, `action`, `description`) VALUES ('$au_username','$au_action','$au_desc') ");
    // Audit Trail =====================================================================================
    // Audit Trail =====================================================================================
    // Audit Trail ===================================================================================== 
    $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit`(`permit_no`,`apn_no`, `owner_id`, `business_id`, `payment_frequency_code`, `status_code`, `step_code`, `permit_application_date`, `permit_for_year`,  `updated_by`, `updated_date`) VALUES (null,'$apn_no','$owner_id','$business_id','$payment_frequency_code','$status_code','APPLI','$permit_application_date','$permit_for_year','$updated_by',now() ) ");
    if ($q) {
    } else {
        $error++;
        echo "error business_permit";

    }
    $q = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_permit` ORDER BY `geo_bpls_business_permit`.`permit_id` DESC limit 1");

    $r = mysqli_fetch_assoc($q);
    $newpermit_id = $r["permit_id"];

// echo $newpermit_id;
    // get busienss nature
    $q1 = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_permit_nature` where md5(permit_id) = '$good_id' ");
    while ($r1 = mysqli_fetch_assoc($q1)) {

        $nature_id = $r1["nature_id"];
        $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit_nature`( `nature_id`, `permit_id`, `capital_investment`, `last_year_gross`, `updated_by`, `nature_application_type`, `updated_date`) VALUES ('$nature_id','$newpermit_id',null,0,'$updated_by','REN',now() )");
        if ($q) {
        } else {
            $error++;
            echo "error permit_nature";

        }
    }

// get
    if ($error > 0) {
        ?>
                     <script>
                     $(document).ready(function(){
                         myalert_danger_af("Failed to process renewal!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($newpermit_id); ?>");
                     });
                    </script>
                <?php
} else {
        // redirect to multistep
        ?>
                    <script>
                     $(document).ready(function(){
                         myalert_success_af("Please complete renewal application!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($newpermit_id); ?>");
                     });
                    </script>
               <?php
}

}

// retirement else
    }else{
$q = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_permit` where md5(permit_id) = '$good_id' ");
$r = mysqli_fetch_assoc($q);

$owner_id = $r["owner_id"];
$business_id = $r["business_id"];
        
$payment_frequency_code = $r["payment_frequency_code"];
$status_code = "RET";
$permit_application_date = date("Y-m-d");
$permit_for_year = date("Y");
$updated_by = $_SESSION['uname'];

$error = 0;

// checking if this business is trying to renew this year
$check_q = mysqli_query($conn, "SELECT permit_id FROM `geo_bpls_business_permit` where  business_id = '$business_id' and owner_id = '$owner_id' and  permit_for_year = '$permit_for_year' and status_code = 'RET' ");

// count of exist
$count_check = mysqli_num_rows($check_q);

if ($count_check > 0) {
    $check_r = mysqli_fetch_assoc($check_q);

    $newpermit_id = $check_r["permit_id"];
    ?>
                    <script>
                     $(document).ready(function(){
                         myalert_success_af("Please complete retirement application!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($newpermit_id); ?>");
                     });
                    </script>
               <?php
} else {

    

    // Audit Trail =====================================================================================
    // Audit Trail =====================================================================================
    // Audit Trail =====================================================================================

    $q2232 = mysqli_query($conn,"SELECT business_name FROM `geo_bpls_business` where business_id = '$business_id' ");
    $r2232 = mysqli_fetch_assoc($q2232);
    $business_name = $r2232["business_name"];
    $au_username = $_SESSION["uname"];
    $au_action = "Retire Business";
    $au_desc = "Retire this Business >".$business_name;
    mysqli_query($conn,"INSERT INTO `geo_bpls_audit_trail`(`username`, `action`, `description`) VALUES ('$au_username','$au_action','$au_desc') ");
// Audit Trail =====================================================================================
// Audit Trail =====================================================================================
// Audit Trail ===================================================================================== 




     
    mysqli_query($conn, "UPDATE `geo_bpls_business_permit` SET retirement_date_processed = '$permit_application_date' where md5(permit_id) = '$permit_id' ");

    $qt1 = "INSERT INTO `geo_bpls_business_permit`(`permit_no`, `apn_no`, `owner_id`, `business_id`, `payment_frequency_code`, `status_code`, `step_code`, `permit_application_date`, `permit_for_year`,  `updated_by`, `updated_date`) VALUES (null,'$apn_no','$owner_id','$business_id','$payment_frequency_code','$status_code','APPLI','$permit_application_date','$permit_for_year','$updated_by',now() ) ";

    $q = mysqli_query($conn, $qt1);
    if ($q) {
    } else {
        $error++;
        echo $qt1;

    }
    $q = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_permit` ORDER BY `geo_bpls_business_permit`.`permit_id` DESC limit 1");

    $r = mysqli_fetch_assoc($q);
    $newpermit_id = $r["permit_id"];

// echo $newpermit_id;
    // get busienss nature
    $q1 = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_permit_nature` where md5(permit_id) = '$good_id' ");
    while ($r1 = mysqli_fetch_assoc($q1)) {

        $nature_id = $r1["nature_id"];
        $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit_nature`( `nature_id`, `permit_id`, `capital_investment`, `last_year_gross`, `updated_by`,`nature_application_type` , `updated_date`) VALUES ('$nature_id','$newpermit_id',null,0,'$updated_by','RET',now() )");
        if ($q) {
        } else {
            $error++;
            echo  "error _permit_nature";
        }
    }

// get
    if ($error > 0) {
        ?>
                     <script>
                     $(document).ready(function(){
                         myalert_danger_af("Failed to process retirement!","bplsmodule.php?redirect=business_renewal");
                     });
                    </script>
                <?php
} else {
        // redirect to multistep
        ?>
                    <script>
                     $(document).ready(function(){
                         myalert_success_af("Please complete retirement application!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($newpermit_id); ?>");
                     });
                    </script>
               <?php
}

}
 }
?>