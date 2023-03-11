<?php
// ======================================================================================== saving application
        include('php/connect.php');
        include("jomar_assets/input_validator.php");
        $business_name = validate_str($conn,$_POST['business_name']); 
        $business_id = validate_str($conn,$_POST['business_id']); 
        $application_date = validate_str($conn,$_POST['application_date']);
        $dti_sec_cdaRegistrationNo = validate_str($conn,$_POST['dti_sec_cdaRegistrationNo']);
        $dti_sec_cdaRegistrationDate = validate_str($conn,$_POST['dti_sec_cdaRegistrationDate']);
        $type_of_business = validate_str($conn,$_POST['type_of_business']);
      
        $tinNo = validate_str($conn,$_POST['tinNo']);
        // amendment optional
        $amd_from = validate_str($conn,$_POST['amd_from']);
        $amd_to = validate_str($conn,$_POST['amd_to']);
        // tax incentive

        if(isset($_POST['tax_incentive_status'])){
            $tax_incentive_status = validate_str($conn, $_POST['tax_incentive_status']);
            if ($tax_incentive_status == "Yes") {
                $tax_incentive_status = "1";
                $tax_incentive_entity = validate_str($conn, $_POST['tax_incentive_entity']);
            } else {
                $tax_incentive_entity = "0";
                $tax_incentive_status = "0";
            }
        }else{
            $tax_incentive_entity = "0";
            $tax_incentive_status = "0";
        }
        
        $date_explode = explode("-",$application_date);
        $year = $date_explode["0"];

         // $year = date("Y");
        // tax payer
        $tax_payer_lname = validate_str($conn,$_POST['tax_payer_lname']);
        $tax_payer_fname = validate_str($conn,$_POST['tax_payer_fname']);
        $tax_payer_mname = validate_str($conn,$_POST['tax_payer_mname']);
        
        $fullname = $tax_payer_fname." ".$tax_payer_mname." ".$tax_payer_lname;

        // trade name
        $trade_name = validate_str($conn,$_POST['trade_name']);
        $application_type = validate_str($conn,$_POST['application_type']);
        $mode_of_payment = validate_str($conn,$_POST['mode_of_payment']);
        // emergency contact
        $ec_person = validate_str($conn,$_POST['ec_person']);
        $ec_tel_no = validate_str($conn,$_POST['ec_tel_no']);
        $ec_email = validate_str($conn,$_POST['ec_email']);

        // discount'
        if(isset($_POST["PWD_status"])){
                 $PWD_status = 1;
        }else{
                  $PWD_status = 0;
        }
        if(isset($_POST["FPS_status"])){
                   $FPS_status = 1;
        }else{
                  $FPS_status = 0;
        }
        if(isset($_POST["SP_status"])){
                   $SP_status = 1;
        }else{
                  $SP_status = 0;
        }
        // brgy_id
        $b_mob_no = validate_str($conn,$_POST['b_mob_no']);
        $b_email = validate_str($conn,$_POST['b_email']);
        $b_tel_no =
        $o_mob_no = validate_str($conn,$_POST['o_mob_no']);
        $o_email = validate_str($conn,$_POST['o_email']);

        $o_street = validate_str($conn,$_POST['street']);
        $o_brgy  = validate_str($conn,$_POST['barangay']); 
        $o_mun = validate_str($conn,$_POST['municipality']); 
        $o_prov = validate_str($conn,$_POST['province']); 
        $o_reg = validate_str($conn,$_POST['region']); 
        
        $b_street = validate_str($conn,$_POST['b_street']);
        $b_brgy = validate_str($conn,$_POST['b_barangay']); 
        $b_mun = validate_str($conn,$_POST['b_municipality']); 
        $b_prov = validate_str($conn,$_POST['b_province']); 
        $b_reg = validate_str($conn,$_POST['b_region']); 
        $b_email = validate_str($conn,$_POST['b_email']); 

        $rented_status = validate_str($conn,$_POST['b_occupancy']);

        // lessor
        if($rented_status == "R"){
            if(isset($_POST['lessors_fullname'])){
                $lessors_fullname = validate_str($conn,$_POST['lessors_fullname']);
                $l_address = validate_str($conn,$_POST['l_address']);
                $l_email_add = validate_str($conn,$_POST['l_email_add']);
                $monthly_rental = validate_str($conn,$_POST['monthly_rental']);
                $l_mob_tel = validate_str($conn,$_POST['l_mob_tel']);
            }else{
                $lessors_fullname = "";
                $l_address = "";
                $l_email_add = "";
                $monthly_rental = "";
                $l_mob_tel = "";
            }
            
        }else{
            $lessors_fullname = "";
            $l_address = "";
            $l_email_add = "";
            $monthly_rental = "";
            $l_mob_tel = "";
        }
        $username = $_SESSION['uname'];

        //needed input 
        $sector = validate_str($conn,$_POST['b_sector']);
        $scale = validate_str($conn,$_POST['b_scale']);
        $b_zone = validate_str($conn,$_POST['b_zone']);
        $business_area = validate_str($conn,$_POST['b_area_sqm']);
        $business_contact_person ="";
        $b_remarks = "";
        $economic_area_code = validate_str($conn,$_POST['b_area']);
        $economic_org_code =  validate_str($conn,$_POST['b_org']);
        $citizenship_id = validate_str($conn,$_POST['citizenship']);
        $owner_address_house_bldg_lot_no = "";
        $civil_status_id = validate_str($conn,$_POST['civil_status']);
        $gender_code = validate_str($conn,$_POST['gender']);
        $owner_address_subdivision = "";
        $owner_birth_date = validate_str($conn,$_POST['birthdate']);
        $owner_building_name = "";
        $owner_legal_entity = validate_str($conn,$_POST['legal_entity']);
        $permit_approved_remark = "";
        $owner_address_unit_no = "";
        $o_zone = "";
        $b_area_sqm = validate_str($conn,$_POST['b_area_sqm']);
        $emp_establishment_count = validate_str($conn,$_POST['emp_establishment_count']);
        $no_emp_lgu = validate_str($conn,$_POST['no_emp_lgu']);


         if($_POST["hidden_validation"] == "save"){
            
            //  -------------------------------------------------business

            // insert in geo business tbl
            $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business`(`business_name`, `barangay_id`, `business_type_code`, `economic_area_code`, `economic_org_code`, `lgu_code`, `occupancy_code`, `province_code`, `region_code`, `scale_code`, `sector_code`, `zone_id`, `business_address_street`, `business_application_date`, `business_area`, `business_mob_no`, `business_tel_no`, `business_contact_name`, `business_dti_sec_cda_reg_date`, `business_dti_sec_cda_reg_no`, `business_email`, `business_emergency_contact`, `business_emergency_email`, `business_emergency_mobile`, `business_employee_female`, `business_employee_male`, `business_employee_resident`, `business_employee_total`,   `business_remark`, `business_tax_incentive`, `business_tax_incentive_entity`, `business_tin_reg_no`, `business_trade_name_franchise`, `updated_by`, `updated_date`) VALUES ('$business_name','$b_brgy','$type_of_business','$economic_area_code','$economic_org_code','$b_mun','$rented_status','$b_prov','$b_reg','$scale','$sector','$b_zone','$b_street','$application_date','$business_area','$b_mob_no','$b_tel_no','$business_contact_person','$dti_sec_cdaRegistrationDate','$dti_sec_cdaRegistrationNo','$b_email','$ec_person','$ec_email','$ec_tel_no','emp_female','emp_male','$no_emp_lgu','$emp_establishment_count','$b_remarks','$tax_incentive_status','$tax_incentive_entity','$tinNo','$trade_name','$username',now() )");
            if(!$q){
                echo "error11";
            }
            $q00 = mysqli_query($conn,"SELECT business_id FROM `geo_bpls_business`  
ORDER BY `geo_bpls_business`.`business_id` DESC LIMIT 1");
            $r00 = mysqli_fetch_assoc($q00);
             if(!$q00){
                echo "error113";
            }
            $business_id = $r00["business_id"];

            $error = 0;
            // lessor -------------------------------------------------
            if ($rented_status == "R") {
               $q = mysqli_query($conn, "INSERT INTO `geo_bpls_lessor_details`( `business_id`, `fullname`, `address`, `email`, `mob_no`, `monthly_rental`) VALUES ('$business_id','$lessors_fullname','$l_address','$l_email_add','$l_mob_tel','$monthly_rental') ");
               if(!$q){
                echo "error22";
                }
            }
            // lessor -------------------------------------------------

            
            //  -------------------------------------------------business
            if($q){

            }else{
                 $error++;
            }
            // requirement ----------------------------------------------
            

            if(isset($_POST['requirements'])){
                $arr_count2 = count($_POST['requirements']);
                // insert
                if($arr_count2>0){
                    for ($ib=0; $ib<$arr_count2; $ib++) {
                        $requirements_id = $_POST['requirements'][$ib];
                        $q = mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`,`requirement_file`) VALUES ('$requirements_id','$business_id','1','') ");
                        if(!$q){
                            echo "error332";
                            }
                    }
                }
            }

            
            if (isset($_FILES["requirements_files"])) {
                $arr_count2 = count($_FILES["requirements_files"]["name"]);
                // insert
                
                if($arr_count2 > 0){
                    for($ib = 0; $ib < $arr_count2; $ib++) {
                        if($_FILES["requirements_files"]["name"][$ib] != ""){
                        
                            $temp = explode(".", $_FILES["requirements_files"]["name"][$ib]);
                            $requirements_files = "L".$ib.date("Ymdhis").".".end($temp);
                            $requirement_id = $_POST['requirement_id'][$ib];
                            $target_dir = "bpls/images_file/bpls_requirements/";
                            $target_file = $target_dir . $requirements_files;
                            $filename = basename($_FILES["requirements_files"]["name"][$ib]);
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        
                        if (move_uploaded_file($_FILES["requirements_files"]["tmp_name"][$ib], $target_file)) {
                            $q = mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`,`requirement_file`) VALUES ('$requirement_id','$business_id','1','$requirements_files') ");
                                if(!$q){
                                 echo "error323";
                                }

                                   //get docs name 
                                   $q434543 = mysqli_query($conn,"SELECT * from geo_bpls_requirement where requirement_id = '$requirement_id' "); 
                                   $r434543 = mysqli_fetch_assoc($q434543);
                                       $docs_type = $r434543["requirement_desc"];
                                       // insert requirement history
                                   $q = mysqli_query($conn,"INSERT INTO `geo_bpls_uploaded_requirements_history`( `owner_name`, `business_name`,`docs_type`, `transaction_status`, `file_name`, `date_application`) VALUES ('$fullname','$business_name','$docs_type','2','$requirements_files','$application_date') ");
                                   if(!$q){
                                    echo "error6re33";
                                   }

                        }
                        
                    }
                }
              }
            }

            
            // requirement ----------------------------------------------

            if($_POST["owners_id"] != ""){
                $o_id = $_POST["owners_id"];
                $q = mysqli_query($conn, "UPDATE `geo_bpls_owner` SET  `business_id` = '$business_id' ,`owner_first_name` = '$tax_payer_fname' , `owner_middle_name` = '$tax_payer_mname', `owner_last_name` = '$tax_payer_lname', `barangay_id` = '$o_brgy', `citizenship_id` = '$citizenship_id', `civil_status_id` = '$civil_status_id', `gender_code` = '$gender_code', `lgu_code` = '$o_mun', `province_code` = '$o_prov', `region_code` = '$o_reg', `zone_id` = '$o_zone',  `owner_address_street` = '$o_street', `owner_birth_date` = '$owner_birth_date', `owner_email` = '$o_email', `owner_legal_entity` = '$owner_legal_entity', `owner_mobile` = '$o_mob_no',`SP_status` = '$SP_status',`4PS_status` = '$FPS_status',`PWD_status` = '$PWD_status', `updated_by` = '$username', `updated_date` = now() where owner_id  = '$o_id' ");
                if(!$q){
                    echo "error441";
                }
            }else{

             //  owner -------------------------------------------------
             $q = mysqli_query($conn, "INSERT INTO `geo_bpls_owner`(business_id,`owner_first_name`, `owner_middle_name`, `owner_last_name`, `barangay_id`, `citizenship_id`, `civil_status_id`, `gender_code`, `lgu_code`, `province_code`, `region_code`, `zone_id`,  `owner_address_street`, `owner_birth_date`, `owner_email`, `owner_legal_entity`, `owner_mobile`,`4PS_status`,`PWD_status`,`SP_status`,  `updated_by`, `updated_date`)   VALUES ('$business_id','$tax_payer_fname','$tax_payer_mname','$tax_payer_lname','$o_brgy','$citizenship_id','$civil_status_id','$gender_code','$o_mun','$o_prov','$o_reg','$o_zone','$o_street','$owner_birth_date','$o_email','$owner_legal_entity','$o_mob_no','$FPS_status','$PWD_status','$SP_status','$username',now() ) ");
              
                if(!$q){
                    echo "error443";
                }
             //  owner -------------------------------------------------
            }

            //  get owners id
            $id_query = mysqli_query($conn,"SELECT owner_id FROM `geo_bpls_owner` where business_id = '$business_id' ");
            $row = mysqli_fetch_assoc($id_query);
            $owner_id = $row["owner_id"];
            if(!$id_query){
                       echo "error454";
                }
            //  -------------------------------------------------business_permit
            $apn_no = strtoupper(date("Y-mdHis")."-".uniqid());
            $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit`( `permit_no`,`apn_no`, `owner_id`, `business_id`, `payment_frequency_code`, `status_code`, `step_code`, `permit_active`, `permit_application_date`, `permit_approved`, `permit_approved_remark`, `permit_for_year`, `permit_paid`, `permit_pin`, `permit_released`, `permit_released_date`, `retirement_date`, `retirement_date_processed`, `updated_by`, `updated_date`) VALUES (null,'$apn_no','$owner_id','$business_id','$mode_of_payment','$application_type','APPLI','0','$application_date','0','$permit_approved_remark','$year','0',null,'0',null,null,null,'$username',now()) ");

                if(!$q){
                    echo "error55";
                }
            //  -------------------------------------------------business_permit
            $id_query = mysqli_query($conn,"SELECT permit_id FROM `geo_bpls_business_permit` where business_id = '$business_id' ");
            $row = mysqli_fetch_assoc($id_query);
           
                $permit_id = $row["permit_id"];
                if(!$id_query){
                       echo "error454";
                }
            // get permit_id

                // saving discount
                if(isset($_POST["application_dicount"])){
                    $application_dicount_arr_count = count($_POST['application_dicount']);
                    for ($i=0; $i<$application_dicount_arr_count; $i++) {
                        $discount_name_id = $_POST['application_dicount'][$i];
                            mysqli_query($conn,"INSERT INTO `geo_bpls_discounted_business`(`permit_id`, `discount_name_id`) VALUES ('$permit_id','$discount_name_id')");
                    }
                }
                



            //  -------------------------------------------------business_permit_nature
                if(isset($_POST['nature'])){
                $arr_count3 = count($_POST['nature']);
                // insert
                if($arr_count3>0){
                    for ($i=0; $i<$arr_count3; $i++) {
                        $nature = $_POST['nature'][$i];
                        $nature_application_type = $_POST['nature_application_type'][$i];
                        $b_scale_arr = $_POST['b_scale_arr'][$i];
                        $aa = $_POST['cap_investment'][$i];
                        if ($nature_application_type == "NEW") {
                            $cap_investment = $aa;
                            $gross = 0;
                        } else {
                            $gross = $aa;
                            $cap_investment = 0;
                        }

                       $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit_nature`(`nature_id`, `permit_id`, `capital_investment`, `last_year_gross`,`scale_code`, `nature_active`, `nature_paid`, `nature_retire`, `recpaid`, `updated_by`,`nature_application_type`, `updated_date`) VALUES ($nature,$permit_id,$cap_investment,$gross,$b_scale_arr,null,null,null,0,'$username','$nature_application_type',now()) ");
                      
                        if(!$q){
                            echo "error66";
                            }
                        if($q){
                        }else{
                            $error++;
                        }
                    }
                }
            }
            
            // Audit Trail =====================================================================================
            // Audit Trail =====================================================================================
            // Audit Trail =====================================================================================
                $au_username = $_SESSION["uname"];
                $au_action = "Insert Business Application";
                $au_desc = "Insert Business >".$business_name;
                mysqli_query($conn,"INSERT INTO `geo_bpls_audit_trail`(`username`, `action`, `description`) VALUES ('$au_username','$au_action','$au_desc') ");
            // Audit Trail =====================================================================================
            // Audit Trail =====================================================================================
            // Audit Trail =====================================================================================

             if($error >0){
                ?>
                     <script>
                     $(document).ready(function(){
                         myalert_success_af("Failed to submit application form!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($permit_id); ?>");
                     });
                    </script>
                <?php
            }else{
                // redirect to multistep
               ?>
                    <script>
                     $(document).ready(function(){
                         myalert_success_af("Application form saved!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($permit_id); ?>");
                     });
                    </script>
               <?php
            }
    //  -------------------------------------------------business_permit_nature
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ else for update
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ else for update
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ else for update
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ else for update
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ else for update
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ else for update
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ else for update
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ else for update
    // ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ else for update
            
        }else{

         include('php/web_connection.php');
        $owner_id = $_POST["owner_id"];
        $permit_id = $_POST["permit_num"];
        $business_id = $_POST["business_id"];
        $fullname = $tax_payer_fname." ".$tax_payer_mname." ".$tax_payer_lname;

        // Updating discount
        mysqli_query($conn, "DELETE FROM `geo_bpls_discounted_business` WHERE permit_id ='$permit_id' ");
        if(isset($_POST["application_dicount"])){
                 $application_dicount_arr_count = count($_POST['application_dicount']);
                    for ($i=0; $i<$application_dicount_arr_count; $i++) {
                        $discount_name_id = $_POST['application_dicount'][$i];
                            mysqli_query($conn,"INSERT INTO `geo_bpls_discounted_business`(`permit_id`, `discount_name_id`) VALUES ('$permit_id','$discount_name_id')");
            }
        }
        // Updating discount

        // update sa online at local server
       mysqli_query($wconn,"UPDATE `geo_bpls_ol_application` SET  b_name = '$business_name', fname='$tax_payer_fname',mname='$tax_payer_mname',lname='$tax_payer_lname', `step` = 'ASSESSMENT' where  permit_id ='$permit_id' ");

       mysqli_query($conn,"UPDATE `geo_bpls_ol_application` SET  b_name = '$business_name', fname='$tax_payer_fname',mname='$tax_payer_mname',lname='$tax_payer_lname', `step` = 'ASSESSMENT' where  permit_id ='$permit_id' ");


        $f_step_q = mysqli_query($conn,"SELECT step_code from geo_bpls_business_permit where permit_id = '$permit_id'");
        $f_step_r = mysqli_fetch_assoc($f_step_q);
        $step_now = $f_step_r["step_code"];

        if($step_now != "RELEA" &&  $step_now != "PAYME"){
            // delete assessment
        $f_q = mysqli_query($conn,"SELECT count(permit_id) as p_count FROM `geo_bpls_assessment` WHERE permit_id = '$permit_id' ");
        $f_r = mysqli_fetch_assoc($f_q);

         if ($f_r["p_count"] > 0) {
          $q =   mysqli_query($conn,"DELETE FROM `geo_bpls_assessment` where permit_id = '$permit_id' ");  
           if(!$q){
                    echo "error553";
           } 
         }
        }

            // requirements ---------------------------------------------------
            // check req if exist
            $error = 0;
        $checkreqquery = mysqli_query($conn,"SELECT count(*) as checkreq_count FROM `geo_bpls_business_requirement` WHERE `business_id` = '$business_id' ");
        $checkreqrow = mysqli_fetch_assoc($checkreqquery);
            if($checkreqrow["checkreq_count"] == 0){

                if(isset($_POST['requirements'])){
                    $arr_count2 = count($_POST['requirements']);
                    // insert
                    if($arr_count2>0){
                        for ($ib=0; $ib<$arr_count2; $ib++) {
                            $requirements_id = $_POST['requirements'][$ib];
                            $q = mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`,`requirement_file`) VALUES ('$requirements_id','$business_id','1','') ");
                            if(!$q){
                                echo "error33";
                                }
                        }
                    }
                }
    
                
                if (isset($_FILES["requirements_files"])) {
                    $arr_count2 = count($_FILES["requirements_files"]["name"]);
                    // insert
                    
                    if($arr_count2 > 0){
                        for($ib = 0; $ib < $arr_count2; $ib++) {
                            if($_FILES["requirements_files"]["name"][$ib] != ""){
                            
                                $temp = explode(".", $_FILES["requirements_files"]["name"][$ib]);
                                $requirements_files = "L".$ib.date("Ymdhis").".".end($temp);
                                $requirement_id = $_POST['requirement_id'][$ib];
                                $target_dir = "bpls/images_file/bpls_requirements/";
                                $target_file = $target_dir . $requirements_files;
                                $filename = basename($_FILES["requirements_files"]["name"][$ib]);
                                $uploadOk = 1;
                                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                            
                            if (move_uploaded_file($_FILES["requirements_files"]["tmp_name"][$ib], $target_file)) {
                                $q = mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`,`requirement_file`) VALUES ('$requirement_id','$business_id','1','$requirements_files') ");
                                    if(!$q){
                                     echo "error33";
                                    }

                                  //get docs name 
                                  $q434543 = mysqli_query($conn,"SELECT * from geo_bpls_requirement where requirement_id = '$requirement_id' "); 
                                  $r434543 = mysqli_fetch_assoc($q434543);
                                      $docs_type = $r434543["requirement_desc"];
                                      // insert requirement history
                                  $q = mysqli_query($conn,"INSERT INTO `geo_bpls_uploaded_requirements_history`( `owner_name`, `business_name`,`docs_type`, `transaction_status`, `file_name`, `date_application`) VALUES ('$fullname','$business_name','$docs_type','2','$requirements_files','$application_date') ");
                                  if(!$q){
                                   echo "error345633";
                                  }

                            }
                            
                        }
                    }
                  }
                }



            }else{

                $q =mysqli_query($conn,"DELETE FROM `geo_bpls_business_requirement` WHERE `business_id` = '$business_id' ");


                // if may exception
                if(isset($_POST['exception_business_id'])){
                $arr_count44 = count($_POST['exception_business_id']);
                if($arr_count44>0){
                    for ($tb=0; $tb<$arr_count44; $tb++) {
                        $exception_business_id = $_POST['exception_business_id'][$tb];
                        $exception_requirement_id = $_POST['exception_requirement_id'][$tb];
                        $exception_filesname = $_POST['exception_filesname'][$tb];
                        mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`,`requirement_file`) VALUES ('$exception_requirement_id','$exception_business_id','1','$exception_filesname')");
                    }
                }
            }


                if(!$q){
                    echo "error653";
                }
                if(isset($_POST['requirements'])){
                    $arr_count2 = count($_POST['requirements']);
                    // insert
                    if($arr_count2>0){
                        for ($ib=0; $ib<$arr_count2; $ib++) {
                            $requirements_id = $_POST['requirements'][$ib];
                            $q = mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`,`requirement_file`) VALUES ('$requirements_id','$business_id','1','') ");
                            if(!$q){
                                echo "error34873";
                                }
                        }
                    }
                }
    
                
                if (isset($_FILES["requirements_files"])) {
                    $arr_count2 = count($_FILES["requirements_files"]["name"]);
                    // insert
                    
                    if($arr_count2 > 0){
                        for($ib = 0; $ib < $arr_count2; $ib++) {
                            if($_FILES["requirements_files"]["name"][$ib] != ""){
                                
                                $temp = explode(".", $_FILES["requirements_files"]["name"][$ib]);
                                $requirements_files = "L".$ib.date("Ymdhis").".".end($temp);
                                $requirement_id = $_POST['requirement_id'][$ib];
                                $target_dir = "bpls/images_file/bpls_requirements/";
                                $target_file = $target_dir . $requirements_files;
                                $filename = basename($_FILES["requirements_files"]["name"][$ib]);
                                $uploadOk = 1;
                                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                            
                            if (move_uploaded_file($_FILES["requirements_files"]["tmp_name"][$ib], $target_file)) {
                                $q = mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`,`requirement_file`) VALUES ('$requirement_id','$business_id','1','$requirements_files') ");
                                    if(!$q){
                                     echo "error1133";
                                    }

                                    //get docs name 
                                $q434543 = mysqli_query($conn,"SELECT * from geo_bpls_requirement where requirement_id = '$requirement_id' "); 
                                $r434543 = mysqli_fetch_assoc($q434543);
                                    $docs_type = $r434543["requirement_desc"];
                                    // insert requirement history
                                $q = mysqli_query($conn,"INSERT INTO `geo_bpls_uploaded_requirements_history`( `owner_name`, `business_name`,`docs_type`, `transaction_status`, `file_name`, `date_application`) VALUES ('$fullname','$business_name','$docs_type','2','$requirements_files','$application_date') ");
                                if(!$q){
                                 echo "error633";
                                }
                            }
                            
                        }
                    }
                  }
                }
            }
            // requirements ---------------------------------------------------


            // -----------------------------------------lessor
            // check if exist in lessor
        $checkquery = mysqli_query($conn,"SELECT count(*) as check_count FROM `geo_bpls_lessor_details` WHERE `business_id` = '$business_id' ");
        $checkrow = mysqli_fetch_assoc($checkquery);
            if($checkrow["check_count"] == 0){
                if($rented_status == "R") {
                    $q = mysqli_query($conn, "INSERT INTO `geo_bpls_lessor_details`( `business_id`, `fullname`, `address`, `email`, `mob_no`, `monthly_rental`) VALUES ('$business_id','$lessors_fullname','$l_address','$l_email_add','$l_mob_tel','$monthly_rental') ");

                    if($q){
                    }else{
                        echo "error112";
                        $error++;
                    }
                }
            }else{
                if($rented_status == "R") {
                  $q = mysqli_query($conn, "UPDATE `geo_bpls_lessor_details` SET `fullname`='$lessors_fullname',`address`='$l_address' ,`email`='$l_email_add',`mob_no`='$l_mob_tel',`monthly_rental`='$monthly_rental' WHERE `business_id` = '$business_id' ");
                    if($q){
                    }else{
                        echo "error114";

                      $error++;
                    }
                }else{
                    mysqli_query($conn,"DELETE FROM `geo_bpls_lessor_details` WHERE `business_id` = '$business_id' ");
                }
            }
            // -----------------------------------------lessor

            
            // business-----------------------------------------

            // update geo business tbl
            $q = mysqli_query($conn, "UPDATE `geo_bpls_business` SET `business_name` = '$business_name',`barangay_id` = '$b_brgy', `business_type_code`='$type_of_business', `economic_area_code`='$economic_area_code', `economic_org_code` ='$economic_org_code',`lgu_code`= '$b_mun', `occupancy_code` = '$rented_status',`province_code` = '$b_prov',`scale_code` = '$scale',`sector_code` = '$sector' ,`zone_id` = '$o_zone', `business_address_street` = '$b_street', `business_application_date` = '$application_date', `business_area` = '$business_area',`business_mob_no` = '$b_mob_no', `business_tel_no` = '$b_tel_no', `business_contact_name` = '$business_contact_person', `business_dti_sec_cda_reg_date` = '$dti_sec_cdaRegistrationDate',`business_dti_sec_cda_reg_no` = '$dti_sec_cdaRegistrationNo', `business_email` = '$b_email', `business_emergency_contact` = '$ec_person', `business_emergency_email` = '$ec_email', `business_emergency_mobile` ='$ec_tel_no', `business_remark` = '$b_remarks', `business_tax_incentive` = '$tax_incentive_status', `business_tax_incentive_entity` = '$tax_incentive_entity', `business_tin_reg_no` = '$tinNo', `business_trade_name_franchise` = '$trade_name', `updated_by` = '$username', `updated_date` = now() , business_employee_total = '$emp_establishment_count', business_employee_resident = '$no_emp_lgu'  where business_id =  '$business_id' ");

            if($q){
            }else{
                echo "error118";
              $error++;
            }
            

            // business-----------------------------------------
             //  owner -------------------------------------------------
             $q22 = mysqli_query($conn, "UPDATE `geo_bpls_owner` SET `owner_first_name` = '$tax_payer_fname',  `owner_middle_name` = '$tax_payer_mname', `owner_last_name` ='$tax_payer_lname', `barangay_id` = '$o_brgy', `citizenship_id` = '$citizenship_id', `civil_status_id` = '$civil_status_id' ,  `gender_code` = '$gender_code', `lgu_code` = '$o_mun', `province_code` = '$o_prov',  `region_code` = '$o_reg', `zone_id`= '$o_zone',  `owner_address_street`= '$o_street', `owner_birth_date`= '$owner_birth_date',  `owner_email` = '$o_email', `owner_legal_entity` = '$owner_legal_entity', `owner_mobile` = '$o_mob_no',`SP_status` = '$SP_status',`4PS_status` = '$FPS_status',`PWD_status` = '$PWD_status' ,`updated_by` =  '$username' ,  `updated_date` = now() where owner_id =  $owner_id ");
            if($q22){
            }else{
                echo "error1973";
                $error++;
            }

             //  owner -------------------------------------------------
              //  get owners id
            //  -------------------------------------------------business_permit    
        if($step_now != "RELEA" &&  $step_now != "PAYME"){
            if($application_type == "RET"){
                 $retire_date = $_POST["retire_date"];
                    if(isset($_FILES["affidavit"]["name"])){

                    $target_dir = "bpls/retirement_file/";
                    $target_file = $target_dir . basename($_FILES["affidavit"]["name"]);
                    $target_file_name = basename($_FILES["affidavit"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        echo "Sorry, file already exists.";
                        $uploadOk = 0;
                    }

                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["affidavit"]["tmp_name"], $target_file)) {
                            // echo "The file " . htmlspecialchars(basename($_FILES["affidavit"]["name"])) . " has been uploaded.";
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }

                    $q = mysqli_query($conn, "UPDATE  `geo_bpls_business_permit` SET  `payment_frequency_code` = '$mode_of_payment', `status_code` =  '$application_type',  `step_code` = 'ASSES' , retirement_date_processed = '$retire_date', `permit_application_date` = '$application_date', retirement_file = '$target_file_name',`updated_by` = '$username', `updated_date` = now() where  permit_id = '$permit_id' ");

                }else{
                    $q = mysqli_query($conn, "UPDATE  `geo_bpls_business_permit` SET  `payment_frequency_code` = '$mode_of_payment', `status_code` =  '$application_type',  `step_code` = 'ASSES' , retirement_date_processed = '$retire_date', `permit_application_date` = '$application_date', `updated_by` = '$username', `updated_date` = now() where  permit_id = '$permit_id'  ");
                }
            }else{
                $q = mysqli_query($conn, "UPDATE  `geo_bpls_business_permit` SET  `payment_frequency_code` = '$mode_of_payment', `status_code` =  '$application_type',  `step_code` = 'ASSES' , `permit_application_date` = '$application_date',`updated_by` = '$username', `updated_date` = now() where  permit_id = '$permit_id'  ");
            }
            

            if($q){
            }else{
              $error++;
            }
        }else{
            $q = mysqli_query($conn, "UPDATE  `geo_bpls_business_permit` SET  `payment_frequency_code` = '$mode_of_payment', `status_code` =  '$application_type', `permit_application_date` = '$application_date',`updated_by` = '$username', `updated_date` = now() where    permit_id = '$permit_id'");

            if ($q) {
            } else {
                $error++;
            }

        }
            //  -------------------------------------------------business_permit
      
             //  -------------------------------------------------business_permit_nature
                if(isset($_POST['nature'])){
                    mysqli_query($conn, "DELETE FROM geo_bpls_business_permit_nature where permit_id = '$permit_id' ");

                $arr_count3 = count($_POST['nature']);
                // insert
                if($arr_count3>0){
                    for ($i=0; $i<$arr_count3; $i++) {
                        $nature = $_POST['nature'][$i];
                        $nature_application_type = $_POST['nature_application_type'][$i];
                        $b_scale_arr = $_POST['b_scale_arr'][$i];

                        $aa = $_POST['cap_investment'][$i];
                        if ($nature_application_type == "NEW") {
                            $cap_investment = $aa;
                            $gross = 0;
                        } else {
                            $gross = $aa;
                            $cap_investment = 0;
                        }
                       $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit_nature`(`nature_id`, `permit_id`, `capital_investment`, `last_year_gross`,`scale_code`, `nature_active`, `nature_paid`, `nature_retire`, `recpaid`, `updated_by`,`nature_application_type`, `updated_date`) VALUES ($nature,$permit_id,$cap_investment,$gross,$b_scale_arr,null,null,null,0,'$username','$nature_application_type',now()) ");
                      
                        if(!$q){
                            echo "error66";
                            }
                        if($q){
                        }else{
                            $error++;
                        }
                    }
                }
            }
           
            //  -------------------------------------------------business_permit_nature

            
        // Audit Trail =====================================================================================
        // Audit Trail =====================================================================================
        // Audit Trail =====================================================================================
        $au_username = $_SESSION["uname"];
        $au_action = "Update Business Application";
        $au_desc = "Update Business Details >".$business_name;
        mysqli_query($conn,"INSERT INTO `geo_bpls_audit_trail`(`username`, `action`, `description`) VALUES ('$au_username','$au_action','$au_desc') ");
        // Audit Trail =====================================================================================
        // Audit Trail =====================================================================================
        // Audit Trail ===================================================================================== 




             if($error >0){
                ?>
                     <script>
                     $(document).ready(function(){
                         myalert_success_af("Failed to updated application form!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($permit_id); ?>");
                     });
                    </script>
                <?php
            }else{
                // redirect to multistep
               ?>
                    <script>
                     $(document).ready(function(){
                         myalert_success_af("Application form updated!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($permit_id); ?>");

                     });
                    </script>
               <?php
            }
        }
// ======================================================================================== saving application

?>