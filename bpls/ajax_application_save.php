<?php
    session_start();
    include('../php/connect.php');
    include("../jomar_assets/input_validator.php");
    $data = $_POST['serialize'];
    parse_str($data,$arr);


        $business_name = validate_str($conn,$arr['business_name']); 
        $business_id = validate_str($conn,$arr['business_id']); 
        $application_date = validate_str($conn,$arr['application_date']);
        $dti_sec_cdaRegistrationNo = validate_str($conn,$arr['dti_sec_cdaRegistrationNo']);
        $dti_sec_cdaRegistrationDate = validate_str($conn,$arr['dti_sec_cdaRegistrationDate']);
        $type_of_business = validate_str($conn,$arr['type_of_business']);
        $tinNo = validate_str($conn,$arr['tinNo']);
        // amendment optional
        $amd_from = validate_str($conn,$arr['amd_from']);
        $amd_to = validate_str($conn,$arr['amd_to']);
        // tax incentive
        if(isset($arr['tax_incentive_status'])){


        $tax_incentive_status = validate_str($conn,$arr['tax_incentive_status']);
        if($tax_incentive_status == "Yes"){
            $tax_incentive_status = "1";
            $tax_incentive_entity = validate_str($conn,$arr['tax_incentive_entity']);
        }else{
            $tax_incentive_entity = "0";
            $tax_incentive_status = "1";
        }

        }else{
            $tax_incentive_entity = "0";
            $tax_incentive_status = "1";
        }

        $year = date("Y");
        // tax payer
        $tax_payer_lname = validate_str($conn,$arr['tax_payer_lname']);
        $tax_payer_fname = validate_str($conn,$arr['tax_payer_fname']);
        $tax_payer_mname = validate_str($conn,$arr['tax_payer_mname']);
        // trade name
        $trade_name = validate_str($conn,$arr['trade_name']);

        $application_type = validate_str($conn,$arr['application_type']);
        $mode_of_payment = validate_str($conn,$arr['mode_of_payment']);

        // emergency contact
        $ec_person = validate_str($conn,$arr['ec_person']);
        $ec_tel_no = validate_str($conn,$arr['ec_tel_no']);
        $ec_email = validate_str($conn,$arr['ec_email']);

        $b_area_sqm = validate_str($conn,$arr['b_area_sqm']);
        $emp_establishment_count = validate_str($conn,$arr['emp_establishment_count']);
        $no_emp_lgu = validate_str($conn,$arr['no_emp_lgu']);


        // business add
        // brgy_id
        $b_street = validate_str($conn,$arr['b_street']);
        $b_brgy = validate_str($conn,$arr['b_brgy']); 
        $b_mun = "MAJ";
        $b_prov = "LAG";
        $b_postal_code = validate_str($conn,$arr['b_postal_code']);
        $b_email = validate_str($conn,$arr['b_email']);
        $b_tel_no = validate_str($conn,$arr['b_tel_no']);
        $b_mob_no = validate_str($conn,$arr['b_mob_no']);

        // ask same address in business?
        $same_address = validate_str($conn,$arr['same_address']);
            if($same_address == "yes"){
                $o_street = $b_street;
                $o_brgy = $b_brgy;
                $o_mun = "MAJ";
                $o_prov = "LAG";
                $o_postal_code = validate_str($conn,$arr['b_postal_code']);
                $o_email = $b_email;
                $o_tel_no = $b_tel_no;
                $o_mob_no = $b_mob_no;
            }else{
                $o_street = validate_str($conn,$arr['o_street']);
                $o_brgy = validate_str($conn,$arr['o_brgy']);
                $o_mun = validate_str($conn,$arr['o_mun']);
                $o_prov = validate_str($conn,$arr['o_prov']);
                $o_postal_code = validate_str($conn,$arr['o_postal_code']);
                $o_email = validate_str($conn,$arr['o_email']);
                $o_tel_no = validate_str($conn,$arr['o_tel_no']);
                $o_mob_no = validate_str($conn,$arr['o_mob_no']);
            }
        // owner add

        $rented_status = validate_str($conn,$arr['rented_status']);

        // lessor
        if($rented_status == "R"){
            $lessors_fullname = validate_str($conn,$arr['lessors_fullname']);
            $l_address = validate_str($conn,$arr['l_address']);
            $l_email_add = validate_str($conn,$arr['l_email_add']);
            $monthly_rental = validate_str($conn,$arr['monthly_rental']);
            $l_mob_tel = validate_str($conn,$arr['l_mob_tel']);
        }else{
            $lessors_fullname = "";
            $l_address = "";
            $l_email_add = "";
            $monthly_rental = "";
            $l_mob_tel = "";
        }
        $username = $_SESSION['uname'];
        // line of business
        $nature = validate_str($conn,$arr['nature']);
        $cap_investment = validate_str($conn,$arr['cap_investment']);

            //needed input 
        $sector="";
        $scale ="";
        $b_zone ="";
        $business_area ="";
        $business_contact_person ="";
        $b_remarks = "";
        $economic_area_code = "";
        $economic_org_code = "";

        $citizenship_id = "";
        $owner_address_house_bldg_lot_no = "";
        $civil_status_id = "";
        $gender_code = "";
        $req_code = "";
        $gender_code = "";
        $o_zone = "";
        $owner_address_subdivision = "";
        $owner_birth_date = "";
        $owner_building_name = "";
        $owner_legal_entity = "";
        $permit_approved_remark = "";
        $owner_address_unit_no = "";
        $id_query = mysqli_query($conn,"SELECT count(*) as datacount FROM `geo_bpls_business` where business_id = '$business_id' ");
        $row = mysqli_fetch_assoc($id_query);
        
        if($row["datacount"] == 0){
            // lessor -------------------------------------------------
            if ($rented_status == "R") {
                mysqli_query($conn, "INSERT INTO `geo_bpls_lessor_details`( `business_id`, `fullname`, `address`, `email`, `mob_no`, `monthly_rental`) VALUES ('$business_id','$lessors_fullname','$l_address','$l_email_add','$l_mob_tel','$monthly_rental') ");
            }
            // lessor -------------------------------------------------

            //  -------------------------------------------------business

            // insert in geo business tbl
            $query = mysqli_query($conn, "INSERT INTO `geo_bpls_business`(`business_id`,`business_name`, `barangay_id`, `business_type_code`, `economic_area_code`, `economic_org_code`, `lgu_code`, `occupancy_code`, `province_code`, `region_code`, `scale_code`, `sector_code`, `zone_id`, `business_address_street`, `business_application_date`, `business_area`, `business_mob_no`, `business_tel_no`, `business_contact_name`, `business_dti_sec_cda_reg_date`, `business_dti_sec_cda_reg_no`, `business_email`, `business_emergency_contact`, `business_emergency_email`, `business_emergency_mobile`, `business_employee_female`, `business_employee_male`, `business_employee_resident`, `business_employee_total`,   `business_remark`, `business_tax_incentive`, `business_tax_incentive_entity`, `business_tin_reg_no`, `business_trade_name_franchise`, `updated_by`, `updated_date`) VALUES ('$business_id','$business_name','$b_brgy','$type_of_business','$economic_area_code','$economic_org_code','$b_mun','$rented_status','$b_prov','$req_code','$scale','$sector','$b_zone','$b_street','$application_date','$business_area','$b_mob_no','$b_tel_no','$business_contact_person','$dti_sec_cdaRegistrationDate','$dti_sec_cdaRegistrationNo','$b_email','$ec_person','$ec_email','$ec_tel_no','emp_female','emp_male','employee_resident','employee_total','$b_remarks','$tax_incentive_status','$tax_incentive_entity','$tinNo','$trade_name','$username',now() )");
            //  -------------------------------------------------business
            
            // requirement ----------------------------------------------
            if(isset($arr['requirements'])){
                $arr_count2 = count($arr['requirements']);
                // insert
                if($arr_count2>0){
                    for ($ib=0; $ib<$arr_count2; $ib++) {

                        $requirements_id = $arr['requirements'][$ib];

                        mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`) VALUES ('$requirements_id','$business_id','1') ");
                    }
                }
            }
            // requirement ----------------------------------------------

        


             //  owner -------------------------------------------------
             $query = mysqli_query($conn, "INSERT INTO `geo_bpls_owner`( `business_id`,`owner_first_name`, `owner_middle_name`, `owner_last_name`, `barangay_id`, `citizenship_id`, `civil_status_id`, `gender_code`, `lgu_code`, `province_code`, `region_code`, `zone_id`, `owner_address_house_bldg_lot_no`, `owner_address_street`, `owner_address_subdivision`, `owner_address_unit_no`, `owner_birth_date`, `owner_building_name`, `owner_email`, `owner_legal_entity`, `owner_mobile`, `updated_by`, `updated_date`)   VALUES ('$business_id','$tax_payer_fname','$tax_payer_mname','$tax_payer_lname','$o_brgy','$citizenship_id','$civil_status_id','$gender_code','$o_mun','$o_prov','$req_code','$o_zone','$owner_address_house_bldg_lot_no','$o_street','$owner_address_subdivision','$owner_address_unit_no','$owner_birth_date','$owner_building_name','$o_email','$owner_legal_entity','$o_mob_no','$username',now() ) ");
             //  owner -------------------------------------------------

            //  get owners id
            $id_query = mysqli_query($conn,"SELECT owner_id FROM `geo_bpls_owner` where business_id = '$business_id' ");
            $row = mysqli_fetch_assoc($id_query);
                $owner_id = $row["owner_id"];

            //  -------------------------------------------------business_permit
            $query = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit`( `permit_no`, `owner_id`, `business_id`, `payment_frequency_code`, `status_code`, `step_code`, `permit_active`, `permit_application_date`, `permit_approved`, `permit_approved_remark`, `permit_for_year`, `permit_paid`, `permit_pin`, `permit_released`, `permit_released_date`, `retirement_date`, `retirement_date_processed`, `updated_by`, `updated_date`) VALUES (null,'$owner_id','$business_id','$mode_of_payment','$application_type','APPLI','0','$application_date','0','$permit_approved_remark','$year','0',null,'0',null,null,null,'$username',now()) ");

            //  -------------------------------------------------business_permit
            $id_query = mysqli_query($conn,"SELECT permit_id FROM `geo_bpls_business_permit` where business_id = '$business_id' ");
            $row = mysqli_fetch_assoc($id_query);
                $permit_id = $row["permit_id"];
            // get permit_id

            //  -------------------------------------------------business_permit_nature
                 $query = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit_nature`(`nature_id`, `permit_id`, `capital_investment`, `last_year_gross`, `nature_active`, `nature_paid`, `nature_retire`, `recpaid`, `updated_by`, `updated_date`) VALUES ('$nature','$permit_id','$cap_investment',null,null,null,null,0,'$username',now()) ");
            //  -------------------------------------------------business_permit_nature


            // else for update
        }else{

            // requirements ---------------------------------------------------
            // check req if exist
        $checkreqquery = mysqli_query($conn,"SELECT count(*) as checkreq_count FROM `geo_bpls_business_requirement` WHERE `business_id` = '$business_id' ");
        $checkreqrow = mysqli_fetch_assoc($checkreqquery);
            if($checkreqrow["checkreq_count"] == 0){
                if(isset($arr['requirements'])){
                    $arr_count2 = count($arr['requirements']);
                    // insert
                    if($arr_count2>0){
                        for ($ib=0; $ib<$arr_count2; $ib++) {
    
                            $requirements_id = $arr['requirements'][$ib];
    
                            mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`) VALUES ('$requirements_id','$business_id','1') ");
                        }
                    }
                }
            }else{
                mysqli_query($conn,"DELETE FROM `geo_bpls_business_requirement` WHERE `business_id` = '$business_id' ");

                if(isset($arr['requirements'])){
                    $arr_count2 = count($arr['requirements']);
                    // insert
                    if($arr_count2>0){
                        for ($ib=0; $ib<$arr_count2; $ib++) {
    
                            $requirements_id = $arr['requirements'][$ib];
    
                            mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`) VALUES ('$requirements_id','$business_id','1') ");
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
                    mysqli_query($conn, "INSERT INTO `geo_bpls_lessor_details`( `business_id`, `fullname`, `address`, `email`, `mob_no`, `monthly_rental`) VALUES ('$business_id','$lessors_fullname','$l_address','$l_email_add','$l_mob_tel','$monthly_rental') ");
                }
            }else{
                if($rented_status == "R") {
                    mysqli_query($conn, "UPDATE `geo_bpls_lessor_details` SET `fullname`='$lessors_fullname',`address`='$l_address' ,`email`='$l_email_add',`mob_no`='$l_mob_tel',`monthly_rental`='$monthly_rental' WHERE `business_id` = '$business_id' ");
                }else{
                    mysqli_query($conn,"DELETE FROM `geo_bpls_lessor_details` WHERE `business_id` = '$business_id' ");
                }
            }
            // -----------------------------------------lessor

            
            // business-----------------------------------------

            // update geo business tbl
            $query = mysqli_query($conn, "UPDATE `geo_bpls_business` SET `business_name` = '$business_name',`barangay_id` = '$b_brgy', `business_type_code`='$type_of_business', `economic_area_code`='$economic_area_code', `economic_org_code` ='$economic_org_code',`lgu_code`= '$b_mun', `occupancy_code` = '$rented_status',`province_code` = '$b_prov',`scale_code` = '$scale',`sector_code` = '$sector' ,`zone_id` = '$o_zone', `business_address_street` = '$b_street', `business_application_date` = '$application_date', `business_area` = '$business_area',`business_mob_no` = '$b_mob_no', `business_tel_no` = '$b_tel_no', `business_contact_name` = '$business_contact_person', `business_dti_sec_cda_reg_date` = '$dti_sec_cdaRegistrationDate',`business_dti_sec_cda_reg_no` = '$dti_sec_cdaRegistrationNo', `business_email` = '$b_email', `business_emergency_contact` = '$ec_person', `business_emergency_email` = '$ec_email', `business_emergency_mobile` ='$ec_tel_no', `business_remark` = '$b_remarks', `business_tax_incentive` = '$tax_incentive_status', `business_tax_incentive_entity` = '$tax_incentive_entity', `business_tin_reg_no` = '$tinNo', `business_trade_name_franchise` = '$trade_name', `updated_by` = '$username', `updated_date` = now()  where business_id =  '$business_id' ");
            // business-----------------------------------------


             //  owner -------------------------------------------------
             $query = mysqli_query($conn, "UPDATE `geo_bpls_owner` SET `owner_first_name` = '$tax_payer_fname',  `owner_middle_name` = '$tax_payer_mname', `owner_last_name` ='$tax_payer_lname', `barangay_id` = '$o_brgy', `citizenship_id` = '$citizenship_id', `civil_status_id` = '$civil_status_id' ,  `gender_code` = '$gender_code', `lgu_code` = '$o_mun', `province_code` = '$o_prov',  `region_code` = '$req_code', `zone_id`= '$o_zone', `owner_address_house_bldg_lot_no`= '$owner_address_house_bldg_lot_no',  `owner_address_street`= '$o_street', `owner_address_subdivision` = '$owner_address_subdivision', `owner_address_unit_no` = '$owner_address_unit_no', `owner_birth_date`= '$owner_birth_date', `owner_building_name` = '$owner_building_name',  `owner_email` = '$o_email', `owner_legal_entity` = '$owner_legal_entity', `owner_mobile` = '$o_mob_no', `updated_by` =  '$username' ,  `updated_date` = now() where business_id =  '$business_id'   ");
             //  owner -------------------------------------------------
              //  get owners id
            //  -------------------------------------------------business_permit

            mysqli_query($conn, "UPDATE  `geo_bpls_business_permit` SET  `payment_frequency_code` = '$mode_of_payment', `status_code` =  '$application_type',  `step_code` = 'APPLI' , `permit_application_date` = '$application_date',`updated_by` = '$username', `updated_date` = now() where   business_id =  '$business_id'  ");
            //  -------------------------------------------------business_permit
            $id_query = mysqli_query($conn,"SELECT permit_id FROM `geo_bpls_business_permit` where business_id = '$business_id' ");
            $row = mysqli_fetch_assoc($id_query);
            $permit_id = $row["permit_id"];
            // business_permit_nature-------------------------------------------------
            $query = mysqli_query($conn,"UPDATE `geo_bpls_business_permit_nature` SET `nature_id` = '$nature', `capital_investment` = '$cap_investment', `updated_by` = '$username',  `updated_date` = now() where permit_id = '$permit_id ' ");
            //  business_permit_nature-------------------------------------------------
        }


?>