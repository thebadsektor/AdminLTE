
<div class="box">
    <div class="box-header">
            <button class="btn btn-primary pull-right" data-toggle='modal' data-target='#create_sub'>Activate Tax/Fees/Collection</button>
        <h3>Active Tax/Fees in Business Permit</h3>

    </div>
    <div class="box-body table-responsive">
        <table id="tb_a" class="table table-bordered table-striped " style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>Fees/Collection</th>
                    <th>Chart of Account No.</th>
                    <th>Chart of Account Name.</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<form method="POST" action="">
<!-- Modal -->
<div id="create_sub" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title ">Activate Tax/Fees/Collection</h4>
      </div>
      <div class="modal-body">
      <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                            <label for="">Nature of Collection: </label>
                            <select name="naturecollection_id" class="form-control selectpicker" data-live-search="true" required>
                                <option value="">--Select Nature of Collection -- </option>
                                <?php
                                    $q = mysqli_query($conn,"SELECT * from natureOfCollection_tbl");
                                    while($r = mysqli_fetch_assoc($q)){
                                        ?>
                                    <option value="<?php echo $r["id"]; ?>"><?php echo $r["name"]; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                     </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
        <button type="submit" name="create_btn" class="btn btn-success">Add</button>
      </div>
    </div>

  </div>
</div>
</div>
</form>

<!-- view Modal --> 
<div id="view_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Refer Details</h4>
      </div>
      <div class="modal-body">
            <div class="view_modal_details"></div>     
        <h4><b>Printables</b></h4>
        <ul>
            <li><a href="#" ca_target="t1" class="printables_btn1" target="_blank">Certification Philhealth</a></li>
            <li><a href="#" ca_target="t2" class="printables_btn2" target="_blank" >Clerical Error </a></li>
            <!-- <li><a href="#" ca_target="t3" class="printables_btn3" target="_blank" >Certificate of Indigency</a></li> -->
            <li><a href="#" ca_target="t4" class="printables_btn4"  target="_blank">Certificate of Indigency - Registration</a></li>
            <li><a href="#" ca_target="t5"  class="printables_btn5" target="_blank">Certificate of Indigency - Scholarship</a></li>
        </ul>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- view Modal -->

<script>
    $(document).on("click",".rm_active_tax",function(){
        ca_target = $(this).attr("ca_target");
        if(confirm("Are you sure you want to deactivate this tax/fee?")){
        $.ajax({
            method:"POST",
            url:"bpls/delete_section/delete_active_tax_collection.php",
            dataType:"html",
            data:{ca_target:ca_target},
            success:function(result){
                 if(result == 1){
                    alert("Tax/Fees/Collection Deactivated");
                    location.replace("bplsmodule.php?redirect=active_nature_collection");
                 }
            }   
        });
    }
    });
$(document).ready(function(){
    var dataTable = $('#tb_a').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [
                [1, "asc"]
            ],
            "ajax": {
                url: "bpls/dataTables/active_tax_collection.php",
                type: "post",
            }
        });
    });
</script>

<?php
if(isset($_POST["create_btn"])){
        include 'jomar_assets/input_validator.php';
        $naturecollection_id = validate_str($conn, $_POST["naturecollection_id"]);

        $q = mysqli_query($conn," INSERT INTO `geo_bpls_active_tfo`( `naturecollection_id`) VALUES ('$naturecollection_id') ") or  die(mysqli_error($conn));
        ?>
            <script>
                alert("Tax/Fees/Collection Activated!");
                window.location.replace("bplsmodule.php?redirect=active_nature_collection");
            </script>
        <?php
    }
?>
