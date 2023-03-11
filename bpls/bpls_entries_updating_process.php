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
        $permit_id = $_POST["permit_num"];

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
        
        $year = date("Y");
        // tax payer
        $tax_payer_lname = validate_str($conn,$_POST['tax_payer_lname']);
        $tax_payer_fname = validate_str($conn,$_POST['tax_payer_fname']);
        $tax_payer_mname = validate_str($conn,$_POST['tax_payer_mname']);
        // trade name
        $trade_name = validate_str($conn,$_POST['trade_name']);

        $application_type = validate_str($conn,$_POST['application_type']);
        $mode_of_payment = validate_str($conn,$_POST['mode_of_payment']);

        // emergency contact
        $ec_person = validate_str($conn,$_POST['ec_person']);
        $ec_tel_no = validate_str($conn,$_POST['ec_tel_no']);
        $ec_email = validate_str($conn,$_POST['ec_email']);



        
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
    
                           $q = mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`) VALUES ('$requirements_id','$business_id','1') ");
                           if($q){
                            }else{
                                $error++;
                            }
                        }
                    }
                }
            }else{
                mysqli_query($conn,"DELETE FROM `geo_bpls_business_requirement` WHERE `business_id` = '$business_id' ");

                if(isset($_POST['requirements'])){
                    $arr_count2 = count($_POST['requirements']);
                    // insert
                    if($arr_count2>0){
                        for ($ib=0; $ib<$arr_count2; $ib++) {
    
                            $requirements_id = $_POST['requirements'][$ib];
    
                          $q =  mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`) VALUES ('$requirements_id','$business_id','1') ");
                          if($q){
                            }else{
                                $error++;
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
                        $error++;
                    }
                }
            }else{
                if($rented_status == "R") {
                  $q = mysqli_query($conn, "UPDATE `geo_bpls_lessor_details` SET `fullname`='$lessors_fullname',`address`='$l_address' ,`email`='$l_email_add',`mob_no`='$l_mob_tel',`monthly_rental`='$monthly_rental' WHERE `business_id` = '$business_id' ");
                    if($q){
                    }else{
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
              $error++;
            }

            // business-----------------------------------------

             //  owner -------------------------------------------------
             $q = mysqli_query($conn, "UPDATE `geo_bpls_owner` SET `owner_first_name` = '$tax_payer_fname',  `owner_middle_name` = '$tax_payer_mname', `owner_last_name` ='$tax_payer_lname', `barangay_id` = '$o_brgy', `citizenship_id` = '$citizenship_id', `civil_status_id` = '$civil_status_id' ,  `gender_code` = '$gender_code', `lgu_code` = '$o_mun', `province_code` = '$o_prov',  `region_code` = '$o_reg', `zone_id`= '$o_zone',  `owner_address_street`= '$o_street', `owner_birth_date`= '$owner_birth_date',  `owner_email` = '$o_email', `owner_legal_entity` = '$owner_legal_entity', `owner_mobile` = '$o_mob_no', `updated_by` =  '$username' ,  `updated_date` = now() where business_id =  '$business_id'   ");
             if($q){
            }else{
              $error++;
            }
             //  owner -------------------------------------------------
              //  get owners id
            //  -------------------------------------------------business_permit

            $q = mysqli_query($conn, "UPDATE  `geo_bpls_business_permit` SET  `payment_frequency_code` = '$mode_of_payment', `status_code` =  '$application_type',  `step_code` = 'ASSES' , `permit_application_date` = '$application_date',`updated_by` = '$username', `updated_date` = now() where   business_id =  '$business_id'  ");
            if($q){
            }else{
              $error++;
            }
            //  -------------------------------------------------business_permit
                        //  -------------------------------------------------business_permit_nature
                if(isset($_POST['nature'])){
                $arr_count3 = count($_POST['nature']);
                // insert
                if($arr_count3>0){

                    // delete 
                    mysqli_query($conn,"DELETE FROM geo_bpls_business_permit_nature where permit_id = '$permit_id' ");
                    for ($i=0; $i<$arr_count3; $i++) {
                        $nature = $_POST['nature'][$i];
                        $aa = $_POST['cap_investment'][$i];


                        if($application_type == "NEW"){
                            $cap_investment = $aa; 
                            $gross = null;
                        }else{
                            $gross = $aa; 
                            $cap_investment = null;
                        }
                       $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit_nature`(`nature_id`, `permit_id`, `capital_investment`, `last_year_gross`, `nature_active`, `nature_paid`, `nature_retire`, `recpaid`, `updated_by`, `updated_date`) VALUES ('$nature','$permit_id',$cap_investment,'$gross',null,null,null,0,'$username',now()) ");
                       if($q){
                        }else{
                        $error++;
                        }
                    }
                }
            }
            //  -------------------------------------------------business_permit_nature
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
// ======================================================================================== saving application

?>