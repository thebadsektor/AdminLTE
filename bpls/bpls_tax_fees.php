
<?php
        include("jomar_assets/input_validator.php");
          // check sync settings
        $q = mysqli_query($conn, "SELECT `status` from geo_bpls_sync_status_ol where 1");
        $r = mysqli_fetch_assoc($q);
        $status = $r["status"];
        if($status == "ON"){
        include 'php/web_connection.php';
        }
?>
<!-- copy -->
<div class="row" style="margin-bottom:5px;">
    <div class="col-md-3">
        <div class="btn btn-primary form-control" style="margin:5px;"  data-toggle="modal" data-target="#myModals1">
            CREATE NATURE
        </div>
    </div>    
    <div class="col-md-3"  >
        <div class="btn btn-primary form-control"  style="margin:5px;"  data-toggle="modal" data-target="#myModals2">
            CREATE FEES
        </div>
    </div>    
    <div class="col-md-3" >
        <div class="btn btn-primary form-control"  style="margin:5px;"  data-toggle="modal" data-target="#myModals3">
            COPY FEES
        </div>
    </div>
    <div class="col-md-3">
        <div class="btn btn-primary form-control"  style="margin:5px;"  data-toggle="modal" data-target="#myModal2345">
             REVENUE CODE
        </div>
    </div>  
</div>

<!-- nature -->
<div id="myModals1" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

  <form method="POST" action="">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Nature</h4>
      </div>
      <div class="modal-body">
     <div class="form-group"> <label for="">Nature</label> <input type="text" name="i1" class="form-control" required>     </div>    <div class="form-group"> </div>  
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-success pull-right " name="nature_btn" value="Save" >    
      </div>
    </div>
  </div>
</div>
</form> 
<!-- create fees -->
<div id="myModals2" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
             <div class="panel box box-primary">
                  <div class="box-header with-border bg-primary">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne12" aria-expanded="true" style="color:white;" >
                            Create Tax, Fee and other Charges
                      </a>
                    </h4>
                    <span class="pull-right"  data-toggle="modal" data-target="#modal_info" >
                        <i class="fa fa-info-circle" style="font-size:30px; color:red;"> </i>
                      </span>
                  </div>
                    <div id="collapseOne12" class="panel-collapse collapse in" aria-expanded="true" >
                    <div class="box-body">
        <form method="POST" action="">
                     <div class="row">
    
                        <div class="col-md-4">
                            <label for="">Revenue Code</label>
                        <input type="text" name="revenue" class="form-control" value="RC" readonly> </div>
                        <div class="col-md-4">
                        <label for=""> Year</label>
                        <input type="number" name="revenue_year" class="form-control" value="<?php echo date("Y"); ?>" required></div>
                        <div class="col-md-4">
                            <label for="">Series</label>
                        <input type="number" name="revenue_series" class="form-control" required ></div>
                    </div>
        <div class="row">
            <div class="col-md-12">
            <table style="width:100%;">
                <tr>
                    <td>
                        <div class="form-group">
                                <label for="">Business Nature</label>
                                    <select class=" selectpicker form-control" name="nature" data-show-subtext="true" data-live-search="true" required>
                                        <option value="">--Select Nature--</option>
                                            <?php
                                        $query = mysqli_query($conn, "SELECT nature_id, nature_desc FROM `geo_bpls_nature`");
                                            while ($row = mysqli_fetch_assoc($query)) {?>
                                                <!-- count sa tfo_nature -->
                                                <?php 
                                                $find_nature = mysqli_query($conn,"SELECT nature_id from geo_bpls_tfo_nature where nature_id='".$row["nature_id"]."'");
                                                $find_nature_count = mysqli_num_rows($find_nature);
                                                if($find_nature_count !=0){ }

                                                ?>
                                                <option value="<?php echo $row["nature_id"]; ?>">
                                                <?php echo $row["nature_desc"]; ?> 
                                            </option>
                                            
                                        <?php } ?>
                                </select>
                    </div>
                </td>
                    <td style="width:60px;">
                    </td>
                </tr>
                <tr>
                    <td>
                      <div class="row">
                          <div class="col-md-3">
                             <div class="form-group">
                                <label for="">Tax/Fees</label>
                                    <select name="charges[]" id="sub_acc_no" class=" selectpicker form-control"   data-show-subtext="true" data-live-search="true" required>
                                        
                                    <option value="">--Select Tax/fee--</option>
                                            <?php
                                        $query = mysqli_query($conn, "SELECT natureOfCollection_tbl.`name` as sub_account_title , natureOfCollection_tbl.`id` as sub_account_no FROM `geo_bpls_active_tfo` inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_active_tfo.naturecollection_id ");
                                        while ($row = mysqli_fetch_assoc($query)) { 
                                            $sub_account_no = $row["sub_account_no"];

                                            if($sub_account_no == 1010 || $sub_account_no == 1011  || $sub_account_no == 1012  || $sub_account_no == 1013  || $sub_account_no == 1014  || $sub_account_no == 1015 || $sub_account_no == 1016 || $sub_account_no == 1017 || $sub_account_no == 1018 || $sub_account_no == 1019 || $sub_account_no == 1020 || $sub_account_no == 1021){
                                                $bb++;
                                                if($bb == 1){
                                                    echo '<option value="'.$row["sub_account_no"].'" >';
                                                        echo substr(strtoupper($row["sub_account_title"]),0,15);
                                                    echo '</option>';
                                                }
                                            }else{
                                                echo '<option value="'.$row["sub_account_no"].'" >';
                                                         echo $row["sub_account_title"];
                                                  echo '</option>';
                                            }
                                    
                                            } 
                                             ?>
                                    </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                             <div class="form-group">
                                <label for="">Transaction</label>
                                    <select class="form-control transaction_0 transaction_class" name="transaction[]" ca_attr="0"  required>
                                        <option value="">--Select Transaction--</option>
                                        <option value="NEW">New</option>
                                        <option value="REN">Renew</option>
                                        <option value="RET">Retire</option>
                                        
                                    </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                             <div class="form-group">
                                <label for="">Basis</label>
                                    <select class="form-control basis_class basis_c0" ca_attr="0" name="basis[]"  required>
                                        <option value="">--Select Basis--</option>
                                        <option value="I">Inputed Value</option>
                                    </select>
                            </div>
                            <script>
                                $(document).on("change",".basis_class",function(){
                                    basis = $(this).val();
                                    ca_attr = $(this).attr("ca_attr");
                                    if(basis == "I"){
                                        $(".indicator_c"+ca_attr+" option[value='C']").remove();
                                        $(".indicator_c"+ca_attr+" option[value='R']").remove();
                                        $(".indicator_c"+ca_attr+" option[value='F']").remove();
                                        $(".indicator_c"+ca_attr+"").append('<option value="F">Formula</option>');
                                    }else{
                                        $(".indicator_c"+ca_attr+" option[value='C']").remove();
                                        $(".indicator_c"+ca_attr+" option[value='R']").remove();
                                        $(".indicator_c"+ca_attr+" option[value='F']").remove();
                                        $(".indicator_c"+ca_attr+"").append('<option value="R">Range</option>');
                                        $(".indicator_c"+ca_attr+"").append('<option value="C">Constant</option>');
                                        $(".indicator_c"+ca_attr+"").append('<option value="F">Formula</option>');

                                    }
                                });
                                $(document).on("change",".transaction_class",function(){
                                    transaction = $(this).val();
                                    ca_attr = $(this).attr("ca_attr");
                                    if(transaction == "NEW"){
                                        $(".basis_c"+ca_attr+" option[value='G']").remove();
                                        $(".basis_c"+ca_attr+" option[value='C']").remove();

                                        $(".basis_c"+ca_attr+"").append('<option value="C">Capital Investment</option>');
                                    }else{
                                        $(".basis_c"+ca_attr+" option[value='C']").remove();
                                        $(".basis_c"+ca_attr+" option[value='G']").remove();

                                        $(".basis_c"+ca_attr+"").append('<option value="G">Gross/Sales</option>');
                                    }
                                });
                                
                            </script>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                                    <label for="">Indicator</label>
                                        <select  name="indicator[]" class="form-control indicator_btn indicator_c0" required disabled>
                                            <option value="">--Select Indicator--</option>
                                        </select>
                                </div>
                          </div>
                      </div>  
                    </td>
                    <td>
                    <button type="button" id="append_btn" style="margin:2px; margin-top:13px; margin-left:5px;" class="btn btn-success">   <i class="fa fa-plus"> </i>  </button>
                    </td>
                </tr>
                <tr>
                   <td colspan="2">
                       <div class="indicator_content"> </div>
                   </td>
                </tr>
                <tr class="append_here"></tr>
            </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" name="save_settings" value="Save" class="btn btn-success pull-right">
            </div>
        </div>
</form>
                    </div>
                  </div>
                </div>
      </div>
    </div>
  </div>
</div>

<!-- copy fees -->
<div id="myModals3" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body">
       
<div class="panel box box-primary">
                  <div class="box-header with-border bg-primary">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="true" style="color:white;" >
                   Copy Tax, Fee and other Charges
                      </a>
                    </h4>
                  </div>
      <div id="collapseOne1" class="panel-collapse collapse in" aria-expanded="true" style="height: 0px;">
         <div class="box-body">
            <form method="POST" action="">

             <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                                <label for="">Business Nature (to):</label>
                                    <select class=" selectpicker form-control" name="t_nature" data-show-subtext="true" data-live-search="true" required>
                                        <option value="">--Select Nature--</option>
                                            <?php
                                        $query = mysqli_query($conn, "SELECT nature_id, nature_desc FROM `geo_bpls_nature`");
                                            while ($row = mysqli_fetch_assoc($query)) {?>
                                                <!-- count sa tfo_nature -->
                                                <?php 
                                                $find_nature = mysqli_query($conn,"SELECT nature_id from geo_bpls_tfo_nature where nature_id='".$row["nature_id"]."'");
                                                $find_nature_count = mysqli_num_rows($find_nature);
                                                if($find_nature_count !=0){ }

                                                ?>
                                                <option value="<?php echo $row["nature_id"]; ?>">
                                                <?php echo $row["nature_desc"]; ?>
                                            </option>
                                            
                                        <?php } ?>
                                </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                     <label for="">Revenue Code</label>
                        <input type="text" name="c_revenue" class="form-control" value="RC" readonly> </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                         <label for=""> Year</label>
                        <input type="number" name="c_revenue_year" class="form-control" value="<?php echo date("Y"); ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                   <div class="form-group">
                           <label for="">Series</label>
                            <input type="number" name="c_revenue_series" class="form-control" required >
                   </div>
                </div>
             </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                                <label for="">Business Nature (From):</label>
                                    <select class=" selectpicker form-control" name="f_nature" data-show-subtext="true" id="f_nature" data-live-search="true" required>
                                        <option value="">--Select Nature--</option>
                                            <?php
                                        $query = mysqli_query($conn, "SELECT nature_id, nature_desc FROM `geo_bpls_nature`");
                                            while ($row = mysqli_fetch_assoc($query)) {?>
                                                <!-- count sa tfo_nature -->
                                                <?php 
                                                $find_nature = mysqli_query($conn,"SELECT nature_id from geo_bpls_tfo_nature where nature_id='".$row["nature_id"]."'");
                                                $find_nature_count = mysqli_num_rows($find_nature);
                                                if($find_nature_count !=0){ }

                                                ?>
                                                <option value="<?php echo $row["nature_id"]; ?>">
                                                <?php echo $row["nature_desc"]; ?>
                                            </option>
                                            
                                        <?php } ?>
                                </select>
                    </div>
                </div>
                <div class="col-md-9">
                 <label for="">&nbsp;</label>
                    <select name="multiselect_name[]" id="multiselect_id"  class="selectpicker"   data-width="100%" multiple>
                      <option value="">--Select Tax/Fees--</option>
                    </select>
               
                </div>
            </div>
         </div>
         <div class="row">
             <div class="col-md-12">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                 <button type="submit" name="copy_tax" class="btn btn-success pull-right" style="margin:10px;">Save</button>
             </div>
         </div>
        </form>
      </div>
   </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div>
            <!-- Modal -->
            <div id="myModal2345" class="modal fade" role="dialog">
            <div class="modal-dialog modal-md">

                <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Revenue Code Settings</h4>
                </div>
                <div class="modal-body">
                         <table id="bpls_rc_dt" class="table table-bordered table-striped" style="width:100%;">
                        <thead style="background-color: #3c8dbc;color: white;">
                            <tr>
                                <th style='width:160px;' >Revenue Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </div>

            </div>
            </div>
            <!-- Modal -->
<div class="box">
    <div class="box-header">
        
    </div>
    <div class="box-body">
        <table id="bpls_tax_fee_dt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>Revenue Code</th>
                    <th>Business Nature</th>
                    <th>Tax/Fee</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

    </div>
</div>

<form method="POST" action=""><!-- The Modal -->
<div class="modal" id="mytaxModal">
  <div class="modal-dialog " style="width:64%;">
    <div class="modal-content">

      <!-- Modal body -->
      <div class="modal-body">
        <span class="m_body"></span>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success pull-right" name="update_fees" >Update</button>
      </div>
    </div>
  </div>
</div>
</form>

<div class="modal" id="mytaxModal2">
  <div class="modal-dialog " style="width:85%;">
    <div class="modal-content">

      <!-- Modal body -->
      <div class="modal-body">
        <span class="m_body2"></span>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success pull-right" name="update_fees" >Update</button>
      </div>
    </div>
  </div>
</div>

<!-- Info modal -->
<div class="modal" id="modal_info">
  <div class="modal-dialog modal-md" >
    <div class="modal-content">
      <!-- Modal body -->
      <div class="modal-body">
           <div class="box box-info">
               <div class="box-header">
                    <h4>Info</h4>
               </div>
               <div class="box-body">
                   <table class="table">
                        <tr>
                            <td> 
                            <ul>
                                <li> Arithmetic operator
                                    <ul>
                                        <li>+ for Addition </li>
                                        <li>- for Subtraction </li>
                                        <li>* for Multiplication </li>
                                        <li>/ for Division </li>
                                    </ul>
                                </li>
                                <li><p>if<b style='color:black;'> Basis</b> is <b style='color:black;'>Inputed Value</b> then <b style='color:black;'>indicator</b> must be <b style='color:green;'>Formula</b> and the value of Formula is <b style='color:black;'>X0</b></p></li>
                                
                                <li>
                                    <p><b>X0</b> can be Basis for Formula or Range</p>
                                    <ul>
                                        <li>Range Amount: (((X0-2000000).0055)+12100)/2</li>
                                        <li>Formula: X0*.0005</li>
                                    </ul>
                                </li>
                                <li>
                                    <p><b> X0*.0005</b>  is equivalent of Capital Investmetn or Gross Sales(Basis) multiply 0.0005 Percent or simply getting the 0.0005 percent of your capital  invesment or gross sales</p>
                                </li>
                                <li><b>S0</b> is equivalent in Scale Code</li>
                                <li>S0 is used in Formula like IF(S0=1,210,IF(S0=2,210,IF(S0=3,440,IF(S0=4,880,IF(S0=5,1100))))) </li>
                                <li>IF(S0=1,210,IF(S0=2,210,IF(S0=3,440,IF(S0=4,880,IF(S0=5,1100))))) the equivalent of this formula is If S0 or scale_code_id is equal to 1 then the fee is 210 pesos else scale_code_id equal to 2 then the fee is 210. you can check scale_code_id in Setting->Business Scale </li>
                            </ul>
                                
                            </td>
                        </tr>
                   </table>
               </div>
            </div>                              
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<style>
/* solution for 1st modal cant scroll after showing modal 2 */
    #mytaxModal23 {
        overflow-y: scroll;
    }
    .modal {
        overflow-y:auto;
    }
</style>
<div class="modal" id="mytaxModal23">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">

      <!-- Modal body -->
      <div class="modal-body">
            <span class="mytaxModal23_body">

            </span>
      </div>
    </div>
  </div>
</div>
   <script>
      function toggleSelectAll(control) {
                var allOptionIsSelected = (control.val() || []).indexOf("All") > -1;
                function valuesOf(elements) {
                    return $.map(elements, function(element) {
                        return element.value;
                    });
                }

                if (control.data('allOptionIsSelected') != allOptionIsSelected) {
                    // User clicked 'All' option
                    if (allOptionIsSelected) {
                        // Can't use .selectpicker('selectAll') because multiple "change" events will be triggered
                        control.selectpicker('val', valuesOf(control.find('option')));
                    } else {
                        control.selectpicker('val', []);
                    }
                } else {
                    // User clicked other option
                    if (allOptionIsSelected && control.val().length != control.find('option').length) {
                        // All options were selected, user deselected one option
                        // => unselect 'All' option
                        control.selectpicker('val', valuesOf(control.find('option:selected[value!=All]')));
                        allOptionIsSelected = false;
                    } else if (!allOptionIsSelected && control.val().length == control.find('option').length - 1) {
                        // Not all options were selected, user selected all options except 'All' option
                        // => select 'All' option too
                        control.selectpicker('val', valuesOf(control.find('option')));
                        allOptionIsSelected = true;
                    }
                }
                control.data('allOptionIsSelected', allOptionIsSelected);
            }

            $('#multiselect_id').selectpicker().change(function(){toggleSelectAll($(this));}).trigger('change');
  
// onchange indicator in TF02

    $(document).on('change','.indicator_btn_tfo2',function(){
        
        var value = $(this).val();
        if(value == "F"){
            $(".indicator_contenttfo2").html("<div class='form-group'><label> Formula </label> <input type='text' class='form-control' name='formula'  placeholder='X0 * 0005' required>  </div>");
        }else if(value == "R"){
              $(".indicator_contenttfo2").html("<table style='width:99%;'> <tr> <td><div class='form-group'><label> Range Low </label>   <input type='text' class='form-control' name='range_low[]' style='margin-left:2px; width:97%;' placeholder='0' required></div></td><td><div class='form-group'><label> Range High </label> <input type='text' class='form-control' name='range_high[]' style='margin-left:2px; width:97%;' placeholder='999'  required></div></td><td><div class='form-group'><label> Range Amount </label> <input type='text' class='form-control' name='range_amount[]' style='margin-left:2px; width:97%;' required></div> </div></td> <td>  <button type='button' id='append_indicator_btn'style='margin:2px; margin-top:13px; margin-left:5px;' class='btn btn-success'>   <i class='fa fa-plus'> </i>  </button> </td> </tr> <tr class='tr_fetch_append_here'>  </tr> </table>");
        }else if(value == "C"){
             $(".indicator_contenttfo2").html("<div class='form-group'><label> Formula </label> <input type='text' class='form-control' name='formula'  placeholder='X0 * 0005' required>  </div>");
        }else{
            $(".indicator_content").html(" ");
        }
    });

        // validate delete
$(document).on("click",".delete_btn",function(){
        var target = $(this).attr("ca_target");
        var title = $(this).attr("ca_title");

      myalert_danger("Are you sure do you want to delete "+title+"?");
      $('.modal-open').css({"overflow":"visible","padding-right":"0px"});
      $(".d35343_btn").click(function() {
        location.replace(target);
    });
    $(".d64534_btn").click(function() {
        // $('#myModal_alert_w').modal('hide');
        $('#myModal_alert_s').remove();
        $('.modal-backdrop').remove();
        // add for datatbales disabled scrol
        $('.modal-open').css({"overflow":"visible","padding-right":"0px"});
    });
});

$(document).on("click",".delete_tfo_btn",function(){
        var title = $(this).attr("ca_title");
       var tfo_nature_id = $(this).attr("ca_id");

      myalert_danger("Are you sure do you want to delete "+title+"?");
      $('.modal-open').css({"overflow":"visible","padding-right":"0px"});
            $(".d35343_btn").click(function() {
            $.ajax({
            url: "bpls/delete_section/bpls_delete_tax_fee2.php",
            type: "post",
            data:{"tfo_nature_id":tfo_nature_id},
            success:function(result){
                if(result == 1){
                    alert("Fee Successfully Deleted");
                    $(".tr_rm"+tfo_nature_id).remove();
                    // location.reload();
                }
            }
        });
    });
    $(".d64534_btn").click(function() {
        // $('#myModal_alert_w').modal('hide');
        $('#myModal_alert_s').remove();
        $('.modal-backdrop').remove();
        // add for datatbales disabled scrol
        $('.modal-open').css({"overflow":"visible","padding-right":"0px"});
    });
});


    // update fee 
    $(document).on("click",".edit_tfo_btn",function(){
        var tfo_nature_id = $(this).attr("ca_id");
        $('#mytaxModal23').modal('show');
        $.ajax({
                type:'POST',
                url:'bpls/edit_section/bpls_edit_tax_fee.php',
                dataType:"HTML",
                data:{tfo_nature_id:tfo_nature_id},
                success:function(result){
                    $(".mytaxModal23_body").html(result);
                    $(".selectpicker").selectpicker("refresh");
                }
            });

    });
    // update rc status

    $(document).on("change",".rc_btn",function(){
        var val = $(this).val();
        var ca_rc = $(this).attr("ca_rc");

        if(val == 0){
            $(this).css("background","#ad2a21");
        }else{
            $(this).css("background","#13801a");
        }
        $.ajax({
            url: "bpls/bpls_tax_ajax_update_rc.php",
            type: "post",
            data:{"val":val,"ca_rc":ca_rc},
            success:function(result){
            }
        });
    });
// <!-- bpls revenue dt -->

$(document).ready(function(){
    var dataTable = $('#bpls_rc_dt').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            url: "bpls/dataTables/fetch_bpls_rc_dt.php",
            type: "post",
            data:{"page":"entries"}
        }
    });
});
</script>

 <!-- req -->
   <script>
    
        $(document).on("change","#f_nature",function(){
            var id = $(this).val();
           $.ajax({
                type:'POST',
                url:'bpls/bpls_tax_ajax_fetch_copy_nature.php',
                dataType:"HTML",
                data:{id:id},
                success:function(result){
                // $(".dropdown-menu").html(result);
                    $("#multiselect_id").html(result);
                    // $(".multi-select-menu").html(result[0]["arr2"]);
                   $('.selectpicker').selectpicker('refresh');

                }
            });
        });

     $(document).on('click','.tax_formula',function(){
    var id = $(this).attr("data-id");

        // get data in tfo_nature
        $.ajax({
            type:'POST',
            url:'bpls/bpls_tax_ajax_fetch_formula.php',
            dataType:"HTML",
            data:{id:id},
            success:function(result){
                $(".m_body").html(result);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    
 });
 $(document).on('click','.tax_formula2',function(){
    var id = $(this).attr("data-id");

        // get data in tfo_nature
        $.ajax({
            type:'POST',
            url:'bpls/bpls_tax_ajax_fetch_formula2.php',
            dataType:"HTML",
            data:{id:id},
            success:function(result){
                $(".m_body2").html(result);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    
 });
 
$(document).ready(function(){
    var dataTable = $('#bpls_tax_fee_dt').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            url: "bpls/dataTables/fetch_bpls_tax_fee_dt.php",
            type: "post",
            data:{"page":"renewal"}
        }
    });
});

// remove disabled in indicator
$(document).on("change","#sub_acc_no",function(){
    if($(this).val() != ""){
        $(".indicator_btn").prop("disabled",false);

       
        if($(".indicator_btn").val() == "F"){
            $(".formula_charges").val($(this).val());
        }
        if($(".indicator_btn").val() == "C"){
            $(".constant_charges").val($(this).val());
        }
        if($(".indicator_btn").val() == "R"){
            $(".range_charges").val($(this).val());
            $("#append_indicator_btn").attr("sub_acc_no",$(this).val());
        }
    }else{
         $(".indicator_btn").prop("disabled",true);
         $('.indicator_btn').prop('selectedIndex',0);
         $(".indicator_content").html(" ");


    }
});

$(document).on("change",".sub_acc_no_class",function(){

    var ca_attr = $(this).attr('ca_attr');
    if($(this).val() != ""){
        $(".indicator_class"+ca_attr).prop("disabled",false);
        if($(".indicator_class"+ca_attr).val() == "F"){
            $(".formula_charges"+ca_attr).val($(this).val());
        }
        if($(".indicator_class"+ca_attr).val() == "C"){
            $(".constant_charges"+ca_attr).val($(this).val());
        }
        if($(".indicator_class"+ca_attr).val() == "R"){
            $(".range_charges"+ca_attr).val($(this).val());
             $(".append_in_append_indicator_btn").attr("sub_acc_no",$(this).val());
        }

    }else{
         $(".indicator_class"+ca_attr).prop("disabled",true);
         $('.indicator_class'+ca_attr).prop('selectedIndex',0);
          $(".indicator_content"+ca_attr).html(" ");
    }
});
// aappend the main
  ap1 = 0;

    $(document).on('click',"#append_btn",function(){
        ap1++;
        var text = '<tr class="tr1_'+ap1+'"><td><div class="row"> <div class="col-md-3"> <div class="form-group">  <select class=" selectpicker form-control sub_acc_no_class" id="sub_acc_no_class'+ap1+'" ca_attr="'+ap1+'" name="charges[]" data-show-subtext="true" data-live-search="true"> <option value="" required>--Select Tax/fee--</option><?php $query = mysqli_query($conn, "SELECT natureOfCollection_tbl.`name` as sub_account_title , natureOfCollection_tbl.`id` as sub_account_no FROM `geo_bpls_active_tfo` inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_active_tfo.naturecollection_id");  while ($row = mysqli_fetch_assoc($query)) {?> <option value="<?php echo $row["sub_account_no"]; ?>"> <?php echo str_replace("'","\'",$row["sub_account_title"]); ?> </option> <?php } ?></select> </div> </div> <div class="col-md-3"> <div class="form-group"> <select class="form-control transaction_class transaction_app transaction_app'+ap1+'" ca_attr="'+ap1+'" name="transaction[]" required> <option value="">--Select Transaction--</option> <option value="NEW">New</option> <option value="REN">Renew</option> <option value="RET">Retire</option> </select> </div> </div> <div class="col-md-3"> <div class="form-group"> <select class="form-control basis_c'+ap1+' basis_class" name="basis[]" ca_attr="'+ap1+'" required> <option value="">--Select Basis--</option> <option value="C">Capital Investment</option> <option value="G">Gross/Sales</option> <option value="I">Inputed Value</option> </select> </div> </div> <div class="col-md-3"> <div class="form-group"><select name="indicator[]" class="form-control indicator_c'+ap1+' indicator_class'+ap1+' indicator_class" ca_attr="'+ap1+'" required disabled> <option value="">--Select Indicator--</option> <option value="F">Formula</option> <option value="R">Range</option> <option value="C">Constant</option> </select> </div> </div> </div> </td><td><button type="button" style="margin-bottom:15px; margin-left:5px;" class="btn btn-danger append1_indicator_remove_btn" ca_attr="'+ap1+'" >   <i class="fa fa-minus"> </i>  </button></td> </tr><tr class="tr1_'+ap1+'" ><td colspan="2"> <div class="indicator_content'+ap1+'"> </td> </div> </tr>';
        $(".append_here").before(text);

    $('.selectpicker').selectpicker('refresh');

    });
    // aappend the main in edit
     eap1 = 100;

    $(document).on('click',".edit_append_tax_fees",function(){
        eap1++;
        var text = '<tr class="edit_tr'+eap1+'"> <td><select class=" selectpicker form-control edit_sub_acc_no_class" id="sub_acc_no_class'+eap1+'" ca_attr="'+eap1+'" name="charges[]" data-show-subtext="true" data-live-search="true"> <option value="" required>--Select Tax/fee--</option><?php $query = mysqli_query($conn, "SELECT natureOfCollection_tbl.`name` as sub_account_title , natureOfCollection_tbl.`id` as sub_account_no FROM `geo_bpls_active_tfo` inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_active_tfo.naturecollection_id ");  while ($row = mysqli_fetch_assoc($query)) {?> <option value="<?php echo $row["sub_account_no"]; ?>"> <?php echo str_replace("'","\'",$row["sub_account_title"]); ?> </option> <?php } ?></select>  </td> <td> <select class="form-control edit_append_transaction edit_append_transaction'+eap1+' " ca_attr="'+eap1+'" name="transaction[]" required> <option value="">--Select Transaction--</option> <option value="NEW">New</option> <option value="REN">Renew</option> <option value="RET">Retire</option> </select> </td><td> <select class="form-control" name="basis[]" required> <option value="">--Select Basis--</option> <option value="C">Capital Investment</option> <option value="G">Gross/Sales</option> <option value="I">Inputed Value</option> </select>  </td><td> <select name="indicator[]" class="form-control edit_indicator_class'+eap1+' edit_indicator_class" ca_attr="'+eap1+'" required > <option value="">--Select Indicator--</option> <option value="F">Formula</option> <option value="R">Range</option> <option value="C">Constant</option> </select> </td><td> <button type="button"  class="btn btn-danger remove_tax_fee_edit" ca_attr="'+eap1+'" style="margin:4px;" >   <i class="fa fa-minus"> </i>  </button> </td> </tr> <tr class="edit_tr'+eap1+'"> <td colspan="5"> <span class="edit_indicator_content'+eap1+'"> </span> </td> </tr>';
        $(".edit_append_tax_fee").before(text);

    $('.selectpicker').selectpicker('refresh');

    });

    // onchange transaction in append 
    $(document).on("change",".edit_append_transaction",function(){
        var ca_attr = $(this).attr("ca_attr");
        var val = $(this).val();
        $(".formula_transaction"+ca_attr).val(val);
        $(".constant_transaction"+ca_attr).val(val);
        $(".range_transaction"+ca_attr).val(val);
    });

// on change transaction_0

    $(document).on("change",".transaction_0",function(){
           var transaction = $(this).val();
         $(".range_transaction").val(transaction);
         $(".formula_transaction").val(transaction);
         $(".constant_transaction").val(transaction);
    });


// append the indicator
  ap2 = 0;
    $(document).on('click',"#append_indicator_btn",function(){ 
        ap2++;
        var sub_acc_no = $(this).attr("sub_acc_no");

        var transaction = $(".transaction_0").val();

        $(".range_transaction").val(transaction);
        var text = "<tr class='tr_"+ap2+"'> <td><div class='form-group'><input type='hidden' name='range_charges[]' value='"+sub_acc_no+"' class='range_charges'> <input type='hidden' name='range_transaction[]' value='"+transaction+"' class='range_transaction'>  <input type='text' class='form-control' name='range_low[]' style='margin-left:2px; width:97%;' placeholder='0' required></div></td><td><div class='form-group'> <input type='text' class='form-control' name='range_high[]' style='margin-left:2px; width:97%;' placeholder='999' required></div></td><td><div class='form-group'><input type='text' class='form-control' name='range_amount[]' style='margin-left:2px; width:97%;' required></div> </div></td> <td>  <button type='button' style=' margin-bottom:15px;' class='btn btn-danger append_indicator_remove_btn' ca_attr='"+ap2+"' >   <i class='fa fa-minus'> </i>  </button> </td> </tr>";
        $(".tr_fetch_append_here").before(text);
    });

    // append in append the indicator
  ap33 = 0;
    $(document).on('click',".append_in_append_indicator_btn",function(){ 
        ap33++;
         var sub_acc_no = $(this).attr("sub_acc_no");
         var ca_attr = $(this).attr("ca_attr")
         var transaction = $(".transaction_app"+ca_attr).val();
        
        if(transaction == "" || transaction == "undefined" || transaction == null){
           var  transaction = $(".transaction_edit"+ca_attr).val();
        }

        if(transaction == "" || transaction == "undefined" || transaction == null){
           var  transaction = $(".edit_append_transaction"+ca_attr).val();
        }
         
        var text = "<tr class='tr_"+ap33+"'> <td><div class='form-group'> <input type='hidden' name='range_charges[]' class='range_charges"+ca_attr+"' value='"+sub_acc_no+"'> <input type='hidden' name='range_transaction[]' class='range_transaction"+ca_attr+"' value='"+transaction+"' >  <input type='text' class='form-control' name='range_low[]' style='margin-left:2px; width:97%;' placeholder='0' required></div></td><td><div class='form-group'> <input type='text' class='form-control' name='range_high[]' style='margin-left:2px; width:97%;' placeholder='999' required></div></td><td><div class='form-group'><input type='text' class='form-control' name='range_amount[]' style='margin-left:2px; width:97%;' required></div> </div></td> <td>  <button type='text' style=' margin-bottom:15px; margin-left:5px;' class='btn btn-danger append_indicator_remove_btn' ca_attr='"+ap33+"' >   <i class='fa fa-minus'> </i>  </button> </td> </tr>";
        $(".tr_fetch_append_here"+ca_attr).before(text);
    });

        // edit append in append the indicator
  eap33 = 0;
    $(document).on('click',".append_indicator_btn_edit",function(){ 
        eap33++;
        var sub_acc_no = $(this).attr("sub_acc_no");
        var ca_attr = $(this).attr("ca_attr");
        var transaction = $(".transaction_edit"+ca_attr).val();
        var text = "<tr class='tr_"+eap33+"'> <td><div class='form-group'> <input type='hidden' name='range_charges[]' class='range_charges"+ca_attr+"' value='"+sub_acc_no+"' required> <input type='hidden' name='range_transaction[]' class='range_transaction"+ca_attr+"' value='"+transaction+"' required>  <input type='text' class='form-control' name='range_low[]' style='margin-left:2px; width:97%;' placeholder='0' required></div></td><td><div class='form-group'> <input type='text' class='form-control' name='range_high[]' style='margin-left:2px; width:97%;' placeholder='999' required></div></td><td><div class='form-group'><input type='text' class='form-control' name='range_amount[]' style='margin-left:2px; width:97%;' required></div> </div></td> <td>  <button type='button' style=' margin-bottom:15px; ' class='btn btn-danger append_indicator_remove_btn' ca_attr='"+eap33+"' >   <i class='fa fa-minus'> </i>  </button> </td> </tr>";
        $(".edit_fetch_range_indicator"+ca_attr).before(text);
    });

     // remove append 1
    $(document).on("click",".append1_indicator_remove_btn",function(){
        var ca_attr = $(this).attr("ca_attr");
        $(".tr1_"+ca_attr).remove();
      
    });
    // remove append 2
    $(document).on("click",".append_indicator_remove_btn",function(){
        var ca_attr = $(this).attr("ca_attr");
        $(".tr_"+ca_attr).remove();
      
    });

     // remove append in edit tax
    $(document).on("click",".remove_tax_fee_edit",function(){
        var ca_attr = $(this).attr("ca_attr");
        $(".edit_tr"+ca_attr).remove();
      
    });
     // remove append in edit indicator
    $(document).on("click",".remove_append_indicator_edit",function(){
        var ca_attr = $(this).attr("ca_attr");
        $(".tr_append_edit"+ca_attr).remove();
      
    });
// edit onchange inditicator
    $(document).on('change','.edit_indicator_btn',function(){
        
        var ca_attr = $(this).attr("ca_attr");
        var sub_account_no = $("#edit_sub_acc_no_class"+ca_attr).val();
        var transaction = $(".transaction_edit"+ca_attr).val();

        var value = $(this).val();
        if(value == "F"){
            $(".edit_indicator_content"+ca_attr).html("<td colspan='5'> <div class='form-group'><label> Formula </label>   <input type='hidden'  name='tfo_nature_id[]'  value='"+ca_attr+"'> <input type='text' class='form-control' name='formula[]'  placeholder='X0 * 0005' required> <input type='hidden' name='formula_transaction[]' class='formula_transaction"+ca_attr+"' ca_attr='"+ca_attr+"' value='"+transaction+"' > <input type='hidden' class='formula_charges"+ca_attr+"' name='formula_charges[]' value='"+sub_account_no+"' required>   </div></td>");
        }else if(value == "R"){
              $(".edit_indicator_content"+ca_attr).html("<td colspan='5'> <table style='width:99%;'> <tr> <td> <input type='hidden' name='range_transaction[]' class='range_transaction"+ca_attr+"' ca_attr='"+ca_attr+"' value='"+transaction+"' >  <input type='hidden'  name='tfo_nature_id[]' value='"+ca_attr+"'>   <div class='form-group'><label> Range Low </label> <input type='hidden' name='range_charges[]'  class='range_charges"+ca_attr+"' value='"+sub_account_no+"' required>  <input type='text' class='form-control' name='range_low[]' style='margin-left:2px; width:97%;' placeholder='0' required></div></td><td><div class='form-group'><label> Range High </label> <input type='text' class='form-control' name='range_high[]' style='margin-left:2px; width:97%;' placeholder='999'  required></div></td><td><div class='form-group'><label> Range Amount </label> <input type='text' class='form-control' name='range_amount[]' style='margin-left:2px; width:97%;' required ></div> </div></td> <td>  <button type='button' style='margin:2px; margin-top:13px; margin-left:5px;' class='btn btn-success append_in_append_indicator_btn append_in_append_indicator_btn"+ca_attr+"' sub_acc_no='"+sub_account_no+"' ca_attr='"+ca_attr+"'>   <i class='fa fa-plus'> </i>  </button> </td> </tr> <tr class='tr_fetch_append_here"+ca_attr+"'>  </tr> </table> </td>");
        }else if(value == "C"){
             $(".edit_indicator_content"+ca_attr).html("<td colspan='5'><div class='form-group'><label> Constant </label> <input type='text' class='form-control' name='constant[]' placeholder='200' required> <input type='hidden'  name='constant_transaction[]' class='constant_transaction"+ca_attr+"' ca_attr='"+ca_attr+"' value='"+transaction+"' >  <input type='hidden' name='constant_charges[]' value='"+sub_account_no+"' class='constant_charges"+ca_attr+"' required>  <input type='hidden'  name='tfo_nature_id[]' value='"+ca_attr+"'>  </div> </td>");
        }else{
            $(".edit_indicator_content"+ca_attr).html(" ");
        }
    });

// onchange chargers in edit and set hidden sub acc
$(document).on("change",".edit_sub_acc_no_class",function(){
     var ca_attr = $(this).attr("ca_attr");

     $(".formula_charges"+ca_attr).val($(this).val());
     $(".range_charges"+ca_attr).val($(this).val());
     $(".constant_charges"+ca_attr).val($(this).val());
     
     $(".append_in_append_indicator_btn"+ca_attr).attr("sub_acc_no",$(this).val());
     $(".append_indicator_btn_edit"+ca_attr).attr("sub_acc_no",$(this).val());
});

// onchange indicator

    $(document).on('change','.indicator_btn',function(){
        
        var value = $(this).val();
        var sub_acc_no = $("#sub_acc_no").val();
        var transaction = $(".transaction_0").val();

        if(value == "F"){
            $(".indicator_content").html("<div class='form-group'><label> Formula </label> <input type='text' class='form-control' name='formula[]'  placeholder='X0 * 0005' required>  <input type='hidden'  name='tfo_nature_id[]' value=''> <input type='hidden' name='formula_charges[]' class='formula_charges' value='"+sub_acc_no+"'>  <input type='hidden' name='formula_transaction[]' value='"+transaction+"' class='formula_transaction'> </div>");
        }else if(value == "R"){
              $(".indicator_content").html("<table style='width:99%;'> <tr> <td><div class='form-group'><label> Range Low </label>  <input type='hidden' name='range_charges[]' value='"+sub_acc_no+"' class='range_charges'> <input type='hidden'  name='tfo_nature_id[]' value=''>   <input type='hidden' name='range_transaction[]' value='"+transaction+"' class='range_transaction'>  <input type='text' class='form-control' name='range_low[]' style='margin-left:2px; width:97%;' placeholder='0' required></div></td><td><div class='form-group'><label> Range High </label> <input type='text' class='form-control' name='range_high[]' style='margin-left:2px; width:97%;' placeholder='999'  required></div></td><td><div class='form-group'><label> Range Amount </label> <input type='text' class='form-control' name='range_amount[]' style='margin-left:2px; width:97%;' required></div> </div></td> <td>  <button type='button' id='append_indicator_btn' sub_acc_no='"+sub_acc_no+"' style='margin:2px; margin-top:13px; margin-left:5px;' class='btn btn-success'>   <i class='fa fa-plus'> </i>  </button> </td> </tr> <tr class='tr_fetch_append_here'>  </tr> </table>");
        }else if(value == "C"){
             $(".indicator_content").html("<div class='form-group'><label> Constant </label> <input type='text' class='form-control' name='constant[]' placeholder='200' required>  <input type='hidden' name='constant_charges[]' value='"+sub_acc_no+"'  class='constant_charges'> <input type='hidden' name='constant_transaction[]' value='"+transaction+"' class='constant_transaction'>  <input type='hidden'  name='tfo_nature_id[]'  value=''> </div>");
        }else{
            $(".indicator_content").html(" ");
        }
    });


//  transaction_app onchage transaction in append set append button attr
 
    $(document).on("change",".transaction_app",function(){
        var ca_attr = $(this).attr("ca_attr");
        var val = $(this).val();
        $(".formula_transaction"+ca_attr).val(val);
        $(".constant_transaction"+ca_attr).val(val);
        $(".range_transaction"+ca_attr).val(val);
        $(".append_in_append_indicator_btn").attr("ca_transaction",val);
    });

    // app2 

// onchange indicator in append
        $(document).on('change','.indicator_class',function(){
        
        var ca_attr = $(this).attr("ca_attr");
        var sub_acc_no = $("#sub_acc_no_class"+ca_attr).val();
        var transaction = $(".transaction_app"+ca_attr).val();

        var value = $(this).val();
        if(value == "F"){
            $(".indicator_content"+ca_attr).html("<div class='form-group'><label> Formula </label> <input type='text' class='form-control' name='formula[]'  placeholder='X0 * 0005' required>  <input type='hidden' name='formula_charges[]' class='formula_charges"+ca_attr+"' value='"+sub_acc_no+"'> <input type='hidden' name='formula_transaction[]' class='formula_transaction"+ca_attr+"' value='"+transaction+"'> <input type='hidden'  name='tfo_nature_id[]' class='formula_charges' value=''>   </div>");
        }else if(value == "R"){
              $(".indicator_content"+ca_attr).html("<table style='width:99%;'> <tr> <td>  <input type='hidden'  name='tfo_nature_id[]' class='formula_charges' value=''> <div class='form-group'><label> Range Low </label>  <input type='hidden' name='range_charges[]' class='range_charges"+ca_attr+"' value='"+sub_acc_no+"'> <input type='hidden' name='range_transaction[]' class='range_transaction"+ca_attr+"' value='"+transaction+"'>  <input type='text' class='form-control' name='range_low[]' style='margin-left:2px; width:97%;' placeholder='0' required></div></td><td><div class='form-group'><label> Range High </label> <input type='text' class='form-control' name='range_high[]' style='margin-left:2px; width:97%;' placeholder='999'  required></div></td><td><div class='form-group'><label> Range Amount </label> <input type='text' class='form-control' name='range_amount[]' style='margin-left:2px; width:97%;' required ></div> </div></td> <td>  <button type='button' style='margin:2px; margin-top:13px; margin-left:5px;' class='btn btn-success append_in_append_indicator_btn append_in_append_indicator_btn"+ca_attr+"'  sub_acc_no='"+sub_acc_no+"' ca_attr='"+ca_attr+"'>   <i class='fa fa-plus'> </i>  </button> </td> </tr> <tr class='tr_fetch_append_here"+ca_attr+"'>  </tr> </table>");
        }else if(value == "C"){
             $(".indicator_content"+ca_attr).html("<div class='form-group'><label> Constant </label> <input type='text' class='form-control' name='constant[]' placeholder='200' required>  <input type='hidden' name='constant_charges[]' class='constant_charges"+ca_attr+"'  value='"+sub_acc_no+"'> <input type='hidden' name='constant_transaction[]' class='constant_transaction"+ca_attr+"' value='"+transaction+"'>  <input type='hidden'  name='tfo_nature_id[]' class='formula_charges' value=''> </div>");
        }else{
            $(".indicator_content"+ca_attr).html(" ");
        }
    });

// edit onchange indicator in append
        $(document).on('change','.edit_indicator_class',function(){
        

        var ca_attr = $(this).attr("ca_attr");
        
        var transaction = $(".edit_append_transaction"+ca_attr).val();
        var sub_acc_no = $("#sub_acc_no_class"+ca_attr).val();
        alert(sub_acc_no)
        var value = $(this).val();
        if(value == "F"){
            $(".edit_indicator_content"+ca_attr).html("<div class='form-group'><label> Formula </label> <input type='text' class='form-control' name='formula[]'  placeholder='X0 * 0005' required>  <input type='hidden' name='formula_charges[]' class='formula_charges"+ca_attr+"' value='"+sub_acc_no+"'> <input type='hidden' name='formula_transaction[]' class='formula_transaction"+ca_attr+"' value='"+transaction+"'>   <input type='hidden'  name='tfo_nature_id[]' class='formula_charges' value=''>  </div>");
        }else if(value == "R"){
              $(".edit_indicator_content"+ca_attr).html("<table style='width:99%;'> <tr> <td><div class='form-group'><label> Range Low </label> <input type='hidden'  name='tfo_nature_id[]' class='formula_charges' value=''>  <input type='hidden' name='range_transaction[]' class='range_transaction"+ca_attr+"' value='"+transaction+"'>    <input type='hidden' name='range_charges[]' class='range_charges"+ca_attr+"' value='"+sub_acc_no+"'> <input type='text' class='form-control' name='range_low[]' style='margin-left:2px; width:97%;' placeholder='0' required></div></td><td><div class='form-group'><label> Range High </label> <input type='text' class='form-control' name='range_high[]' style='margin-left:2px; width:97%;' placeholder='999'  required></div></td><td><div class='form-group'><label> Range Amount </label> <input type='text' class='form-control' name='range_amount[]' style='margin-left:2px; width:97%;' required ></div> </div></td> <td>  <button type='button' style='margin:2px; margin-top:13px; margin-left:5px;' class='btn btn-success append_in_append_indicator_btn append_in_append_indicator_btn"+ca_attr+"'  sub_acc_no='"+sub_acc_no+"' ca_attr='"+ca_attr+"'>   <i class='fa fa-plus'> </i>  </button> </td> </tr> <tr class='tr_fetch_append_here"+ca_attr+"'>  </tr> </table>");
        }else if(value == "C"){
             $(".edit_indicator_content"+ca_attr).html("<div class='form-group'><label> Constant </label> <input type='text' class='form-control' name='constant[]' placeholder='200' required>  <input type='hidden' name='constant_charges[]' class='constant_charges"+ca_attr+"'  value='"+sub_acc_no+"'>  <input type='hidden' name='constant_transaction[]' class='constant_transaction"+ca_attr+"' value='"+transaction+"'>  <input type='hidden'  name='tfo_nature_id[]' class='formula_charges' value=''>  </div>");
        }else{
            $(".edit_indicator_content"+ca_attr).html(" ");
        }
    });

    // onchange transaction in edit
    $(document).on("change",".transaction_edit",function(){
        var ca_attr = $(this).attr("ca_attr");
        var val = $(this).val();

        $(".formula_transaction"+ca_attr).val(val);
        $(".range_transaction"+ca_attr).val(val);
        $(".constant_transaction"+ca_attr).val(val);
    });

    $(document).on("click",".update_tfo_settings",function(){
        var data = $("#update_tfo_settings_form").serialize();
        $.ajax({
            url: "bpls/ajax_updaing_tfo_nature.php",
            type: "post",
            data:{"obj_data":data},
            success:function(result){
                 if(result == 0){
                    alert("Nature successfully updated");
                    $("#mytaxModal23").modal("hide");
                 }else{
                    alert("failed to update nature!");
                 }
            }
        });
    })
</script>

<?php
  if(isset($_POST["save_settings"])){
     $nature = $_POST["nature"];


     $revenue_code = $_POST["revenue"]."-".$_POST["revenue_year"]."-".$_POST["revenue_series"];
     $username = $_SESSION['uname'];
    // saving revenue code
   $q000 =  mysqli_query($conn,"SELECT * from geo_bpls_revenue_code where revenue_code = '$revenue_code' ");

    $rc_count = mysqli_num_rows($q000);

    if($rc_count == 0){
         mysqli_query($conn,"INSERT INTO `geo_bpls_revenue_code`(`revenue_code`, `revenue_code_status`) VALUES ('$revenue_code',0)");

         if($status == "ON"){
              mysqli_query($wconn,"INSERT INTO `geo_bpls_revenue_code`(`revenue_code`, `revenue_code_status`) VALUES ('$revenue_code',0)");
         }
    }

    // saving revenue code

    $charges_count = count($_POST["charges"]);
      // check available tfo nature
        $q = mysqli_query($conn,"SELECT tfo_nature_id FROM `geo_bpls_tfo_nature` ORDER BY `geo_bpls_tfo_nature`.`tfo_nature_id` DESC ");
        $r = mysqli_fetch_assoc($q);
        $tfo_nature = $r["tfo_nature_id"];
    
    for($a=0; $a<$charges_count; $a++){
        $aa = $a+1;
        $charges = $_POST["charges"][$a];
        $transaction = $_POST["transaction"][$a];
        $basis = $_POST["basis"][$a];
        $indicator = $_POST["indicator"][$a];
        $tfo_nature_id = $tfo_nature+$aa;
        
        if($indicator == "F"){
            $formula_charges_count = count($_POST["formula_charges"]);
            for($b=0; $b<$formula_charges_count; $b++){
                if($_POST["formula_charges"][$b] == $charges && $_POST["formula_transaction"][$b] == $transaction ){
                    $formula = $_POST["formula"][$b];
                    
                    mysqli_query($conn,"INSERT INTO `geo_bpls_tfo_nature`(`tfo_nature_id`,revenue_code, `basis_code`, `indicator_code`, `mode_formula_code`, `nature_id`, `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`) VALUES ('$tfo_nature_id','$revenue_code','$basis','$indicator',null,'$nature','$charges','$transaction','$formula','0','','$username') ");

                    if($status == "ON"){
                        mysqli_query($wconn, "INSERT INTO `geo_bpls_tfo_nature`(`tfo_nature_id`,revenue_code, `basis_code`, `indicator_code`, `mode_formula_code`, `nature_id`, `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`) VALUES ('$tfo_nature_id','$revenue_code','$basis','$indicator',null,'$nature','$charges','$transaction','$formula','0','','$username') ");
                    }
                }
            }
            
        }elseif($indicator == "R"){
        
            $range_charges_count = count($_POST["range_charges"]);

                for($nn=0; $nn<$range_charges_count; $nn++){
                    $r_low = $_POST["range_low"][$nn];
                    $r_high = $_POST["range_high"][$nn];
                    $r_amount = $_POST["range_amount"][$nn];
                    if($_POST["range_charges"][$nn] == $charges && $_POST["range_transaction"][$nn] == $transaction){
                        mysqli_query($conn, "INSERT INTO `geo_bpls_tfo_range`(`tfo_nature_id`, `range_amount`, `range_high`, `range_low`, `updated_by`) VALUES ('$tfo_nature_id','$r_amount','$r_high','$r_low','$username')");
                    }
                }

           mysqli_query($conn, "INSERT INTO `geo_bpls_tfo_nature`(`tfo_nature_id`,revenue_code, `basis_code`, `indicator_code`, `mode_formula_code`, `nature_id`, `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`) VALUES ('$tfo_nature_id','$revenue_code','$basis','$indicator',null,'$nature','$charges','$transaction','0','0','','$username') ");
            if($status == "ON"){
                mysqli_query($wconn, "INSERT INTO `geo_bpls_tfo_nature`(`tfo_nature_id`,revenue_code, `basis_code`, `indicator_code`, `mode_formula_code`, `nature_id`, `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`) VALUES ('$tfo_nature_id','$revenue_code','$basis','$indicator',null,'$nature','$charges','$transaction','0','0','','$username') ");
            }
        //    count tfo in db tfo range

          $q0 = mysqli_query($conn,"SELECT count(`tfo_range_id`) as count_1 FROM `geo_bpls_tfo_range` WHERE `tfo_nature_id` = '$tfo_nature_id' ");
          $r0 = mysqli_fetch_assoc($q0);
            $aaaaa = $r0["count_1"];
            if($aaaaa>0){
                mysqli_query($conn, "UPDATE geo_bpls_tfo_nature SET amount_formula_range = '$aaaaa'  WHERE `tfo_nature_id` = '$tfo_nature_id' ");
                if($status == "ON"){
                     mysqli_query($wconn, "UPDATE geo_bpls_tfo_nature SET amount_formula_range = '$aaaaa'  WHERE `tfo_nature_id` = '$tfo_nature_id' ");
                }
            }


        }elseif($indicator == "C"){
            $formula_charges_count = count($_POST["constant_charges"]);
            for($b=0; $b<$formula_charges_count; $b++){
                if($_POST["constant_charges"][$b] == $charges  && $_POST["constant_transaction"][$b] == $transaction){
                    $formula = $_POST["constant"][$b];
                    mysqli_query($conn,"INSERT INTO `geo_bpls_tfo_nature`(`tfo_nature_id`,revenue_code, `basis_code`, `indicator_code`, `mode_formula_code`, `nature_id`, `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`) VALUES ('$tfo_nature_id','$revenue_code','$basis','$indicator',null,'$nature','$charges','$transaction','$formula','0','','$username') ");
                    
                    if($status == "ON"){
                        mysqli_query($wconn, "INSERT INTO `geo_bpls_tfo_nature`(`tfo_nature_id`,revenue_code, `basis_code`, `indicator_code`, `mode_formula_code`, `nature_id`, `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`) VALUES ('$tfo_nature_id','$revenue_code','$basis','$indicator',null,'$nature','$charges','$transaction','$formula','0','','$username') ");
                    }
                }
            }
        }
           
    }
    ?>
 <script>
    myalert_warning_af("Tax/Fee Successfully Inserted!","bplsmodule.php?redirect=tax_fees");
 </script>
<?php
    }

    if(isset($_POST["update_fees"])){
    $nature = $_POST["nature_id"];


    $username = $_SESSION['uname'];
     include("myfunction/myquery_function.php");
    $charges_count = count($_POST["charges"]);

// check available tfo nature
// $q = mysqli_query($conn, "SELECT tfo_nature_id FROM `geo_bpls_tfo_nature` ORDER BY `geo_bpls_tfo_nature`.`tfo_nature_id` DESC ");
// $r = mysqli_fetch_assoc($q);
// $tfo_nature = $r["tfo_nature_id"];
for ($a = 0; $a < $charges_count; $a++) {

    // check if may tfo_id

    $charges = $_POST["charges"][$a];
    $transaction = $_POST["transaction"][$a];
    $basis = $_POST["basis"][$a];
    $indicator = $_POST["indicator"][$a];
    // echo $transaction;
    // $tfo_nature_id = $tfo_nature + $aa;
        $tfo_nature_id =   $_POST["tfo_nature_id"][$a];
        // echo $tfo_nature_id."-"."(".$charges.")";
    if ($indicator == "F") {
        $formula_charges_count = count($_POST["formula_charges"]);
        for ($b = 0; $b < $formula_charges_count; $b++) {
            if ($_POST["formula_charges"][$b] == $charges && $_POST["formula_transaction"][$b] == $transaction) {
                $formula = $_POST["formula"][$b];
                mysqli_query($conn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code` = '$basis', `indicator_code` = '$indicator', `nature_id` = '$nature', `sub_account_no` = '$charges', `status_code` = '$transaction', `amount_formula_range` = '$formula' , `updated_by` = '$username' where `tfo_nature_id` = '$tfo_nature_id'");

                if($status == "ON"){
                    mysqli_query($wconn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code` = '$basis', `indicator_code` = '$indicator', `nature_id` = '$nature', `sub_account_no` = '$charges', `status_code` = '$transaction', `amount_formula_range` = '$formula' , `updated_by` = '$username' where `tfo_nature_id` = '$tfo_nature_id'");

                }
            }
        }

    } elseif ($indicator == "R") {

        $range_charges_count = count($_POST["range_charges"]);
        mysqli_query($conn, "DELETE FROM geo_bpls_tfo_range where tfo_nature_id = '$tfo_nature_id' ");
        for ($nn = 0; $nn < $range_charges_count; $nn++) {
            $r_low = $_POST["range_low"][$nn];
            $r_high = $_POST["range_high"][$nn];
            $r_amount = $_POST["range_amount"][$nn];
            if ($_POST["range_charges"][$nn] == $charges && $_POST["range_transaction"][$nn] == $transaction) {

                mysqli_query($conn, "INSERT INTO `geo_bpls_tfo_range`(`tfo_nature_id`, `range_amount`, `range_high`, `range_low`, `updated_by`) VALUES ('$tfo_nature_id','$r_amount','$r_high','$r_low','$username')");
            }
        }

        mysqli_query($conn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code`= '$basis', `indicator_code` = '$indicator', `nature_id` ='$nature', `sub_account_no` = '$charges', `status_code` = '$transaction',  `updated_by`='$username' where `tfo_nature_id` = '$tfo_nature_id' ");
        if($status == "ON"){
            mysqli_query($wconn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code` = '$basis', `indicator_code` = '$indicator', `nature_id` = '$nature', `sub_account_no` = '$charges', `status_code` = '$transaction', `amount_formula_range` = '$formula' , `updated_by` = '$username' where `tfo_nature_id` = '$tfo_nature_id'");
        }
        //    count tfo in db tfo range

        $q0 = mysqli_query($conn, "SELECT count(`tfo_range_id`) as count_1 FROM `geo_bpls_tfo_range` WHERE `tfo_nature_id` = '$tfo_nature_id' ");
        $r0 = mysqli_fetch_assoc($q0);
        $aaaaa = $r0["count_1"];
        if ($aaaaa > 0) {
            mysqli_query($conn, "UPDATE geo_bpls_tfo_nature SET amount_formula_range = '$aaaaa'  WHERE `tfo_nature_id` = '$tfo_nature_id' ");

            if($status == "ON"){
                mysqli_query($wconn, "UPDATE geo_bpls_tfo_nature SET amount_formula_range = '$aaaaa'  WHERE `tfo_nature_id` = '$tfo_nature_id' ");
            }

        }
        // echo "r".$range_charges_count."="."<br>";

    } elseif ($indicator == "C") {
        $formula_charges_count = count($_POST["constant_charges"]);
        for ($b = 0; $b < $formula_charges_count; $b++) {
            if ($_POST["constant_charges"][$b] == $charges && $_POST["constant_transaction"][$b] == $transaction) {
                $formula = $_POST["constant"][$b];
                mysqli_query($conn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code`='$basis', `indicator_code`='$indicator', `nature_id` ='$nature', `sub_account_no` = '$charges', `status_code` = '$transaction', `amount_formula_range` = '$formula', `updated_by` =' $username' WHERE `tfo_nature_id` = '$tfo_nature_id' ");

                if($status == "ON"){
                    mysqli_query($wconn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code`='$basis', `indicator_code`='$indicator', `nature_id` ='$nature', `sub_account_no` = '$charges', `status_code` = '$transaction', `amount_formula_range` = '$formula', `updated_by` =' $username' WHERE `tfo_nature_id` = '$tfo_nature_id' ");
                }
            }
        }
        // echo "c".$formula_charges_count."="."<br>";

    }

}
?>
 <script>
    myalert_warning_af("Tax/Fee Successfully Update!","bplsmodule.php?redirect=tax_fees");
 </script>
<?php
}

if(isset($_POST["copy_tax"])){
    $count = count($_POST["multiselect_name"]);
    $revenue_code = $_POST["c_revenue"]."-".$_POST["c_revenue_year"]."-".$_POST["c_revenue_series"];
    $nature_id = $t_nature = $_POST["t_nature"];

        $username = $_SESSION['uname'];
    // saving revenue code
    $q000 = mysqli_query($conn, "SELECT * from geo_bpls_revenue_code where revenue_code = '$revenue_code' ");

    $rc_count = mysqli_num_rows($q000);

    if ($rc_count == 0) {
        mysqli_query($conn, "INSERT INTO `geo_bpls_revenue_code`(`revenue_code`, `revenue_code_status`) VALUES ('$revenue_code',0)");
        if($status == "ON"){
             mysqli_query($wconn, "INSERT INTO `geo_bpls_revenue_code`(`revenue_code`, `revenue_code_status`) VALUES ('$revenue_code',0)"); 
        }
    }

    // saving revenue code


    //   assign tfo_nature_id
    
        $q = mysqli_query($conn,"SELECT tfo_nature_id FROM `geo_bpls_tfo_nature` ORDER BY `geo_bpls_tfo_nature`.`tfo_nature_id` DESC limit 1 ");
        $r = mysqli_fetch_assoc($q);
        $tfo_nature = $r["tfo_nature_id"]+1;
    
    for($vv = 0; $vv < $count; $vv++){ 
       
        if($_POST["multiselect_name"][$vv] != "All"){
        $tfo_nature_id = $_POST["multiselect_name"][$vv];
        $tfo_nature = $tfo_nature + $vv;

        
    //   checking if range
    $check_q = mysqli_query($conn,"SELECT indicator_code From geo_bpls_tfo_nature WHERE `tfo_nature_id` = '$tfo_nature_id' ");
    $check_r = mysqli_fetch_assoc($check_q);

    if($check_r["indicator_code"] == "R"){
        mysqli_query($conn, "INSERT INTO `geo_bpls_tfo_nature`(tfo_nature_id,`revenue_code`, `basis_code`, `indicator_code`, `mode_formula_code`, `nature_id`, `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`, `updated_date`) SELECT '$tfo_nature', '$revenue_code', `basis_code`, `indicator_code`, `mode_formula_code`, '$nature_id', `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`, `updated_date` FROM `geo_bpls_tfo_nature` WHERE `tfo_nature_id` = '$tfo_nature_id' ");

        if($status == "ON"){
             mysqli_query($wconn, "INSERT INTO `geo_bpls_tfo_nature`(tfo_nature_id,`revenue_code`, `basis_code`, `indicator_code`, `mode_formula_code`, `nature_id`, `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`, `updated_date`) SELECT '$tfo_nature', '$revenue_code', `basis_code`, `indicator_code`, `mode_formula_code`, '$nature_id', `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`, `updated_date` FROM `geo_bpls_tfo_nature` WHERE `tfo_nature_id` = '$tfo_nature_id' ");    
        }
        mysqli_query($conn, "INSERT INTO `geo_bpls_tfo_range`( `tfo_nature_id`, `range_amount`, `range_high`, `range_low`, `updated_by`, `updated_date`) SELECT '$tfo_nature', `range_amount`, `range_high`, `range_low`, `updated_by`, `updated_date` FROM `geo_bpls_tfo_range`  WHERE `tfo_nature_id` = '$tfo_nature_id' ");


    }else{
        mysqli_query($conn, "INSERT INTO `geo_bpls_tfo_nature`(tfo_nature_id,`revenue_code`, `basis_code`, `indicator_code`, `mode_formula_code`, `nature_id`, `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`, `updated_date`) SELECT '$tfo_nature', '$revenue_code', `basis_code`, `indicator_code`, `mode_formula_code`, '$nature_id', `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`, `updated_date` FROM `geo_bpls_tfo_nature` WHERE `tfo_nature_id` = '$tfo_nature_id'  ");

        if($status == "ON"){
             mysqli_query($wconn, "INSERT INTO `geo_bpls_tfo_nature`(tfo_nature_id,`revenue_code`, `basis_code`, `indicator_code`, `mode_formula_code`, `nature_id`, `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`, `updated_date`) SELECT '$tfo_nature', '$revenue_code', `basis_code`, `indicator_code`, `mode_formula_code`, '$nature_id', `sub_account_no`, `status_code`, `amount_formula_range`, `minimum_amount`, `unit_of_measure`, `updated_by`, `updated_date` FROM `geo_bpls_tfo_nature` WHERE `tfo_nature_id` = '$tfo_nature_id'  ");
        }
    }
        }
      
    }
    ?>
 <script>
    myalert_warning_af("Tax/Fee Successfully Copied!","bplsmodule.php?redirect=tax_fees");
 </script>
<?php
}

if (isset($_POST["nature_btn"])) {
    $i1 = validate_str($conn, $_POST["i1"]);
    $query = mysqli_query($conn, "INSERT into geo_bpls_nature (nature_desc) VALUES ('$i1') ");
    if($status == "ON"){
        $wquery = mysqli_query($wconn, "INSERT into geo_bpls_nature (nature_desc) VALUES ('$i1') ");

    }
    if ($query) {?>
                    <script>
                    myalert_success_af("<?php echo $i1; ?> Successfully Inserted!","bplsmodule.php?redirect=tax_fees");
                    </script>
                    <?php } else {?>
                    <script>
                    myalert_danger_af("Failed to Insert! <?php echo $i1; ?> ","bplsmodule.php?redirect=tax_fees");
                    </script>
                    <?php
}
}

// update tfo2

if(isset($_POST["update_tfo_settings"])){
    
    $basis = $_POST["basis"];
    $indicator = $_POST["indicator"];
    $charges = $_POST["charges"];
    $transaction = $_POST["transaction"];
    $tfo_nature_id = $_POST["tfo_nature_id"];
    $nature_id = $_POST["nature_id"];
    $username = $_SESSION['uname'];

    if($indicator == "F" || $indicator == "C"){
        $formula = $_POST["formula"];
         mysqli_query($conn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code` = '$basis', `indicator_code` = '$indicator', `nature_id` = '$nature_id', `sub_account_no` = '$charges', `status_code` = '$transaction', `amount_formula_range` = '$formula' , `updated_by` = '$username' where `tfo_nature_id` = '$tfo_nature_id'");
         
         if($status == "ON"){
             mysqli_query($wconn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code` = '$basis', `indicator_code` = '$indicator', `nature_id` = '$nature_id', `sub_account_no` = '$charges', `status_code` = '$transaction', `amount_formula_range` = '$formula' , `updated_by` = '$username' where `tfo_nature_id` = '$tfo_nature_id'");   
         }
    }

    if($indicator == "R" ){
       $count = count($_POST["range_low"]);
        mysqli_query($conn, "DELETE FROM geo_bpls_tfo_range where tfo_nature_id = '$tfo_nature_id' ");
       for($a=0; $a<$count; $a++ ){
            $r_low = $_POST["range_low"][$a];
            $r_high = $_POST["range_high"][$a];
            $r_amount = $_POST["range_amount"][$a];
           
            mysqli_query($conn, "INSERT INTO `geo_bpls_tfo_range`(`tfo_nature_id`, `range_amount`, `range_high`, `range_low`, `updated_by`) VALUES ('$tfo_nature_id','$r_amount','$r_high','$r_low','$username')");
       }
        mysqli_query($conn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code`= '$basis', `indicator_code` = '$indicator', `nature_id` ='$nature_id', `sub_account_no` = '$charges', `status_code` = '$transaction',  `updated_by`='$username' where `tfo_nature_id` = '$tfo_nature_id' ");

        if($status == "ON"){
            mysqli_query($wconn, "UPDATE `geo_bpls_tfo_nature` SET  `basis_code`= '$basis', `indicator_code` = '$indicator', `nature_id` ='$nature_id', `sub_account_no` = '$charges', `status_code` = '$transaction',  `updated_by`='$username' where `tfo_nature_id` = '$tfo_nature_id' ");
        }
        //    count tfo in db tfo range
        $q0 = mysqli_query($conn, "SELECT count(`tfo_range_id`) as count_1 FROM `geo_bpls_tfo_range` WHERE `tfo_nature_id` = '$tfo_nature_id' ");
        $r0 = mysqli_fetch_assoc($q0);
        $aaaaa = $r0["count_1"];
        if ($aaaaa > 0) {
            mysqli_query($conn, "UPDATE geo_bpls_tfo_nature SET amount_formula_range = '$aaaaa'  WHERE `tfo_nature_id` = '$tfo_nature_id' ");

            if($status == "ON"){
                mysqli_query($conn, "UPDATE geo_bpls_tfo_nature SET amount_formula_range = '$aaaaa'  WHERE `tfo_nature_id` = '$tfo_nature_id' ");
            }
        }
        // echo "r".$range_charges_count."="."<br>";

    }
   
?>
 <script>
    myalert_warning_af("Tax/Fee Successfully Updated!","bplsmodule.php?redirect=tax_fees");
 </script>
<?php
}

?>