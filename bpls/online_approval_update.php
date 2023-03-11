<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

// ======================================================================================== saving application
        include('php/connect.php');
        include('php/web_connection.php');
        include("jomar_assets/input_validator.php");
        $business_name = validate_str($conn,$_POST['business_name']); 
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


         if($_POST["hidden_validation"] == "save"){
            
            //  -------------------------------------------------business

            // insert in geo business tbl
            $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business`(`business_name`, `barangay_id`, `business_type_code`, `economic_area_code`, `economic_org_code`, `lgu_code`, `occupancy_code`, `province_code`, `region_code`, `scale_code`, `sector_code`, `zone_id`, `business_address_street`, `business_application_date`, `business_area`, `business_mob_no`, `business_tel_no`, `business_contact_name`, `business_dti_sec_cda_reg_date`, `business_dti_sec_cda_reg_no`, `business_email`, `business_emergency_contact`, `business_emergency_email`, `business_emergency_mobile`, `business_employee_female`, `business_employee_male`, `business_employee_resident`, `business_employee_total`,   `business_remark`, `business_tax_incentive`, `business_tax_incentive_entity`, `business_tin_reg_no`, `business_trade_name_franchise`, `updated_by`, `updated_date`) VALUES ('$business_name','$b_brgy','$type_of_business','$economic_area_code','$economic_org_code','$b_mun','$rented_status','$b_prov','$b_reg','$scale','$sector','$b_zone','$b_street','$application_date','$business_area','$b_mob_no','$b_tel_no','$business_contact_person','$dti_sec_cdaRegistrationDate','$dti_sec_cdaRegistrationNo','$b_email','$ec_person','$ec_email','$ec_tel_no','emp_female','emp_male','$no_emp_lgu','$emp_establishment_count','$b_remarks','$tax_incentive_status','$tax_incentive_entity','$tinNo','$trade_name','$username',now() )");
            if(!$q){
                echo "error11";
            }

            // getting business ID
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
            $uniqID = $_POST["uniqID"];
            $q65v = mysqli_query($wconn,"SELECT * from geo_bpls_business_requirement_ol where uniqID = '$uniqID' ");
            while($r65v = mysqli_fetch_assoc($q65v)){

                $requirement_id = $r65v["requirement_id"];
                $requirement_file = $r65v["requirement_file"];
                $requirement_desc = $r65v["requirement_desc"];


                mysqli_query($conn,"INSERT INTO `geo_bpls_business_requirement`( `requirement_id`, `business_id`, `requirement_active`,`requirement_file`) VALUES ($requirement_id,$business_id,1,'$requirement_file') ");

                  // insert requirement history
                  $q = mysqli_query($conn,"INSERT INTO `geo_bpls_uploaded_requirements_history`( `owner_name`, `business_name`,`docs_type`, `transaction_status`, `file_name`, `date_application`) VALUES ('$fullname','$business_name','$requirement_desc','1','$requirement_file','$application_date') ");
                  if(!$q){
                   echo "error633";
                  }

            }

            // requirement ----------------------------------------------

             //  owner -------------------------------------------------
             $q = mysqli_query($conn, "INSERT INTO `geo_bpls_owner`(business_id,`owner_first_name`, `owner_middle_name`, `owner_last_name`, `barangay_id`, `citizenship_id`, `civil_status_id`, `gender_code`, `lgu_code`, `province_code`, `region_code`, `zone_id`,  `owner_address_street`, `owner_birth_date`, `owner_email`, `owner_legal_entity`, `owner_mobile`,`4PS_status`,`PWD_status`,`SP_status`,  `updated_by`, `updated_date`)   VALUES ('$business_id','$tax_payer_fname','$tax_payer_mname','$tax_payer_lname','$o_brgy','$citizenship_id','$civil_status_id','$gender_code','$o_mun','$o_prov','$o_reg','$o_zone','$o_street','$owner_birth_date','$o_email','$owner_legal_entity','$o_mob_no','$FPS_status','$PWD_status','$SP_status','$username',now() ) ");
              
                if(!$q){
                    echo "error443";
                }
             //  owner -------------------------------------------------

            //  get owners id
            $id_query = mysqli_query($conn,"SELECT owner_id FROM `geo_bpls_owner` where business_id = '$business_id' ");
            $row = mysqli_fetch_assoc($id_query);
            $owner_id = $row["owner_id"];
            if(!$id_query){
                       echo "error454";
                }
            //  -------------------------------------------------business_permit
            $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit`( `permit_no`, `owner_id`, `business_id`, `payment_frequency_code`, `status_code`, `step_code`, `permit_active`, `permit_application_date`, `permit_approved`, `permit_approved_remark`, `permit_for_year`, `permit_paid`, `permit_pin`, `permit_released`, `permit_released_date`, `retirement_date`, `retirement_date_processed`, `updated_by`, `updated_date`) VALUES (null,'$owner_id','$business_id','$mode_of_payment','$application_type','APPLI','0','$application_date','0','$permit_approved_remark','$year','0',null,'0',null,null,null,'$username',now()) ");

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

            $md5_permit_id = md5($permit_id);
            // get permit_id

            //  -------------------------------------------------business_permit_nature
                if(isset($_POST['nature'])){
                $arr_count3 = count($_POST['nature']);
                // insert
                if($arr_count3>0){
                    for ($i=0; $i<$arr_count3; $i++) {
                        $nature = $_POST['nature'][$i];
                        $aa = $_POST['cap_investment'][$i];

                        if ($application_type == "NEW") {
                            $cap_investment = $aa;
                            $gross = 0;
                        } else {
                            $gross = $aa;
                            $cap_investment = 0;
                        }

                       $q = mysqli_query($conn, "INSERT INTO `geo_bpls_business_permit_nature`(`nature_id`, `permit_id`, `capital_investment`, `last_year_gross`, `nature_active`, `nature_paid`, `nature_retire`, `recpaid`,`nature_application_type`, `updated_by`, `updated_date`) VALUES ($nature,$permit_id,$cap_investment,$gross,null,null,null,0,'$application_type','$username',now()) ");
                        

                   

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
            
             if($error >0){
                ?>
                     <script>
                     $(document).ready(function(){
                         myalert_success_af("Failed!!","bplsmodule.php?redirect=online_transac");
                     });
                    </script>
                <?php
            }else{
                // Update Online Application Status and STEP from user and insert in local server
            mysqli_query($wconn,"UPDATE `geo_bpls_ol_application` SET `step` = 'ASSESSMENT', `status` = 'APPROVED', permit_id ='$permit_id' where uniqID = '$uniqID' ");
            $q = mysqli_query($wconn,"SELECT `id`, `uniqID`, `permit_id`, `customer_id`, `fname`,`mname`,`lname`, `b_name`, `date`, `address`, `step`, `status`, `remarks`, `created_at` FROM `geo_bpls_ol_application` where permit_id ='$permit_id' and  uniqID = '$uniqID' ");
            $r = mysqli_fetch_assoc($q);
            
            $id = validate_str($wconn,$r["id"]);
            $uniqID = validate_str($wconn,$r["uniqID"]);
            $permit_id = validate_str($wconn,$r["permit_id"]);
            $customer_id = validate_str($wconn,$r["customer_id"]);
            $fname = validate_str($wconn,$r["fname"]);
            $mname = validate_str($wconn,$r["mname"]);
            $lname = validate_str($wconn,$r["lname"]);
            $b_name = validate_str($wconn,$r["b_name"]);
            $date = validate_str($wconn,$r["date"]);
            $address = validate_str($wconn,$r["address"]);
            $step = validate_str($wconn,$r["step"]);
            $status = validate_str($wconn,$r["status"]);
            $remarks = validate_str($wconn,$r["remarks"]);
            $created_at = validate_str($wconn,$r["created_at"]);
            
            mysqli_query($conn,"INSERT INTO `geo_bpls_ol_application`(`id`, `uniqID`, `permit_id`, `customer_id`, `fname`,`mname`,`lname`, `b_name`, `date`, `address`, `step`, `status`, `remarks`, `created_at`) VALUES ('$id','$uniqID','$permit_id','$customer_id','$fname','$mname','$lname','$b_name','$date','$address','$step','$status','$remarks','$created_at') ");
            
             // remove ol details ex permit/business/owners
            
            $q252 = mysqli_query($wconn,"SELECT business_id, owner_id, permit_id FROM geo_bpls_business_permit_ol where  uniqID = '$uniqID' ");
            $r252 = mysqli_fetch_assoc($q252);
            $business_id = $r252["business_id"];
            $owner_id = $r252["owner_id"];
            $permit_id = $r252["permit_id"];
            
            mysqli_query($wconn,"DELETE FROM `geo_bpls_business_permit_nature_ol` WHERE permit_id = '$permit_id' ");
            mysqli_query($wconn,"DELETE FROM `geo_bpls_business_permit_ol` WHERE permit_id = '$permit_id' ");
            // mysqli_query($wconn,"DELETE FROM `geo_bpls_business_requirement_ol` WHERE uniqID = '$uniqID' ");
            mysqli_query($wconn,"DELETE FROM `geo_bpls_business_ol` WHERE business_id = '$business_id' ");
            mysqli_query($wconn,"DELETE FROM `geo_bpls_lessor_details_ol` WHERE business_id = '$business_id' ");
            mysqli_query($wconn,"DELETE FROM `geo_bpls_owner_ol` WHERE owner_id = '$owner_id' ");
             
         //  EMAIL NOTIFICATION================
                
        $q433 = mysqli_query($wconn,"SELECT email from usersacc_tbl inner join geo_bpls_ol_application on geo_bpls_ol_application.customer_id =  usersacc_tbl.usersacc_id where uniqID = '$uniqID' ");
        $r433 = mysqli_fetch_assoc($q433);
        $to = $r433["email"];

            //Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'great.system.mailer@gmail.com';                     //SMTP username
                $mail->Password   = 'ahyou1324^^_mailer';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 465;                                    // 587 TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                //Recipients
                $mail->setFrom('great.system.mailer@gmail.com', 'GreatSystem');
                // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
                $mail->AddAddress($to);      //Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');
                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Business Permit';
                $mail->Body  = '<table style="width:100%; font-size:16px; margin-top:5px;">
                    <tr>
                         <td><p>Good Day, This is to inform you that your Business Application has been Approved. we will Assess your business application.</p></td>
                    </tr>
                </table>
                <br>
                <br>
                <br>';
               
                $mail->send();
                ?>
                <script>
                    // alert("We already sent you an email");
                    // location.replace("login.php");
                </script>
                <?php
                } catch (Exception $e) {
                    ?>
                <script>
                    // alert("Sending error");
                    // location.replace("login.php");
                </script>
                <?php
                }       
        
                //  EMAIL NOTIFICATION================

                // redirect to multistep
               ?>
                    <script>
                     $(document).ready(function(){
                         myalert_success_af("Form Application Approved!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo $md5_permit_id; ?>");
                     });
                    </script>
               <?php
            }
            //  -------------------------------------------------business_permit_nature

        }

?>