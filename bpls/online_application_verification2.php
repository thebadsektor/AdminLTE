<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

include 'jomar_assets/enc.php';
include 'php/web_connection.php';
include 'php/connect.php';
$uniqID = $_GET["a"];
$ver = 0;

// detete bpls application notification
if (isset($_GET["id"])) {
    $id = mysqli_real_escape_string($conn,$_GET["id"]);
    $q = mysqli_query($conn, "DELETE from greatsystem_notification where id = '$id' ");
}
// detete bpls application notification

// check kung nakapag fill-up na ng form
$q34l = mysqli_query($wconn,"SELECT * from geo_bpls_business_permit_ol where uniqID = '$uniqID' ");
$aaab = mysqli_num_rows($q34l);
if($aaab == 0){
    ?>
    <div class="alert alert-warning" style="text-align:center;">
        <h3>No Business Application Form Exist!! <br>
        User need to fill-up the Application Form.
        </h3>
    </div>
    <?php
}else{

if(isset($_POST["disapprove_process"])){

    
    $remarks = mysqli_real_escape_string($wconn, $_POST["remarks"]);

        $q433 = mysqli_query($wconn,"SELECT email from usersacc_tbl inner join geo_bpls_ol_application on geo_bpls_ol_application.customer_id =  usersacc_tbl.usersacc_id where uniqID = '$uniqID' ");
        $r433 = mysqli_fetch_assoc($q433);
         $to = $r433["email"];

         //  EMAIL NOTIFICATION================
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
                    <td><p>Good Day, This is to inform you that your Business Application has been Disapproved.</p></td>
                    </tr>
                </table>
                <br>
                <br>
                <br>';
                if($remarks != ""){
                $mail->Body  .= '<div style=" font-size:16px;" >
                    Reason: <i style="color:red;">'.$remarks.'</i>
                </div>
                ';
                    }
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

    mysqli_query($wconn, "UPDATE `geo_bpls_ol_application` set  `status` = 'DISAPPROVED', remarks='$remarks' where uniqID = '$uniqID' ");

   ?>
    <script>
        alert("Application Disapproved!");
    </script>
   <?php
}


// check uniqID if Exist
$var_exist_status = 0;
$q543 = mysqli_query($wconn, "SELECT * FROM `geo_bpls_ol_application` where uniqID = '$uniqID' ");
if (mysqli_num_rows($q543) > 0) {
    // Application Status
    $r545 = mysqli_fetch_assoc($q543);
    if($r545["status"] == "DISAPPROVED" ){
        ?>
            <div class ="alert alert-danger">
                <h3>DISAPPROVED </h3>
        <?php 
            if($r545["remarks"] != ""){
        ?>
                <b>Remarks:</b> <p><?php echo $r545["remarks"]; ?></p>
        <?php } ?>
            </div>
        <?php
    }

    if($r545["status"] == "APPROVED" ){
        ?>
            <div class ="alert alert-success">
                <h3>APPROVED </h3>
        <?php 
            if($r545["remarks"] != ""){
        ?>
                <b>Remarks:</b> <p><?php echo $r545["remarks"]; ?></p>
        <?php } ?>
            </div>
        <?php
    }
    $app_status = $r545["status"];
    $var_exist_status++;
}

// section for validating all requirements
$qy = mysqli_query($wconn, "SELECT * FROM `geo_bpls_requirement` where requirement_default = 0");

while ($rw = mysqli_fetch_assoc($qy)) {
    $requirement_id = $rw["requirement_id"];
    $qy1 = mysqli_query($wconn, "SELECT * FROM `geo_bpls_business_requirement_ol` where requirement_id = '$requirement_id' and uniqID = '$uniqID' and requirement_status != 1 ");
    if (mysqli_num_rows($qy1) == 1) {
        $ver++;
    }

}
    if($ver == 0 && $var_exist_status > 0) {
        $q11 = mysqli_query($wconn,"SELECT retirement_date_processed, retirement_file, 4PS_status, PWD_status, SP_status, permit_for_year ,geo_bpls_owner_ol.owner_id, geo_bpls_business_permit_ol.permit_approved_remark, geo_bpls_business_permit_ol.permit_approved,permit_id, civil_status_id, geo_bpls_business_ol.business_id, business_emergency_contact, geo_bpls_business_permit_ol.payment_frequency_code, status_code, step_code, permit_application_date, business_name, geo_bpls_business_ol.barangay_id as b_barangay_id , business_type_code, economic_area_code, economic_org_code, geo_bpls_business_ol.lgu_code as b_lgu_code, occupancy_code, geo_bpls_business_ol.province_code as b_province_code, geo_bpls_business_ol.region_code as b_reg_code, scale_code, sector_code, business_address_street, business_application_date, business_area, business_mob_no, business_tel_no, business_contact_name, business_dti_sec_cda_reg_date, business_dti_sec_cda_reg_no, business_email, business_email, business_emergency_email, business_emergency_mobile, business_employee_resident, business_employee_total,business_tax_incentive, business_tax_incentive_entity, business_tin_reg_no, business_trade_name_franchise, owner_first_name, owner_middle_name, owner_last_name, geo_bpls_owner_ol.barangay_id as o_barangay_id, citizenship_id,gender_code, geo_bpls_owner_ol.lgu_code as o_lgu_code, geo_bpls_owner_ol.province_code as o_province_code, geo_bpls_owner_ol.region_code as o_reg_code, geo_bpls_owner_ol.zone_id as o_zone_id, geo_bpls_owner_ol.owner_address_street, owner_birth_date, owner_email,owner_legal_entity, owner_mobile FROM `geo_bpls_business_permit_ol`
        INNER JOIN geo_bpls_business_ol on geo_bpls_business_ol.business_id = geo_bpls_business_permit_ol.business_id
        INNER JOIN geo_bpls_owner_ol on geo_bpls_owner_ol.owner_id = geo_bpls_business_permit_ol.owner_id
        WHERE geo_bpls_business_permit_ol.uniqID = '$uniqID'; 
    ");

    $r11 = mysqli_fetch_assoc($q11);
    
    $barangay_id0 = $r11["b_barangay_id"];
    $qaddddd = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as b_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id0' ");
    $raddddd = mysqli_fetch_assoc($qaddddd);
    $business_address = $raddddd["b_add"];
    $owner_id0 = $r11["o_barangay_id"];

    $qadddd2 = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as o_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$owner_id0' ");
    $raddddd2 = mysqli_fetch_assoc($qadddd2);
    $owner_address = $raddddd2["o_add"];

    $status_code = $r11["status_code"];

    $q = mysqli_query($wconn, "SELECT step_code from geo_bpls_business_permit_ol where uniqID = '$uniqID'");
    $r = mysqli_fetch_assoc($q);
    $step_code1 = $r["step_code"];

    $permit_id_dec = $r11["permit_id"];
    $status_code = $r11["status_code"];
    $q = mysqli_query($wconn, "SELECT status_desc from geo_bpls_status where status_code = '$status_code' ");
    $r = mysqli_fetch_assoc($q);
    $status_desc = $r["status_desc"];

    $permit_id = $r11["permit_id"];
    ?>
    <!-- content here -->

<div class='application_mess'></div>
<link rel="stylesheet" href="bpls/myassets/multistep.css">
<form method="POST" action="bplsmodule.php?redirect=online_approval_update"  enctype="multipart/form-data" id="bpls_form">
    <div class="box box-primary" style="background:white; ">
        <div class=" box-body">
            <!-- add  in class from validation -->
            <!-- start -->
            <div class="row">
                <div class="col-md-8">
                    <!-- OWNER INFORMATION -->
                    <div class="panel-group" style="cursor:pointer;">
                        <div class="panel panel-default">
                            <div class="panel-heading"
                                style="color:white; text-align:center; background:#343536; padding:2px;"
                                data-toggle="collapse" href="#collapse01a" aria-expanded="true">
                                OWNER'S INFORMATION
                            </div>
                            <div id="collapse01a" class="panel-collapse collapse in" aria-expanded="true">
                                <div class="row" style="margin:2px">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <tr>
                                                <td style="width:25%;"><b>Owner's Name:</b></td>
                                                <td> <span class="owners_name_mess "> <?php echo $r11["owner_first_name"]." ".$r11["owner_middle_name"]." ".$r11["owner_last_name"]; ?> </span> </td>
                                            </tr>
                                            <tr>
                                                <td><b>Owner's Address:</b></td>
                                                <td><span class="owners_add_mess  "> <?php echo $owner_address; ?> </span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row" style="margin:2px">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success pull-right" data-toggle="modal"
                                            data-target="#owners_modal">New</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- OWNER INFORMATION -->
                    <!-- BUSINESS INFORMATON -->
                    <div class="panel-group" style="cursor:pointer;">
                        <div class="panel panel-default">
                            <div class="panel-heading"
                                style="color:white; text-align:center; background:#343536; padding:2px;"
                                data-toggle="collapse" href="#collapse01" aria-expanded="true">
                                BUSINESS INFORMATION
                            </div>
                            <div id="collapse01" class="panel-collapse collapse in" aria-expanded="true">
                                <div class="row" style="margin:2px">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <tr>
                                                <td style="width:25%;"><b>Business Name:</b></td>
                                                <td> <span class="business_name_mess  "><?php echo $r11["business_name"]; ?></span> </td>
                                            </tr>
                                            <tr>
                                                <td><b>Business Address:</b></td>
                                                <td> <span class="business_add_mess ">  <?php echo $business_address; ?> </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row" style="margin:2px">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success pull-right" data-toggle="modal"
                                            data-target="#business_modal">New</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- BUSINESS INFORMATION -->


           <?php if( $status_code == "RET"){ ?>
                                    <!-- 001 -->
                                    <div class="panel-group" style="cursor:pointer;">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"
                                                style="color:white; text-align:center; background:#343536; padding:2px;"
                                                data-toggle="collapse" href="#collapse0ara1" aria-expanded="true">
                                                BUSINESS RETIREMENT
                                            </div>
                                              <div id="collapse0ara1" class="panel-collapse collapse in" aria-expanded="true">
                                               <div class="row" style="margin:5px;">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="">Retirement Date Process:</label>
                                                            <input type="date" name="retire_date" value="<?php echo $r11["retirement_date_processed"]; ?>" class="form-control saving_validator">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="">Retirement affidavit:</label>

                                                    <?php
                                                        if($r11["retirement_file"] == null || $r11["retirement_file"] == "" ){
                                                                ?>
                                                    <input type="file" name="affidavit"   class="form-control saving_validator" value="bpls/retirement_file/<?php echo $r11["retirement_file"]; ?>" >
                                                                <?php
                                                        }else{
                                                            ?>
                                                        <input type="text"   class="form-control " value="bpls/retirement_file/<?php echo $r11["retirement_file"]; ?>" readonly >
                                                            <?php
                                                        }
                                                    ?>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <label for=""> &nbsp;</label>
                                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModalret" style="width:100%; height:100%;" title="view affidavit" >
                                                              <i class="fa fa-image"> </i>
                                                            </button>
                                                        </div>
                                                    </div>
                                               </div>
                                                
                                            </div>
                                            <!-- <div class="panel-footer">Footer</div> -->
                                        </div>
                                    </div>
                                    <!-- 001 -->

                                   
                            <?php } ?>

                                    <!-- 001 -->
                                    <div class="panel-group" style="cursor:pointer;">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"
                                                style="color:white; text-align:center; background:#343536; padding:2px;"
                                                data-toggle="collapse" href="#collapse0aa" aria-expanded="true">
                                                BUSINESS NATURE
                                            </div>
                                            <div class="row" style="margin:2px;">
                                                <div class="col-md-12">
                                                <?php
                                                if($step_code1 == "PAYME" || $step_code1 == "RELEA" ){ ?>
                                                    <table style="width:100%;">
                                                    <tr>
                                                        <td>
                                                            <label for="">Business Nature</label>
                                                        </td>
                                                        <td>
                                                        <?php 
                                                           
                                                        if( $status_code == "REN"){
                                                            echo "<label>Gross/Sales:</label>";
                                                        }elseif( $status_code == "RET"){
                                                            echo "<label>Gross/Sales:</label>";
                                                        }else{
                                                            echo "<label>Capital Investment:</label>";
                                                        } ?>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                            <?php
                                            $q12 = mysqli_query($wconn,"SELECT * FROM `geo_bpls_business_permit_nature` 
                                            inner join `geo_bpls_nature` on   geo_bpls_nature.nature_id = geo_bpls_business_permit_nature.nature_id 
                                            where md5(permit_id) = '$id' ");   
                                            while($r12 = mysqli_fetch_assoc($q12)){
                                                ?>
                                            <tr>
                                                <td >
                                                    <div class="form-group" style="margin:2px;">
                                                    
                                                    <input type="text" class="form-control" value="<?php echo $r12["nature_desc"];?>" readonly>
                                                </div>
                                                </td>
                                                <td>
                                                <div class="form-group" style="margin:2px;">
                                                    
                                                    <input type="text" class="form-control" value="<?php 
                                                if($r12["capital_investment"] == 0.00){
                                                    echo $r12["last_year_gross"];
                                                }else{
                                                    echo $r12["capital_investment"];
                                                }
                                                ?>" readonly>
                                                </div>
                                                </td>
                                            </tr>
                                                <?php
                                            }

                                            ?>
                                            </table>
                                                <?php }else{ ?>
                                            <table style="width:100%;">
                                             <?php
                                            $q12 = mysqli_query($wconn,"SELECT * FROM `geo_bpls_business_permit_nature_ol` 
                                            inner join `geo_bpls_nature` on   geo_bpls_nature.nature_id = geo_bpls_business_permit_nature_ol.nature_id  where permit_id = '$permit_id' "); 
                                            
                                            if(mysqli_num_rows($q12) >0 ){
                                            $counter_a = 200;  
                                            while($r12 = mysqli_fetch_assoc($q12)){
                                                $counter_a++;
                                                 if($status_desc == "New"){
                                                        $cap_inv = $r12["capital_investment"];
                                                }else{
                                                    $cap_inv = $r12["last_year_gross"];
                                                } ?>
                                            <tr class="mother_tr<?php echo $counter_a; ?>" >
                                                <td>
                                                        <?php if($counter_a == 201){ ?> <label for="">Business Nature</label> <?php }?>
                                                        <select class="form-control selectpicker" name="nature[]" id="nature_id"
                                                            data-show-subtext="true" data-live-search="true">
                                                            <option value="">--Select Nature--</option>
                                                            <?php
                                                            $query = mysqli_query($wconn, "SELECT DISTINCT nature_desc, geo_bpls_nature.nature_id FROM `geo_bpls_nature`
                                                            inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.nature_id = geo_bpls_nature.nature_id
                                                            inner join geo_bpls_revenue_code on geo_bpls_revenue_code.`revenue_code` = geo_bpls_tfo_nature.revenue_code
                                                            where revenue_code_status = 1");
                                                        while ($row = mysqli_fetch_assoc($query)) {?>
                                                            <option value="<?php echo $row["nature_id"]; ?>" <?php if($r12["nature_id"] == $row["nature_id"] ){ echo "selected"; } ?>>
                                                                <?php echo $row["nature_desc"]; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                </td> 
                                                <td style="width:25%;">
                                                        <?php if($counter_a == 201){ ?> <?php 
                                                           
                                                          if( $status_code == "REN"){
                                                            echo "<label>Gross/Sales:</label>";
                                                            }elseif( $status_code == "RET"){
                                                                echo "<label>Gross/Sales:</label>";
                                                            }else{
                                                                echo "<label>Capital Investment:</label>";
                                                            }
                                                         ?> <?php }?>

                                                       
                                                        <input type="number" name="cap_investment[]" class="form-control saving_validator"  style="margin:2px;" value="<?php echo $cap_inv; ?>">
                                                </td>
                                                <td>
                                                        <?php if($counter_a == 201){ ?>  <label for=""> </label>
                                                        <button type="button" id="append_nature_btn" style="margin:2px; margin-top:26px;" class="btn btn-success"
                                                        > 
                                                            <i class="fa fa-plus"> </i> 
                                                        </button>
                                                        <?php }else{?>
                                                        <button type="button" id="delete_btn" style="margin:5px; " class="btn btn-danger delete_nature_btn" ca_attr='<?php echo $counter_a; ?>'
                                                        > 
                                                            <i class="fa fa-minus"> </i> 
                                                        </button>
                                                        <?php }?>
                                                </td>
                                            </tr>
                                                        <?php }
                                                    }else{
                                                    ?>
                                                     <tr>
                                    <td>
                                            <label for="">Business Nature</label>
                                            <select class="form-control selectpicker" name="nature[]" id="nature_id"
                                                data-show-subtext="true" data-live-search="true">
                                                <option value="">--Select Nature--</option>
                                                <?php
                                                $query = mysqli_query($conn, "SELECT DISTINCT nature_desc, geo_bpls_nature.nature_id FROM `geo_bpls_nature`
                                                inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.nature_id = geo_bpls_nature.nature_id
                                                inner join geo_bpls_revenue_code on geo_bpls_revenue_code.`revenue_code` = geo_bpls_tfo_nature.revenue_code
                                                where revenue_code_status = 1");
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                ?>
                                                <option value="<?php echo $row["nature_id"]; ?>">
                                                    <?php echo $row["nature_desc"]; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                    </td> 
                                    <td style="width:25%;">
                                          <label for="">Capital Investment</label>
                                            <input type="number" name="cap_investment[]" class="form-control saving_validator"  style="margin:2px;">
                                    </td>
                                    <td>
                                            <label for=""> </label>
                                            <button type="button" id="append_nature_btn" style="margin:2px; margin-top:26px;" class="btn btn-success"
                                             > 
                                                <i class="fa fa-plus"> </i> 
                                            </button>
                                    </td>
                                </tr>
                            
                                                    <?php

                                                    } ?>
                                            <tr class="append_nature_here">
                                            </tr>
                                        </table>

                                        <?php }?>
                                                </div>
                                            </div>
                                            <!-- <div class="panel-footer">Footer</div> -->
                                        </div>
                                    </div>
                                    <!-- 001 -->

                </div>
                <div class="col-md-4">
                    <!-- 001 -->
                    <div class="panel-group" style="cursor:pointer;">
                        <div class="panel panel-default">
                            <div class="panel-heading"
                                style="color:white; text-align:center; background:#343536; padding:2px;"
                                data-toggle="collapse" href="#collapse1" aria-expanded="true">
                                APPLICATION & PAYMENT
                            </div>
                            <div id="collapse1" class="panel-collapse collapse in" aria-expanded="true">
                                <div class="row" style="margin:2px;">
                                    <div class="col-md-6">
                                        <label for="">Apllication Type</label>
                                        <select name="application_type" class="form-control saving_validator"  >
                                            <option value="NEW" <?php if($r11["status_code"] == "NEW" ){ echo "selected"; } ?> >New</option>
                                            <option value="REN"  <?php if($r11["status_code"] == "REN" ){ echo "selected"; } ?>  >Renew</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Mode of Payments</label>
                                        <select name="mode_of_payment" class="form-control saving_validator">
                                            <option value="">--Select Mode of Payment--</option>
                                            <?php
$query = mysqli_query($wconn, "SELECT payment_frequency_code, payment_frequency_desc FROM geo_bpls_payment_frequency");
    while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["payment_frequency_code"]; ?>" <?php if($r11["payment_frequency_code"] == $row["payment_frequency_code"] ){ echo "selected"; } ?> >
                                                <?php echo $row["payment_frequency_desc"]; ?> </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="panel-footer">Footer</div> -->
                            </div>
                        </div>
                    </div>
                    <!-- 001 -->

                    <!-- 001 -->
                    <div class="panel-group" style="cursor:pointer;">
                        <div class="panel panel-default">
                            <div class="panel-heading"
                                style="color:white; text-align:center; background:#343536; padding:2px;"
                                data-toggle="collapse" href="#collapse0" aria-expanded="true">
                                REQUIREMENTS
                            </div>
                            <div id="collapse0" class="panel-collapse collapse in" aria-expanded="true">
                               <div style="text-align:center; background:#40b34c;">
                                         <i class="fa fa-check-circle"  style="margin:5px; font-size:50px; color:white;"></i>
                                    <br>
                                   <p  style="margin:5px; font-size:50px; color:white;" > DONE </p>
                               </div>
                            </div>
                        </div>
                    </div>
                    <!-- 001 -->
                </div>
            </div>
            <!-- end -->
           
            
            <div class="button-row">
                 <?php
                if($app_status != "APPROVED") {
                ?>
                 <button type="button" class="btn btn-warning ml-auto js-btn-next pull-left"
                     data-toggle="modal" data-target="#disapproved" > DISAPPROVED </button>
                <button type="button" class="btn btn-success ml-auto js-btn-next pull-right"
                    name="save_application_form" id="form_save" btn_name="save">UPDATE and APPROVE </button>
             <?php }?>
                <input type="hidden" name="hidden_validation" id="hidden_validation">
            </div>
        </div>
    </div>
      

    <!-- Owners Modal -->
    <div class="modal fade" id="owners_modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <!-- <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
                <h4 class="modal-title">OWNER'S INFORMATION</h4>
            </div> -->
                <div class="modal-body">
                    <!-- body start -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <span style="font-size:16px; font-weight:bold;"> OWNER'S DETAILS</span>
                        </div>
                        <div class=" box-body">


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Last Name</label>
                                        <input type="text" name="tax_payer_lname" id="l_name" value="<?php echo $r11["owner_last_name"]; ?>"
                                            class="form-control o_validator">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" name="tax_payer_fname" id="f_name" value="<?php echo $r11["owner_first_name"]; ?>"
                                            class="form-control o_validator">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for=""> Middle Name</label>
                                        <input type="text" name="tax_payer_mname" id="m_name" value="<?php echo $r11["owner_middle_name"]; ?>"
                                            class="form-control o_validator">
                                    </div>
                                </div>
                            </div>
                            <!-- 2nd row -->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Citizenship</label>
                                        <select class="form-control  o_validator" name="citizenship" id="citizenship_id">
                                            <option value="">--Select Citizenship--</option>
                                            <?php
$query = mysqli_query($wconn, "SELECT * FROM `geo_bpls_citizenship`");
    while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["citizenship_id"]; ?>"  <?php if($r11["citizenship_id"] == $row["citizenship_id"]){ echo "selected"; } ?> >
                                                <?php echo $row["citizenship_desc"]; ?>
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Civil Status</label>
                                        <select class="form-control  o_validator" name="civil_status" id="civil_status_id">
                                            <option value="">--Select Civil Status--</option>
                                            <?php
$query = mysqli_query($wconn, "SELECT * FROM `geo_bpls_civil_status`");
    while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["civil_status_id"]; ?>"  <?php if ($r11["civil_status_id"] == $row["civil_status_id"]) {echo "selected";}?> >
                                                <?php echo $row["civil_status_desc"]; ?>
                                            </option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Gender</label>
                                        <select class="form-control o_validator" name="gender" id="gender_id">
                                            <option value="">--Select Gender--</option>
                                            <option value="M" <?php if($r11["gender_code"] == "M" ){ echo "selected"; } ?> >Male</option>
                                            <option value="F" <?php if($r11["gender_code"] == "F" ){ echo "selected"; } ?> >Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Birthdate</label>
                                        <input type="date" name="birthdate" id="birthdate_id" class="form-control o_validator" value="<?php echo $r11["owner_birth_date"]; ?>" >
                                    </div>
                                </div>
                            </div>
                            <!-- 3rd row -->


                            <!-- 4rth row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Mobile No.</label>
                                        <input type="text" name="o_mob_no" id="o_mob_no_id" class="form-control "  value="<?php echo $r11["owner_mobile"]; ?>" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email Address</label>
                                        <input type="email" name="o_email" id="o_email_id" class="form-control " value="<?php echo $r11["owner_email"]; ?>" >
                                    </div>
                                </div>
                            </div>
                            <!-- 5th row -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Legal Entity</label>
                                        <textarea name="legal_entity" id="legal_entity_id" class="form-control "><?php echo $r11["owner_legal_entity"]; ?> </textarea>
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Person with Disability</label>
                                        <input type="checkbox" name="PWD_status" style="margin-right:30px;" <?php if($r11["PWD_status"] == 1){ echo "checked";  } ?> >

                                        <label for="">4PS</label>
                                        <input type="checkbox" name="4PS_status" style="margin-right:30px;"  <?php if($r11["4PS_status"] == 1){ echo "checked";  } ?> >

                                         <label for="">Solo Parent</label>
                                        <input type="checkbox" name="SP_status" style=" margin-right:30px;"  <?php if($r11["SP_status"] == 1){ echo "checked";  } ?> >
                                    </div>
                                </div>
                            </div>

                            <!-- box end -->
                        </div>
                    </div>

                    <!-- ADDRESS  -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <span style="font-size:16px; font-weight:bold;"> OWNER'S ADDRESS</span>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Region</label>
                                        <select class=" selectpicker form-control"  name="region"  id="region" data-show-subtext="true"  data-live-search="true">
                                          <option value="">--Select Region--</option>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_region`");
                                             while ($row = mysqli_fetch_assoc($query)) {?>
                                                <option value="<?php echo $row["region_code"]; ?>" ca_attr="<?php echo $row["region_desc"]; ?>"
                                                    <?php if($r11["o_reg_code"] == $row["region_code"]){ echo "selected"; } ?>>
                                                    <?php echo $row["region_desc"]; ?>
                                                </option>
                                          <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Province</label>
                                   <select class="selectpicker form-control " name="province"
                                                        data-show-subtext="true" id="province" data-live-search="true">
                                                        <option value="">--Select Region first--</option>
                                                        <?php
                                    $targetaddress =  $r11["o_reg_code"];
                                    $makeSelected = $r11["o_province_code"];
                                    $q = mysqli_query($conn,"SELECT province_code, province_desc from geo_bpls_province  WHERE `region_code` = '$targetaddress' ");
                                    while($r = mysqli_fetch_assoc($q)){
                                        ?>
                                       <option value="<?php echo $r["province_code"]; ?>"
                                            <?php if($makeSelected == $r["province_code"]){ echo "selected"; } ?>>
                                            <?php echo $r["province_desc"]; ?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Municipality</label>
                                                <select class=" selectpicker form-control" name="municipality"   data-show-subtext="true" id="municipality"
                                                        data-live-search="true">
                                                        <option value="">--Select Province first--</option>
                                                        <?php
                                                    $targetaddress =  $r11["o_province_code"];
                                                    $makeSelected = $r11["o_lgu_code"];
                                                    $q = mysqli_query($conn,"SELECT * from geo_bpls_lgu  WHERE `province_code` = '$targetaddress' ");
                                                    while($r = mysqli_fetch_assoc($q)){
                                                        ?>
                                                        <option value="<?php echo $r["lgu_code"]; ?>"
                                                            <?php if($makeSelected == $r["lgu_code"]){ echo "selected"; } ?>>
                                                            <?php echo $r["lgu_desc"]; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Barangay</label>
                                                        <select class="selectpicker form-control " name="barangay" data-show-subtext="true" id="barangay" data-live-search="true">
                                                            <option value="">--Select Municipality first--</option>
                                                        <?php
                                                        $targetaddress =  $r11["o_lgu_code"];
                                                        $makeSelected = $r11["o_barangay_id"];
                                                        $q = mysqli_query($conn,"SELECT * from geo_bpls_barangay  WHERE `lgu_code` = '$targetaddress' ");
                                                        while($r = mysqli_fetch_assoc($q)){
                                                            ?>
                                                                <option value="<?php echo $r["barangay_id"]; ?>"
                                                                    <?php if($makeSelected == $r["barangay_id"]){ echo "selected"; } ?>>
                                                                    <?php echo $r["barangay_desc"]; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Street</label>
                                        <input type="text" name="street" class="form-control ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ADDRESS  -->

                    <!-- body end -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success save_owners">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- Owners Modal -->

    <!-- Business Modal -->
    <div class="modal fade" id="business_modal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
                <h4 class="modal-title">BUSINESS INFORMATION</h4>
            </div> -->
                <div class="modal-body">
                    <!-- modal body start  -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <span style="font-size:16px; font-weight:bold;">BUSINESS DETAILS</span>
                        </div>
                        <div class="box-body">


                              <div class="row" style="margin:2px;">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Business Name</label>
                                                        <input type="text" id="b_name" name="business_name"
                                                            class="form-control b_validator"
                                                            value="<?php echo ($r11["business_name"]); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Trade Name/Franchise</label>
                                                        <input type="text" name="trade_name"
                                                            class="form-control "
                                                            value="<?php echo $r11["business_trade_name_franchise"]; ?>">
                                                    </div>
                                                </div>
                                            </div>
                            <!-- 1st row -->
                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row" style="margin:2px;">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Date of Application:</label>
                                                                <input type="hidden" class="form-control "
                                                                    name="uniqID" value="<?php echo $uniqID; ?>">
                                                                <input type="date" class="form-control b_validator"
                                                                    name="application_date"
                                                                    value="<?php echo $r11["permit_application_date"]; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Tin No.:</label>
                                                                <input type="text" name="tinNo"
                                                                    class="form-control "
                                                                    value="<?php echo $r11["business_tin_reg_no"]; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">DTI/SEC/CDA Registration No.:</label>
                                                                <input type="text" name="dti_sec_cdaRegistrationNo"
                                                                    class="form-control "
                                                                    value="<?php echo $r11["business_dti_sec_cda_reg_no"]; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">DTI/SEC/CDA Registration Date.:</label>
                                                                <input type="date" name="dti_sec_cdaRegistrationDate"
                                                                    value="<?php echo $r11["business_dti_sec_cda_reg_date"]; ?>"
                                                                    class="form-control ">
                                                            </div>
                                                        </div>

                                                        <div class="row" style="margin:2px;">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Business Mobile No.</label>
                                                                    <input type="text" name="b_mob_no"
                                                                        value="<?php echo $r11["business_mob_no"]; ?>"  class="form-control ">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Business Email </label>
                                                                    <input type="email" name="b_email"
                                                                        value="<?php echo $r11["business_email"]; ?>"
                                                                        class="form-control ">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row" style="margin:2px;">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="">Type of Business</label>
                                                                    <select name="type_of_business"
                                                                        class="b_validator form-control ">
                                                                        <option value="">--Select Type of Business--
                                                                        </option>
                                                                        <?php
                                                $query = mysqli_query($wconn, "SELECT business_type_code, business_type_desc FROM geo_bpls_business_type");
                                                while ($row = mysqli_fetch_assoc($query)) {?>
                                                                        <option
                                                                            value="<?php echo $row["business_type_code"]; ?>"
                                                                            <?php if($r11["business_type_code"] == $row["business_type_code"]){ echo "selected"; } ?>>
                                                                            <?php echo $row["business_type_desc"]; ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <label for="">Amendment:</label>
                                                                    <table style="width:100%; ">
                                                                        <tr>
                                                                            <td>From</td>
                                                                            <td>
                                                                                <select name="amd_from"
                                                                                    class="form-control"
                                                                                    style="margin-left:10px; width:80%;">
                                                                                    <option value="">--Amendment From--
                                                                                    </option>
                                                                                    <?php
                                                $query = mysqli_query($wconn, "SELECT business_type_code, business_type_desc FROM geo_bpls_business_type");
                                                while ($row = mysqli_fetch_assoc($query)) {?>
                                                                                    <option
                                                                                        value="<?php echo $row["business_type_code"]; ?>"
                                                                                        <?php if($_POST["amd_from"] == $row["business_type_code"]){ echo "selected"; } ?>>
                                                                                        <?php echo $row["business_type_desc"]; ?>
                                                                                    </option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </td>
                                                                            <td>To</td>
                                                                            <td>
                                                                                <select name="amd_to"
                                                                                    class="form-control"
                                                                                    style="margin-left:10px; width:80%;">
                                                                                    <option value="">----Amendment
                                                                                        To----
                                                                                    </option>
                                                                                    <?php
                                                    $query = mysqli_query($wconn, "SELECT business_type_code, business_type_desc FROM geo_bpls_business_type");
                                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                                                                    <option
                                                                                        value="<?php echo $row ["business_type_code"]; ?>"
                                                                                        <?php if($_POST["amd_to"] == $row["business_type_code"]){ echo "selected"; } ?>>
                                                                                        <?php echo $row["business_type_desc"]; ?>
                                                                                    </option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table
                                                                    style="width:100%;  background: rgb(247, 247, 247); padding:2px;"
                                                                    class="r1_step0">
                                                                    <tr>
                                                                        <td>Are you enjoying tax incentive from any
                                                                            Goverment Entity?</td>
                                                                        <td style="width:80px;"><label>Yes</label>
                                                                            <input type="radio"
                                                                                name="tax_incentive_status"
                                                                                class="ri1_step0 " value="Yes"
                                                                                <?php if($r11["business_tax_incentive"] == "1"){ echo "checked"; } ?>>
                                                                        </td>
                                                                        <td><label>No</label> <input type="radio"
                                                                                class=" ri1_step0"
                                                                                name="tax_incentive_status" value="No"
                                                                                <?php if($r11["business_tax_incentive"] == "0"){ echo "checked"; } ?>>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                     <td colspan="3" style="padding:5px;"><span
                                                                                class="entity_here">
                                                                                <?php
                                                                        if($r11["business_tax_incentive"] == "1"){
                                                                            echo "<textarea class='form-control b_validator' name='tax_incentive_entity'>".$r11["business_tax_incentive_entity"]."</textarea>";
                                                                         }else{

                                                                         }
                                                                        ?>
                                                                            </span></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                            <!-- PART 2 -->
                           <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Business Organization</label>
                                                        <select class="form-control b_validator" name="b_org"
                                                            id="b_org">
                                                            <option value="">--Select Business Organization--</option>
                                                            <?php
                                    $query = mysqli_query($wconn, "SELECT * FROM `geo_bpls_economic_org`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                                            <option value="<?php echo $row["economic_org_code"]; ?>"
                                                                <?php if($r11["economic_org_code"] == $row["economic_org_code"]){ echo "selected"; } ?>>
                                                                <?php echo $row["economic_org_desc"]; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Business Area</label>
                                                        <select class="form-control b_validator" name="b_area"
                                                            id="b_area">
                                                            <option value="">--Select Business Area--</option>
                                                            <?php
                                    $query = mysqli_query($wconn, "SELECT * FROM `geo_bpls_economic_area`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                                            <option value="<?php echo $row["economic_area_code"]; ?>"
                                                                <?php if($r11["economic_area_code"] == $row["economic_area_code"]){ echo "selected"; } ?>>
                                                                <?php echo $row["economic_area_desc"]; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Business Scale</label>
                                                        <select class="form-control b_validator" name="b_scale"
                                                            id="b_scale">
                                                            <option value="">--Select Business Scale--</option>
                                                            <?php
                                    $query = mysqli_query($wconn, "SELECT * FROM `geo_bpls_scale`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                                            <option value="<?php echo $row["scale_code"]; ?>"
                                                                <?php if($r11["scale_code"] == $row["scale_code"]){ echo "selected"; } ?>>
                                                                <?php echo $row["scale_desc"]; ?>(<?php echo $row["scale_code"]; ?>)
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Business Sector</label>
                                                        <select class="form-control b_validator" name="b_sector"
                                                            id="b_sector">
                                                            <option value="">--Select Business Sector--</option>
                                                            <?php
                                    $query = mysqli_query($wconn, "SELECT * FROM `geo_bpls_sector`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                                            <option value="<?php echo $row["sector_code"]; ?>"
                                                                <?php if($r11["sector_code"] == $row["sector_code"]){ echo "selected"; } ?>>
                                                                <?php echo $row["sector_desc"]; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Zone</label>
                                                        <select class="form-control " name="b_zone" id="b_zone">
                                                            <option value="">--Select Zone--</option>
                                                            <?php
                                    $query = mysqli_query($wconn, "SELECT * FROM `geo_bpls_zone`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                                            <option value="<?php echo $row["zone_id"]; ?>"
                                                                <?php if($r11["b_zone"] == $row["zone_id"]){ echo "selected"; } ?>>
                                                                <?php echo $row["zone_desc"]; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row  ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Occupancy</label>
                                                        <select class="form-control" name="b_occupancy"
                                                            id="b_occupancy">
                                                            <option value="">--Select Occupancy--</option>
                                                            <?php
                                    $query = mysqli_query($wconn, "SELECT * FROM `geo_bpls_occupancy`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                                            <option value="<?php echo $row["occupancy_code"]; ?>"
                                                                <?php if($r11["occupancy_code"] == $row["occupancy_code"]){ echo "selected"; } ?>>
                                                                <?php echo $row["occupancy_desc"]; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Business Area (sqm):</label>
                                                        <input type="int" name="b_area_sqm"
                                                            class="form-control b_validator"
                                                            value="<?php echo $r11["business_area"]; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Total Employees in Establishment:</label>
                                                        <input type="int" name="emp_establishment_count"
                                                            value="<?php echo $r11["business_employee_total"]; ?>"
                                                            class="form-control b_validator">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">No of Employee Residing with LGU:</label>
                                                        <input type="int" name="no_emp_lgu"
                                                            value="<?php echo $r11["business_employee_resident"]; ?>"
                                                            class="form-control b_validator">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                   <!-- business ADDRESS  -->
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <span style="font-size:16px; font-weight:bold;"> BUSINESS ADDRESS</span>
                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Region</label>
                                                        <select class="form-control selectpicker " name="b_region"
                                                            id="b_region" data-show-subtext="true"
                                                            data-live-search="true">
                                                            <option value="">--Select Region--</option>
                                                            <?php
                                $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_region`");
                                while ($row = mysqli_fetch_assoc($query)) {?>
                                                            <option value="<?php echo $row["region_code"]; ?>"
                                                                ca_attr="<?php echo $row["region_desc"]; ?>"
                                                                <?php if($r11["b_reg_code"] == $row["region_code"]){ echo "selected"; } ?>>
                                                                <?php echo $row["region_desc"]; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Province</label>
                                                    <select class="form-control selectpicker" name="b_province"
                                                        data-show-subtext="true" id="b_province"
                                                        data-live-search="true">
                                                        <option value="">--Select Region first--</option>
                                                        <?php
                                    $targetaddress =  $r11["b_reg_code"];
                                    $makeSelected = $r11["b_province_code"];
                                    $q = mysqli_query($conn,"SELECT province_code, province_desc from geo_bpls_province  WHERE `region_code` = '$targetaddress' ");
                                    while($r = mysqli_fetch_assoc($q)){
                                        ?>
                                                        <option value="<?php echo $r["province_code"]; ?>"
                                                            <?php if($makeSelected == $r["province_code"]){ echo "selected"; } ?>>
                                                            <?php echo $r["province_desc"]; ?></option>
                                                        <?php
                                    }
                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Municipality</label>
                                                    <select class="form-control selectpicker " name="b_municipality"
                                                        data-show-subtext="true" id="b_municipality"
                                                        data-live-search="true">
                                                        <option value="">--Select Province first--</option>
                                                        <?php
                                    $targetaddress =  $r11["b_province_code"];
                                    $makeSelected = $r11["b_lgu_code"];
                                    $q = mysqli_query($conn,"SELECT * from geo_bpls_lgu  WHERE `province_code` = '$targetaddress' ");
                                    while($r = mysqli_fetch_assoc($q)){
                                        ?>
                                                        <option value="<?php echo $r["lgu_code"]; ?>"
                                                            <?php if($makeSelected == $r["lgu_code"]){ echo "selected"; } ?>>
                                                            <?php echo $r["lgu_desc"]; ?></option>
                                                        <?php
                                    }
                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">Barangay</label>
                                                    <select class="form-control selectpicker " name="b_barangay"
                                                        data-show-subtext="true" id="b_barangay"
                                                        data-live-search="true">
                                                        <option value="">--Select Municipality first--</option>
                                                        <?php
                                    $targetaddress =  $r11["b_lgu_code"];
                                    $makeSelected = $r11["b_barangay_id"];
                                    $q = mysqli_query($conn,"SELECT * from geo_bpls_barangay  WHERE `lgu_code` = '$targetaddress' ");
                                    while($r = mysqli_fetch_assoc($q)){
                                        ?>
                                                        <option value="<?php echo $r["barangay_id"]; ?>"
                                                            <?php if($makeSelected == $r["barangay_id"]){ echo "selected"; } ?>>
                                                            <?php echo $r["barangay_desc"]; ?></option>
                                                        <?php
                                    }
                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Street</label>
                                                        <input type="text" name="b_street"
                                                            value="<?php echo $r11["business_address_street"]; ?>"
                                                            class="form-control ">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ADDRESS  -->

                    <!-- lessor -->
                    <div class="lessors_div">
                    </div>

                    <!-- lessor -->

                    <!-- emergency  -->
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <span style="font-size:16px; font-weight:bold;"> EMERGENCY CONTACT
                                                PERSON</span>
                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Contact Person:</label>
                                                        <input type="text" name="ec_person"
                                                            class="form-control "
                                                            value="<?php echo $r11["business_emergency_contact"]; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Tel/Mobile No.:</label>
                                                        <input type="text" name="ec_tel_no"
                                                            value="<?php echo $r11["business_emergency_mobile"]; ?>"
                                                            class="form-control ">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Email Address.:</label>
                                                        <input type="email" name="ec_email"
                                                            value="<?php echo $r11["business_emergency_email"]; ?>"
                                                            class="form-control ">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- emergency  -->
                    <!-- modal body eend  -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-success save_business">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- Business Modal -->

</form>

  <!-- DISAPPROVED MODAL -->
        <form method="POST" action="bplsmodule.php?redirect=OAV2&a=<?php echo $uniqID; ?>" >
        <div class="modal fade" id="disapproved">
            <div class="modal-dialog">
                <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">DISAPPROVAL PROCESS</h4>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                   <div class="form-group">
                       <label for="">Remarks</label>
                       <textarea name="remarks" class="form-control" ></textarea>
                   </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">CANCEL</button>
                    <button type="submit" name="disapprove_process" class="btn btn-warning pull-right" >DISAPPROVED</button>
                  
                </div>

                </div>
            </div>
            </div>
            </form>
        <!-- DISAPPROVED MODAL -->

<script>
$(document).on("change","#b_name",function(){
    var business_name = $(this).val();
    var find_business = $("#find_business").val();

    $.ajax({
        type: 'POST',
        url: 'bpls/businessname_validation.php',
        dataType:'JSON',
        data: {
            business_name: business_name,
        },
         success: function(result) {
            if(result == 1){
                alert("Business is Already used!")
                $("#b_name").css({"border":"2px solid red"});
                // $("#form_save").prop("disabled",true);
            }else{
                // $("#form_save").prop("disabled",false);
            }
        }
    });
});


// append nature
var a = 0;
$(document).on('click', '#append_nature_btn', function() {
    a++
    var text = '<tr class="mother_tr' + a +
        '"> <td> <select class="form-control selectpicker"  name="nature[]" id="nature_id" data-show-subtext="true" data-live-search="true"> <option value="">--Select Nature--</option> <?php $query = mysqli_query($wconn, "SELECT DISTINCT nature_desc, geo_bpls_nature.nature_id FROM `geo_bpls_nature` inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.nature_id = geo_bpls_nature.nature_id inner join geo_bpls_revenue_code on   geo_bpls_revenue_code.`revenue_code` = geo_bpls_tfo_nature.revenue_code where revenue_code_status = 1");while ($row = mysqli_fetch_assoc($query)) {?> <option value="<?php echo $row["nature_id"]; ?>"> <?php echo $row["nature_desc"]; ?> </option> <?php }?> </select></td> <td> <input type="number" name="cap_investment[]" class="form-control saving_validator"  style="margin:2px;" ></td> <td style="width:10%;"> <button type="button"  class="btn btn-danger delete_nature_btn" ca_attr="' +
        a + '" style="margin:5px;"> <i class="fa fa-minus"> </i> </button> </td> </tr>';

    $(".append_nature_here").after(text);
    $('.selectpicker').selectpicker('refresh');

});
// delete append nature
$(document).on('click', '.delete_nature_btn', function() {
    var id = $(this).attr("ca_attr");
    $(".mother_tr" + id).remove();
});

$(document).on("click", "#form_save", function() {

    var error = 0;
    $(".prevent_saving").each(function() {
        error++;
    });

    var sp_error_count = 0;
    if ($("#nature_id").val() == "") {
        sp_error_count++;
        $("#nature_id").parent().find("button").addClass("border_red2");
        $("#nature_id").parent().find("button").addClass("form-control");
    } else {
        $("#nature_id").parent().find("button").removeClass("border_red2");
    }

    var saving_error_counter = 0;
    $('.saving_validator').each(function() {
        if ($(this).val() == "") {
            $(this).closest("div").find("label").css({
                "color": "#c43831"
            });
            $(this).addClass("border_red2");
            saving_error_counter++;
        } else {
            $(this).closest("div").find("label").css({
                "color": "#333"
            })
            $(this).removeClass("border_red2");
        }
    });

    var total = sp_error_count + saving_error_counter + error;

    if (total == 0) {
        $("#hidden_validation").val("save");
        $("#bpls_form").submit();
    } else {
        myalert_warning_af("Please fill up all required inputs!!","nothing");
    }


});


// for region
$(document).on('change', '#region', function() {
    var id = $(this).val();
    var target = "region";
    $.ajax({
        type: 'POST',
        url: 'bpls/ajax_fetching_address.php',
        data: {
            id: id,
            target: target
        },
        success: function(result) {
            $("#province").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
    })

});

// for province
$(document).on('change', '#province', function() {
    var id = $(this).val();
    var target = "province";
    $.ajax({
        type: 'POST',
        url: 'bpls/ajax_fetching_address.php',
        data: {
            id: id,
            target: target
        },
        success: function(result) {
            $("#municipality").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
    })

});

// for municipality
$(document).on('change', '#municipality', function() {
    var id = $(this).val();
    var target = "municipality";
    $.ajax({
        type: 'POST',
        url: 'bpls/ajax_fetching_address.php',
        data: {
            id: id,
            target: target
        },
        success: function(result) {
            $("#barangay").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
    })

});
// business adrees dependednt
$(document).on('change', '#b_region', function() {
    var id = $(this).val();
    var target = "region";
    $.ajax({
        type: 'POST',
        url: 'bpls/ajax_fetching_address.php',
        data: {
            id: id,
            target: target
        },
        success: function(result) {
            $("#b_province").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
    })

});

// for province
$(document).on('change', '#b_province', function() {
    var id = $(this).val();
    var target = "province";
    $.ajax({
        type: 'POST',
        url: 'bpls/ajax_fetching_address.php',
        data: {
            id: id,
            target: target
        },
        success: function(result) {
            $("#b_municipality").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
    })

});

// for municipality
$(document).on('change', '#b_municipality', function() {
    var id = $(this).val();
    var target = "municipality";
    $.ajax({
        type: 'POST',
        url: 'bpls/ajax_fetching_address.php',
        data: {
            id: id,
            target: target
        },
        success: function(result) {
            $("#b_barangay").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
    })

});

// gov entity

$(document).on("click", ".ri1_step0", function() {
    var val = $(this).val();
    if (val == "Yes") {
        $(".entity_here").html(
            "<textarea class='form-control b_validator' name='tax_incentive_entity'></textarea>");
    } else {
        $(".entity_here").html("")
    }
});

$(document).on("click", "#b_occupancy", function() {
    var val = $(this).val();
    if (val == "R" || val == "RO") {
        $(".lessors_div").html(
            '<div class="box box-primary"> <div class="box-header"> <span style="font-size:16px; font-weight:bold;">LESSOR DETAILS</span> </div> <div class="box-body"> <div class="row"> <div class="col-md-6"> <div class="form-group"> <label for="">Full Name:</label> <input type="text" class="form-control in_modal20" name="lessors_fullname"> </div> </div> <div class="col-md-6"> <div class="form-group"> <label for=""> Address:</label> <input type="text" class="form-control in_modal20" name="l_address"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label for=""> Telephone/Mobile No.:</label> <input type="text" class="form-control in_modal20" name="l_mob_tel"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label for=""> Full Email Address:</label> <input type="email" class="form-control in_modal20" name="l_email_add"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label for="">Monthly Rental:</label> <input type="number" class="form-control in_modal20" name="monthly_rental"> </div> </div> </div> </div> </div>'
        );
    } else {
        $(".lessors_div").html("")
    }
});

// Owners modal
$(document).on('click', '.save_owners', function() {

    var sp_error_count = 0;
    if ($("#region").val() == "") {
        sp_error_count++;
        $("#region").parent().find("button").addClass("border_red2");
        $("#region").parent().find("button").addClass("form-control");
    } else {
        $("#region").parent().find("button").removeClass("border_red2");
    }
    if ($("#province").val() == "") {
        sp_error_count++;
        $("#province").parent().find("button").addClass("border_red2");
        $("#province").parent().find("button").addClass("form-control");
    } else {
        $("#province").parent().find("button").removeClass("border_red2");
    }
    if ($("#municipality").val() == "") {
        sp_error_count++;
        $("#municipality").parent().find("button").addClass("border_red2");
        $("#municipality").parent().find("button").addClass("form-control");

    } else {
        $("#municipality").parent().find("button").removeClass("border_red2");
    }
    if ($("#barangay").val() == "") {
        sp_error_count++;
        $("#barangay").parent().find("button").addClass("border_red2");
        $("#barangay").parent().find("button").addClass("form-control");

    } else {
        $("#barangay").parent().find("button").removeClass("border_red2");
    }

    var o_error_counter = 0;
    $('.o_validator').each(function() {
        if ($(this).val() == "") {
            $(this).closest("div").find("label").css({
                "color": "#c43831"
            });
            $(this).addClass("border_red");
            o_error_counter++;
        } else {
            $(this).closest("div").find("label").css({
                "color": "#333"
            })
            $(this).removeClass("border_red");
        }
    });

    $("#region").parent().find("button").addClass("region_title");
    $("#province").parent().find("button").addClass("province_title");
    $("#municipality").parent().find("button").addClass("municipality_title");
    $("#barangay").parent().find("button").addClass("barangay_title");

    var reg = $(".region_title").attr("title");
    var prov = $(".province_title").attr("title");
    var mun = $(".municipality_title").attr("title");
    var brgy = $(".barangay_title").attr("title");

    var total_error = parseInt(o_error_counter) + parseInt(sp_error_count);
    if (total_error == 0) {
        $('#owners_modal').modal('hide');

        var lname = $("#l_name").val();
        var mname = $("#m_name").val();
        var fname = $("#f_name").val();

        $(".owners_name_mess").html(lname + " " + mname + " " + fname);
        $(".owners_add_mess").html("BARANGAY " + brgy + " " + mun + " " + prov);
        $(".owners_name_mess").removeClass("prevent_saving");
        $(".owners_add_mess").removeClass("prevent_saving");
        $(".owners_name_mess").removeClass("mydanger");


    } else {
        $(".owners_name_mess").html(
            "<span class='prevent_saving' style='color:red; font-weight:bold; font-size:20px;' >Please fill up required input!! </span>"
        );
        $(".owners_add_mess").html(
            "<span class='prevent_saving' style='color:red; font-weight:bold; font-size:20px;' >Please fill up required input!! </span>"
        );
    }
});
$(document).on('change', '.border_red', function() {

    $('.o_validator').each(function() {
        if ($(this).val() == "") {
            $(this).closest("div").find("label").css({
                "color": "#c43831"
            });
            //   set css this input
            $(this).addClass("border_red");
        } else {
            $(this).closest("div").find("label").css({
                "color": "#333"
            })
            $(this).removeClass("border_red");
        }

    });
});

// Business modal
$(document).on('click', '.save_business', function() {

    //   radio checking
    //   if step is 0 or first


    var sp_error_count = 0;
    if ($("#b_region").val() == "") {
        sp_error_count++;
        $("#b_region").parent().find("button").addClass("border_red2");
        $("#b_region").parent().find("button").addClass("form-control");

    } else {
        $("#b_region").parent().find("button").removeClass("border_red2");
    }
    if ($("#b_province").val() == "") {
        sp_error_count++;
        $("#b_province").parent().find("button").addClass("border_red2");
        $("#b_province").parent().find("button").addClass("form-control");

    } else {
        $("#b_province").parent().find("button").removeClass("border_red2");
    }
    if ($("#b_municipality").val() == "") {
        sp_error_count++;
        $("#b_municipality").parent().find("button").addClass("border_red2");
        $("#b_municipality").parent().find("button").addClass("form-control");

    } else {
        $("#b_municipality").parent().find("button").removeClass("border_red2");
    }
    if ($("#b_barangay").val() == "") {
        sp_error_count++;
        $("#b_barangay").parent().find("button").addClass("border_red2");
        $("#b_barangay").parent().find("button").addClass("form-control");

    } else {
        $("#b_barangay").parent().find("button").removeClass("border_red2");
    }

    var b_error_counter = 0;
    $('.b_validator').each(function() {
        if ($(this).val() == "") {
            $(this).closest("div").find("label").css({
                "color": "#c43831"
            });
            $(this).addClass("border_red2");
            b_error_counter++;
        } else {
            $(this).closest("div").find("label").css({
                "color": "#333"
            })
            $(this).removeClass("border_red2");
        }
    });
    // tax incentive validatioon
    if ($('input[name="tax_incentive_status"]:checked').length == 0) {
        $(".r1_step0").css({
            "border": "2px solid #c43831"
        });
        b_error_counter++;
    } else {
        $(".r1_step0").css({
            "border": "none"
        });
    }
    $("#b_region").parent().find("button").addClass("b_region_title");
    $("#b_province").parent().find("button").addClass("b_province_title");
    $("#b_municipality").parent().find("button").addClass("b_municipality_title");
    $("#b_barangay").parent().find("button").addClass("b_barangay_title");

    var reg = $(".b_region_title").attr("title");
    var prov = $(".b_province_title").attr("title");
    var mun = $(".b_municipality_title").attr("title");
    var brgy = $(".b_barangay_title").attr("title");
    var total_error = parseInt(b_error_counter) + parseInt(sp_error_count);
    if (total_error == 0) {
        $('#business_modal').modal('hide');

        var b_name = $("#b_name").val();

        $(".business_name_mess").html(b_name);
        $(".business_add_mess").html("BARANGAY " + brgy + " " + mun + " " + prov);
        $(".business_name_mess").removeClass("prevent_saving");
        $(".business_name_mess").removeClass("mydanger");
        $(".business_add_mess").removeClass("prevent_saving");

    } else {
        $(".business_name_mess").html(
            "<span class='prevent_saving' style='color:red; font-weight:bold; font-size:20px;' >Please fill up required input!! </span>"
        );
        $(".business_add_mess").html(
            "<span class='prevent_saving' style='color:red; font-weight:bold; font-size:20px;' >Please fill up required input!! </span>"
        );
    }
});
$(document).on('change', '.border_red2', function() {

    $('.b_validator').each(function() {
        if ($(this).val() == "") {
            $(this).closest("div").find("label").css({
                "color": "#c43831"
            });
            //   set css this input
            $(this).addClass("border_red2");
        } else {
            $(this).closest("div").find("label").css({
                "color": "#333"
            })
            $(this).removeClass("border_red2");
        }

    });
});

// select all requirement

$(document).on("click",".select_all_req1",function(){
    var status = $(this).is(":checked");

    if(status == true){
        $(".select_all_req").each(function(){
        $(this).attr("checked",true);
    });
    }else{
        $(".select_all_req").each(function(){
        $(this).attr("checked",false);
    });
    }

});
</script>
    <!-- content here -->
    <?php
} else {
    ?>
    <script>
        location.replace("bplsmodule.php?redirect=online_transac");
    </script>
    <?php
}
}
?>