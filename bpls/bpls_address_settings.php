
<?php
        include("jomar_assets/input_validator.php");
?>


<div class="row">
        <div class="col-md-3">
            <div class="btn btn-primary form-control" data-toggle="modal" data-target="#myModal_reg">
                  <b>REGION SETTINGS</b>
            </div>
        </div>        
        <div class="col-md-3">
            <div  class="btn btn-primary form-control"  data-toggle="modal" data-target="#myModal_prov">
                   <b>PROVINCE SETTINGS</b>
                </div>                
        </div>        
        <div class="col-md-3">
            <div  class="btn btn-primary form-control" data-toggle="modal" data-target="#myModal_lgu">
                    <b>LGU SETTINGS</b> 
                </div>                
            </div>        
        <div class="col-md-3">
            <div  class="btn btn-primary form-control" data-toggle="modal" style="" data-target="#myModal_brgy">
                    <b>BARANGAY SETTINGS</b>
            </div>                
        </div>        
    </div>
<br>
<div class="box box-primary">
    <div class="box-body">



    <!-- reg Modal -->
<div id="myModal_reg" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-success">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class="box box-success">
                    <div class="box-header">
                        <h4>REGION SETTINGS</h4>
                    </div>
                    <div class="box-body">
                        <form method="POST" action="" >
                             <div class="form-group">
                                    <label for="">Region Code:</label>
                                    <input type="text" class="form-control" name="reg_code" required>
                             </div>
                             <div class="form-group">
                                    <label for="">Region Desc:</label>
                                    <input type="text" class="form-control" name="reg_desc" required>
                             </div>
                             <div class="form-group">
                                    <label for="">Psg Code:</label>
                                    <input type="text" class="form-control" name="psg_code" required>
                             </div>
                             <div class="form-group">
                                    <input type="submit" class="form-control btn btn-success"  name="reg_btn" >
                             </div>         
                        </form>
                    </div>
                </div>
      </div>
    </div>
  </div>
</div>

    <!-- prov Modal -->
<div id="myModal_prov" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header  bg-success">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class="box box-success">
                    <div class="box-header">
                        <h4>PROVINCE SETTINGS</h4>
                    </div>
                    <div class="box-body">
                        <form method='POST' action="">
                             <div class="form-group">
                                    <label for="">Region:</label>
                                   <select name="reg_code" id="reg_in_prov" class="form-control selectpicker" required>
                                        <option value="">--Select Region--</option>
                                        <?php
                                            $q = mysqli_query($conn,"SELECT * from 	geo_bpls_region");
                                            while($r = mysqli_fetch_assoc($q)){
                                            ?>
                                                <option value="<?php echo $r["region_code"];  ?>"> <?php echo $r["region_desc"];  ?>  </option>
                                            <?php
                                            }
                                        ?>
                                   </select>
                             </div>
                             <div class="form-group">
                                    <label for="">Province Code:</label>
                                    <input type="text" class="form-control" name="prov_code" required>
                             </div>
                             <div class="form-group">
                                    <label for="">Province Desc:</label>
                                    <input type="text" class="form-control" name="prov_desc" required>
                             </div>
                             <div class="form-group">
                                    <label for="">Psg Code:</label>
                                    <input type="text" class="form-control" name="psg_code" required>
                             </div>
                             <div class="form-group">
                                    <input type="submit" class="form-control btn btn-success"  name="prov_btn" >
                             </div>         
                        </form>
                    </div>
                </div>
      </div>
    </div>
  </div>
</div>

    <!-- lgu Modal -->
<div id="myModal_lgu" class="modal fade" role="dialog">
  <div class="modal-dialog  modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header  bg-success">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
       <div class="box box-success">
                    <div class="box-header">
                        <h4>LGU SETTINGS</h4>
                    </div>
                    <div class="box-body">
                        <form method='POST' action="">
                             <div class="form-group">
                                    <label for="">Province:</label>
                                   <select name="prov_code" class="form-control selectpicker" id="prov_in_lgu" required>
                                        <option value="">--Select Province--</option>
                                        <?php
                                            $q = mysqli_query($conn,"SELECT * from 	geo_bpls_province");
                                            while($r = mysqli_fetch_assoc($q)){
                                            ?>
                                                <option value="<?php echo $r["province_code"];  ?>"> <?php echo $r["province_desc"];  ?>  </option>
                                            <?php
                                            }
                                        ?>
                                   </select>
                             </div>
                             <div class="form-group">
                                    <label for="">LGU Code:</label>
                                    <input type="text" class="form-control" name="lgu_code" required>
                             </div>
                             <div class="form-group">
                                    <label for="">LGU Desc:</label>
                                    <input type="text" class="form-control" name="lgu_desc" required>
                             </div>
                             <div class="form-group">
                                    <label for="">Psg Code:</label>
                                    <input type="text" class="form-control" name="psg_code" required>
                             </div>
                             <div class="form-group">
                                    <label for="">LGU zip:</label>
                                    <input type="text" class="form-control" name="lgu_zip" required>
                             </div>
                             <div class="form-group">
                                    <input type="submit" class="form-control btn btn-success"  name="lgu_btn" >
                             </div>         
                        </form>
                    </div>
                </div>
      </div>
    </div>
  </div>
</div>

<form method="POST" action="">
<style>
    .dt_list:hover{
        background:#4860e8 !important;
        color:white;
        border-radius:2px 2px;
        font-size:16px;
    }
    .active{
        font-size:16px;
        color: white !important;
        cursor: default;
        background-color: #4860e8;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
    }
</style>
<?php
    $counter = 0;
    if(isset($_POST["reg_list"])){
        $counter++;
    }
    if(isset($_POST["prov_list"])){
        $counter++;
    }
    if(isset($_POST["lgu_list"])){
        $counter++;
    }
    if(isset($_POST["brgy_list"])){
        $counter++;
    }
?>
<ul class="nav nav-tabs" style="margin-bottom:10px; margin-top:5px;">
  <li class="<?php if(isset($_POST["reg_list"]) || $counter == 0){ echo 'active'; } ?>" ><input type="submit" style="font-size:16px; padding:10px 15px; display:block; background:none;border:none; " class="dt_list " name="reg_list" value="Region List"> </li>
  <li class="<?php if(isset($_POST["prov_list"])){ echo 'active'; } ?>"><input type="submit" style="font-size:16px; padding:10px 15px; display:block; background:none;border:none; " class="dt_list " name="prov_list" value="Province List"></li>
   <li class="<?php if(isset($_POST["lgu_list"])){ echo 'active'; } ?>" ><input type="submit" style="font-size:16px; padding:10px 15px; display:block; background:none; border:none; " class="dt_list " name="lgu_list" value="LGU List"></li>
    <li class="<?php if(isset($_POST["brgy_list"])){ echo 'active'; } ?>" ><input type="submit" style="font-size:16px; padding:10px 15px; display:block; background:none; border:none; " class="dt_list " name="brgy_list" value="Barangay List"></li>
</ul>
</form>

    <?php
        if(isset($_POST["reg_list"])){

    ?>
    <table id="dtt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>Region Code</th>
                    <th>Region Desc</th>
                    <th>Psg Code</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        <script>
        $(document).ready(function(){
        var dataTable = $('#dtt').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                url: "bpls/dataTables/fetch_bpls_address_settings_dt.php",
                type: "post",
                data:{"page":"reg"}
            }
        });
    });
        </script>
    <?php
        }elseif(isset($_POST["prov_list"])) {

    ?>
    <table id="dtt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>Region</th>
                    <th>Province Code</th>
                    <th>Province Desc</th>
                    <th>Psg Code</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        <script>
        $(document).ready(function(){
        var dataTable = $('#dtt').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                url: "bpls/dataTables/fetch_bpls_address_settings_dt.php",
                type: "post",
                data:{"page":"prov"}
            }
        });
    });
        </script>
    <?php
}elseif (isset($_POST["lgu_list"])) {
    ?>
    <table id="dtt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>LGU Code</th>
                    <th>Province Code</th>
                    <th>PSG Code</th>
                    <th>LGU Desc</th>
                    <th>LGU Zip</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        <script>
        $(document).ready(function(){
            var dataTable = $('#dtt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_address_settings_dt.php",
                    type: "post",
                    data:{"page":"lgu"}
                }
        });
    });
        </script>
    <?php
}elseif (isset($_POST["brgy_list"])) {
    ?>
    <table id="dtt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>LGU Desc</th>
                    <th>Barangay Desc</th>
                    <th>PSG Code</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        <script>
        $(document).ready(function(){
            var dataTable = $('#dtt').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/fetch_bpls_address_settings_dt.php",
                    type: "post",
                    data:{"page":"brgy"}
                }
        });
    });
        </script>
    <?php
}else{
    
?>
    <table id="dtt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>Region Code</th>
                    <th>Region Desc</th>
                    <th>Psg Code</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
        <script>
        $(document).ready(function(){
        var dataTable = $('#dtt').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                url: "bpls/dataTables/fetch_bpls_address_settings_dt.php",
                type: "post",
                data:{"page":"reg"}
            }
        });
    });
        </script>
    <?php
}
    ?>
    <!-- brgy Modal -->
<div id="myModal_brgy" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header  bg-success">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="box box-success">
                    <div class="box-header">
                        <h4>BARANGAY SETTINGS</h4>
                    </div>
                    <div class="box-body">
                        <form method='POST' action="">
                             <div class="form-group">
                                    <label for="">Province:</label>
                                   <select name="prov_code" class="form-control selectpicker" id="prov_in_brgy" required>
                                       <option value="">--Select Province--</option>
                                        <?php
                                            $q = mysqli_query($conn,"SELECT * from 	geo_bpls_province");
                                            while($r = mysqli_fetch_assoc($q)){
                                            ?>
                                                <option value="<?php echo $r["province_code"];  ?>"> <?php echo $r["province_desc"];  ?>  </option>
                                            <?php
                                            }
                                        ?>
                                   </select>
                             </div>
                             <div class="form-group">
                                    <label for="">Lgu:</label>
                                   <select name="lgu_code" class="form-control selectpicker" id="lgu_in_brgy" required>
                                        <option value="">--Select Province First--</option>
                                   </select>
                             </div>
                             <div class="form-group">
                                    <label for="">Barangay Desc:</label>
                                    <input type="text" class="form-control" name="brgy_desc" required>
                             </div>
                             <div class="form-group">
                                    <label for="">Psg Code:</label>
                                    <input type="text" class="form-control" name="psg_code" required>
                             </div>
                             
                             <div class="form-group">
                                    <input type="submit" class="form-control btn btn-success"  name="brgy_btn" >
                             </div>         
                        </form>
                    </div>
                </div>
      </div>
    </div>
  </div>
</div>
    </div>
</div>


<!-- The Modal -->
<div class="modal" id="myModal_loc">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> <span class="edit_header"> </span> </h4>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <span class="edit_body"></span>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
<script>
    // update loc
      // update fee 
    $(document).on("click",".edit_btn",function(){
        var ca_loc = $(this).attr("ca_loc");
        var ca_title = $(this).attr("ca_title");
        var ca_data = $(this).attr("ca_data");

        $(".edit_header").html("Edit "+ca_title);
        $('#myModal_loc').modal('show');
        $.ajax({
                type:'POST',
                url:'bpls/edit_section/bpls_edit_address_settings.php',
                dataType:"HTML",
                data:{ca_data:ca_data,ca_loc:ca_loc},
                success:function(result){
                    $(".edit_body").html(result);
                    $(".selectpicker").selectpicker("refresh");
                }
            });

    });

    // delete loc
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

    $(document).on("change","#reg_in_lgu",function(){
       var val = $(this).val();
       var target ="REG";
       $.ajax({
        type: 'POST',
        url: 'bpls/ajax_address_settings.php',
        dataType:'HTML',
        data: { val: val, target: target},
        success:function(result) {
            $("#prov_in_lgu").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
        });
    });

     $(document).on("change","#reg_in_brgy",function(){
       var val = $(this).val();
       var target ="REG";
       $.ajax({
        type: 'POST',
        url: 'bpls/ajax_address_settings.php',
        dataType:'HTML',
        data: { val: val, target: target},
        success:function(result) {
            $("#prov_in_brgy").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
        });
    });

       $(document).on("change","#prov_in_brgy",function(){
       var val = $(this).val();
       var target ="PROV";
       $.ajax({
        type: 'POST',
        url: 'bpls/ajax_address_settings.php',
        dataType:'HTML',
        data: { val: val, target: target},
        success:function(result) {
            $("#lgu_in_brgy").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
        });
    });
    $(document).on("change","#prov_in_brgy_u",function(){
       var val = $(this).val();
       var target ="PROV";
       $.ajax({
        type: 'POST',
        url: 'bpls/ajax_address_settings.php',
        dataType:'HTML',
        data: { val: val, target: target},
        success:function(result) {
            $("#lgu_in_brgy_u").html(result);
            $('.selectpicker').selectpicker('refresh');
        }
        });
    });
</script>

<?php
    // address saving
    if(isset($_POST["reg_btn"])){

        $region_code = validate_str($conn,$_POST["reg_code"]);
        $region_desc = validate_str($conn,$_POST["reg_desc"]);
        $psg_code =  validate_str($conn,$_POST["psg_code"]);

        mysqli_query($conn,"INSERT INTO `geo_bpls_region`(`region_code`, `region_desc`, `psg_code`) VALUES ('$region_code','$region_desc','$psg_code') ") or die(mysqli_error());
        ?>
        <script>
            myalert_warning_af("Region Successfully Inserted!","bplsmodule.php?redirect=address_settings");
        </script>
        <?php
    }

    if(isset($_POST["up_reg_btn"])){
        $region_code1 = validate_str($conn,$_POST["reg_code1"]);
        $region_code = validate_str($conn,$_POST["reg_code"]);
        $region_code = validate_str($conn,$_POST["reg_code"]);
        $region_desc = validate_str($conn,$_POST["reg_desc"]);
        $psg_code =  validate_str($conn,$_POST["psg_code"]);
        mysqli_query($conn,"UPDATE geo_bpls_region set region_code ='$region_code', region_desc='$region_desc', psg_code = '$psg_code' where region_code = '$region_code1' ") or die(mysqli_error());
        ?>
        <script>
            myalert_warning_af("Region Successfully Updated!","bplsmodule.php?redirect=address_settings");
        </script>
        <?php
    }


    if(isset($_POST["prov_btn"])){

        $region_code = validate_str($conn,$_POST["reg_code"]);
        $prov_code = validate_str($conn,$_POST["prov_code"]);
        $prov_desc = validate_str($conn,$_POST["prov_desc"]);
        $psg_code =  validate_str($conn,$_POST["psg_code"]);

        mysqli_query($conn,"INSERT INTO `geo_bpls_province`(`province_code`, `region_code`, `province_desc`, `psg_code`) VALUES ('$prov_code','$region_code','$prov_desc','$psg_code') ") or die(mysqli_error());
        ?>
        <script>
            myalert_warning_af("Province Successfully Inserted!","bplsmodule.php?redirect=address_settings");
        </script>
        <?php
    }

    if(isset($_POST["up_prov_btn"])){

        $region_code = validate_str($conn,$_POST["reg_code"]);
        $prov_code = validate_str($conn,$_POST["prov_code"]);
        $prov_code1= validate_str($conn,$_POST["prov_code1"]);
        $prov_desc = validate_str($conn,$_POST["prov_desc"]);
        $psg_code =  validate_str($conn,$_POST["psg_code"]);

        mysqli_query($conn,"UPDATE `geo_bpls_province` SET province_code = '$prov_code',region_code='$region_code', province_desc ='$prov_desc', psg_code ='$psg_code' where province_code = '$prov_code1' ") or die(mysqli_error());
        ?>
        <script>
            myalert_warning_af("Province Successfully Updated!","bplsmodule.php?redirect=address_settings");
        </script>
        <?php
    }

    if(isset($_POST["lgu_btn"])){

        $lgu_code = validate_str($conn,$_POST["lgu_code"]);
        $lgu_desc = validate_str($conn,$_POST["lgu_desc"]);
        $prov_code = validate_str($conn,$_POST["prov_code"]);
        $psg_code =  validate_str($conn,$_POST["psg_code"]);
        $lgu_zip =  validate_str($conn,$_POST["lgu_zip"]);

        mysqli_query($conn,"INSERT INTO `geo_bpls_lgu`(`lgu_code`, `province_code`, `psg_code`, `lgu_desc`, `lgu_zip`) VALUES ('$lgu_code','$prov_code','$psg_code','$lgu_desc','$lgu_zip') ") or die(mysqli_error());
        ?>
        <script>
            myalert_warning_af("LGU Successfully Inserted!","bplsmodule.php?redirect=address_settings");
        </script>
        <?php
    }
    
    
    if(isset($_POST["up_lgu_btn"])){

        $lgu_code1 = validate_str($conn,$_POST["lgu_code1"]);
        $lgu_code = validate_str($conn,$_POST["lgu_code"]);
        $lgu_desc = validate_str($conn,$_POST["lgu_desc"]);
        $prov_code = validate_str($conn,$_POST["prov_code"]);
        $psg_code =  validate_str($conn,$_POST["psg_code"]);
        $lgu_zip =  validate_str($conn,$_POST["lgu_zip"]);

        mysqli_query($conn,"UPDATE `geo_bpls_lgu` SET lgu_code = '$lgu_code',province_code = '$prov_code',psg_code = '$psg_code',lgu_desc ='$lgu_desc',lgu_zip = '$lgu_zip' where lgu_code = '$lgu_code1' ") or die(mysqli_error());
        ?>
        <script>
            myalert_warning_af("LGU Successfully Updated!","bplsmodule.php?redirect=address_settings");
        </script>
        <?php
    }

    if(isset($_POST["brgy_btn"])){

        $lgu_code = validate_str($conn,$_POST["lgu_code"]);
        $brgy_desc = validate_str($conn,$_POST["brgy_desc"]);
        $psg_code =  validate_str($conn,$_POST["psg_code"]);

        mysqli_query($conn,"INSERT INTO `geo_bpls_barangay`( `lgu_code`, `barangay_desc`, `psg_code`, `garbage_zone`)  VALUES ('$lgu_code','$brgy_desc','$psg_code',0) ") or die(mysqli_error());
        ?>
        <script>
            myalert_warning_af("Barangays Successfully Inserted!","bplsmodule.php?redirect=address_settings");
        </script>
        <?php
    }

    if (isset($_POST["up_brgy_btn"])) {

    $barangay_id = validate_str($conn, $_POST["barangay_id"]);
    $lgu_code = validate_str($conn, $_POST["lgu_code"]);
    $brgy_desc = validate_str($conn, $_POST["brgy_desc"]);
    $psg_code = validate_str($conn, $_POST["psg_code"]);

    mysqli_query($conn, "UPDATE `geo_bpls_barangay` SET barangay_desc = '$brgy_desc', psg_code = '$psg_code' where barangay_id = '$barangay_id' ") or die(mysqli_error());
    ?>
        <script>
            myalert_warning_af("Barangay Successfully Updated!","bplsmodule.php?redirect=address_settings");
        </script>
        <?php
}

?>