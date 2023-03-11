<?php
  include('php/connect.php');
    // check sync settings
    $q = mysqli_query($conn, "SELECT `status` from geo_bpls_sync_status_ol where 1");
    $r = mysqli_fetch_assoc($q);
    $status = $r["status"];
    if($status == "ON"){
        include 'php/web_connection.php';
    }

    if(isset($_POST["submit_btn"])){
        $post_count = count($_POST["sequence_input"]);
        mysqli_query($conn,"DELETE FROM `geo_bpls_requirement_sequence` WHERE 1");
        for($a = 0; $a<$post_count; $a++){
            $sequence_input = $_POST["sequence_input"][$a];
            $requirement_desc = $_POST["requirement_desc"][$a];
            $requirement_id = $_POST["requirement_id"][$a];

            // insert
            $q3 = mysqli_query($conn,"INSERT INTO `geo_bpls_requirement_sequence`( `sequence_no`, `requirement_id`, `requirement_desc`) VALUES ('$sequence_input','$requirement_id','$requirement_desc') ");
        }
        ?>
        <script>
            myalert_success_af("Sequence of requirements updated!","bplsmodule.php?redirect=bpls_settings&settings_type=sequence");
        </script>
        <?php
        }
    if(isset($_GET["settings_type"])){
        // selecting_all requiremrnt
        $q6457 = mysqli_query($conn,"SELECT * FROM `geo_bpls_requirement` where requirement_default != 1");
        if(mysqli_num_rows($q6457) > 0){
            ?>
            <div class="box box-primary">
                <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" action="">
            <table class="table table-bordered">
                <tr>
                    <td>
                        <b>Requirement</b>
                    </td>
                    <td>
                        <b>Sequence</b>
                    </td>
                </tr>
            <?php
            $counter = 0;
            while($r6457 = mysqli_fetch_assoc($q6457)){
                $counter++;
                ?>
                <tr>
                    <td> <?php echo $r6457["requirement_desc"]; ?></td>
                    <td> 
                        <input type="hidden" name="requirement_desc[]" value="<?php echo $r6457["requirement_desc"]; ?>" required>  
                        <input type="hidden" name="requirement_id[]"  value="<?php echo $r6457["requirement_id"]; ?>" required>     
                        <input type="number" name="sequence_input[]" class="sequence_input" required> </td>
                </tr>
                <?php
            }
            ?>
                </table>
                <input type="submit" name="submit_btn" class="form-control btn btn-success" id="submit_btn" value="Submit">
                <input type="hidden" value="<?php echo $counter; ?>" id="total_seq">
                </form>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan=2 style="text-align:center; background:green; color:white;">Current Sequence</td>
                        </tr>
                    <?php
                        $counter = 0;
                        $q222 = mysqli_query($conn,"SELECT * FROM `geo_bpls_requirement_sequence` ORDER BY `geo_bpls_requirement_sequence`.`sequence_no` ASC
                        ");
                        while($r222 = mysqli_fetch_assoc($q222)){
                           
                            ?>
                            <tr>
                                <td> <?php echo $r222["sequence_no"]; ?> </td>
                                <td> <?php echo $r222["requirement_desc"]; ?> </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </table>

                </div>
            </div>   
            <!-- end row -->
                </div>
            </div>
            <!-- end box -->
            <script>
               function hasDuplicates(arr) {
                        return new Set(arr).size !== arr.length;
                    }
                $(document).on("change",".sequence_input",function(){
                    if($(this).val()==0){
                        $(this).val("");
                    }
                    total_seq = parseInt($("#total_seq").val());
                    
                    lampas_sa_sequence_counter = 0;
                    
                    myarr = [];
                    $(".sequence_input").each(function(){
                        value = parseInt($(this).val());
                        if(value >total_seq){
                            lampas_sa_sequence_counter++;
                            $(this).val("");
                        }
                        
                        if(value > 0){
                            // save sa array lahat
                            myarr.push(value);
                        }
                    });
                   if(hasDuplicates(myarr) == true){
                       alert("Duplicate Value detected!");
                        $("#submit_btn").prop("disabled",true);
                    }else{
                        $("#submit_btn").prop("disabled",false);
                   }
                    if(lampas_sa_sequence_counter){
                        alert("Sequence No. not greater than "+total_seq);
                    }
                });
            </script>
            <?php
        }else{
            ?>
            <div class="alert alert-danger">There is no requirement active!</div>
            <?php
        }
    ?>
        

        <?php
    }else{

?>
<div class="row">
    <div class="col-md-12">
        <!-- box start -->
        <div class="box box-primary">
            <div class="box-body">
                <!-- 001 -->
                <div class="panel-group" style="cursor:pointer;">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="color:white; background:#3c8dbc;" data-toggle="collapse"
                            href="#collapse1">
                            <h4 class="panel-title">
                                <a>SETTINGS</a> 
                            </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="row" style='margin:2px;'>
                                <div class="col-md-4">
                                      <h4>BPLS ONLINE AUTO SYNCHRONIZE STATUS</h4>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <i class="fa fa-info-circle" style="font-size:25px;"></i>
                                        </div>
                                        <div class="col-md-10">
                                        <div class="form-group">
                                         <select id="sync_status" class="form-control" <?php if($status == "ON"){ echo 'style="color:white; background:green ;"'; }else{ echo 'style="color:white; background:red ;"'; } ?> >
                                      
                                             <option <?php if($status == "ON"){ echo "selected"; } ?> >ON</option >
                                             <option <?php if($status == "OFF"){ echo "selected"; } ?> >OFF</option>
                                         </select>
                                         <script>
                                             $(document).on("change","#sync_status",function(){
                                                if($(this).val() == "ON"){
                                                    $(this).css({"background":"green","color":"white"});
                                                }else{
                                                      $(this).css({"background":"red","color":"white"});
                                                }
                                                var aa = $(this).val();
                                                  $.ajax({
                                                     method:"POST",
                                                     url:"bpls/edit_section/bpls_update_sync_ol.php",
                                                     data:{aa:aa},
                                                     success:function(result){
                                                        if(result == 1){
                                                            alert("Auto Sync updated");
                                                        }else{
                                                                alert("Failed to updated Auto Sync ");
                                                        }
                                                     }
                                                  });
                                             });
                                         </script>
                                            </div>
                                        </div>
                                    </div>

                                    <h4>BUSINESS PERMIT</h4>
                                    <ul class="list-group text-primary">
                                        <!-- <li class="list-group-item li_btn" data-value="Nature"><span data-toggle="modal" data-target="#myModal">Nature</span></li> -->
                                        <!-- <li class="list-group-item li_btn" data-value="Tax, Fee and other charges"><span data-toggle="modal" data-target="#myModal">Tax, Fee and other charges</span></li> -->
                                        <a href="bplsmodule.php?redirect=tax_fees"><li class="list-group-item ">Nature, Tax, Fee and other charges</li></a>

                                        <a href="bplsmodule.php?redirect=active_nature_collection"><li class="list-group-item ">Active Tax/Fees</li></a>

                                        <li class="list-group-item li_btn" data-value="Requirement"><span data-toggle="modal"
                                                data-target="#myModal">Requirement</span></li>
                                        <li class="list-group-item li_btn" ><a href="bplsmodule.php?redirect=bpls_settings&settings_type=sequence">Sequence of requirement to be approve</a></li>
                                        <li class="list-group-item li_btn" data-value="Penalty (Interest/Surcharges)"><span  data-toggle="modal" data-target="#myModal_surch">Penalty (Interest/Surcharges)</span>
                                        </li>

                                        <li class="list-group-item li_btn" data-value="Discount Details"><span  data-toggle="modal" data-target="#myModal">Discount Details</span> </li>

                                        <li class="list-group-item li_btn" data-value="Discount Formula"><span  data-toggle="modal" data-target="#myModal">Discount Formula</span> </li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                 <h4>BUSINESS</h4>
                                    <ul class="list-group text-primary">
                                        <li class="list-group-item li_btn" data-value="Business Type"><span data-toggle="modal"
                                                data-target="#myModal">Business Type</span></li>
                                        <li class="list-group-item li_btn" data-value="Business Scale"><span data-toggle="modal"
                                                data-target="#myModal">Business Scale</span></li>
                                        <li class="list-group-item li_btn" data-value="Business Sector"><span
                                                data-toggle="modal" data-target="#myModal">Business Sector</span></li>
                                        <li class="list-group-item li_btn" data-value="Business Area"><span data-toggle="modal"
                                                data-target="#myModal">Business Area</span></li>
                                        <li class="list-group-item li_btn" data-value="Business Organization"><span
                                                data-toggle="modal" data-target="#myModal">Business Organization</span></li>
                                        <li class="list-group-item li_btn" data-value="Occupancy"><span data-toggle="modal"
                                                data-target="#myModal">Occupancy</span></li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                 <h4>OWNER</h4>
                                 <ul class="list-group text-primary">
                                    <li class="list-group-item li_btn" data-value="Citizenship"><span data-toggle="modal" data-target="#myModal">Citizenship</span></li>
                                </ul>
                                </div>
                                <div class="col-md-4">
                                 <h4>LOCATION</h4>
                                 <ul class="list-group text-primary">
                                     <a href="bplsmodule.php?redirect=address_settings"><li class="list-group-item li_btn" >Address</li></a>
                                 </ul>
                                    
                                </div>
                                <div class="col-md-4">
                                 <h4>SIGNATORIES</h4>
                                 <ul class="list-group text-primary">
                                     <a href="bplsmodule.php?redirect=signatories"><li class="list-group-item li_btn" >Signatories</li></a>
                                 </ul>
                                    
                                </div>
                                <div class="col-md-4">
                                 <h4>Other Settings</h4>
                                 <ul class="list-group text-primary">
                                     <li class="list-group-item li_btn bfp_btn" ><span data-toggle="modal"
                                                data-target="#myModal_bfp">FIRE SAFETY INSPECTION FEE(BFP) </span></li>
                                 </ul>
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- 001 -->
            </div>
        </div>
        <!-- box end -->
    </div>
</div>
<form method="POST" action="">

<!-- bfp modal -->
<div id="myModal_bfp" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                FIRE SAFETY INSPECTION FEE(BFP)
                </h4>
            </div>
            <div class="modal-body">
                <!-- modal body start -->
                    <div class="bfp_modal_body"></div>
                <!-- modal body end -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                <button type="submit" name="update_bfp" class="btn btn-success pull-right" >Update</button>
            </div>
        </div>

    </div>
</div>
<!-- bfp modal -->
</form>

<script>
    
// ajax Edit BFP
$(document).on('click', '.bfp_btn', function() {
    // My alert!
    $.ajax({
            method: "POST",
            url: "bpls/edit_section/bfp_setting.php",
            success: function(result) {
                // alert(title+" successfully edited!!!");
                // location.reload();
                $(".bfp_modal_body").html(result);
            }
        });
   
    // My alert!
});
</script>
<style>
/* solution for 1st modal cant scroll after showing modal 2 */
#myModal {
    overflow-y: scroll;
}
</style>
<div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width:98%;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span class="modal_title"></span>
                </h4>
            </div>
            <div class="modal-body">
                <!-- modal body start -->
                <div class="row">
                    <!-- col start form -->
                    <div class="col-md-4">

                        <div class="box box-primary">
                            <div class="box-header">
                                <div class="box-title">
                                    <span class="form_title"> </span>
                                </div>
                                <div class="box-body" style="background:#e6e6e6;">
                                    <!-- 00a -->
                                    <span class="form_content"></span>
                                    <!-- 00a -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- col end form -->
                    <!-- col start datatables -->
                    <div class="col-md-8">
                        <div class="box box-primary">
                            <div class="box-header">
                                <div class="box-title">
                                </div>
                                <div class="box-body">
                                    <!-- 00a -->
                                    <div class="well">
                                        <div class="modal_tbl">
                                        </div>
                                    </div>
                                    <!-- 00a -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- col start datatables -->
                </div>
                <!-- modal body end -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- Edit Modal -->
<div id="myModal_edit" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <span class="modal2_header"> </span>
                </h4>
            </div>
            <div class="modal-body">
                <span class="modal2_content"></span>
            </div>
        </div>
    </div>

    <!-- end edit modal -->
</div>

<?php
    $q01 = mysqli_query($conn,"SELECT * FROM `geo_bpls_penalty`
    inner JOIN geo_bpls_payment_frequency on geo_bpls_payment_frequency.payment_frequency_code = geo_bpls_penalty.payment_frequency_code
    where geo_bpls_penalty.payment_frequency_code = 'ANN'");
    $r01 = mysqli_fetch_assoc($q01);

    $q02 = mysqli_query($conn,"SELECT * FROM `geo_bpls_penalty`
    inner JOIN geo_bpls_payment_frequency on geo_bpls_payment_frequency.payment_frequency_code = geo_bpls_penalty.payment_frequency_code
    where geo_bpls_penalty.payment_frequency_code = 'SEM'");
    $r02 = mysqli_fetch_assoc($q02);

    $q03 = mysqli_query($conn,"SELECT * FROM `geo_bpls_penalty`
    inner JOIN geo_bpls_payment_frequency on geo_bpls_payment_frequency.payment_frequency_code = geo_bpls_penalty.payment_frequency_code
    where geo_bpls_penalty.payment_frequency_code = 'QUA'");
    $r03 = mysqli_fetch_assoc($q03);

?>
 <form method="POST" action="">
<!-- Penalty and surcharges hiwalay na Modal -->
<div id="myModal_surch" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                         Penalty (Interest/Surcharges)
                </h4>
            </div>
            <div class="modal-body">
               
             <div class="box box-primary">
                <div class="box-header">
                    <h3>Annual</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Annual Due: </label>
                                    <input type="date" name="ann1" class="form-control" value="<?php $exp_a1 = explode("-",$r01["payment_anndue1"]); echo date("Y")."-".$exp_a1[0]."-".$exp_a1[1]; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Surcharge Rate: </label>
                                    <input type="text" name="ann_surc" class="form-control" value="<?php echo $r01["surcharge_rate"]; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Surcharge Status: </label>
                                    <select name="ann_surc_status" id="" class="form-control" required>
                                        <option value="1" <?php if($r01["surcharge_on"] == 1){ echo "selected"; } ?> >On</option>
                                        <option value="0" <?php if($r01["surcharge_on"] == 0){ echo "selected"; } ?> >OFF</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="box box-primary">
                <div class="box-header">
                    <h3>Semi-Annual</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Semi-Annual Due: </label>
                                    <input type="date" name="sem1" class="form-control"  value="<?php $exp_s1 = explode("-",$r02["payment_semdue1"]); echo date("Y")."-".$exp_s1[0]."-".$exp_s1[1]; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Semi-Annual Due:</label>
                                    <input type="date" name="sem2" class="form-control"  value="<?php $exp_s2 = explode("-",$r02["payment_semdue2"]); echo date("Y")."-".$exp_s2[0]."-".$exp_s2[1]; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Surcharge Rate: </label>
                                    <input type="text" name="sem_surc" class="form-control" value="<?php echo $r02["surcharge_rate"]; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Surcharge Status: </label>
                                    <select name="s_surc_status" id="" class="form-control" required>
                                        <option value="1" <?php if($r02["surcharge_on"] == 1){ echo "selected"; } ?> >On</option>
                                        <option value="0" <?php if($r02["surcharge_on"] == 0){ echo "selected"; } ?> >OFF</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="box box-primary">
                <div class="box-header">
                    <h3>Quarter</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">1st Quarter Due: </label>
                                    <input type="date" name="q1" class="form-control" value="<?php $exp_q1 = explode("-",$r03["payment_qtrdue1"]); echo date("Y")."-".$exp_q1[0]."-".$exp_q1[1]; ?>"  required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">2nd Quarter Due: </label>
                                    <input type="date" name="q2" class="form-control"  value="<?php $exp_q2 = explode("-",$r03["payment_qtrdue2"]); echo date("Y")."-".$exp_q2[0]."-".$exp_q2[1]; ?>"  required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">3rd Quarter Due: </label>
                                    <input type="date" name="q3" class="form-control"  value="<?php $exp_q3 = explode("-",$r03["payment_qtrdue3"]); echo date("Y")."-".$exp_q3[0]."-".$exp_q3[1]; ?>"  required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">4rth Quarter Due: </label>
                                    <input type="date" name="q4" class="form-control"  value="<?php $exp_q4 = explode("-",$r03["payment_qtrdue4"]); echo date("Y")."-".$exp_q4[0]."-".$exp_q4[1]; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="">Surcharge Rate: </label>
                                    <input type="text" name="q_surc" class="form-control" value="<?php echo $r03["surcharge_rate"]; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Surcharge Status: </label>
                                    <select name="q_surc_status" id="" class="form-control" required>
                                        <option value="1" <?php if($r03["surcharge_on"] == 1){ echo "selected"; } ?> >On</option>
                                        <option value="0" <?php if($r03["surcharge_on"] == 0){ echo "selected"; } ?> >OFF</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                   <button type="submit" name="update_penalty" class="btn btn-success pull-right">Save</button>
            </div>
        </div>
    </div>
</div>
    <!-- end surc modal -->

       </form>
    <?php
              // update surcharges and penalty
    if(isset($_POST["update_bfp"])){
        $percentage = $_POST["percentage"];
        $q = mysqli_query($conn,"UPDATE geo_bpls_bfp_settings set `percentage` = '$percentage' where id = '1' ");
        if($q){
            ?>
            <script>
                myalert_success_af("FIRE SAFETY INSPECTION FEE UPDATED!","bplsmodule.php?redirect=bpls_settings");
            </script>
        <?php
        }else{
            ?>
            <script>
                myalert_success_af("FAILED TO UPDATE FIRE SAFETY INSPECTION FEE!","bplsmodule.php?redirect=bpls_settings");
            </script>
        <?php
        }
    }   

    if(isset($_POST["update_penalty"])){
        $a_exp = explode("-",$_POST["ann1"]);

        $ann_surc_rate = $_POST["ann_surc"];
        $ann_surc_status = $_POST["ann_surc_status"];
        $new_date = $a_exp[1]."-".$a_exp[2];

        mysqli_query($conn,"UPDATE geo_bpls_payment_frequency SET payment_anndue1 = '$new_date' where payment_frequency_code = 'ANN' ") or die(mysqli_error($this));

        if($status == "ON"){
              mysqli_query($wconn,"UPDATE geo_bpls_payment_frequency SET payment_anndue1 = '$new_date' where payment_frequency_code = 'ANN' ") or die(mysqli_error($this));
        }
        mysqli_query($conn, "UPDATE `geo_bpls_penalty` SET `surcharge_on` = '$ann_surc_status', surcharge_rate = '$ann_surc_rate' where payment_frequency_code = 'ANN' ") or die(mysqli_error($this));

        $s1_exp = explode("-", $_POST["sem1"]);
        $s2_exp = explode("-", $_POST["sem2"]);
        $s_surc_rate = $_POST["sem_surc"];
        $s_surc_status = $_POST["s_surc_status"];
        $s1_new_date = $s1_exp[1]."-".$s1_exp[2];
        $s2_new_date = $s2_exp[1]."-".$s2_exp[2];

        mysqli_query($conn,"UPDATE geo_bpls_payment_frequency SET payment_semdue1 = '$s1_new_date' , payment_semdue2 = '$s2_new_date' where payment_frequency_code = 'SEM' ") or die(mysqli_error($this));
         if($status == "ON"){
              mysqli_query($wconn,"UPDATE geo_bpls_payment_frequency SET payment_semdue1 = '$s1_new_date' , payment_semdue2 = '$s2_new_date' where payment_frequency_code = 'SEM' ") or die(mysqli_error($this));
        }
        mysqli_query($conn, "UPDATE `geo_bpls_penalty` SET `surcharge_on` = '$s_surc_status', surcharge_rate = '$s_surc_rate' where payment_frequency_code = 'SEM' ") or die(mysqli_error($this));

        $q1_exp = explode("-", $_POST["q1"]);
        $q2_exp = explode("-", $_POST["q2"]);
        $q3_exp = explode("-", $_POST["q3"]);
        $q4_exp = explode("-", $_POST["q4"]);
        $q_surc_rate = $_POST["q_surc"];
        $q_surc_status = $_POST["q_surc_status"];
        $q1_new_date = $q1_exp[1]."-".$q1_exp[2];
        $q2_new_date = $q2_exp[1]."-".$q2_exp[2];
        $q3_new_date = $q3_exp[1]."-".$q3_exp[2];
        $q4_new_date = $q4_exp[1]."-".$q4_exp[2];

        mysqli_query($conn,"UPDATE geo_bpls_payment_frequency SET payment_qtrdue1 = '$q1_new_date' , payment_qtrdue2 = '$q2_new_date' , payment_qtrdue3 = '$q3_new_date' , payment_qtrdue4 = '$q4_new_date' where payment_frequency_code = 'QUA' ") or die(mysqli_error($this));
         if($status == "ON"){
            mysqli_query($wconn,"UPDATE geo_bpls_payment_frequency SET payment_qtrdue1 = '$q1_new_date' , payment_qtrdue2 = '$q2_new_date' , payment_qtrdue3 = '$q3_new_date' , payment_qtrdue4 = '$q4_new_date' where payment_frequency_code = 'QUA' ") or die(mysqli_error($this));
         }
        mysqli_query($conn, "UPDATE `geo_bpls_penalty` SET `surcharge_on` = '$q_surc_status', surcharge_rate = '$q_surc_rate' where payment_frequency_code = 'QUA' ") or die(mysqli_error($this));

        ?>
        <script>
            myalert_success_af("Penalty Successfully Updated!","bplsmodule.php?redirect=bpls_settings");
        </script>
    <?php

    }
    ?>
<script src="jomar_assets/myalert.js"></script>
<script>
// ajax delete target
$(document).on('click', '.delete_btn', function() {
    var settings_name = $(this).attr("data-settings-name");
    var value = $(this).attr("data-value");
    var title = $(this).attr("data-alert-title");
    myalert_danger("Are you sure you want to delete " + title + "?");
    $(".d35343_btn").click(function() {
        $.ajax({
            method: "POST",
            url: "bpls/delete_section/bpls_delete_settings.php",
            data: {
                value: value,
                settings_name: settings_name
            },
            success: function(result) {
                myalert_success_af(title + " successfully deleted!!!","bplsmodule.php?redirect=bpls_settings");
            }
        });
    });
    $(".d64534_btn").click(function() {
        // $('#myModal_alert_w').modal('hide');
        $('#myModal_alert_d').remove();
        $('.modal-backdrop').remove();
    });
});


// ajax Edit target
$(document).on('click', '.edit_btn', function() {
    var settings_name = $(this).attr("data-settings-name");
    var value = $(this).attr("data-value");
    var title = $(this).attr("data-alert-title");
    // My alert!
    myalert_warning("Are you sure you want to edit " + title + "?");
    $(".w35343_btn").click(function() {
        // ---------
        // set modal 2 header title
        $(".modal2_header").html("Edit " + settings_name);
        // show edit modal
        $('#myModal_edit').modal('show');
        $.ajax({
            method: "POST",
            url: "bpls/edit_section/bpls_edit_settings.php",
            data: {
                value: value,
                settings_name: settings_name
            },
            success: function(result) {
                // alert(title+" successfully edited!!!");
                // location.reload();
                $(".modal2_content").html(result);

            }
        });
        // -----------
    });
    $(".w64534_btn").click(function() {
        setTimeout(function() {
            // $('#myModal_alert_w').modal('hide');
            $('#myModal_alert_w').remove();
            $('.modal-backdrop').remove();

        }, 0);
    });
    // My alert!
});

$(document).on('click', '.li_btn', function() {
    if ($(this).attr("data-value") != "") {
        $(".modal_title").html($(this).attr("data-value"));
        var settings_name = $(this).attr("data-value");

        // Owner ----------------------

        // fetch datatables in bpls_settings
        if (settings_name == "Citizenship") {

            // fetch form title
            $(".form_title").html("Manage " + settings_name);

            // fetch form
            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Citizenship</label> <input type="text" name="i1" class="form-control" required>     </div>  <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="citizenship_btn" >    </div>   </form> '
                )


            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>Citezenship</th>  <th>Action</th> </tr> </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });


        }else if (settings_name == "Discount Details") {

            // fetch form title
            $(".form_title").html("Manage " + settings_name);

            // fetch form
            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Discount Title </label>  <input type="text" name="i1" class="form-control" required>  </div>  <div class="form-group"> <label for="">Discount Date</label> <input type="date" name="i2" class="form-control" required>     </div>   <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="discount_btn01" >    </div>   </form> '
                );
                $('.selectpicker').selectpicker('refresh');


            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>Discount Title</th> <th>Discount Date</th> <th>Discount Status</th>  <th>Action</th> </tr> </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });


        }else if (settings_name == "Discount Formula") {

        // fetch form title
        $(".form_title").html("Manage " + settings_name);

        // fetch form
        $(".form_content").html(
            '<form method="POST" action=""> <div class="form-group"> <label for="">Discount </label> <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true" name="i1"> <?php $q = mysqli_query($conn,"SELECT discount_name_id, discount_name from geo_bpls_discount_name"); while($r = mysqli_fetch_assoc($q)){?><option value="<?php echo $r["discount_name_id"]; ?>"> <?php echo str_replace("'","asd",$r["discount_name"]); ?> </option> <?php } ?> </select>  </div>  <div class="form-group"> <label for="">Discount Amount</label> <input type="text" name="i2" class="form-control" required>     </div> <div class="form-group"> <label for="">Discount Tax/Fee </label> <select class="form-control selectpicker" data-show-subtext="true" data-live-search="true" name="i3"> <?php $q = mysqli_query($conn,"SELECT  natureOfCollection_tbl.`name` as sub_account_title , chartOfAccountNo, chartOfAccountName ,  `active_tfo_if` , natureOfCollection_tbl.id as sub_account_no  FROM `geo_bpls_active_tfo` inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_active_tfo.naturecollection_id "); while($r = mysqli_fetch_assoc($q)){?><option value="<?php echo $r["sub_account_no"]; ?>"> <?php echo str_replace("'","asd",$r["sub_account_title"]); ?> </option> <?php } ?> </select>  </div>    <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="discount_btn" >    </div>   </form> '
            );
            $('.selectpicker').selectpicker('refresh');


        // update table in datatable bpls settings
        $(".modal_tbl").html(
            '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>Discount</th> <th>Discount Amount</th> <th>Tax/Fee</th>  <th>Action</th> </tr> </thead> </table>'
            );

        var dataTable = $('#bpls_settings_dt').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                type: "post",
                data: {
                    settings_name: settings_name
                }

            }
        });


        } else if (settings_name == "Business Type") {

            // Business -------------------------
            // fetch form title
            $(".form_title").html("Manage " + settings_name);

            // fetch form
            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Business Type</label> <input type="text" name="i1" class="form-control" required>     </div>              <div class="form-group"> <label for="">Tax Exemption</label> <input type="number" name="i2" class="form-control" required> </div>         <div class="form-group"> <label for="">Code</label> <input type="text" name="i3" class="form-control" required> </div>          <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="businesstype_btn" >    </div>   </form> '
                )


            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr>  <th>Business Type </th> <th> Tax Exemption </th> <th>CODE</th> <th>Action</th> </tr> </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        } else if (settings_name == "Zone") {

            // Business -------------------------
            // fetch form title
            $(".form_title").html("Manage " + settings_name);

            // fetch form
            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Barangay</label> <select class="form-control"  name="i1" required> <option>Sample</option> </select>     </div>    <div class="form-group"> <label for="">Garbage Zone</label> <input type="text" name="i2" class="form-control" required>    </div>        <div class="form-group"> <label for="">Zone Desc</label> <input type="text" name="i3" class="form-control" required>    </div>     <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="zone_btn" >    </div>   </form> '
                )


            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr>  <th>Barangay</th> <th> Garbage Zone </th> <th>Zone Desc</th> <th>Action</th> </tr> </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        } else if (settings_name == "Business Scale") {

            // fetch form title
            $(".form_title").html("Manage " + settings_name);

            // fetch form
            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Business Scale</label> <input type="text" name="i1" class="form-control" required>     </div>                  <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="businessscale_btn" >    </div>   </form> '
                )

            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>Scale Code</th>  <th>Scale Desc</th>  <th>Action</th>  </tr> </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        } else if (settings_name == "Business Sector") {
            // fetch form title
            $(".form_title").html("Manage " + settings_name);

            // fetch form
            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Business Sector</label> <input type="text" name="i1" class="form-control" required>     </div>                  <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="businesssector_btn" >    </div>   </form> '
                );

            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr>  <th>Sector Desc</th> <th>Action</th>  </tr> </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        } else if (settings_name == "Business Area") {
            // fetch form title
            $(".form_title").html("Manage " + settings_name);
            // fetch form
            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Business Area</label> <input type="text" name="i1" class="form-control" required>     </div>                   <div class="form-group"> <label for="">Business Area Code</label> <input type="text" name="i2" class="form-control" required>     </div>                  <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="businessarea_btn" >    </div>   </form> '
                );


            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>CODE</th> <th>Area</th> <th>Action</th>   </tr> </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        } else if (settings_name == "Business Organization") {
            // fetch form title
            $(".form_title").html("Manage " + settings_name);
            // fetch form

            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Business Organization</label> <input type="text" name="i1" class="form-control" required>     </div>                   <div class="form-group"> <label for="">Business Organization Code</label> <input type="text" name="i2" class="form-control" required>     </div>                  <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="businessorg_btn" >    </div>   </form> '
                );

            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>CODE</th> <th>Business Organization</th> <th>Action</th> </tr> </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        } else if (settings_name == "Occupancy") {
            // fetch form title
            $(".form_title").html("Manage " + settings_name);
            // fetch form
            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Occupancy</label> <input type="text" name="i1" class="form-control" required>     </div>                   <div class="form-group"> <label for="">Occupancy Code</label> <input type="text" name="i2" class="form-control" required>     </div>                  <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="occupancy_btn" >    </div>   </form> '
                );

            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>CODE</th> <th>Occupancy</th> <th>Action</th>   </tr> </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        } else if (settings_name == "Requirement") {
            // fetch form title
            $(".form_title").html("Manage " + settings_name);

            // fetch form
            $(".form_content").html('<form method="POST" action=""> <div class="form-group"> <label for="">Requirement</label> <input type="text" name="i1" class="form-control" required>     </div>   <div class="form-group"> <label for="">Reference Module</label> <select name="i3" class="form-control">   <option>BPLS Module</option>  <option>Engineering Module</option> <option>CTC Module</option>    <option>RPT Module</option>  <option>No Reference Module</option>  </select>  </div>   <div class="form-group"> <input type="submit" class="btn btn-success pull-right" name="requirement_btn" >    </div>   </form> ');

            // update table in datatable bpls settings
            $(".modal_tbl").html( '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>Requirents</th>  <th>Reference Module</th>  <th>Status</th> <th>Status</th> </tr> </thead> </table>');

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        }else if (settings_name == "Nature") {
            // fetch form title
            $(".form_title").html("Manage " + settings_name);

            // fetch form
            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Nature</label> <input type="text" name="i1" class="form-control" required>     </div>    <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="nature_btn" >    </div>   </form> '
                );

            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>Nature</th><th>Action</th>   </tr> </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        }else if (settings_name == "Tax, Fee and other charges") {
            // fetch form title
            $(".form_title").html("Manage " + settings_name);

            // fetch form
            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Nature</label> <input type="text" name="i1" class="form-control" required>     </div>    <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="nature_btn" >    </div>   </form> '
                );

            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>Nature</th><th>Action</th>   </tr> </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        } else if (settings_name == "Penalty (Interest/Surcharges)") {

            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>Payment Mode.</th> <th>Interest Status</th> <th>Interest Mode</th>  <th>Interest On</th>  <th>Interest Rate</th> <th>Penalty Remark</th> <th>Renewal Date</th> <th>Surcharge Mode</th> <th>Interest Status</th>  <th>Surcharges Status</th>   </tr>  </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        } else if (settings_name == "Signatory") {
            // fetch form title
            $(".form_title").html("Manage " + settings_name);

            // fetch form
            $(".form_content").html(
                '<form method="POST" action=""> <div class="form-group"> <label for="">Signatory Name</label> <input type="text" name="i1" class="form-control" required></div>      <div class="form-group"> <label for="">Signatory Office</label> <input type="text" name="i2" class="form-control" required></div>      <div class="form-group"> <label for="">Signatory Position</label> <input type="text" name="i3" class="form-control" required>  </div>     <div class="form-group"> <input type="submit" class="btn btn-success pull-right " name="signatory_btn" >    </div>   </form> '
                );

            // update table in datatable bpls settings
            $(".modal_tbl").html(
                '<table id="bpls_settings_dt" class="table table-bordered table-striped" style="width:100%;"> <thead style="background-color: #3c8dbc;color: white;"> <tr> <th>Signatory Name</th> <th>Signatory Office</th> <th>Signatory Position</th> <th>Action</th>  </tr>  </thead> </table>'
                );

            var dataTable = $('#bpls_settings_dt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_settings_dt.php",
                    type: "post",
                    data: {
                        settings_name: settings_name
                    }

                }
            });
        }
        // 
    }

});
</script>
<?php

        // Save -----------------------------------------
        include("jomar_assets/input_validator.php");
        // save citezenship
        if(isset($_POST["citizenship_btn"])){
                $i1 = validate_str($conn,$_POST["i1"]);
                $query = mysqli_query($conn,"INSERT into geo_bpls_citizenship (citizenship_desc) VALUES ('$i1') ");
                if($status == "ON"){
                    $wquery = mysqli_query($wconn,"INSERT into geo_bpls_citizenship (citizenship_desc) VALUES ('$i1') ");
                }
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1; ?> Successfully Inserted!","bplsmodule.php?redirect=bpls_settings");
    </script>
    <?php  }else{    ?>
    <script>
    myalert_danger_af("Failed to Insert! <?php echo $i1; ?> ","bplsmodule.php?redirect=bpls_settings");
    </script>
    <?php }
        }

         if(isset($_POST["discount_btn"])){
                $i1 = validate_str($conn,$_POST["i1"]);
                $i2 = validate_str($conn,$_POST["i2"]);
                $i3 = validate_str($conn,$_POST["i3"]);

                $query = mysqli_query($conn,"INSERT INTO `geo_bpls_discount`( `discount_name_id`, `discount_amount`, `sub_account_no`,nature_id) VALUES ('$i1','$i2','$i3',0) ");
                if($query){ ?>
                    <script>
                    myalert_success_af("New Settings Added!","bplsmodule.php?redirect=bpls_settings");
                    </script>
                <?php  }else{    ?>
                    <script>
                    myalert_danger_af("Failed to Insert settings","bplsmodule.php?redirect=bpls_settings");
                    </script>
                <?php }
                    }
        
                    if(isset($_POST["discount_btn01"])){
                        $i1 = validate_str($conn,$_POST["i1"]);
                        $i2 = validate_str($conn,$_POST["i2"]);
        
                        $query = mysqli_query($conn,"INSERT INTO `geo_bpls_discount_name`( `discount_name`, `discount_date`, `discount_status`) VALUES ('$i1','$i2',1) ");
                        if($query){ ?>
                            <script>
                            myalert_success_af("New Settings Added!","bplsmodule.php?redirect=bpls_settings");
                            </script>
                        <?php  }else{    ?>
                            <script>
                            myalert_danger_af("Failed to Insert settings","bplsmodule.php?redirect=bpls_settings");
                            </script>
                        <?php }
                            }




        if(isset($_POST["businesstype_btn"])){
                $i1 = validate_str($conn,$_POST["i1"]);
                $i2 = validate_str($conn,$_POST["i2"]);
                $i3 = validate_str($conn,$_POST["i3"]);
                $query = mysqli_query($conn,"INSERT into geo_bpls_business_type (business_type_desc,tax_exemption,business_type_code) VALUES ('$i1','$i2','$i3') ");

                // check online sync status is online
                if($status == "ON"){
                    $wquery = mysqli_query($wconn, "INSERT into geo_bpls_business_type (business_type_desc,tax_exemption,business_type_code) VALUES ('$i1','$i2','$i3') ");
                }
                
                if($query){   ?>
    <script>
    myalert_success_af("<?php echo $i1; ?> Successfully Inserted!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php }else{  ?>
    <script>
    myalert_danger_af("Failed to Insert! <?php echo $i1; ?> ","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php  }
        }

        if(isset($_POST["businessscale_btn"])){
                $i1 = validate_str($conn,$_POST["i1"]);
                $query = mysqli_query($conn,"INSERT into geo_bpls_scale (scale_desc) VALUES ('$i1') ");
                if($status == "ON"){
                    $wquery = mysqli_query($wconn,"INSERT into geo_bpls_scale (scale_desc) VALUES ('$i1') ");
                }
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1; ?> Successfully Inserted!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php  }else{  ?>
    <script>
    myalert_danger_af("Failed to Insert! <?php echo $i1; ?> ","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php   }
        }

        if(isset($_POST["businesssector_btn"])){
                $i1 = validate_str($conn,$_POST["i1"]);
                $query = mysqli_query($conn,"INSERT into geo_bpls_sector (sector_desc) VALUES ('$i1') ");
                if($status == "ON"){
                  $wquery = mysqli_query($wconn,"INSERT into geo_bpls_sector (sector_desc) VALUES ('$i1') ");
                }
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1; ?> Successfully Inserted!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php  }else{  ?>
    <script>
    myalert_danger_af("Failed to Insert! <?php echo $i1; ?> ","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php   }
        }

        if(isset($_POST["businessarea_btn"])){
                $i1 = validate_str($conn,$_POST["i1"]);
                $i2 = validate_str($conn,$_POST["i2"]);

                $query = mysqli_query($conn,"INSERT into geo_bpls_economic_area (economic_area_desc,economic_area_code) VALUES ('$i1','$i2') ");

                if($status == "ON"){
                    $wquery = mysqli_query($wconn,"INSERT into geo_bpls_economic_area (economic_area_desc,economic_area_code) VALUES ('$i1','$i2') ");
                }
                if($query){ ?>
        <script>
        myalert_success_af("<?php echo $i1; ?> Successfully Inserted!","bplsmodule.php?redirect=bpls_settings");

        </script>
        <?php  }else{  ?>
        <script>
        myalert_danger_af("Failed to Insert! <?php echo $i1; ?> ","bplsmodule.php?redirect=bpls_settings");

        </script>
    <?php   }
            }

        if(isset($_POST["businessorg_btn"])){
                $i1 = validate_str($conn,$_POST["i1"]);
                $i2 = validate_str($conn,$_POST["i2"]);
                
                $query = mysqli_query($conn,"INSERT into geo_bpls_economic_org (economic_org_desc,economic_org_code) VALUES ('$i1','$i2') ");

                if($status == "ON"){
                    $wquery = mysqli_query($wconn,"INSERT into geo_bpls_economic_org (economic_org_desc,economic_org_code) VALUES ('$i1','$i2') ");
                }

                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1; ?> Successfully Inserted!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php  }else{  ?>
    <script>
    myalert_danger_af("Failed to Insert! <?php echo $i1; ?> ","bplsmodule.php?redirect=bpls_settings");
 
    </script>
    <?php   }
            }
        if(isset($_POST["occupancy_btn"])){
                $i1 = validate_str($conn,$_POST["i1"]);
                $i2 = validate_str($conn,$_POST["i2"]);
                $query = mysqli_query($conn,"INSERT into geo_bpls_occupancy (occupancy_desc,occupancy_code) VALUES ('$i1','$i2') ");

                if($status == "ON"){
                    $query = mysqli_query($wconn, "INSERT into geo_bpls_occupancy (occupancy_desc,occupancy_code) VALUES ('$i1','$i2') ");
                }
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1; ?> Successfully Inserted!","bplsmodule.php?redirect=bpls_settings");
  
    </script>
    <?php  }else{  ?>
    <script>
    myalert_danger_af("Failed to Insert! <?php echo $i1; ?> ","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php   }
            }
        if(isset($_POST["requirement_btn"])){
                $i1 = validate_str($conn,$_POST["i1"]);
                $i3 = validate_str($conn, $_POST["i3"]);

                $query = mysqli_query($conn,"INSERT into geo_bpls_requirement (requirement_desc,requirement_default,reference_module) VALUES ('$i1','0','$i3') ");
                if($status == "ON"){
                    $query = mysqli_query($wconn, "INSERT into geo_bpls_requirement (requirement_desc,requirement_default) VALUES ('$i1','0') ");
                }
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1; ?> Successfully Inserted!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php  }else{  ?>
    <script>
    myalert_danger_af("Failed to Insert! <?php echo $i1; ?> ","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php   }
            }



        if(isset($_POST["signatory_btn"])){
                $i1 = validate_str($conn,$_POST["i1"]);
                $i2 = validate_str($conn,$_POST["i2"]);
                $i3 = validate_str($conn,$_POST["i3"]);
                $query = mysqli_query($conn,"INSERT into geo_bpls_signatory (signatory_name,signatory_office,signatory_position) VALUES ('$i1','$i2','$i3') ");
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1; ?> Successfully Inserted!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php  }else{  ?>
    <script>
    myalert_danger_af("Failed to Insert! <?php echo $i1; ?> ","bplsmodule.php?redirect=bpls_settings");
   
    </script>
    <?php   }
            }
        if(isset($_POST["zone_btn"])){
                $i1 = validate_str($conn,$_POST["i1"]);
                $i2 = validate_str($conn,$_POST["i2"]);
                $i3 = validate_str($conn,$_POST["i3"]);
                $query = mysqli_query($conn,"INSERT into geo_bpls_zone (barangay_id,garbage_zone,zone_desc) VALUES ('$i1','$i2','$i3') ");
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1; ?> Successfully Inserted!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php  }else{  ?>
    <script>
    myalert_danger_af("Failed to Insert! <?php echo $i1; ?> ","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php   }
            }

        // Update-----------------------------------
        if(isset($_POST["citizenship_btn_e"])){
               
                $i1_e = validate_str($conn,$_POST["i1_e"]);
                $hi1_e = validate_str($conn,$_POST["hi1_e"]);
                
                $query = mysqli_query($conn, "UPDATE  geo_bpls_citizenship SET citizenship_desc = '$i1_e' where  MD5(citizenship_id) = '$hi1_e' ");

                if($status == "ON"){
                    $wquery = mysqli_query($wconn,"UPDATE  geo_bpls_citizenship SET citizenship_desc = '$i1_e' where  MD5(citizenship_id) = '$hi1_e' ");
                }
                

                if($query){  ?>
    <script>
    myalert_success_af("<?php echo $i1_e; ?> Successfully updated!","bplsmodule.php?redirect=bpls_settings");
    
    </script>
    <?php  }else{  ?>
    <script>
    myalert_danger_af("Failed to execute changes!","bplsmodule.php?redirect=bpls_settings");
   
    </script>
    <?php  }
        }
        if(isset($_POST["businesstype_btn_e"])){
               
                $i1_e = validate_str($conn,$_POST["i1_e"]);
                $i2_e = validate_str($conn,$_POST["i2_e"]);
                $i3_e = validate_str($conn,$_POST["i3_e"]);
                $hi1_e = validate_str($conn,$_POST["hi1_e"]);
                $query = mysqli_query($conn,"UPDATE  geo_bpls_business_type SET business_type_desc = '$i1_e' , tax_exemption = '$i2_e',  business_type_code = '$i3_e'  where  MD5(business_type_code) = '$hi1_e' ");
                 if($status == "ON"){
                    $query = mysqli_query($wconn,"UPDATE  geo_bpls_business_type SET business_type_desc = '$i1_e' , tax_exemption = '$i2_e',  business_type_code = '$i3_e'  where  MD5(business_type_code) = '$hi1_e' ");
                }

                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1_e; ?> Successfully updated!","bplsmodule.php?redirect=bpls_settings");
 
    </script> <?php
                    }else{  ?>
    <script>
    myalert_danger_af("Failed to execute changes!","bplsmodule.php?redirect=bpls_settings");
 
    </script>
    <?php  }
        }
        if(isset($_POST["businessscale_btn_e"])){
                $i1_e = validate_str($conn,$_POST["i1_e"]);
                $hi1_e = validate_str($conn,$_POST["hi1_e"]);
                $query = mysqli_query($conn,"UPDATE  geo_bpls_scale SET scale_desc = '$i1_e'   where  MD5(scale_code) = '$hi1_e' ");
                if($status == "ON"){
                    $query = mysqli_query($wconn,"UPDATE  geo_bpls_scale SET scale_desc = '$i1_e'   where  MD5(scale_code) = '$hi1_e' ");  
                }
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1_e; ?> Successfully updated!","bplsmodule.php?redirect=bpls_settings");
    
    </script>
    <?php }else{  ?>
    <script>
    myalert_danger_af("Failed to execute changes!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php }
        }
        if(isset($_POST["businesssector_btn_e"])){
               
                $i1_e = validate_str($conn,$_POST["i1_e"]);
                $hi1_e = validate_str($conn,$_POST["hi1_e"]);
                $query = mysqli_query($conn,"UPDATE  geo_bpls_sector SET sector_desc = '$i1_e'   where  MD5(sector_code) = '$hi1_e' ");

                if($status == "ON"){
                    $wquery = mysqli_query($wconn,"UPDATE  geo_bpls_sector SET sector_desc = '$i1_e'   where  MD5(sector_code) = '$hi1_e' ");
                }
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1_e; ?> Successfully updated!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php }else{  ?>
    <script>
    myalert_danger_af("Failed to execute changes!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php }
        }

        if(isset($_POST["businessarea_btn_e"])){
                $i1_e = validate_str($conn,$_POST["i1_e"]);
                $i2_e = validate_str($conn,$_POST["i2_e"]);
                $hi1_e = validate_str($conn,$_POST["hi1_e"]);

                $query = mysqli_query($conn,"UPDATE  geo_bpls_economic_area SET economic_area_code = '$i2_e',economic_area_desc = '$i1_e'   where  MD5(economic_area_code) = '$hi1_e' ");
                if($status == "ON"){
                    $wquery = mysqli_query($wconn, "UPDATE  geo_bpls_economic_area SET economic_area_code = '$i2_e',economic_area_desc = '$i1_e'   where  MD5(economic_area_code) = '$hi1_e' ");

                }
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1_e; ?> Successfully updated!","bplsmodule.php?redirect=bpls_settings");
  
    </script>
    <?php }else{  ?>
    <script>
    myalert_danger_af("Failed to execute changes!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php }
        }
        if(isset($_POST["businessorg_btn_e"])){
                $i1_e = validate_str($conn,$_POST["i1_e"]);
                $i2_e = validate_str($conn,$_POST["i2_e"]);
                $hi1_e = validate_str($conn,$_POST["hi1_e"]);

                $query = mysqli_query($conn,"UPDATE  geo_bpls_economic_org SET economic_org_code = '$i2_e',economic_org_desc = '$i1_e'   where  MD5(economic_org_code) = '$hi1_e' ");

                if($status == "ON"){
                    $wquery = mysqli_query($wconn,"UPDATE  geo_bpls_economic_org SET economic_org_code = '$i2_e',economic_org_desc = '$i1_e'   where  MD5(economic_org_code) = '$hi1_e' ");
                }
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1_e; ?> Successfully updated!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php }else{  ?>
    <script>
    myalert_danger_af("Failed to execute changes!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php }
        }

        if(isset($_POST["occupancy_btn_e"])){
                $i1_e = validate_str($conn,$_POST["i1_e"]);
                $i2_e = validate_str($conn,$_POST["i2_e"]);
                $hi1_e = validate_str($conn,$_POST["hi1_e"]);
                
                $query = mysqli_query($conn,"UPDATE  geo_bpls_occupancy SET occupancy_code = '$i2_e',occupancy_desc = '$i1_e'   where  MD5(occupancy_code) = '$hi1_e' ");

                if($status == "ON"){
                    $wquery = mysqli_query($wconn, "UPDATE  geo_bpls_occupancy SET occupancy_code = '$i2_e',occupancy_desc = '$i1_e'   where  MD5(occupancy_code) = '$hi1_e' ");
                }

                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1_e; ?> Successfully updated!","bplsmodule.php?redirect=bpls_settings");
 
    </script>
    <?php }else{  ?>
    <script>
    myalert_danger_af("Failed to execute changes!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php }
        }

        if(isset($_POST["requirement_btn_e"])){
                $i1_e = validate_str($conn,$_POST["i1_e"]);
                $i2_e = validate_str($conn,$_POST["i2_e"]);
                $i3_e = validate_str($conn, $_POST["i3_e"]);

                $hi1_e = validate_str($conn,$_POST["hi1_e"]);
                $query = mysqli_query($conn,"UPDATE  geo_bpls_requirement SET requirement_default = '$i2_e' , requirement_desc = '$i1_e' , reference_module = '$i3_e'    where  md5(requirement_id) = '$hi1_e' ") or die(mysqli_error($conn));
                if($status == "ON"){
                    $wquery = mysqli_query($wconn,"UPDATE  geo_bpls_requirement SET requirement_default = '$i2_e' , requirement_desc = '$i1_e'     where  md5(requirement_id) = '$hi1_e' ") or die(mysqli_error($conn));
                }
                if($query){ ?>
    <script>
    myalert_success_af("<?php echo $i1_e; ?> Successfully updated!","bplsmodule.php?redirect=bpls_settings");
 
    </script>
    <?php }else{  ?>
    <script>
    myalert_danger_af("Failed to execute changes!","bplsmodule.php?redirect=bpls_settings");

    </script>
    <?php }
        }

        
        if(isset($_POST["signatory_btn_e"])){
                $i1_e = validate_str($conn,$_POST["i1_e"]);
                $i2_e = validate_str($conn,$_POST["i2_e"]);
                $i3_e = validate_str($conn,$_POST["i3_e"]);
                $hi1_e = validate_str($conn,$_POST["hi1_e"]);
                $query = mysqli_query($conn,"UPDATE  geo_bpls_signatory SET signatory_name = '$i1_e', signatory_office = '$i2_e',signatory_position = '$i3_e'   where  MD5(signatory_id) = '$hi1_e' ");
                if($query){ ?>
                <script>
                myalert_success_af("<?php echo $i1_e; ?> Successfully updated!","bplsmodule.php?redirect=bpls_settings");
             
                </script>
                <?php }else{  ?>
                <script>
                myalert_danger_af("Failed to execute changes!","bplsmodule.php?redirect=bpls_settings");
               
                </script>
                <?php }
        }

         if(isset($_POST["nature_btn_e"])){
                $i1_e = validate_str($conn,$_POST["i1_e"]);
                 $hi1_e = validate_str($conn,$_POST["hi1_e"]);

                $query = mysqli_query($conn,"UPDATE  geo_bpls_nature SET nature_desc = '$i1_e'  where  MD5(nature_id) = '$hi1_e' ");

                if($status == "ON"){
                    $wquery = mysqli_query($wconn, "UPDATE  geo_bpls_nature SET nature_desc = '$i1_e'  where  MD5(nature_id) = '$hi1_e' ");
                }
                if($query){ ?>
                <script>
                myalert_success_af("<?php echo $i1_e; ?> Successfully updated!","bplsmodule.php?redirect=bpls_settings");
               
                </script>
                <?php }else{  ?>
                <script>
                myalert_danger_af("Failed to execute changes!","bplsmodule.php?redirect=bpls_settings");
           
                </script>
                <?php }
        }

  
?>
<script>
    $(document).on("change",".discount_selection_set",function(){
        val = $(this).val();
        target = $(this).attr("id");
        $.ajax({
            method: "POST",
            url: "bpls/ajax_update_discount_status.php",
            data: {
                val: val,
                target: target
            },
            success: function(result) {
                if(result == "ok"){
                    alert("Discount Details updated");
                }else{
                    alert("Failed to updated Discount Details ");
                }
            }
});
});
</script>
<?php
    }
?>