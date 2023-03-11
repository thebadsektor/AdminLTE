<?php 
    include('php/connect.php');
    include("jomar_assets/input_validator.php");

    $id = $_GET["target"];

    $q11 = mysqli_query($conn,"SELECT apn_no, retirement_date_processed, retirement_file, 4PS_status, PWD_status, SP_status, permit_for_year ,geo_bpls_owner.owner_id, geo_bpls_business_permit.permit_approved_remark, geo_bpls_business_permit.permit_approved,permit_id, civil_status_id, geo_bpls_business.business_id, business_emergency_contact, geo_bpls_business_permit.payment_frequency_code, status_code, step_code, permit_application_date, business_name, geo_bpls_business.barangay_id as b_barangay_id , business_type_code, economic_area_code, economic_org_code, geo_bpls_business.lgu_code as b_lgu_code, occupancy_code, geo_bpls_business.province_code as b_province_code, geo_bpls_business.region_code as b_reg_code, scale_code, sector_code, business_address_street, business_application_date, business_area, business_mob_no, business_tel_no, business_contact_name, business_dti_sec_cda_reg_date, business_dti_sec_cda_reg_no, business_email, business_email, business_emergency_email, business_emergency_mobile, business_employee_resident, business_employee_total,business_tax_incentive, business_tax_incentive_entity, business_tin_reg_no, business_trade_name_franchise, owner_first_name, owner_middle_name, owner_last_name, geo_bpls_owner.barangay_id as o_barangay_id, citizenship_id,gender_code, geo_bpls_owner.lgu_code as o_lgu_code, geo_bpls_owner.province_code as o_province_code, geo_bpls_owner.region_code as o_reg_code, geo_bpls_owner.zone_id as o_zone_id, geo_bpls_owner.owner_address_street, owner_birth_date, owner_email,owner_legal_entity, owner_mobile FROM `geo_bpls_business_permit`
    INNER JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id
    INNER JOIN geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id
    WHERE md5(geo_bpls_business_permit.permit_id) = '$id' ");

    $r11 = mysqli_fetch_assoc($q11);
    $apn_no = $r11["apn_no"];
    $sector_code = $r11["sector_code"];
    // business address
    $barangay_id0 = $r11["b_barangay_id"];
    $qaddddd = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as b_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id0' ");
    $raddddd = mysqli_fetch_assoc($qaddddd);
    $business_address = $raddddd["b_add"];
    // owners address
    $owner_id0 = $r11["o_barangay_id"];

    $qadddd2 = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as o_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$owner_id0' ");
    $raddddd2 = mysqli_fetch_assoc($qadddd2);
    $owner_address = $raddddd2["o_add"];

    $permit_id_dec = $r11["permit_id"];
    $status_code = $r11["status_code"];
    $q = mysqli_query($conn,"SELECT status_desc from geo_bpls_status where status_code = '$status_code' ");
    $r = mysqli_fetch_assoc($q);
    $status_desc = $r["status_desc"];
    
    $mode_of_payment_code = $r11["payment_frequency_code"];

    $q = mysqli_query($conn,"SELECT payment_frequency_desc from geo_bpls_payment_frequency where payment_frequency_code = '$mode_of_payment_code' ");
    $r = mysqli_fetch_assoc($q);
    $mode_of_payment = $r["payment_frequency_desc"];

    $business_id = $r11["business_id"];
    $q = mysqli_query($conn,"SELECT step_code from geo_bpls_business_permit where md5(permit_id) = '$id'");
    $r = mysqli_fetch_assoc($q);
    $step_code1 = $r["step_code"];

    $q = mysqli_query($conn,"SELECT step_desc from geo_bpls_step where step_code = '$step_code1' ");
    $r = mysqli_fetch_assoc($q);
    $step_code = $r["step_desc"];
    $permit_application_date = $r11["permit_application_date"];
   
    // ============================================
    $unpaid_amount1 = 0;
            //  for approval
       $permit_approved = $r11["permit_approved"];
        // getting backtaxes in same business owner 
        $owner_id = $r11["owner_id"];
            // getting permit id

        // checking kung paid backtax na
        $yeardd = date("Y");
        $qq1 = mysqli_query($conn, "SELECT permit_no, permit_id, step_code FROM `geo_bpls_business_permit` where owner_id = '$owner_id' and md5(permit_id) != '$id'  and (permit_for_year != '2017' and permit_for_year != '2018' and permit_for_year != '2019'  and permit_for_year != '2020' and permit_for_year  != '$yeardd' )    ");
        $permit_no = "";
 

        while($rr1 = mysqli_fetch_assoc($qq1)){
        
        $step_code_11 = $rr1["step_code"];

        // get total Assessment amount
        $abc =  $rr1["permit_id"];

        $backtax_permit_id = $abc;

   
        $qq2 = mysqli_query($conn, "SELECT sum(assessment_tax_due) as ass_tot FROM `geo_bpls_assessment` where permit_id = '$backtax_permit_id' ");
        $q4570 = mysqli_query($conn,"SELECT * FROM `geo_bpls_payment_paid_backtax` where  permit_id = '$backtax_permit_id' ");
        if(mysqli_num_rows($q4570) > 0){
            $status = "backtax paid";
        }else{
            $status = "backtax unpaid";
        }
        if($status == "backtax unpaid"){

            if ($_SESSION["uname"] == "admin") {
                // echo "SELECT * FROM `geo_bpls_payment_paid_backtax` where  permit_id = '$backtax_permit_id' ";
                    // echo $business_id."<br>";
                    // echo $id."<br>";
                    // echo  $abc."<br>";
                }
        

        $rr2 = mysqli_fetch_assoc($qq2);           
        $qq3 = mysqli_query($conn, "SELECT payment_backtax as payment_backtaxs, sum(payment_surcharge) as payment_surcharges ,sum(payment_total_amount_paid) as paid_tot FROM `geo_bpls_payment` where permit_id = '$abc' ");
            $rr3 = mysqli_fetch_assoc($qq3);
            $sur111 = $rr3["payment_surcharges"];

            // kukunin yung binayaran na backtax ng prev year
            $prev_paid_amount = 0;
            $normal_backtaxt = 0;
            $backtax_arr = explode('+',$rr3["payment_backtaxs"]);
            $back = 0;
            if(count($backtax_arr) == 3){
                $prev_paid_amount = floatval($backtax_arr[2]);
                $back = floatval($backtax_arr[1]);
            }
            // kukunin yung binayaran na backtax ng current year
            if(count($backtax_arr) == 2){
                $back = floatval($backtax_arr[0]) + floatval($backtax_arr[1]);
            }

            // get surcharges
            $sur111 =0;
            if($sur111 == null){
                $sur111 = 0;
            }
            if($back == null){
                $back = 0;
            }
            
            $ass_to =  $rr2["ass_tot"] * 1;
            $paid_am = (($rr3["paid_tot"] * 1) - ($back + $sur111));

            $paid_am = $paid_am - $prev_paid_amount;    
            if($rr2["ass_tot"] > $paid_am){
                
                $unpaid = $rr2["ass_tot"] - $paid_am;
                if($unpaid != "0" && $step_code_11 === "RELEA" ){
                    $unpaid_amount1 += $unpaid;
                    $permit_no .= $rr1["permit_no"]." &nbsp;";
                }
              }
        }
        }

        $surc_prev_year  = 0;
        // unpaid_amount1 is backtax for prev year
        if($unpaid_amount1>0 && $status == "backtax unpaid"){
        // if($unpaid_amount1==99999999){

                // check if surcharges and penalty  is set in penalty_table
                $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

                $penalty_r = mysqli_fetch_assoc($penalty_q);

                if ($penalty_r["surcharge_on"] == 1) {
                    $surcharges_rate = $penalty_r["surcharge_rate"];
                } else {
                    $surcharges_rate = 0;
                }

           // check if surcharges is set in onsurcharge_on in penalty_table
             $surc_prev_year = $unpaid_amount1 * $penalty_r["surcharge_rate"];
         
            ?>
            <div class="alert alert-danger">
                <?php 
                if($permit_no != ""){
                    echo "<i> ( ".$permit_no.")</i> <br>";
                } 
                
                ?>
                This Person has a backtaxes  amounting of   &#8369;  <?php echo number_format($unpaid_amount1,2);  ?> and Surcharges of   &#8369; <?php echo number_format($surc_prev_year,2);  ?>   
            </div>
            <?php
            
        }else{
            $unpaid_amount1 = 0;
        }
    // ============================================
    // ============================================
       

?>

    <link href="jomar_assets/multistep.css" rel="stylesheet" type="text/css">

<!--multisteps-form-->
<?php if(!empty($_GET["target"])){ ?>

    <?php
    // ginamit sa pag seset ng backtax at surc
        $type_of_include = "";
        include "include_surc_backtax.php";
    ?>


<div class="multisteps-form ">
    <!--progress bar-->
    <div class="row">
        <div class="col-12 col-lg-8 ml-auto mr-auto mb-4" style="width:100% !important; margin-top:10px;">
            <div class="multisteps-form__progress">
                <button class="multisteps-form__progress-btn  step_btn0" type="button" step_status="unlock_btn"
                    title="Application ">Application</button>
                <button class="multisteps-form__progress-btn js-active step_btn1" type="button" title="Assessment"
                    step_status="lock_btn">Assessment</button>
                <button class="multisteps-form__progress-btn step_btn2" type="button" title="Approval"
                    step_status="lock_btn">Approval</button>
                <button class="multisteps-form__progress-btn step_btn3" type="button" title="Payment"
                    step_status="lock_btn">Payment</button>
                <button class="multisteps-form__progress-btn step_btn4" type="button" title="Release"
                    step_status="lock_btn"> Release </button>
            </div>
        </div>
    </div>

    <!--form panels-->
    <div class="row">
        <div class="col-md-12">
            <div class="multisteps-form__form"><!-- start mother form fields -->
                <!--single form panel-->
                <form method="POST" action="bplsmodule.php?redirect=saving_process" id="bpls_form" enctype="multipart/form-data" >
                    <input type="hidden" name="owner_id" value="<?php echo $owner_id; ?>">
                    <div class="multisteps-form__panel shadow p-4 rounded form_step_btn0  <?php   if($step_code1 == "APPLI" ){ echo 'js-active'; } ?>" data-animation="scaleIn" style="background:white;" >
                        
                        <div class=" box box-primary">
                            <div class="box-body">
                                    
                        <h3 class="multisteps-form__title" style="margin-left:20px;"> Application</h3>
                        <div class="multisteps-form__content" style="background:white; padding:20px; ">
                            <!-- add i_step01 in class from validation -->
                            <!-- start ------------------------------------------------------------------------------- -->

                            <div class="box box-primary" style="background:white; ">
                                <div class=" box-body">
                                    <?php
                                        if($apn_no != null){
                                    ?>
                                    <div class="form-group">
                                        <label for="">Application No.</label>
                                        <input type="" class="form-control" value="<?php echo $apn_no; ?>" readonly>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <!-- add  in class from validation -->
                                    <!-- start -->
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="hidden" id="permit_id" value="<?php echo  $permit_id_dec; ?>">
                                            <!-- OWNER INFORMATION -->
                                            <div class="panel-group" style="cursor:pointer;">
                                                <div class="panel panel-default">
                    <div class="panel-heading"
                        style="color:white; text-align:center; background:#343536; padding:2px;"
                        data-toggle="collapse" href="#collapse01a" aria-expanded="true">
                        OWNER'S INFORMATION
                    </div>
                    <div id="collapse01a" class="panel-collapse collapse in"
                        aria-expanded="true">
                        <div class="row" style="margin:2px">
                            <div class="col-md-12">
                                <table class="table">
                                    <tr>
                                        <td style="width:25%;"><b>Owner's Name:</b></td>
                                        <td> <span class="owners_name_mess "> </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Owner's Address:</b></td>
                                        <td>  <?php echo $owner_address; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row" style="margin:2px">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success pull-right"
                                    data-toggle="modal"
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
                                        <td style="width:25%;"><b>Business Name:</b>
                                        </td>
                                        <td> <span class="business_name_mess "> </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Business Address:</b></td>
                                        <td> <?php echo $business_address; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row" style="margin:2px">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-success pull-right"
                                    data-toggle="modal"
                                    data-target="#business_modal">New</button>
                            </div>
                        </div>
                    </div>
                    </div>
                  </div>
                  <!-- BUSINESS INFORMATION -->

                </div>
                    <div class="col-md-5">
                     <!-- 001 -->
                    <div class="panel-group" style="cursor:pointer;">
                      <div class="panel panel-default">
                        <div class="panel-heading"
                        style="color:white; text-align:center; background:#343536; padding:2px;"
                        data-toggle="collapse" href="#collapse1" aria-expanded="true">
                        APPLICATION & PAYMENT
                        <input type="hidden" name="permit_num"
                        value="<?php echo $permit_id_dec; ?>">
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in"
                        aria-expanded="true">
                        <div class="row" style="margin:2px;">
                            <div class="col-md-6">
                                <label for="">Apllication Type</label>
                                  <input type="text" value="<?php if($status_code == "NEW"){echo "New"; }elseif($status_code == "RET"){echo "Retire"; }else{ echo "Renew"; } ?>" class="form-control" readonly>
                                <input type="hidden" name="application_type" value="<?php echo $status_code; ?>" >
                            </div>
                            <div class="col-md-6">
                                <label for="">Mode of Payments</label>
                                <select name="mode_of_payment"
                                    class="form-control saving_validator" <?php if($step_code1 == "RELEA" ){ echo "readonly"; } ?> >
                                    <option value="">--Select Mode of Payment--</option>
                                    <?php
                                            $query = mysqli_query($conn, "SELECT payment_frequency_code, payment_frequency_desc FROM geo_bpls_payment_frequency");
                                                while ($row = mysqli_fetch_assoc($query)) {?>
                                    <option value="<?php echo $row["payment_frequency_code"]; ?>"
                                        <?php if($r11["payment_frequency_code"] == $row["payment_frequency_code"]){ echo "selected"; } ?>>
                                        <?php echo $row["payment_frequency_desc"]; ?>
                        </option>
                        <?php } ?>
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
                    <div id="collapse0" class="panel-collapse collapse in"  aria-expanded="true">
                        <table class="table">
                            <tr>
                                <td colspan=2>
                                    if check box is selected. the requirement will mark as submited
                                </td>
                            </tr>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM geo_bpls_requirement");
                            $req_counter=0;
                                while ($row = mysqli_fetch_assoc($query)) {
                                    $req_counter++;
                                        if ($row["requirement_default"] == 0) {
                       
                                $q = mysqli_query($conn,"SELECT * FROM geo_bpls_business_requirement where business_id = '$business_id' ");
                                $checked_status = "";
                                $file_input_status = "";
                                $saving_validator_class = "";
                                $file_viewing_button = "";

                                if(mysqli_num_rows($q) > 0){  
                                    while($r = mysqli_fetch_assoc($q) ){
                                        if($row["requirement_id"] == $r['requirement_id'] && $r['requirement_file'] == ""  ){ 
                                            $checked_status = "checked"; 
                                            $file_input_status = "disabled";
                                            $saving_validator_class = "";
                                            $file_viewing_button ="off";

                                        }else{
                                            $saving_validator_class = "saving_validator";
                                            $file_viewing_button ="on";
                                        }
                                        
                                    }   
                                } ?>
                            <tr>
                                <td> <input type="checkbox" name="requirements[]"  class="select_all_req  " value="<?php echo $row["requirement_id"]; ?>" ca_req_counter="<?php echo $req_counter; ?>" <?php echo $checked_status; ?>  > </td>

                                <td>
                                    <b class="text-primary" ><?php echo $row["requirement_desc"]; ?></b><br><input type="file" name="requirements_files[]"  class="   tragetfileinput tragetfileinput<?php echo $req_counter; ?>"  ca_req_counter="<?php echo $req_counter; ?>"  <?php echo $file_input_status; ?> style="width:70%;"  > 
                                    
                                    <input type="hidden" value="<?php echo $row["requirement_id"]; ?>" name="requirement_id[]" class="requirements_id<?php echo $req_counter; ?>" disabled>

                                    
                                </td>
                                <td>
                                <?php
                                // check if file_viewing_button is OK
                                $requirement_id = $row["requirement_id"];
                                $q15t = mysqli_query($conn,"SELECT * FROM geo_bpls_business_requirement where business_id = '$business_id' and requirement_id = '$requirement_id' ");
                                if(mysqli_num_rows($q15t) > 0){  
                                    $r15t = mysqli_fetch_assoc($q15t);
                                    $filesname = $r15t["requirement_file"];
                                    $exception_business_id = $r15t["business_id"];
                                    $exception_requirement_id = $r15t["requirement_id"];
                                ?>
                                
                                <input type="hidden" name="exception_filesname[]" value="<?php echo $filesname; ?>" class="exception_filesname<?php echo $req_counter; ?>"  <?php echo $file_input_status; ?> >
                                <input type="hidden" name="exception_business_id[]" value="<?php echo $exception_business_id; ?>" class="exception_business_id<?php echo $req_counter; ?>"  <?php echo $file_input_status; ?> >
                                <input type="hidden" name="exception_requirement_id[]" value="<?php echo $exception_requirement_id; ?>" class="exception_requirement_id<?php echo $req_counter; ?>"  <?php echo $file_input_status; ?> >

                                          <button type="button" class="btn btn-info btn-sm view_doc_btn" style="margin-top:5px;" requirement_id = "<?php echo $row["requirement_id"]; ?>" permit_id="<?php echo $permit_id_dec; ?>" business_id = "<?php echo $business_id; ?>"  data-toggle="modal" data-target="#view_doc" <?php echo $file_input_status; ?>> view</button>
                                        <?php
                                    }
                                ?>
                                </td>
                            </tr>
                            <?php
                                }
                            } ?>
                        </table>
                        <!-- <div class="panel-footer">Footer</div> -->
                           </div>
                       </div>
                     </div>
                <!-- 001 -->
                 </div>
                </div>
                <!-- end -->
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
                            <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"  data-toggle="collapse" href="#collapse0aa" aria-expanded="true">
                                                BUSINESS NATURE 
                        </div>
                <div class="row" style="margin:2px;">
                   <div class="col-md-12">
                    <?php
                    if($step_code1 == "PAYME" || $step_code1 == "RELEA" ){ ?>
                    <table style="width:100%;">
                    <tr>
                        <td>
                            <label for="">Business Nature </label>
                        </td>
                        <td>
                            <label for="">Scale Code</label>
                        </td>
                        <td>
                        </td>
                        <td>
                        <?php 
                            if( $status_code == "REN"){
                                echo "<label>Gross/Sales:</label>";
                            }elseif( $status_code == "RET"){
                                echo "<label>Gross/Sales:</label>";
                            }else{
                                echo "<label>Capital Investment:</label>";
                            } 
                        ?>
                        </td>
                        <td></td>
                    </tr>
                    <?php
                        $q12 = mysqli_query($conn,"SELECT * FROM `geo_bpls_business_permit_nature` 
                        inner join `geo_bpls_nature` on   geo_bpls_nature.nature_id = geo_bpls_business_permit_nature.nature_id 
                        where md5(permit_id) = '$id' ");   
                        while($r12 = mysqli_fetch_assoc($q12)){
                            $nature_application_type = $r12["nature_application_type"];
                            $nature_scale_code = $r12["scale_code"];
                            ?>
                    <tr>
                    <td >
                        <div class="form-group" style="margin:2px;">
                        <input type="text" class="form-control" value="<?php echo $r12["nature_desc"];?>" readonly>
                        </div>
                    </td>
                    <td style="width:16%;">
                   <select class="form-control "  readonly>
                        <option value="">--Select Business Scale--</option>
                        <?php
                                $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_scale`");
                                while ($row = mysqli_fetch_assoc($query)) {?>
                        <option value="<?php echo $row["scale_code"]; ?>"
                            <?php if($nature_scale_code == $row["scale_code"]){ echo "selected"; } ?>>
                            <?php echo $row["scale_desc"]; ?>(<?php echo $row["scale_code"]; ?>)
                        </option>
                        <?php } ?>
                    </select>
                   </td>
                    <td style="width:10%;">
                   <select  class="form-control" readonly>
                        <option value="NEW" <?php if($nature_application_type != ""){ if($nature_application_type == "NEW"){ echo "selected"; } }else{ if($status_code == "NEW"){ echo "selected"; } }  ?> >New</option>
                        <option value="REN"  <?php  if($nature_application_type != ""){ if($nature_application_type == "REN"){ echo "selected"; } }else{ if($status_code == "REN"){ echo "selected"; } } ?> >Renew</option>

                        <option value="RET"  <?php  if($nature_application_type != ""){ if($nature_application_type == "RET"){ echo "selected"; } }else{ if($status_code == "RET"){ echo "selected"; } } ?> >Retire</option>
                        </select>
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
                        $q12 = mysqli_query($conn,"SELECT * FROM `geo_bpls_business_permit_nature` 
                        inner join `geo_bpls_nature` on   geo_bpls_nature.nature_id = geo_bpls_business_permit_nature.nature_id 
                        where md5(permit_id) = '$id' "); 
                        $counter_a = 200;  
                        if(mysqli_num_rows($q12)>0){
                        while($r12 = mysqli_fetch_assoc($q12)){
                            $nature_application_type = $r12["nature_application_type"];
                            $nature_scale_code = $r12["scale_code"];
                            $counter_a++;
                             if($nature_application_type == "NEW"){
                    $cap_inv = $r12["capital_investment"];
                            }else{
                    $cap_inv = $r12["last_year_gross"];
                            } ?>
                       <tr class="mother_tr<?php echo $counter_a; ?>" > 
                    <td> 
                    <?php if($counter_a == 201){ ?> <label for="">Business Nature</label> <?php } ?>
                        <select class="form-control selectpicker" name="nature[]" id="nature_id"
                            data-show-subtext="true" data-live-search="true">
                            <option value="">--Select Nature--</option>
                            <?php
                            $query = mysqli_query($conn, "SELECT DISTINCT nature_desc, geo_bpls_nature.nature_id FROM `geo_bpls_nature`
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
                        <td style="width:10%;">
                         <?php 
                            if($counter_a == 201){ ?> <label for="">Business Scale</label> <?php }?>
                                 <select class="form-control b_validator" name="b_scale_arr[]"  id="b_scale">
                        <option value="">--Select Business Scale--</option>
                        <?php
                                $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_scale`");
                                while ($row = mysqli_fetch_assoc($query)) {?>
                        <option value="<?php echo $row["scale_code"]; ?>"
                            <?php if($nature_scale_code == $row["scale_code"]){ echo "selected"; } ?>>
                            <?php echo $row["scale_desc"]; ?>(<?php echo $row["scale_code"]; ?>)
                        </option>
                        <?php } ?>
                    </select>
                    </td>
                    <td style="width:10%;">
                     <?php 
                    if($counter_a == 201){ ?> <label for=""> &nbsp;</label> <?php }?>
                    <select name="nature_application_type[]" class="form-control">
                        <option value="NEW" <?php if($nature_application_type != ""){ if($nature_application_type == "NEW"){ echo "selected"; } }else{ if($status_code == "NEW"){ echo "selected"; } }  ?> >New</option>
                        <option value="REN"  <?php  if($nature_application_type != ""){ if($nature_application_type == "REN"){ echo "selected"; } }else{ if($status_code == "REN"){ echo "selected"; } } ?> >Renew</option>
                        <option value="RET"  <?php  if($nature_application_type != ""){ if($nature_application_type == "RET"){ echo "selected"; } }else{ if($status_code == "RET"){ echo "selected"; } } ?> >Retire</option>
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
                <?php } }else{
                    // pag walang mahanap na nature
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
                                    <td style="width:10%;">
                                        <label for="">Business Scale</label>
                                            <select class="form-control saving_validator" name="b_scale_arr[]" id="b_scale">
                                                <option value="">--Select Business Scale--</option>
                                                  <?php
                                $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_scale`");
                                while ($row = mysqli_fetch_assoc($query)) {?>
                                                <option value="<?php echo $row["scale_code"]; ?>"> <?php echo $row["scale_desc"]; ?>(<?php echo $row["scale_code"]; ?>) </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td style="width:10%;">
                                          <label for="">&nbsp;</label>
                                        <select name="nature_application_type[]" class="form-control" >
                                            <option value="NEW">New</option>
                                            <option value="REN">Renew</option>
                                            <option value="RET">Retire</option>
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

                    <?php } ?>
                            </div>
                        </div>
                        <!-- <div class="panel-footer">Footer</div> -->
                    </div>
                </div>
                <!-- 001 -->
                                </div>
                            </div>
                            <!-- end ----------------------------------------------------------------------------------->
                            <div class="button-row">
                                <button type="button" class="btn btn-success pull-right" name="update_application_form"
                                    id="form_save" btn_name="save">SAVE & PROCEED TO ASSESSMENT </button>
                                <input type="hidden" name="hidden_validation" id="hidden_validation">

                                
                                </div>
                                
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Owners Modal -->
                    <div class="modal fade" id="owners_modal" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog " style="width:80%;">
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
                                        <div class="box-body">

                                        <div class="row" style="margin-bottom:10px;">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Find Owner's:</label>
                                                    <select  class="selectpicker form-control" name="owners_id" id="find_owners" data-live-search="true" data-show-subtext="true"  >
                                                    <option value=""></option>
                                                    <?php
                                                        $q = mysqli_query($conn,"SELECT owner_id, CONCAT(owner_first_name,' ', owner_middle_name,' ', owner_last_name) as fname, barangay_id, owner_birth_date FROM geo_bpls_owner");
                                                        while($r = mysqli_fetch_assoc($q)){
                                                            $barangay_id = $r["barangay_id"];
                                                                    $q1212 = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as o_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");
                                                                    $r1212 = mysqli_fetch_assoc($q1212);

                                                            ?>
                                                        <option value="<?php echo $r["owner_id"]; ?>"> <?php echo $r["fname"]." | ".$r1212["o_add"]." | ".$r["owner_birth_date"]; ?> </option>
                                                            <?php
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Last Name</label>
                                                        <input type="text" name="tax_payer_lname"
                                                            value="<?php echo ($r11["owner_last_name"]); ?>" id="l_name"
                                                            class="form-control o_validator">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">First Name</label>
                                                        <input type="text" name="tax_payer_fname"
                                                            value="<?php echo ($r11["owner_first_name"]); ?>" id="f_name"
                                                            class="form-control o_validator">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for=""> Middle Name</label>
                                                        <input type="text" name="tax_payer_mname"
                                                            value="<?php echo ($r11["owner_middle_name"]); ?>" id="m_name"
                                                            class="form-control o_validator">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 2nd row -->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Citizenship</label>
                                                        <select name="citizenship" id="citizenship_id" class="form-control  o_validator" >
                                                            <option value="">--Select Citizenship--</option>
                                                            <?php
                                $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_citizenship`");
                                while ($row = mysqli_fetch_assoc($query)) {?>
                                                            <option value="<?php echo $row["citizenship_id"]; ?>"
                                                                <?php if($r11["citizenship_id"] == $row["citizenship_id"]){ echo "selected"; } ?>>
                                                                <?php echo $row["citizenship_desc"]; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Civil Status</label>
                                                        <select  name="civil_status" id="civil_status_id" class="form-control  o_validator" >
                                                            <option value="">--Select Civil Status--</option>
                                                            <?php
                                $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_civil_status`");
                                while ($row = mysqli_fetch_assoc($query)) {?>
                                                            <option value="<?php echo $row["civil_status_id"]; ?>"
                                                                <?php if($r11["civil_status_id"] == $row["civil_status_id"]){ echo "selected"; } ?>>
                                                                <?php echo $row["civil_status_desc"]; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Gender</label>
                                                        <select name="gender" id="gender_id" class="form-control o_validator" >
                                                            <option value="">--Select Gender--</option>
                                                            <option value="M"
                                                                <?php if($r11["gender_code"] == "M"){ echo "selected"; } ?>>
                                                                Male
                                                            </option>
                                                            <option value="F"
                                                                <?php if($r11["gender_code"] == "F"){ echo "selected"; } ?>>
                                                                Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Birthdate</label>
                                                        <input type="date" name="birthdate"   id="birthdate_id" class="form-control "    value="<?php echo $r11["owner_birth_date"]; ?>"
                                                         >
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 3rd row -->


                                            <!-- 4rth row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Mobile No.</label>
                                                        <input type="text" name="o_mob_no"
                                                            value="<?php echo $r11["owner_mobile"]; ?>"
                                                            id="o_mob_no_id" class="form-control o_validator">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Email Address</label>
                                                        <input type="email" name="o_email"   id="o_email_id" class="form-control "  value="<?php echo $r11["owner_email"]; ?>"
                                                         >
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- 5th row -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Legal Entity</label>
                                                        <textarea name="legal_entity"
                                                            id="legal_entity_id" class="form-control "><?php echo $r11["owner_legal_entity"]; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                    <hr>
                                   
                                            <div class="row">

                                                <!-- section for discount -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Person with Disability</label>
                                                    <input type="checkbox" name="PWD_status" style="margin-right:30px;" <?php if($r11["PWD_status"] == 1){echo "checked"; } ?>>

                                                    <label for="">4PS</label>
                                                    <input type="checkbox" name="FPS_status" style="margin-right:30px;" <?php if($r11["4PS_status"] == 1){echo "checked"; } ?>>

                                                    <label for="">Solo Parent</label>
                                                    <input type="checkbox" name="SP_status" style=" margin-right:30px;" <?php if($r11["SP_status"] == 1){echo "checked"; } ?>>
                                                </div>

                                                <div class="box">
                                                    <div class="box-body">
                                                        <!-- select all active discount in DB -->
                                                        <?php
                                                    $q4540 = mysqli_query($conn,"SELECT * FROM `geo_bpls_discount_name` where discount_status = 1");
                                                    while($r4540 = mysqli_fetch_assoc($q4540)){
                                                        // checked if nag exist na sa discount recored
                                                        $discount_name_id = $r4540["discount_name_id"];

                                                        $q232 = mysqli_query($conn,"SELECT * FROM `geo_bpls_discounted_business` where  discount_name_id = '$discount_name_id' and permit_id = '$permit_id_dec' ");
                                                        $q232_count = mysqli_num_rows($q232);
                                                        ?>
                                                        <label for=""><?php echo $r4540["discount_name"]; ?></label>
                                                        <input type="checkbox" name="application_dicount[]" style="margin-right:30px;" value="<?php echo $discount_name_id; ?>" <?php if($q232_count > 0){ echo "checked"; } ?>  >
                                                        <?php
                                                    }
                                                        ?>  
                                                        <!-- select all active discount in DB -->
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- section for discount -->

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
                                                        <select class=" selectpicker form-control"  name="region"  id="region" data-show-subtext="true"
                                                            data-live-search="true">
                                                            <option value="">--Select Region--</option>
                                                            <?php
                                $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_region`");
                                while ($row = mysqli_fetch_assoc($query)) {?>
                                                            <option value="<?php echo $row["region_code"]; ?>"
                                                                ca_attr="<?php echo $row["region_desc"]; ?>"
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
                                                    <select class="selectpicker form-control " name="barangay"
                                                        data-show-subtext="true" id="barangay" data-live-search="true">
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
                                                        <input type="text" name="street"
                                                            value="<?php echo $r11["owner_address_street"]; ?>"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ADDRESS  -->
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
                                    <!-- body end -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger pull-left"
                                        data-dismiss="modal">Cancel</button>
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
                                                                    name="business_id" id="business_id"
                                                                    value="<?php echo $r11["business_id"]; ?>">

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
                                                $query = mysqli_query($conn, "SELECT business_type_code, business_type_desc FROM geo_bpls_business_type");
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
                                                $query = mysqli_query($conn, "SELECT business_type_code, business_type_desc FROM geo_bpls_business_type");
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
                                                    $query = mysqli_query($conn, "SELECT business_type_code, business_type_desc FROM geo_bpls_business_type");
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
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_economic_org`");
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
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_economic_area`");
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
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_scale`");
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
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_sector`");
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
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_zone`");
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
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_occupancy`");
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
                                    <!-- modal body eend  -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger pull-left"
                                        data-dismiss="modal">Cancel</button>

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

                <?php 
                    if($r11["retirement_file"] != null && $r11["retirement_file"] != "" ){
                ?>
                 <!-- Modal -->
                <div id="myModalret" class="modal fade" role="dialog">
                <div class="modal-dialog modal-md">

                    <!-- Modal content-->
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">
                            <?php echo $r11["retirement_file"]; ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                    <img src="bpls/retirement_file/<?php echo $r11["retirement_file"]; ?>" style="width:100%; height:100%;">
                      
                    </div>
                    <div class="modal-footer">
                    <a href="bpls/retirement_file/<?php echo $r11["retirement_file"]; ?>"  target="_blank" > 
                        <button type="button" class="btn btn-info pull-left" >Download</button>
                    </a>
                      <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
                    </div>
                    </div>

                </div>
                </div>
                <?php } ?>
                <!--single form panel-->
                <div class="multisteps-form__panel <?php  if($step_code1 == "ASSES" ){ echo "js-active "; } ?>  shadow p-4 rounded bg-white form_step_btn1"
                    data-animation="scaleIn">

                    <div class="box box-primary">
                        <div class="box-body">
                            <h3 class="multisteps-form__title">Assessment</h3>
                            <div class="multisteps-form__content">
                                <!-- start -->
                                <!--  header info -->
                                <?php
                                    // include for multi use
                                    // if($status_code == "RET"){
                                    //     include("include_ret_assesment_multistep.php");
                                    // }else{
                                        include("include_assesment_multistep.php");
                                    // }
                                ?>
                                <div class="button-row d-flex mt-4">
                                    <button class="btn btn-primary ml-auto js-btn-next pull-right" type="button"
                                        title="Next">Approval</button>
                                    <button class="btn btn-primary js-btn-prev pull-left" style="margin-right:8px;"
                                        type="button" title="Prev">Application</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    


                </div>
                <!--single form panel-->
                <div class="multisteps-form__panel <?php  if($step_code1 == "APPRO" ){ echo "js-active "; }  ?>   shadow p-4 rounded bg-white form_step_btn2"
                    data-animation="scaleIn">
                    
                     <div class="box box-primary">
                        <div class="box-body">
                            <h3 class="multisteps-form__title">Approval</h3>
                            <div class="multisteps-form__content" >
                                <!-- start -->
                                <?php
                                    // include for multi use
                                    include("include_approval_multistep.php");
                                ?>
                                <!-- end -->
                                <div class="button-row d-flex mt-4 ">
                                    <button class="btn btn-primary ml-auto js-btn-next pull-right" type="button"
                                        title="Next">Payment</button>
                                    <button class="btn btn-primary js-btn-prev pull-left" style="margin-right:8px;"
                                        type="button" title="Prev">Assessment</button>
                                </div>
                            </div>
                        </div>
                    </div>

      
                </div>
                <!--single form panel-->
                <div class="multisteps-form__panel <?php if(isset($_GET["traget_n"])){ if($_GET["traget_n"] == "tres"){ echo "js-active"; }else{ if($step_code1 == "PAYME" ){ echo "js-active "; } } 
    }else{ if($step_code1 == "PAYME" ){ echo "js-active "; }  }  ?> shadow p-4 rounded bg-white form_step_btn3"
                    data-animation="scaleIn">
                    <div class="box box-primary">
                        <div class="box-body">
                            <h3 class="multisteps-form__title">Payment</h3>
                            <div class="multisteps-form__content">
                                <!-- start -->
                                <?php
                                    // include for multi use
                                    include("include_payment_multistep.php");
                                ?>
                                <!-- end -->
                                <div class="button-row d-flex mt-4">
                                    <button class="btn btn-primary ml-auto js-btn-next pull-right" type="button"
                                        title="Next">Release</button>
                                    <button class="btn btn-primary js-btn-prev pull-left" style="margin-right:8px;"
                                        type="button" title="Prev">Approval</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                <!--single form panel-->
                <div class="multisteps-form__panel <?php if(isset($_GET["traget_n"])){ if($step_code1 == "RELEA" && $_GET["traget_n"] != "tres" ){ echo "js-active "; } }else{ if($step_code1 == "RELEA" ){ echo "js-active "; } }  ?> shadow p-4 rounded bg-white form_step_btn4"
                    data-animation="scaleIn">

                   
                  <div class="box box-primary">
                        <div class="box-body">
                            <h3 class="multisteps-form__title">Release</h3>
                            <div class="multisteps-form__content">
                                <!-- start -->
                            <?php
                                    include("include_release_multistep.php");
                            ?>
                            </div>
                            <!-- end -->
                        <div class="button-row d-flex mt-4">
                                <button class="btn btn-primary js-btn-prev pull-left" style="margin-right:8px;"
                                        type="button" title="Prev">Payments</button>
                                </div>
                                <br>
                                <br>
                                <br>
                        </div>
                    </div>

                </div>

                
            </div><!-- end mother form fields -->
        </div>
    </div>
</div>
<!-- partial -->



<!-- nature onchange fetch assestment -->
<style>
        /* solution for 1st modal cant scroll after showing modal 2 */
    #payments_modal {
        overflow-y: scroll;
    }
</style>
                <form role="form" method="POST" action="bplsmodule.php?redirect=payment_process">
                    <!-- Payments  Modal -->
                    <div class="modal fade" id="payments_modal" data-backdrop="static" data-keyboard="false" >
                        <div class="modal-dialog modal-md " style="  margin-top:5px; ">
                            <div class="modal-content">
                                <!-- <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
                <h4 class="modal-title">BUSINESS INFORMATION</h4>
            </div> -->
                                <div class="modal-body" >
                                    <!-- modal body start  -->
                                    <div class="box box-primary">
                                        <div class="box-header">
                                            <big class="box-title"><b>51 C Receipt Form</b></big>

                                        </div>
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="hidden" name="permit_num"
                                                        value="<?php echo $permit_id_dec; ?>">
                                                    <input type="hidden" name="mode_of_payment"
                                                        value="<?php echo $mode_of_payment; ?>">
                                                    <input type="hidden" name="sector_code" value="<?php echo $sector_code; ?>">
                                                    <div
                                                        style="border:gray solid 2px; padding: 2px; margin-bottom: 3px;">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-inline">
                                                                    <div >
                                                                        <label style="font-size: 1.4em;">Date :</label>
                                                                        <td align="center" > <input type="date"
                                                                                name="or_date" value="<?php echo date("Y-m-d"); ?>"
                                                                                style="border:none; text-align:right; font-size: 1.5em;"
                                                                                class="form-control"
                                                                                placeholder="Select Date"
                                                                                class="form-control" required>
                                                                            <input type="hidden" name="target"
                                                                                value="<?php echo $id; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-inline">
                                                                    <div >
                                                                        <label style="font-size: 1.4em;">O.R.
                                                                            No.</label>

                                                                        <input type="hidden" id="cashier" value="<?php echo $_SESSION["uname"]; ?>">
                                                                        <td align="center" ><input type="number"
                                                                                name="or_num"
                                                                                style="border:solid lightgreen 2px; text-align:right; font-size: 1.6em; font-weight: bold; background-color: #F5F5DC; max-width:220px;"
                                                                                class="form-control"
                                                                                id="or_num" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div style="border:gray solid 2px; padding: 2px;">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div class="form-group">
                                                                    <label for="mto" style="font-size: 1em;">
                                                                        Agency</label>
                                                                    <input type="text" name="agency"
                                                                        value="MTO-Majayjay"
                                                                        class="form-control input-sm"
                                                                        placeholder="MTO-Gumaca" id="mto"
                                                                        style="font-size: 1.3em; font-weight: bold;"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="fcode" style="font-size: 1em;"> Fund
                                                                        Code</label>
                                                                    <select class="form-control input-sm"
                                                                        name="fund_code" id="fcode"
                                                                        style="font-size: 1.2em; font-weight: bold;"
                                                                        required>
                                                                        <option value="100">100 | General Fund</option>
                                                                        <option value="200">200 | SEP</option>
                                                                        <option value="300">300 | Trust Fund</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="or_payor" style="font-size: 1em;">
                                                                        Payor</label>
                                                                    <input type="text" name="or_payor" value="<?php echo ($r11["owner_first_name"])." ".($r11["owner_middle_name"])." ".($r11["owner_last_name"]); ?>"
                                                                        class="form-control input-md"
                                                                        placeholder="Fullname or Company name"
                                                                        id="or_payor"
                                                                        style="font-size: 1.2em; font-weight: bold;"
                                                                        required>
                                                                </div>
                                                            </div>

                                                          
                                                        </div>
                                                    </div>
                                                 
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <style type="text/css">
                                                            th.xyz {
                                                                border: black solid 2px;
                                                                text-align: center;
                                                                font-size: 1.3em;
                                                            }

                                                            td.abc {
                                                                border: black solid 1px;
                                                                text-align: left;
                                                                padding: 3px;
                                                            }

                                                            .bs-searchbox {
                                                                width: 300px;
                                                            }
                                                            </style>
                                                          
                                                            <table style="margin-top:2px; margin-bottom:2px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="xyz" colspan="3">LOCAL TAXES FEES
                                                                        </th>
                                                                        <!--  <th width="22%" class="xyz">Account Code</th> -->
                                                                        <th class="xyz">Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="p_scents">
<?php
  $q_payments = mysqli_query($conn, "SELECT natureOfCollection_tbl.id as sub_account_no, sum(assessment_tax_due) as assessment_tax_due FROM `geo_bpls_assessment` inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no where md5(permit_id) = '$id' and assessment_tax_due != 0 GROUP by sub_account_no ");
      
           // check 1st payment in quarter
                    $check_part1_quarter = mysqli_query($conn,"SELECT payment_date FROM `geo_bpls_payment` where  permit_id = '$permit_id_dec'  ORDER BY `geo_bpls_payment`.`payment_date` DESC limit 1");

                    $check_part1_count = mysqli_num_rows($check_part1_quarter);
                    $check_part1_quarter_row = mysqli_fetch_assoc($check_part1_quarter);
                    $last_payment_date_arr = explode(" ", $check_part1_quarter_row["payment_date"]);
                        if ($check_part1_count == 1) {
                             //  get last day and f day of latest payment
                            $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
                            $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
                            $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "03" . "-31";
                            //  get last day and f day of latest payment
                        } elseif ($check_part1_count == 2) {
                            //  get last day and f day of latest payment
                            $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
                            $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
                            $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "06" . "-31";
                            //  get last day and f day of latest payment
                        } elseif ($check_part1_count == 3) {
                            //  get last day and f day of latest payment
                            $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
                            $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
                            $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "09" . "-31";
                            //  get last day and f day of latest payment
                        } elseif ($check_part1_count == 4) {
                            //  get last day and f day of latest payment
                            $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
                            $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
                            $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "12" . "-31";
                            //  get last day and f day of latest payment
                        }

                        $current_quarter = 0;
                        $active_quarter = 0;
                        $done_quarter = 0;
                        $p_total = 0;
                        $gross_tax = 0;
                        $sur_counter = 0;
                        $backtax = 0;
                        $backtax_tax = 0;
                        $backtax_fee = 0;
                        $date_now = date("Y-m-d"); 
                        $backtax_counter = 0;
                        $loop_counter = 0;
            while($r_payments = mysqli_fetch_assoc($q_payments)){
                $loop_counter++;
                $sub_account_no = $r_payments["sub_account_no"];
                // getting account tittle
                $q454a = mysqli_query($conn,"SELECT natureOfCollection_tbl.name as sub_account_title from natureOfCollection_tbl where id = '$sub_account_no' ");
                $r454a = mysqli_fetch_assoc($q454a);
                // getting nature_id
                $q22a = mysqli_query($conn,"SELECT nature_id from geo_bpls_business_permit_nature where md5(permit_id) = '$id' ");
                $r22a = mysqli_fetch_assoc($q22a);
                $nature_id = $r22a["nature_id"];
                ?>
                 <tr>
                <?php
/* *********************************************************  */ if ($mode_of_payment == "Quarterly") {
                 $division_no = 4;
                // Quarter ------------------------------------
                // cheking date of paymemnts
                $p_date_q = mysqli_query($conn, "SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");
                $p_date_r = mysqli_fetch_assoc($p_date_q);
                // cheking date of paymemnts
                // check if surcharges and penalty  is set in penalty_table
                $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");
                $penalty_r = mysqli_fetch_assoc($penalty_q);
                if ($penalty_r["surcharge_on"] == 1) {
                    $surcharges_rate = $penalty_r["surcharge_rate"];
                } else {
                    $surcharges_rate = 0;
                }
                if ($penalty_r["interest_on"] == 1) {
                    $penalty_rate = $penalty_r["surcharge_rate"];
                } else {
                    $penalty_rate = 0;
                }
                // check if surcharges is set in onsurcharge_on in penalty_table
                $check_part_quarter = mysqli_query($conn, "SELECT payment_part FROM `geo_bpls_payment` WHERE permit_id = '$permit_id_dec' order by payment_id DESC limit 1 ");
                $check_part_quarter_row = mysqli_fetch_assoc($check_part_quarter);
                    $paidQTR = $check_part_quarter_row["payment_part"];
                        if ($paidQTR == "" || $paidQTR == null || $paidQTR == 0) {
                            $paidQTR = 0;
                        }
                    $m = date("m");
                // important in current quarter 3 for division of year into 4 quarter
                 $current_quarter = floor(($m - 1) / 3) + 1;
                    for ($am = 1; $am < 5; $am++) {
                        $year = date("Y");
                        $aa1 = $year . "-" . $p_date_r["payment_qtrdue" . $am];
                        $date_arr = explode('-', $p_date_r["payment_qtrdue" . $am]);
                        $month_start = $year . "-" . $date_arr[0] . "-01";
                // surcharges counter
                // may loop counter para isang beses languulit ang pag cocondition kung lampas na sa due surc date
                        if($loop_counter == 1){
                            if($am > $paidQTR) {
                                if($date_now > $aa1) {
                                    $sur_counter++;
                                }
                            }
                        }
                         // check what payment quarter
                      }
                                    
               ?>
                <td class="abc" colspan="3"  style="width: 70%; font-weight: bold; font-size: 1.2em;">
                
               <?php 
                $gross_counter = 0;
                if($sub_account_no == 1010 || $sub_account_no == 1011  || $sub_account_no == 1012  || $sub_account_no == 1013  || $sub_account_no == 1014  || $sub_account_no == 1015 || $sub_account_no == 1016 || $sub_account_no == 1017 || $sub_account_no == 1018 || $sub_account_no == 1019 || $sub_account_no == 1020 || $sub_account_no == 1021){
                    // check sector kung ano ang gross sales auto inc
                    echo substr(strtoupper($r454a["sub_account_title"]),0,15);
                    // changing the value of sub_account/or auto in ID
                    $gross_counter++;
                }else{
                    echo strtoupper($r454a["sub_account_title"]);
                }
                ?>
                </td>
                <td class="abc"  style="width: 25%; text-align:right; font-weight: bold; font-size: 1.2em;">
                <?php
                $vav = str_replace(',', '', number_format(($r_payments["assessment_tax_due"] / $division_no), 2));
                $qtr_count = $current_quarter - $paidQTR;
                if ($qtr_count > 1) {
                    if ( $gross_counter > 0) {
                        $backtax_tax += $vav * ($qtr_count -1);
                    } else {
                         $backtax_fee += $vav * ($qtr_count -1);
                    }
                 // add backtax
                $backtax += $vav * ($qtr_count - 1);
                $payment_qtr =  $paidQTR + ($qtr_count - 1) + 1;
                // pagcount kung ilan ang backtax
                    if($loop_counter == 1){
                        $backtax_counter = $qtr_count - 1;
                    }
                }else{
                    $payment_qtr =  $paidQTR +1;
                }
                $p_total += $vav;
                 ?>
                    <span class="normal_label<?php echo $loop_counter; ?>">
                        <?php echo number_format($vav, 2); ?>
                    </span>
                                    <!-- Quarter input 1+1+1 -->

                        <input type="hidden" name="payment_qtr" value="<?php echo $payment_qtr; ?>" class="form-control taxs_payment_qtr"  required>
                        <input type="hidden" name="desc[]" value="<?php echo $r454a["sub_account_title"]; ?>" class="form-control" required>
                         <input type="hidden" name="nature[]" value="<?php echo $nature_id; ?>" class="form-control" required>
                        <input type="hidden" name="normal[]" value="<?php echo $vav; ?>" class="form-control total_amount_counter base_normal_amount " ca_normal_fields="<?php echo $loop_counter; ?>" required>
                        <!-- reference only base normal amount -->
                        <input type="hidden" value="<?php echo $vav; ?>" class=" <?php if($gross_counter>0){ echo "gross_normal_amount_class"; }else{ echo "normal_amount_class"; } ?> base_normal_amount<?php echo $loop_counter; ?>" >
                        <!-- reference only base normal amount -->
                        <input type="hidden" name="sub_account_no[]" value="<?php echo $r_payments["sub_account_no"]; ?>" class="form-control" required>
                        </td>
                                    <!--Quarter input -->
                        <?php
           // end of if for cheking payment part1
 /* *********************************************************  */  }elseif ($mode_of_payment == "Semi-annual") {
                        $division_no = 2;
                        // Quarter ------------------------------------
                        // cheking date of paymemnts
                        $p_date_q = mysqli_query($conn, "SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");

                        $p_date_r = mysqli_fetch_assoc($p_date_q);
                        // cheking date of paymemnts

                        // check if surcharges and penalty  is set in penalty_table
                        $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

                        $penalty_r = mysqli_fetch_assoc($penalty_q);

                        if ($penalty_r["surcharge_on"] == 1) {
                            $surcharges_rate = $penalty_r["surcharge_rate"];
                        } else {
                            $surcharges_rate = 0;
                        }

                        if ($penalty_r["interest_on"] == 1) {
                            $penalty_rate = $penalty_r["surcharge_rate"];
                        } else {
                            $penalty_rate = 0;
                        }
                              // check if surcharges is set in onsurcharge_on in penalty_table
                       // check if surcharges is set in onsurcharge_on in penalty_table
                       $check_part_quarter = mysqli_query($conn, "SELECT payment_part FROM `geo_bpls_payment` WHERE permit_id = '$permit_id_dec' order by payment_id DESC limit 1 ");
                       $check_part_quarter_row = mysqli_fetch_assoc($check_part_quarter);
                       $paidQTR = $check_part_quarter_row["payment_part"];
                       if ($paidQTR == "" || $paidQTR == null || $paidQTR == 0) {
                           $paidQTR = 0;
                       }
                       $m = date("m");
                       // important in current quarter 3 for division of year into 4 quarter
                       $current_quarter = floor(($m - 1) / 6) + 1;
                       for ($am = 1; $am < 3; $am++) {
                           $year = date("Y");
                           $aa1 = $year . "-" . $p_date_r["payment_semdue" . $am];

                           $date_arr = explode('-', $p_date_r["payment_semdue" . $am]);
                           $month_start = $year . "-" . $date_arr[0] . "-01";
                           // surcharges counter
                           // may loop counter para isang beses languulit ang pag cocondition kung lampas na sa due surc date
                           if($loop_counter == 1){
                            if ($am > $paidQTR) {
                                if ($date_now > $aa1) {
                                    $sur_counter++;
                                }
                            }
                          }
                    // check what payment quarter
                                            }
                         ?>
                       <td class="abc" colspan="3"  style="width: 70%; font-weight: bold; font-size: 1.2em;">
                       <?php 
                       $gross_counter = 0;
                     if($sub_account_no == 1010 || $sub_account_no == 1011  || $sub_account_no == 1012  || $sub_account_no == 1013  || $sub_account_no == 1014  || $sub_account_no == 1015 || $sub_account_no == 1016 || $sub_account_no == 1017 || $sub_account_no == 1018 || $sub_account_no == 1019 || $sub_account_no == 1020 || $sub_account_no == 1021){
                        // check sector kung ano ang gross sales auto inc
                        echo substr(strtoupper($r454a["sub_account_title"]),0,15);
                        // changing the value of sub_account/or auto in ID
                        $gross_counter++;
                        }else{
                            echo strtoupper($r454a["sub_account_title"]);
                        }
                     ?>
                      </td>
                       <td class="abc" style="width: 25%; text-align:right; font-weight: bold; font-size: 1.2em;">
                     <?php
                     $vav = str_replace(',', '', number_format(($r_payments["assessment_tax_due"] / $division_no), 2));
                    $qtr_count = $current_quarter - $paidQTR;
                    if ($qtr_count > 1) {
                        if ($gross_counter > 0){
                            $backtax_tax += $vav * ($qtr_count - 1);
                        }else{
                            $backtax_fee += $vav * ($qtr_count - 1);
                        }
                        $backtax += $vav * ($qtr_count - 1);
                        $payment_qtr = $paidQTR + ($qtr_count - 1) + 1;
                        
                        if($loop_counter == 1){
                            $backtax_counter = $qtr_count - 1;
                        }

                    } else {
                        $payment_qtr = $paidQTR + 1;
                    }
                    $p_total += $vav;
                    ?>
                    <span class="normal_label<?php echo $loop_counter; ?>">
                        <?php echo number_format($vav, 2); ?>
                    </span>
                   <!-- Semi Annual input 1+1+1 -->
                        <input type="hidden" name="payment_qtr" value="<?php echo $payment_qtr; ?>" class="form-control taxs_payment_qtr"  required>
                        <input type="hidden" name="desc[]" value="<?php echo $r454a["sub_account_title"]; ?>" class="form-control" required>
                         <input type="hidden" name="nature[]" value="<?php echo $nature_id; ?>" class="form-control" required>
                        <input type="hidden" name="normal[]" value="<?php echo $vav; ?>" class="form-control total_amount_counter base_normal_amount " ca_normal_fields="<?php echo $loop_counter; ?>" required>
                        <!-- reference only base normal amount -->
                        <input type="hidden" value="<?php echo $vav; ?>" class=" <?php if($gross_counter>0){ echo "gross_normal_amount_class"; }else{ echo "normal_amount_class"; } ?> base_normal_amount<?php echo $loop_counter; ?>" >
                        <!-- reference only base normal amount -->
                        <input type="hidden" name="sub_account_no[]" value="<?php echo $r_payments["sub_account_no"]; ?>" class="form-control" required>
                        </td>
                       <!--Semi Annual input -->
                        <?php
                                    // end of if for cheking payment part1
                      } else {
                        // Annual payment

                    // check if surcharges and penalty  is set in penalty_table
                    $penalty_q = mysqli_query($conn,"SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");
                    
                    $penalty_r = mysqli_fetch_assoc($penalty_q);

                    if($penalty_r["surcharge_on"] == 1){
                        $surcharges_rate = $penalty_r["surcharge_rate"];
                    }else{
                        $surcharges_rate = 0;
                    }

                    if($penalty_r["interest_on"] == 1){
                        $penalty_rate = $penalty_r["surcharge_rate"];
                    }else{
                        $penalty_rate = 0;
                    }
                    // check if surcharges is set in onsurcharge_on in penalty_table

                    // cheking date of paymemnts
                    $p_date_q = mysqli_query($conn,"SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");
                    
                    $p_date_r = mysqli_fetch_assoc($p_date_q);
                        // cheking date of paymemnts
                        $year = date("Y");
                        $aa1 = $year . "-" . $p_date_r["payment_anndue1"];
                         // surcharges counter
                         // fecthing date of not paid quarter
                        if ($date_now > $aa1 ){
                            $sur_counter++;
                        }
                     // annual -----------------------------
                    ?>
                    <td class="abc" colspan="3"  style="width: 70%; font-weight: bold; font-size: 1.2em;">
                    <?php 
                     if($sub_account_no == 1010 || $sub_account_no == 1011  || $sub_account_no == 1012  || $sub_account_no == 1013  || $sub_account_no == 1014  || $sub_account_no == 1015 || $sub_account_no == 1016 || $sub_account_no == 1017 || $sub_account_no == 1018 || $sub_account_no == 1019 || $sub_account_no == 1020 || $sub_account_no == 1021){
                        // check sector kung ano ang gross sales auto inc
                        echo substr(strtoupper($r454a["sub_account_title"]),0,15);
                        // changing the value of sub_account/or auto in ID
                     
                        }else{
                            echo strtoupper($r454a["sub_account_title"]);
                        }
                     ?>
                    </td>
                    <td class="abc" style="width: 25%; text-align:right; font-weight: bold; font-size: 1.2em;">
                     <?php
                            $mnmn = str_replace(',', '', number_format($r_payments["assessment_tax_due"],2)); 
                            $p_total += $mnmn;
                            echo number_format($mnmn,2);
                    ?>
                                 <!-- Annual input -->
                        <input type="hidden" name="desc[]" value="<?php echo $r454a["sub_account_title"]; ?>" class="form-control" required>
                         <input type="hidden" name="nature[]" value="<?php echo $nature_id; ?>" class="form-control" required>
                        <input type="hidden" name="normal[]" value="<?php echo $mnmn; ?>" class="form-control total_amount_counter" required>
                        <input type="hidden" name="sub_account_no[]" value="<?php echo $r_payments["sub_account_no"]; ?>" class="form-control" required>
                                 <!-- Annual input -->

                    <?php
                    }
                    ?>
                    
                    </td>
                    </tr>
                    <?php
    }
                        $amount_sub_for_surc =  $p_total;  
                  // setting Backtaxes
                      ?>
                       <tr>
                        <td class="abc" colspan="3" style="width:  70%; font-weight: bold; font-size: 1.2em;">
                            <span class="backtax_label"> BACKTAXES</span> 
                         </td>
                        <td class="abc"  style="width: 25%; text-align:right; font-weight: bold; font-size: 1.2em;">
                       
                        <?php 
                         $backtax = str_replace(',','',number_format($backtax,2));
                         if($unpaid_amount1 != 0){
                            $backtax += $unpaid_amount1;
                             // update 12522
                         ?>
                         <!-- 1+1+1 -->
                        <input type="hidden"  name="backtax_permit_id" class="form-control " value="<?php echo $backtax_permit_id; ?>" >
                        <input type="hidden"  name="backtax_amount" class="form-control prev_year_backtax" value="<?php echo $unpaid_amount1; ?>" >
                            <?php
                        // update 12522
                        }
                        ?>
                        <span class="backtax_label_amount">
                            <?php echo $backtax; ?>
                        </span>

                         <?php
                         if($unpaid_amount1 == 0){
                            $backtax_var = $backtax_tax." + ".$backtax_fee;
                         }else{
                            $backtax_var = $backtax_tax." + ".$backtax_fee." + ".$unpaid_amount1;
                         }
                        //   eval( '$backtax_var = (' . $backtax_var. ');' );
                        ?>
                                                 <!-- Bakctax input 1+1+1 --><input type="hidden"  name="backtax" class="form-control backtax_class total_amount_counter" style="text-align:right !important;" value="<?php echo $backtax_var; ?>" >
                        <?php $p_total += $backtax; ?>
                         </td>
                            <tr>
                            <!-- <td>
                                <?php
                                    // echo $sur_counter;
                                ?>
                            </td> -->
                           
                             </tr>
                            <?php 
                            // na sa include payment scedule ang sur charges
                            $sur  = $total_surcharges_amount_ps+$backtax022_surcharges;
                            if($sur != 0 ){ 
                                $p_total += $sur;?>
                                <tr>
                                    <td class="abc" colspan="3" style="width:  70%; font-weight: bold; font-size: 1.2em;">
                                        SURCHARGES  
                                    </td>
                                    <td class="abc" style="width: 25%; text-align:right; font-weight: bold; font-size: 1.2em;">
                                   
    <!-- Surcharges input -->       <span class="surcharges_class">
                                        <?php echo number_format($sur,2); ?>
                                    </span>
                                        <!-- 1+1+1 -->
                                     <input type="hidden" name="surcharges" class="form-control  surcharges_class_orig" value="<?php echo $sur; ?>" >
                                     <input type="hidden" name="surcharges" class="form-control total_amount_counter surcharges_class_hi" value="<?php echo $sur; ?>" >
                                     <input type="hidden" name="surcharges_rate" class=" surcharges_rate_class" value="<?php echo $surcharges_rate; ?>" >
                                     
                                     
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                                <input type="hidden" class="current_quarter_surc" value="<?php echo $sur; ?>" >
                                <tfoot>
                                    <tr>
                                        <td class="abc" style="text-align: right; font-weight: bold; font-size: 1.2em;" colspan="3">TOTAL: &nbsp;&nbsp; <b style="font-size: 1.5em;">&#8369;</b> 
                                                
                                        </td>
                                        <td class="abc"  style="text-align: right; font-weight: bold;  font-size: 1.2em;">
                                            <div>
                                                <input type="text"  value="<?php  echo number_format($p_total,2); ?>" class="form-control total_amount_class" min="0" step="0.01" class="form-control" style="font-size: 1.2em; font-weight: bold; text-align:right;" readonly>
                                                <input type="hidden" id="current_quarter" value="<?php echo $current_quarter; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                       <!-- ========================================================== -->
                       <!-- ========================================================== -->

                    <!-- backtax count -->
                    <input type="hidden" class="backtax_count" value="<?php echo $backtax_counter; ?>">
                    <?php
                        // pag hindi retire anf pinprocess lalabas yung checkbox para sa payment
                        if($status_code != "RET"){
                    ?>
                    <div class="row " style="margin-top:2px; margin-bottom:2px; margin-right:1px;  margin-left:1px;   border: black solid 2px;">
                        <div class="col-md-12" >
                            <?php
                            
                              if($mode_of_payment == "Quarterly"){
                            ?>
                            <label for="">Payment Quarter</label>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="checkbox" <?php if($payment_qtr >=1){ echo "checked"; } ?> class="quarter quarter1 <?php if($current_quarter<1){ echo 'advance_quarter_payment'; } ?> " ca_quarter="1" <?php if($paidQTR >= 1){ echo "disabled"; } ?> >
                                        <label for="">1st Quarter</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" <?php if($payment_qtr >=2){ echo "checked"; } ?> class="quarter quarter2 <?php if($current_quarter<2){ echo 'advance_quarter_payment'; } ?> " ca_quarter="2"  <?php if($paidQTR >= 2){ echo "disabled"; } ?> >
                                        <label for="">2nd Quarter</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" <?php if($payment_qtr >=3){ echo "checked"; } ?> class="quarter quarter3 <?php if($current_quarter<3){ echo 'advance_quarter_payment'; } ?> " ca_quarter="3" <?php if($paidQTR >= 3){ echo "disabled"; } ?> >
                                        <label for="">3rd Quarter</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" <?php if($payment_qtr >=4){ echo "checked"; } ?> class="quarter quarter4 <?php if($current_quarter<4){ echo 'advance_quarter_payment'; } ?>" ca_quarter="4" <?php if($paidQTR >= 4){ echo "disabled"; } ?>>
                                        <label for="">4th Quarter</label>
                                    </div>
                                </div>
                            </div>
                            <?php }else if($mode_of_payment == "Semi-annual"){ ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="checkbox" <?php if($payment_qtr >=1){ echo "checked"; } ?> class="quarter quarter1 <?php if($current_quarter<1){ echo 'advance_quarter_payment'; } ?> " ca_quarter="1" <?php if($paidQTR >= 1){ echo "disabled"; } ?> >
                                        <label for="">1st Semi-Annual</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="checkbox" <?php if($payment_qtr >=2){ echo "checked"; } ?> class="quarter quarter2 <?php if($current_quarter<2){ echo 'advance_quarter_payment'; } ?> " ca_quarter="2"  <?php if($paidQTR >= 2){ echo "disabled"; } ?> >
                                        <label for="">2nd Semi-Annual</label>
                                    </div>
                                </div>
                            </div>
                                <?php
                            } ?>
                        </div>
                        <div class="col-md-12">
                        <!-- <input type="checkbox"  class="quarter" > <label for=""> Add Surcharges for Previous year  Backtax  </label> -->
                        </div>
                        
                    </div>
                    <script>
                        $(document).on("change",".quarter",function(){

                            ca_quarter = $(this).attr("ca_quarter");
                            current_quarter = $("#current_quarter").val();
                           
                            backtax_count = parseInt($(".backtax_count").val());
                            $(".taxs_payment_qtr").val(ca_quarter);
                            $(".quarter").each(function(){
                            
                                // set checkthe box
                                ca_quarter2 = $(this).attr("ca_quarter");
                                if(ca_quarter >= ca_quarter2){
                                    $(this).prop('checked', true);
                                }else{
                                    $(this).prop('checked', false);
                                }
                            });

                            // get all amount in normal_amount_class
                            // other misc
                            total_normal_amount = 0;
                            $(".normal_amount_class").each(function(){
                                total_normal_amount += parseFloat($(this).val());
                            });
                            // gross
                            gross_normal_amount_class = 0;
                            $(".gross_normal_amount_class").each(function(){
                                gross_normal_amount_class += parseFloat($(this).val());
                            });

                            // count all checkbox
                            active_check_count = 0;
                            $(".quarter").each(function(){
                                if($(this).is(":checked") && $(this).prop('disabled') == false ){
                                    active_check_count++;
                                }
                               
                            });
                            
                            // checking kung may prev year na backtax
                            prev_year_backtax = $(".prev_year_backtax").val();
                            prev_year_backtax = parseFloat(prev_year_backtax);

                            
                            // cheking pag may babayaran na backtax
                            if(backtax_count >= active_check_count){
                                //mas mataas ang backtax
                                if(active_check_count >1){
                                    backtax_remaining_count = backtax_count - 1;
                                    // pag seset ng backtax amount
                                    gross_normal_amount_class = gross_normal_amount_class * backtax_remaining_count;
                                    total_normal_amount = total_normal_amount * backtax_remaining_count;
                                    if(prev_year_backtax > 0){
                                        $(".backtax_class").val(gross_normal_amount_class+" + "+total_normal_amount+" + "+prev_year_backtax);
                                        backtax_label_amount = gross_normal_amount_class+total_normal_amount+prev_year_backtax;
                                        backtax_amount = backtax_label_amount;
                                        // change amount backtax label
                                        $(".backtax_label_amount").html(backtax_label_amount.toFixed(2));

                                    }else{
                                        $(".backtax_class").val(gross_normal_amount_class+" + "+total_normal_amount);
                                        backtax_label_amount = gross_normal_amount_class+total_normal_amount;
                                        backtax_amount = backtax_label_amount;
                                        // change amount backtax label
                                        $(".backtax_label_amount").html(backtax_label_amount.toFixed(2));
                                    }
                                    
                                }
                            }else{

                                // magbabayad sa backtax pati yung current quarter
                                gross_normal_amount_class = gross_normal_amount_class * backtax_count;
                                total_normal_amount = total_normal_amount * backtax_count;



                                 if(prev_year_backtax > 0){
                                    
                                        $(".backtax_class").val(gross_normal_amount_class+" + "+total_normal_amount+" + "+prev_year_backtax);
                                        backtax_label_amount = gross_normal_amount_class+total_normal_amount+prev_year_backtax;
                                        backtax_amount = backtax_label_amount;

                                        // change amount backtax label
                                        $(".backtax_label_amount").html(backtax_label_amount.toFixed(2));
                                    }else{
                                        
                                        $(".backtax_class").val(gross_normal_amount_class+" + "+total_normal_amount);
                                        backtax_label_amount = gross_normal_amount_class+total_normal_amount;
                                        backtax_amount = backtax_label_amount;

                                        // change amount backtax label
                                    $(".backtax_label_amount").html(backtax_label_amount.toFixed(2));
                                        
                                    }
                                    
                                    
                            }

                            // if na detect naisa lang ang babayaran
                                if(active_check_count == 1){
                                    // pag may prev backtax ng nakaraan taon
                                    if(prev_year_backtax > 0){
                                        $(".backtax_class").val("0 + 0 + "+prev_year_backtax);
                                        $(".backtax_label_amount").html(prev_year_backtax);
                                        backtax_amount = prev_year_backtax;
                                    }else{
                                            // remove ng backtax
                                        $(".backtax_label").css({"color":"red"});
                                        $(".backtax_label_amount").css({"color":"red"});
                                        $(".backtax_label").html("<del>BACKTAXES</del>");
                                        $(".backtax_class").prop("disabled",true);

                                        // set ang backtack to 0 pag isa lang quarter na babayaran
                                        backtax_amount = 0;
                                    }
                                
                                }else{
                                    // remove ng backtax
                                    $(".backtax_label").css({"color":"black"});
                                    $(".backtax_label_amount").css({"color":"black"});
                                    $(".backtax_label").html("BACKTAXES");
                                    $(".backtax_class").prop("disabled",false);
                                }
                            
                            
                             // check kung may advance payment
                             advance_payment_count = 0;
                             var paidQTR = "<?php echo $paidQTR; ?>"
                            $(".advance_quarter_payment").each(function(){
                                if($(this).is(":checked")){
                                    advance_payment_count++;
                                }
                            });

                            if(paidQTR >= 0 || paidQTR != "" ){
                                advance_payment_count = advance_payment_count - paidQTR;
                            }
                            // pag set ng advance payment
                            total_base_normal_amount = 0;
                            if(advance_payment_count > 0){
                                advance_payment_count = parseFloat(advance_payment_count) +1;
                                    $(".base_normal_amount").each(function(){
                                        ca_normal_fields = $(this).attr("ca_normal_fields");
                                        base_normal_amount = $(".base_normal_amount"+ca_normal_fields).val();
                                        new_val = parseFloat(base_normal_amount) * advance_payment_count;
                                        $(this).val(new_val.toFixed(2));
                                        $(".normal_label"+ca_normal_fields).html(new_val.toFixed(2));

                                        total_base_normal_amount += new_val;
                                    });
                            }else{
                                $(".base_normal_amount").each(function(){
                                    ca_normal_fields = $(this).attr("ca_normal_fields");
                                    base_normal_amount = $(".base_normal_amount"+ca_normal_fields).val();
                                    new_val = parseFloat(base_normal_amount);
                                    $(this).val(new_val.toFixed(2));
                                    $(".normal_label"+ca_normal_fields).html(new_val.toFixed(2));

                                    total_base_normal_amount += new_val;

                                });
                            }

                            total_amount = backtax_amount + total_base_normal_amount;
                            current_surc_amount = parseFloat($(".surcharges_class_orig").val());
                            if(current_surc_amount > 0){
                                surcharges_rate = $(".surcharges_rate_class").val();
                                surc_amount = total_amount * surcharges_rate;
                                surc_amount = surc_amount.toFixed(2);
                            }
                            // javascript get current quarter

                             // get surcharges
                            if(ca_quarter >= current_quarter){
                                current_quarter_surc = $(".current_quarter_surc").val();
                                $(".surcharges_class_orig").val(current_quarter_surc);
                                $(".surcharges_class_hi").val(current_quarter_surc);
                                $(".surcharges_class").html(current_quarter_surc);
                                all_amount = parseFloat(current_quarter_surc) + parseFloat(total_amount);
                                $(".total_amount_class").val(all_amount.toFixed(2));
                            }else{
                                $(".surcharges_class_orig").val(surc_amount);
                                $(".surcharges_class_hi").val(surc_amount);
                                $(".surcharges_class").html(surc_amount);
                                all_amount = parseFloat(surc_amount) + parseFloat(total_amount);
                                $(".total_amount_class").val(all_amount.toFixed(2));
                            }
                        });

                    </script>
                     <!-- ========================================================== -->
                    <!-- ========================================================== -->
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table style="width: 100%;" class="abc">
                                <tr>
                                    <td class="abc"
                                        style="text-align: right; font-weight: bold; font-size: 1.2em;"
                                        colspan="3">
                                        Remarks</td>
                                    <td class="abc"
                                        style="text-align: right; font-weight: bold; font-size: 1.2em;">
                                        <input type="test" name="remark"
                                            class="form-control">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row" style="margin-top:2px; margin-bottom:2px;">
                        <div class="col-md-12">
                            <table>
                                <tr>
                                    <td class="abc"
                                        style="text-align: right; font-weight: bold; font-size: 1.2em;"
                                        colspan="3">
                                        Amount&nbsp;in&nbsp;words</td>
                                    <td class="abc box"
                                        style="text-align: right; font-weight: bold; font-size: 1.2em;">
                                        <textarea type="text"  name="amount_word"  id="word"  class="form-control"   style="font-size: 1em; font-weight: bold;"
                                            readonly>
                                         </textarea>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div style="border:gray solid 2px; padding: 5px;">
                        <div class="row">
                            <div class="col-md-3" style="font-size: 1.2em;">
                                <input type="radio" value="cash" name="payment_mode"
                                    checked
                                    style="margin-top: 10px; height: 20px; width: 20px;">
                                Cash <br>
                                <input type="radio" value="check" name="payment_mode"
                                    style="margin-top: 10px; height: 20px; width: 20px;">
                                Check <br>
                                <input type="radio" value="money_order"
                                    name="payment_mode"
                                    style="margin-top: 10px; height: 20px; width: 20px;">
                                Money Order <br>
                            </div>
                            <div class="col-md-9">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th class="xyz">Drawee Bank</th>
                                            <th class="xyz">Number</th>
                                            <th class="xyz">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="abc"
                                                style="padding:none; margin:none;">
                                                <input type="text" name="drawee_check" class="form-control">
                                            </td>
                                            <td class="abc"
                                                style="padding:none; margin:none;">
                                                <input type="text" name="num_check" class="form-control">
                                            </td>
                                            <td class="abc"
                                                style="padding:none; margin:none;">
                                                <input type="date" name="date_check" class="form-control">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td class="abc" style="padding:none; margin:none;">
                                                <input type="text" name="num_order" class="form-control">
                                            </td>
                                            <td class="abc" style="padding:none; margin:none;">
                                                <input type="date" name="date_order"  class="form-control">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                                                </div>

                                            </div>
                                        </div>
                   <div class="modal-footer">
                        <div class="row">
                           <div class="col-md-5">
                    <button type="button" class="btn btn-warning btn-block" data-dismiss="modal"><b style="font-size: 1.2em;">Cancel</b></button>
                            </div>
                    <div class="col-md-2">
                        </div>
                            <div class="col-md-5">
                                <button type="submit" name="OR1_save" class="btn btn-success btn-block" id="or_saving" disabled><b style="font-size: 1.2em;" >Proceed to Payment</b></button>
                             </div>
                        </div>
                    </div>
                                        <!-- <div class="modal-footer">
                                        <button type="button" class="btn btn-danger pull-left"
                                            data-dismiss="modal">Cancel</button>

                                        <button type="button" class="btn btn-success save_business">Save</button>
                                    </div> -->
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            </div>
                            </div>
                            <!-- /.modal -->
                            <!-- Paymenys Modal -->
                </form>



               
                    <!-- view doc Modal -->
                    <div class="modal fade" id="view_doc" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog " style="width:60%;">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <!-- body start -->
                                            <div class="fetch_view_doc"> </div>
                                    <!-- body end -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger pull-left"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                  <!-- view doc Modal -->


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
    // auto fill on change owners
$(document).on("change","#or_num",function(){
    var or_num = $(this).val();
    var cashier = $("#cashier").val();

    $.ajax({
        type: 'POST',
        url: 'bpls/or_validation.php',
        dataType:'JSON',
        data: {
            cashier: cashier,
            or_num: or_num
        },
         success: function(result) {
            if(result == 1){
                $("#or_saving").prop("disabled",true);
                myalert_danger_af("This OR is not assign for you!","nothing");
            }else if(result == 2){
                $("#or_saving").prop("disabled",true);
                myalert_danger_af("This OR is already used!","nothing");
            }else{
                $("#or_saving").prop("disabled",false);
            }
        }
    });
});

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
  // auto fill on change owners
$(document).on("change","#find_owners",function(){
    var id = $(this).val();

    $.ajax({
        type: 'POST',
        url: 'bpls/ajax_fetching_auto_fillup.php',
         dataType:'JSON',
        data: {
            id: id,
            target: "owners"
        },
        success: function(result) {
            $("#f_name").val(result.owner_first_name);
            $("#m_name").val(result.owner_middle_name);
            $("#l_name").val(result.owner_last_name);
            $('#citizenship_id option[value='+result.citizenship_id+']').attr('selected','selected');
            $('#civil_status_id option[value='+result.civil_status_id+']').attr('selected','selected');
            $('#gender_id option[value='+result.gender_code+']').attr('selected','selected');
            $('#birthdate_id').val(result.owner_birth_date);
            $('#o_mob_no_id').val(result.owner_mobile);
            $('#o_email_id').val(result.owner_email);
            $('#legal_entity_id').val(result.owner_legal_entity);
           
        //    $("#region").selectpicker('val',result.region_code)

        }
    });

});
// on change of backtax
    $(document).ready(function(){
        
        
        $(".backtax_class").change(function(){
                var total_amount = 0;
                var backtax_amount = $(this).val();
                // set surcharges
                var surcharges_additional = backtax_amount *.25;
                
                if(backtax_amount != 0){
                    // get the orig backtax
                    var surcharges_old = $(".surcharges_class_orig").val();
                    $(".surcharges_class").html((parseFloat(surcharges_old)+parseFloat(surcharges_additional)).toFixed(2));
                    $(".surcharges_class_hi").val((parseFloat(surcharges_old)+parseFloat(surcharges_additional)).toFixed(2));
                }else{
                     var surcharges_old = $(".surcharges_class_orig").val();
                    $(".surcharges_class").html(parseFloat(surcharges_old));
                    $(".surcharges_class_hi").val(parseFloat(surcharges_old));

                }
                // set total amount
                $(".total_amount_counter").each(function(){
                    if($(this).val() != "" ){
                        total_amount += parseFloat($(this).val());
                    }
                });
                $(".total_amount_class").val((total_amount).toFixed(2));
        });
    });


var a = 0;
$(document).on('click', '#append_nature_btn', function() {
    a++;
    var text = '<tr class="mother_tr' + a +
        '"> <td> <select class="form-control selectpicker"  name="nature[]" id="nature_id" data-show-subtext="true" data-live-search="true"> <option value="">--Select Nature--</option> <?php $query = mysqli_query($conn, "SELECT DISTINCT nature_desc, geo_bpls_nature.nature_id FROM `geo_bpls_nature` inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.nature_id = geo_bpls_nature.nature_id inner join geo_bpls_revenue_code on geo_bpls_revenue_code.`revenue_code` = geo_bpls_tfo_nature.revenue_code where revenue_code_status = 1"); while ($row = mysqli_fetch_assoc($query)) {?> <option value="<?php echo $row["nature_id"]; ?>"> <?php echo $row["nature_desc"]; ?> </option> <?php } ?> </select></td> <td style="width:10%;"> <select class="form-control b_validator" name="b_scale_arr[]" id="b_scale"> <option value="">--Select Business Scale--</option> <?php $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_scale`"); while ($row = mysqli_fetch_assoc($query)) {?> <option value="<?php echo $row["scale_code"]; ?>" <?php if($r11["scale_code"] == $row["scale_code"]){ echo "selected"; } ?>> <?php echo $row["scale_desc"]; ?>(<?php echo $row["scale_code"]; ?>) </option> <?php } ?> </select> </td>  <td> <select name="nature_application_type[]" class="form-control"> <option value="NEW" <?php if($status_code == "NEW"){ echo "selected"; } ?> >New</option> <option value="REN" <?php if($status_code == "REN"){ echo "selected"; } ?> >Renew</option> </select>   </td> <td> <input type="number" name="cap_investment[]" class="form-control saving_validator"  style="margin:2px;" ></td> <td style="width:10%;"> <button type="button"  class="btn btn-danger delete_nature_btn" ca_attr="' +
        a + '" style="margin:5px;"> <i class="fa fa-minus"> </i> </button> </td> </tr>';

    $(".append_nature_here").after(text);
    $('.selectpicker').selectpicker('refresh');

});
// delete append nature
$(document).on('click', '.delete_nature_btn', function() {
    var id = $(this).attr("ca_attr");
    $(".mother_tr" + id).remove();
});
$(document).on('click', '.delete_nature_btn_ms', function() {
    var id = $(this).attr("ca_attr");
    $(".mother_tr_ms" + id).remove();
});
$(document).ready(function() {
    // set owners details

    var a = 0;
    //   check  assess  using btn existence
    $("#assess_btn").each(function() {
        a++;
    });
    if (a == 1) {

    } else {
        //    set unlock code
        $(".step_btn2").attr("step_status", "unlock_btn");
    }

    var lname = $("#l_name").val();
    var mname = $("#m_name").val();
    var fname = $("#f_name").val();
    $("#region").parent().find("button").addClass("region_title");
    $("#province").parent().find("button").addClass("province_title");
    $("#municipality").parent().find("button").addClass("municipality_title");
    $("#barangay").parent().find("button").addClass("barangay_title");
    var reg = $(".region_title").attr("title");
    var prov = $(".province_title").attr("title");
    var mun = $(".municipality_title").attr("title");
    var brgy = $(".barangay_title").attr("title");
    $(".owners_name_mess").html(lname + " " + mname + " " + fname);
    $(".owners_add_mess").html("BARANGAY " + brgy + " " + mun + " " + prov);

    // set business details
    $("#b_region").parent().find("button").addClass("b_region_title");
    $("#b_province").parent().find("button").addClass("b_province_title");
    $("#b_municipality").parent().find("button").addClass("b_municipality_title");
    $("#b_barangay").parent().find("button").addClass("b_barangay_title");

    var reg = $(".b_region_title").attr("title");
    var prov = $(".b_province_title").attr("title");
    var mun = $(".b_municipality_title").attr("title");
    var brgy = $(".b_barangay_title").attr("title");
    var b_name = $("#b_name").val();
    $(".business_name_mess").html(b_name);
    $(".business_add_mess").html("BARANGAY " + brgy + " " + mun + " " + prov);
})

$(document).on("click", "#form_save", function() {

    var error = 0;
    $(".prevent_saving").each(function() {
        error++;
    });

    var sp_error_count = 0;
    if ($("#nature_id").val() == "") {
        sp_error_count++;
        $("#nature_id").parent().find("button").addClass("border_red2");
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


    // requirements counter'
    var err_req = 0;
    // $(".select_all_req").each(function(){
    //     if($('input[name="requirements[]"]:checked').length > 0){ 
    //     }else{  
    //         err_req++;  
    //         $(this).css("border","1px solid red");
    //     }
    // });

    // if(err_req >0){
    //     alert("Please check all requirements needed!");
    // }
    var total = sp_error_count + saving_error_counter + error + err_req;

    if (total == 0) {
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
    } else {
        $("#region").parent().find("button").removeClass("border_red2");
    }
    if ($("#province").val() == "") {
        sp_error_count++;
        $("#province").parent().find("button").addClass("border_red2");
    } else {
        $("#province").parent().find("button").removeClass("border_red2");
    }
    if ($("#municipality").val() == "") {
        sp_error_count++;
        $("#municipality").parent().find("button").addClass("border_red2");
    } else {
        $("#municipality").parent().find("button").removeClass("border_red2");
    }
    if ($("#barangay").val() == "") {
        sp_error_count++;
        $("#barangay").parent().find("button").addClass("border_red2");
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
    } else {
        $("#b_region").parent().find("button").removeClass("border_red2");
    }
    if ($("#b_province").val() == "") {
        sp_error_count++;
        $("#b_province").parent().find("button").addClass("border_red2");
    } else {
        $("#b_province").parent().find("button").removeClass("border_red2");
    }
    if ($("#b_municipality").val() == "") {
        sp_error_count++;
        $("#b_municipality").parent().find("button").addClass("border_red2");
    } else {
        $("#b_municipality").parent().find("button").removeClass("border_red2");
    }
    if ($("#b_barangay").val() == "") {
        sp_error_count++;
        $("#b_barangay").parent().find("button").addClass("border_red2");
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


$(document).on("click",".select_all_req",function(){
    var status = $(this).is(":checked");
    ca_req_counter = $(this).attr("ca_req_counter");

    if(status == true){
        $(".tragetfileinput"+ca_req_counter).removeClass("saving_validator");
        $(".tragetfileinput"+ca_req_counter).removeClass("o_validator");
        $(".tragetfileinput"+ca_req_counter).removeClass("border_red2");
        $(".tragetfileinput"+ca_req_counter).prop("disabled",true);
        $(".requirements_id"+ca_req_counter).prop("disabled",true);

        $(".exception_business_id"+ca_req_counter).prop("disabled",true);
        $(".exception_requirement_id"+ca_req_counter).prop("disabled",true);
        $(".exception_filesname"+ca_req_counter).prop("disabled",true);

        
    }else{
        $(".tragetfileinput"+ca_req_counter).addClass("saving_validator");
        $(".tragetfileinput"+ca_req_counter).addClass("o_validator");
        $(".tragetfileinput"+ca_req_counter).addClass("border_red2");
        $(".tragetfileinput"+ca_req_counter).prop("disabled",false);
        $(".requirements_id"+ca_req_counter).prop("disabled",false);

        $(".exception_business_id"+ca_req_counter).prop("disabled",false);
        $(".exception_requirement_id"+ca_req_counter).prop("disabled",false);
        $(".exception_filesname"+ca_req_counter).prop("disabled",false);

    }
    
});

$(document).on("change",".tragetfileinput",function(){
    ca_req_counter = $(this).attr("ca_req_counter");

    if($(this).val() != ""){
        $(".requirements_id"+ca_req_counter).prop("disabled",false);

        $(".exception_business_id"+ca_req_counter).prop("disabled",true);
        $(".exception_requirement_id"+ca_req_counter).prop("disabled",true);
        $(".exception_filesname"+ca_req_counter).prop("disabled",true);


    }else{
        $(".requirements_id"+ca_req_counter).prop("disabled",true);

        $(".exception_business_id"+ca_req_counter).prop("disabled",false);
        $(".exception_requirement_id"+ca_req_counter).prop("disabled",false);
        $(".exception_filesname"+ca_req_counter).prop("disabled",false);
    }
});

$(document).on("click",".view_doc_btn",function(){
    requirement_id = $(this).attr("requirement_id");
    business_id = $(this).attr("business_id");
    permit_id = $(this).attr("permit_id");
		
		$.ajax({
			method:"POST",
			url:"bpls/multistep_online_verify_doc.php",
			data:{business_id:business_id, requirement_id:requirement_id,permit_id:permit_id},
			success:function(result){
				$(".fetch_view_doc").html(result);
			}
		});
	});


</script>


<?php
// remove class for assessment para clickable ang approval
   if($step_code1 == "APPRO" || $step_code1 == "PAYME" || $step_code1 == "RELEA"  ){
         ?>
            <script>
                $(document).ready(function(){
                    $("#assess_btn").removeClass("assess_btn");
                })
            </script>
         <?php
     }
// end of isset hidden validation
}else{
?>
<script>
window.location.replace("bplsmodule.php");
</script>
<?php
}

?>
<?php
if(isset($_GET["traget_n"])){
      $target_n = $_GET["traget_n"];
    }else{
      $target_n  = "na";
    }  

     if($step_code1 == "APPLI"  && $target_n != "tres"){
                        ?>
<script>
$(document).ready(function() {
    $(".step_btn0").addClass("js-active");
    $(".step_btn1").removeClass("js-active");
    $(".step_btn2").removeClass("js-active");
    $(".step_btn3").removeClass("js-active");
    $(".step_btn4").removeClass("js-active");
});
</script>
<?php
  }elseif($step_code1 == "ASSES"  && $target_n != "tres" ){
                         ?>
<script>
$(document).ready(function() {
    $(".step_btn0").addClass("js-active");
    $(".step_btn1").addClass("js-active");

    $(".step_btn0").attr("step_status", "unlock_btn");
    $(".step_btn1").attr("step_status", "unlock_btn");

    $(".step_btn2").removeClass("js-active");
    $(".step_btn3").removeClass("js-active");
    $(".step_btn4").removeClass("js-active");
});
</script>
<?php
                        }elseif($step_code1 == "APPRO"  && $target_n != "tres"){
                            ?>
<script>
$(document).ready(function() {
    $(".step_btn0").addClass("js-active");
    $(".step_btn1").addClass("js-active");
    $(".step_btn2").addClass("js-active");

    $(".step_btn0").attr("step_status", "unlock_btn");
    $(".step_btn1").attr("step_status", "unlock_btn");
    $(".step_btn2").attr("step_status", "unlock_btn");

    $(".step_btn3").removeClass("js-active");
    $(".step_btn4").removeClass("js-active");
});
</script>
<?php
    
                        }elseif($step_code1 == "PAYME"  &&  $target_n != "tres"){
                           ?>
<script>
$(document).ready(function() {
    $(".step_btn0").addClass("js-active");
    $(".step_btn1").addClass("js-active");
    $(".step_btn2").addClass("js-active");
    $(".step_btn3").addClass("js-active");

    $(".step_btn0").attr("step_status", "unlock_btn");
    $(".step_btn1").attr("step_status", "unlock_btn");
    $(".step_btn2").attr("step_status", "unlock_btn");
    $(".step_btn3").attr("step_status", "unlock_btn");

    $(".step_btn4").removeClass("js-active");
});
</script>
<?php
                        }elseif($step_code1 == "RELEA" && $target_n != "tres"){
                            ?>
<script>
$(document).ready(function() {
    $(".step_btn0").addClass("js-active");
    $(".step_btn1").addClass("js-active");
    $(".step_btn2").addClass("js-active");
    $(".step_btn3").addClass("js-active");
    $(".step_btn4").addClass("js-active");

    $(".step_btn0").attr("step_status", "unlock_btn");
    $(".step_btn1").attr("step_status", "unlock_btn");
    $(".step_btn2").attr("step_status", "unlock_btn");
    $(".step_btn3").attr("step_status", "unlock_btn");
    $(".step_btn4").attr("step_status", "unlock_btn");
});
// select all requirement

</script>
<?php
  
                        }
                        // 
                        if(isset($_GET["t"])){
                                // redirect sa payment view
                            if($_GET["t"]==4){
                                ?>
                            <script>
                            $(document).ready(function() {
                                $(".step_btn0").addClass("js-active");
                                $(".step_btn1").addClass("js-active");
                                $(".step_btn2").addClass("js-active");
                                $(".step_btn3").addClass("js-active");

                                $(".step_btn0").attr("step_status", "unlock_btn");
                                $(".step_btn1").attr("step_status", "unlock_btn");
                                $(".step_btn2").attr("step_status", "unlock_btn");
                                $(".step_btn3").attr("step_status", "unlock_btn");

                                $(".step_btn4").removeClass("js-active");

                                // add class sa form panel
                                //  $(".form_step_btn0").addClass("js-active");
                                // $(".form_step_btn1").addClass("js-active");
                                // $(".form_step_btn2").addClass("js-active");
                                $(".form_step_btn3").addClass("js-active");

                                $(".form_step_btn4").removeClass("js-active");
                                
                            });
                            // select all requirement


                            
                            </script>
                            <?php
                            }
                        }

?>