<?php
if(isset($_GET["target"])){

    include 'jomar_assets/enc.php';
    include 'php/web_connection.php';

    $permit_id = $_GET["target"];
    $uniqID = $_GET["uniqID"];
    $md5id = $_GET["md5id"];
    $count = strlen($permit_id) - 4;
    $good_id = substr($permit_id, 4, $count);
    $target_status_code = substr($permit_id, 0, 4);
    $apn_no = strtoupper(date("Y-mdHis")."-".uniqid());

    if($target_status_code == "ren_"){
        
    $q = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_permit` where md5(permit_id) = '$good_id' ");
    $r = mysqli_fetch_assoc($q);

    $dec_permit_id = $r["permit_id"];
    $owner_id = $r["owner_id"];
    $business_id = $r["business_id"];
    $payment_frequency_code = $r["payment_frequency_code"];
    $status_code = "REN";
    $permit_application_date = date("Y-m-d");
    $permit_for_year = date("Y");
    $updated_by = $_SESSION['uname'];


    // get fullname for upload history
    $fullname = "";
    $q112 = mysqli_query($conn,"SELECT * from geo_bpls_owner where owner_id = '$owner_id' ");
    if(mysqli_num_rows($q112)>0){
        $r112 = mysqli_fetch_assoc($q112);
        $fullname = $r112["owner_first_name"]." ".$r112["owner_middle_name"]." ".$r112["owner_last_name"];
    }
    
     // get business_name for upload history
     $business_name = "";
     $q112 = mysqli_query($conn,"SELECT * from geo_bpls_business where business_id = '$business_id' ");
     if(mysqli_num_rows($q112)>0){
         $r112 = mysqli_fetch_assoc($q112);
         $business_name = $r112["business_name"];
     }
    
     

    $error = 0;
    //  DELETE all requirement exist
    $check_q = mysqli_query($conn, "DELETE FROM `geo_bpls_business_requirement` WHERE   business_id = '$business_id' ");

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
    $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit`(`permit_no`,`apn_no`, `owner_id`, `business_id`, `payment_frequency_code`, `status_code`, `step_code`, `permit_application_date`, `permit_for_year`,  `updated_by`, `updated_date`) VALUES (null,'$apn_no','$owner_id','$business_id','$payment_frequency_code','$status_code','APPLI','$permit_application_date','$permit_for_year','$updated_by',now() ) ");
    if ($q) {
    } else {
        $error++;
        echo "error22";

    }
    $q = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_permit` ORDER BY `geo_bpls_business_permit`.`permit_id` DESC limit 1");
    $r = mysqli_fetch_assoc($q);
    $newpermit_id = $r["permit_id"];

// echo $newpermit_id;
    // get busienss nature
    $q1 = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_permit_nature` where md5(permit_id) = '$good_id' ");
    while ($r1 = mysqli_fetch_assoc($q1)) {

        $nature_id = $r1["nature_id"];
        $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit_nature`( `nature_id`, `permit_id`, `capital_investment`, `last_year_gross`, `updated_by`, `updated_date`,`nature_application_type`) VALUES ('$nature_id','$newpermit_id',null,0,'$updated_by',now(),'REN' )");
        if ($q) {
        } else {
            $error++;
            echo "error33";

        }
    }


    //update sa online
    
    $q333 = mysqli_query($wconn,"UPDATE `geo_bpls_ol_application` SET permit_id='$newpermit_id', step='ASSESSMENT', `status`='APPROVED' where uniqID = '$uniqID'");
    // resync geo_bpls_ol_application online and offline 
    $q2332 = mysqli_query($wconn,"SELECT `id`,`uniqID`, `permit_id`, `customer_id`, `fname`, `mname`, `lname`, `b_name`, `date`, `address`, `step`, `status`, `remarks` FROM `geo_bpls_ol_application` where uniqID = '$uniqID'  ");
    if(mysqli_num_rows($q2332)>0){
        $r2332 = mysqli_fetch_assoc($q2332);
        $uniqID = $r2332["uniqID"];
        $permit_id = $r2332["permit_id"];
        $customer_id = $r2332["customer_id"];
        $fname = $r2332["fname"];
        $mname = $r2332["mname"];
        $lname = $r2332["lname"];
        $b_name = $r2332["b_name"];
        $date = $r2332["date"];
        $address = $r2332["address"];
        $step = $r2332["step"];
        $status = $r2332["status"];
        $remarks = $r2332["remarks"];
        $id = $r2332["id"];
        // insert sa local

        mysqli_query($conn,"INSERT INTO `geo_bpls_ol_application`(`id`,`uniqID`, `permit_id`, `customer_id`, `fname`, `mname`, `lname`, `b_name`, `date`, `address`, `step`, `status`, `remarks`) VALUES ('$id','$uniqID','$newpermit_id','$customer_id','$fname','$mname','$lname','$b_name','$date','$address','$step','$status','$remarks') ");
    }

    // update requirement online to local
    $q233c = mysqli_query($wconn,"SELECT * from geo_bpls_business_requirement_ol where uniqID = '$uniqID'");

    if(mysqli_num_rows($q233c)>0){
        while($r223c = mysqli_fetch_assoc($q233c)){
            $requirement_id = $r223c["requirement_id"];
            $requirement_file = $r223c["requirement_file"];
            $requirement_desc = $r223c["requirement_desc"];
            mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`(`requirement_id`, `business_id`, `requirement_active`, `requirement_file`) VALUES ('$requirement_id','$business_id','1','$requirement_file') ");


            // insert requirement history
            $q = mysqli_query($conn,"INSERT INTO `geo_bpls_uploaded_requirements_history`( `owner_name`, `business_name`,`docs_type`, `transaction_status`, `file_name`, `date_application`) VALUES ('$fullname','$business_name','$requirement_desc','1','$requirement_file','$permit_application_date') ");

            
        }
    }
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

    }
}
?>