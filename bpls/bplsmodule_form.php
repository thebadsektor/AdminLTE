

<form method="POST" action="bplsmodule.php?redirect=saving_process" id="bpls_form"  enctype="multipart/form-data">
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
                                                <td> <span class="owners_name_mess prevent_saving mydanger">Click New
                                                        and fill up owners details. </span> </td>
                                            </tr>
                                            <tr>
                                                <td><b>Owner's Address:</b></td>
                                                <td><span class="owners_add_mess prevent_saving "> </span></td>
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
                                                <td> <span class="business_name_mess prevent_saving mydanger">Click New
                                                        and fill up business details. </span> </td>
                                            </tr>
                                            <tr>
                                                <td><b>Business Address:</b></td>
                                                <td> <span class="business_add_mess prevent_saving"></td>
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
                                        <select name="application_type" class="form-control saving_validator">
                                            <option value="NEW">New</option>
                                            <option value="REN">Renew</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Mode of Payments</label>
                                        <select name="mode_of_payment" class="form-control saving_validator">
                                            <option value="">--Select Mode of Payment--</option>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT payment_frequency_code, payment_frequency_desc FROM geo_bpls_payment_frequency");
                                                while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["payment_frequency_code"]; ?>">
                                                <?php echo $row["payment_frequency_desc"]; ?> </option>
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
                            <div id="collapse0" class="panel-collapse collapse in" aria-expanded="true">
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
                                    ?>
                                    <tr>
                                        <td> <input type="checkbox" name="requirements[]"  class="select_all_req  saving_validator" value="<?php echo $row["requirement_id"]; ?>" ca_req_counter="<?php echo $req_counter; ?>" > </td>

                                        <td>
                                            <b class="text-primary" ><?php echo $row["requirement_desc"]; ?></b><br><input type="file" name="requirements_files[]"  class="  saving_validator tragetfileinput tragetfileinput<?php echo $req_counter; ?>"  ca_req_counter="<?php echo $req_counter; ?>"  > 
                                            
                                            <input type="hidden" value="<?php echo $row["requirement_id"]; ?>" name="requirement_id[]" class="requirements_id<?php echo $req_counter; ?>" disabled>
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


            <!-- 001 -->
            <div class="panel-group" style="cursor:pointer;">
                <div class="panel panel-default">
                    <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
                        data-toggle="collapse" href="#collapse0aa" aria-expanded="true">
                        BUSINESS NATURE
                    </div>
                    <div class="row" style="margin:2px;">
                        <div class="col-md-12">
                            <table style="width:100%;">
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
                                <tr class="append_nature_here">
                                </tr>
                            </table>

                        </div>
                    </div>
                    <!-- <div class="panel-footer">Footer</div> -->
                </div>
            </div>
            <!-- 001 -->
            <div class="button-row">
                <button type="button" class="btn btn-success ml-auto js-btn-next pull-right"
                    name="save_application_form" id="form_save" btn_name="save">Save </button>
                <input type="hidden" name="hidden_validation" id="hidden_validation">
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
                        <div class=" box-body">
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
                                        <input type="text" name="tax_payer_lname" id="l_name"
                                            class="form-control o_validator">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">First Name</label>
                                        <input type="text" name="tax_payer_fname" id="f_name"
                                            class="form-control o_validator">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for=""> Middle Name</label>
                                        <input type="text" name="tax_payer_mname" id="m_name"
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
                                $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_citizenship`");
                                while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["citizenship_id"]; ?>">
                                                <?php echo $row["citizenship_desc"]; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Civil Status</label>
                                        <select class="form-control  o_validator" name="civil_status" id="civil_status_id">
                                            <option value="">--Select Civil Status--</option>
                                            <?php
                                $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_civil_status`");
                                while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["civil_status_id"]; ?>">
                                                <?php echo $row["civil_status_desc"]; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Gender</label>
                                        <select class="form-control o_validator" name="gender" id="gender_id">
                                            <option value="">--Select Gender--</option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Birthdate</label>
                                        <input type="date" name="birthdate" id="birthdate_id" class="form-control o_validator">
                                    </div>
                                </div>
                            </div>
                            <!-- 3rd row -->


                            <!-- 4rth row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Mobile No.</label>
                                        <input type="text" name="o_mob_no" id="o_mob_no_id" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email Address</label>
                                        <input type="email" name="o_email" id="o_email_id" class="form-control ">
                                    </div>
                                </div>
                            </div>
                            <!-- 5th row -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Legal Entity</label>
                                        <textarea name="legal_entity" id="legal_entity_id" class="form-control "></textarea>
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Person with Disability</label>
                                        <input type="checkbox" name="PWD_status" style="margin-right:30px;">

                                        <label for="">4PS</label>
                                        <input type="checkbox" name="4PS_status" style="margin-right:30px;">

                                         <label for="">Solo Parent</label>
                                        <input type="checkbox" name="SP_status" style=" margin-right:30px;">
                                    </div>
                                </div>
                                <div class="box">
                                                    <div class="box-body">
                                                        <!-- select all active discount in DB -->
                                                        <?php
                                                    $q4540 = mysqli_query($conn,"SELECT * FROM `geo_bpls_discount_name` where discount_status = 1");
                                                    while($r4540 = mysqli_fetch_assoc($q4540)){
                                                        // checked if nag exist na sa discount recored
                                                        $discount_name_id = $r4540["discount_name_id"];
                                                        ?>
                                                        <label for=""><?php echo $r4540["discount_name"]; ?></label>
                                                        <input type="checkbox" name="application_dicount[]" style="margin-right:30px;" value="<?php echo $discount_name_id; ?>"  >
                                                        <?php
                                                    }
                                                        ?>  
                                                        <!-- select all active discount in DB -->
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
                                        <select  name="region" id="region" class="selectpicker form-control"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="">--Select Region--</option>
                                            <?php
                                $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_region`");
                                while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["region_code"]; ?>"
                                                ca_attr="<?php echo $row["region_desc"]; ?>">
                                                <?php echo $row["region_desc"]; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Province</label>
                                    <select  name="province" data-show-subtext="true"
                                        id="province" data-live-search="true" class="selectpicker form-control ">
                                        <option value="">--Select Region first--</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Municipality</label>
                                    <select  name="municipality"  id="municipality" class="selectpicker form-control"  data-show-subtext="true" data-live-search="true">
                                        <option value="">--Select Province first--</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Barangay</label>
                                    <select  name="barangay"  id="barangay"  data-show-subtext="true" data-live-search="true" class="selectpicker form-control">
                                        <option value="">--Select Municipality first--</option>
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
                            
                            <div class="row" style="margin-bottom:10px;">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label>Find Business:</label>
                                        <select  class="selectpicker form-control" name="business_id" id="find_business" data-live-search="true" data-show-subtext="true"  >
                                        <option value=""></option>
                                        <?php
                                            $q = mysqli_query($conn,"SELECT business_id, business_name,  barangay_id  FROM geo_bpls_business");
                                            while($r = mysqli_fetch_assoc($q)){
                                                $barangay_id = $r["barangay_id"];
                                                        $q1212 = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as b_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");
                                                        $r1212 = mysqli_fetch_assoc($q1212);

                                                ?>
                                             <option value="<?php echo $r["business_id"]; ?>"> <?php echo $r["business_name"]." | ".$r1212["b_add"]; ?> </option>
                                                <?php
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="margin:2px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Business Name</label>
                                        <input type="text" id="b_name" name="business_name"
                                            class="form-control b_validator">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Trade Name/Franchise</label>
                                        <input type="text" name="trade_name" id="trade_name_id" class="form-control ">
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
                                                <?php 
                                $id_query = mysqli_query($conn,"SELECT business_id FROM `geo_bpls_business` ORDER BY `geo_bpls_business`.`business_id` DESC LIMIT 1");
                            
                                if(mysqli_num_rows($id_query) > 0) {
                                    $row = mysqli_fetch_assoc($id_query);
                                    $business_id = $row["business_id"];
                                } else {
                                    $business_id = "";
                                    // or you can set it to some default value, depending on your use case
                                    // $business_id = "default_value";
                                }
                                 
                                ?>
                                                <input type="hidden" class="form-control " name="business_id"
                                                    id="business_id" value="<?php echo $row["business_id"]+1; ?>">

                                                <input type="date" class="form-control b_validator"
                                                    name="application_date" id="application_date_id" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Tin No.:</label>
                                                <input type="text" class="form-control b_validator" name="tinNo" id="tinNo_id">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">DTI/SEC/CDA Registration No.:</label>
                                                <input type="text" class="form-control b_validator"
                                                    name="dti_sec_cdaRegistrationNo" id="dti_sec_cdaRegistrationNo_id">
                                            </div>
                                            <div class="form-group">
                                                <label for="">DTI/SEC/CDA Registration Date.:</label>
                                                <input type="date" class="form-control b_validator"
                                                    name="dti_sec_cdaRegistrationDate" id="dti_sec_cdaRegistrationDate_id" >
                                            </div>
                                        </div>

                                        <div class="row" style="margin:2px;">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Business Mobile No.</label>
                                                    <input type="text" name="b_mob_no" id="b_mob_no_id" class="form-control "
                                                        class="form-control ">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Business Email </label>
                                                    <input type="email" name="b_email" id="b_email_id" class="form-control ">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin:2px;">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Type of Business</label>
                                                    <select name="type_of_business" id='type_of_business_id' class="b_validator form-control ">
                                                        <option value="">--Select Type of Business--</option>
                                                        <?php
                                                $query = mysqli_query($conn, "SELECT business_type_code, business_type_desc FROM geo_bpls_business_type");
                                                while ($row = mysqli_fetch_assoc($query)) {?>
                                                        <option value="<?php echo $row["business_type_code"]; ?>">
                                                            <?php echo $row["business_type_desc"]; ?> </option>
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
                                                                <select name="amd_from" id="amd_from_id" class="form-control"   style="margin-left:10px; width:80%;" >
                                                                    <option value="">--Amendment From--</option>
                                                                    <?php
                                                $query = mysqli_query($conn, "SELECT business_type_code, business_type_desc FROM geo_bpls_business_type");
                                                while ($row = mysqli_fetch_assoc($query)) {?>
                                                                    <option
                                                                        value="<?php echo $row["business_type_code"]; ?>">
                                                                        <?php echo $row["business_type_desc"]; ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>To</td>
                                                            <td>
                                                                <select name="amd_to" id="amd_to_id" class="form-control"
                                                                    style="margin-left:10px; width:80%;"  >
                                                                    <option value="">----Amendment To----</option>
                                                                    <?php
                                                    $query = mysqli_query($conn, "SELECT business_type_code, business_type_desc FROM geo_bpls_business_type");
                                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                                                    <option
                                                                        value="<?php echo $row["business_type_code"]; ?>">
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
                                                <table style="width:100%;  background: rgb(247, 247, 247); padding:2px;"
                                                    class="r1_step0">
                                                    <tr>
                                                        <td>Are you enjoying tax incentive from any Goverment Entity?
                                                        </td>
                                                        <td style="width:80px;"><label>Yes</label> <input type="radio"   name="tax_incentive_status" id="tax_incentive_status_yes" class="ri1_step0 "  value="Yes">
                                                        </td>
                                                        <td><label>No</label> <input type="radio" name="tax_incentive_status"  id="tax_incentive_status_no" class=" ri1_step0" value="No" checked></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" style="padding:5px;"><span class="entity_here">
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
                                        <select name="b_org" id="b_org"  class="form-control b_validator" >
                                            <option value="">--Select Business Organization--</option>
                                            <?php
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_economic_org`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["economic_org_code"]; ?>">
                                                <?php echo $row["economic_org_desc"]; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Business Area</label>
                                        <select name="b_area" id="b_area"  class="form-control b_validator">
                                            <option value="">--Select Business Area--</option>
                                            <?php
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_economic_area`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["economic_area_code"]; ?>">
                                                <?php echo $row["economic_area_desc"]; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Business Scale</label>
                                        <select name="b_scale" id="b_scale" class="form-control b_validator"  >
                                            <option value="">--Select Business Scale--</option>
                                            <?php
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_scale`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["scale_code"]; ?>">
                                                <?php echo $row["scale_desc"]; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Business Sector</label>
                                        <select  name="b_sector" id="b_sector" class="form-control b_validator">
                                            <option value="">--Select Business Sector--</option>
                                            <?php
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_sector`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["sector_code"]; ?>">
                                                <?php echo $row["sector_desc"]; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Zone</label>
                                        <select name="b_zone" id="b_zone" class="form-control " >
                                            <option value="">--Select Zone--</option>
                                            <?php
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_zone`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["zone_id"]; ?>">
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
                                        <select name="b_occupancy" id="b_occupancy" class="form-control  b_validator">
                                            <option value="">--Select Occupancy--</option>
                                            <?php
                                    $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_occupancy`");
                                    while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["occupancy_code"]; ?>">
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
                                        <input type="text" name="b_area_sqm" id="b_area_sqm" class="form-control b_validator"  >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Total Employees in Establishment:</label>
                                        <input type="text"   name="emp_establishment_count" id="emp_establishment_count" class="form-control b_validator">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">No of Employee Residing with LGU:</label>
                                        <input type="text" name="no_emp_lgu" id="no_emp_lgu"  class="form-control b_validator">
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- b adddress -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <span style="font-size:16px; font-weight:bold;">BUSINESS ADDRESS</span>
                        </div>
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Region</label>
                                        <select  id="b_region" name="b_region" class="form-control selectpicker sp_validator"
                                             data-show-subtext="true" data-live-search="true" >
                                            <option value="">--Select Region--</option>
                                            <?php
                                $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_region`");
                                while ($row = mysqli_fetch_assoc($query)) {?>
                                            <option value="<?php echo $row["region_code"]; ?>">
                                                <?php echo $row["region_desc"]; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Province</label>
                                    <select  name="b_province" 
                                        id="b_province" class="form-control selectpicker" data-live-search="true" data-show-subtext="true">
                                        <option value="">--Select Region first--</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Municipality</label>
                                    <select  name="b_municipality"  id="b_municipality" class="form-control selectpicker"  data-show-subtext="true"  data-live-search="true" >
                                        <option value="">--Select Province first--</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Barangay</label>
                                    <select name="b_barangay"  id="b_barangay" class="form-control selectpicker" data-live-search="true" data-show-subtext="true" >
                                        <option value="">--Select Municipality first--</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Street</label>
                                        <input type="text" name="b_street" class="form-control ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- address -->

                    <!-- lessor -->
                    <div class="lessors_div">
                    </div>

                    <!-- lessor -->

                     <!-- emergency  -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <span style="font-size:16px; font-weight:bold;"> EMERGENCY CONTACT PERSON</span>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Contact Person:</label>
                                        <input type="text"  name="ec_person" id="ec_person_id" class="form-control " > 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Tel/Mobile No.:</label>
                                        <input type="text" name="ec_tel_no" id="ec_tel_no_id" class="form-control " >
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Email Address.:</label>
                                        <input type="email" name="ec_email" id="ec_email_id"  class="form-control ">
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

       // auto fill on change owners
$(document).on("change","#find_business",function(){
    var id = $(this).val();

    $.ajax({
        type: 'POST',
        url: 'bpls/ajax_fetching_auto_fillup.php',
         dataType:'JSON',
        data: {
            id: id,
            target: "business"
        },
        success: function(result) {
            $("#b_name").val(result.business_name);
            $("#trade_name_id").val(result.business_trade_name_franchise);
            $("#application_date_id").val(result.business_application_date);
            $("#dti_sec_cdaRegistrationNo_id").val(result.business_dti_sec_cda_reg_no);
            $("#dti_sec_cdaRegistrationDate_id").val(result.business_dti_sec_cda_reg_date);
            $("#b_mob_no_id").val(result.business_mob_no);
            $("#b_email_id").val(result.business_email);
            $("#tinNo_id").val(result.business_tin_reg_no);
            $('#type_of_business_id option[value='+result.business_type_code+']').attr('selected','selected');
            $('#amd_from_id option[value='+result.amd_from_+']').attr('selected','selected');
            $('#amd_to_id option[value='+result.amd_to_+']').attr('selected','selected');

            $('#b_org option[value='+result.economic_org_code+']').attr('selected','selected');
            $('#b_area option[value='+result.economic_area_code+']').attr('selected','selected');
            $('#b_scale option[value='+result.scale_code+']').attr('selected','selected');
            $('#b_sector option[value='+result.sector_code+']').attr('selected','selected');
            $('#b_zone option[value='+result.zone_id+']').attr('selected','selected');
            $('#b_occupancy option[value='+result.occupancy_code+']').attr('selected','selected');
            $('#b_area_sqm option[value='+result.business_area+']').attr('selected','selected');
            $('#emp_establishment_count option[value='+result.business_employee_total+']').attr('selected','selected');
            $('#no_emp_lgu option[value='+result.business_employee_resident+']').attr('selected','selected');

            alert(result.business_tax_incentive)

        }
    })

});
// append nature
var a = 0;
$(document).on('click', '#append_nature_btn', function() {
    a++
    var text = '<tr class="mother_tr' + a +
        '"> <td> <select class="form-control selectpicker"  name="nature[]" id="nature_id" data-show-subtext="true" data-live-search="true"> <option value="">--Select Nature--</option> <?php $query = mysqli_query($conn, "SELECT DISTINCT nature_desc, geo_bpls_nature.nature_id FROM `geo_bpls_nature` inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.nature_id = geo_bpls_nature.nature_id inner join geo_bpls_revenue_code on   geo_bpls_revenue_code.`revenue_code` = geo_bpls_tfo_nature.revenue_code where revenue_code_status = 1"); while ($row = mysqli_fetch_assoc($query)) {?> <option value="<?php echo $row["nature_id"]; ?>"> <?php echo $row["nature_desc"]; ?> </option> <?php } ?> </select></td>  <td style="width:10%;"> <select class="form-control saving_validator" name="b_scale_arr[]" id="b_scale"> <option value="">--Select Business Scale--</option> <?php $query = mysqli_query($conn, "SELECT * FROM `geo_bpls_scale`"); while ($row = mysqli_fetch_assoc($query)) {?> <option value="<?php echo $row["scale_code"]; ?>"> <?php echo $row["scale_desc"]; ?>(<?php echo $row["scale_code"]; ?>) </option> <?php } ?> </select> </td> <td style="width:10%;"> <select name="nature_application_type[]" class="form-control" > <option value="NEW">New</option> <option value="REN">Renew</option> <option value="RET">Retire</option> </select> </td>  <td> <input type="number" name="cap_investment[]" class="form-control saving_validator"  style="margin:2px;" ></td> <td style="width:10%;"> <button type="button"  class="btn btn-danger delete_nature_btn" ca_attr="' +
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



$(document).on("click",".select_all_req",function(){
    var status = $(this).is(":checked");
    ca_req_counter = $(this).attr("ca_req_counter");

    if(status == true){
        $(".tragetfileinput"+ca_req_counter).removeClass("saving_validator");
        $(".tragetfileinput"+ca_req_counter).removeClass("o_validator");
        $(".tragetfileinput"+ca_req_counter).removeClass("border_red2");
        $(".tragetfileinput"+ca_req_counter).prop("disabled",true);
        $(".requirements_id"+ca_req_counter).prop("disabled",true);
        
    }else{
        $(".tragetfileinput"+ca_req_counter).addClass("saving_validator");
        $(".tragetfileinput"+ca_req_counter).addClass("o_validator");
        $(".tragetfileinput"+ca_req_counter).addClass("border_red2");
        $(".tragetfileinput"+ca_req_counter).prop("disabled",false);
        $(".requirements_id"+ca_req_counter).prop("disabled",false);

    }
    
});

$(document).on("change",".tragetfileinput",function(){
    ca_req_counter = $(this).attr("ca_req_counter");

    if($(this).val() != ""){
        $(".requirements_id"+ca_req_counter).prop("disabled",false);
    }else{
        $(".requirements_id"+ca_req_counter).prop("disabled",true);
    }
});
</script>