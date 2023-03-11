<div class="box">
    <div class="box-header">
        
    </div>
    <div class="box-body">
  
<?php
if (isset($_POST["to"])) {
    $to = $_POST["to"];
} else {
    $aavv = date("Y")-3;
    $to = $aavv."-"."01-01";
}
if (isset($_POST["from"])) {
    $from = $_POST["from"];
} else {
  $aavv = date("Y");
  $from = $aavv . "-" . "12-31";
}

?>


   <form method="POST" action="">
    <input type="hidden" class="status" name="status" value="<?php echo $status; ?>">
        <div class="row" style="background:#b8b8b8; margin:0px; margin-bottom:20px;">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="date" class="form-control to" name="to" value="<?php echo $to; ?>" style="margin-top:15px;">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="date" class="form-control from" name="from" value="<?php echo $from; ?>" style="margin-top:15px;">
                </div>
            </div>
            <div class="col-md-4">
             <div class="form-group">
                    <input type="submit" class="form-control btn btn-primary" name="range_btn" value="Update" style="margin-top:15px;">
                </div>
            </div>
        </div>
    </form>


        <table id="bpls_entries_dt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th style='width:15%;' >Permit Number</th>
                    <th>Owner</th>
                    <th>Business</th>
                    <th>Application Type</th>
                    <th>Step</th>
                    <th>Payment Mode</th>
                    <th style='width:20%;' >Action</th>
                </tr>
            </thead>
        </table>

    </div>
</div>

 
<script>
     $(document).on("click",".retire_btn",function(){
        var b_name = $(this).attr("ca_attr_business_name");
        var ca_attr = $(this).attr("ca_attr");
        $(".business_name").html(b_name); 
        $(".permit_id").val(ca_attr); 
        
    });
    // validate renew
$(document).on("click",".renew_btn",function(){
        var target = $(this).attr("ca_target");
        var ca_business = $(this).attr("ca_business");

      myalert_success("Renew this "+ca_business+" Business?");
      $('.modal-open').css({"overflow":"visible","padding-right":"0px"});
    $(".s35343_btn").click(function() {
        location.replace("bplsmodule.php?redirect=business_renewal&target=ren_"+target);
    });
    $(".s64534_btn").click(function() {
        // $('#myModal_alert_w').modal('hide');
        $('#myModal_alert_s').remove();
        $('.modal-backdrop').remove();
        // add for datatbales disabled scrol and padding-right;
        $('.modal-open').css({"overflow":"visible","padding-right":"0px"});

    });
});

    // validate retire
$(document).on("click",".retire_btn",function(){
        var target = $(this).attr("ca_target");
        var ca_business = $(this).attr("ca_business");

      myalert_danger("Are you sure do you want to close "+ca_business+"?");
      $('.modal-open').css({"overflow":"visible","padding-right":"0px"});
    $(".d35343_btn").click(function() {
        location.replace("bplsmodule.php?redirect=business_renewal&target=ret_"+target);
    });
    $(".d64534_btn").click(function() {
        // $('#myModal_alert_w').modal('hide');
        $('#myModal_alert_s').remove();
        $('.modal-backdrop').remove();
        // add for datatbales disabled scrol
        $('.modal-open').css({"overflow":"visible","padding-right":"0px"});
    });
});

$(document).ready(function(){
    var year_to = $(".to").val();
    var year_from = $(".from").val();

    var dataTable = $('#bpls_entries_dt').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            url: "bpls/dataTables/fetch_bpls_entries_dt.php",
            type: "post",
            data:{"page":"renewal","to":year_to,"from":year_from,"status":status},
        }
    });
});
</script>