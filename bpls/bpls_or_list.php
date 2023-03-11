<div class="box">
    <div class="box-header">
        
    </div>
    <div class="box-body">
   <h4>BPLS Active OR list</h4>

<?php
    if(isset($_POST["to"])){
        $to = $_POST["to"];
    }else{
        $to = date("Y-m-d");
    }


    if(isset($_POST["from"])){
        $from = $_POST["from"];
    }else{
        $from =  date("Y-m-d");
    }

    if(isset($_POST["status"])){
        $status = $_POST["status"];
    }else{
        $status = $_GET["status"];
    }
?>
   <form method="POST" action="">
    <input type="hidden" class="status" name="status" value="<?php echo $status; ?>">
        <div class="row" style="background:#d9d8d7; margin:0px; margin-bottom:10px;">
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
        <table id="bpls_or_list_dt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>OR Number</th>
                    <th>OR Date</th>
                    <th>Payor</th>
                    <th>Payor Amount</th>
                    <th style="width:150px;">Action</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
<input type="hidden" class="year1111" value="<?php echo $_GET["year"]; ?>" >
<script>
$(document).ready(function(){

    var year_to = $(".to").val();
    var year_from = $(".from").val();
    var status = $(".status").val();
    var dataTable = $('#bpls_or_list_dt').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [
            [1, "asc"]
        ],
        "ajax": {
            url: "bpls/dataTables/fetch_bpls_or_list_dt.php",
            type: "post",
            data:{"to":year_to,"from":year_from,"status":status}
        }
    });
});

$(document).on("click",".void_btn",function(){
   target = $(this).attr("ca_target");
   if(confirm("Do you want to void this Receipt?")){
        location.replace(" bplsmodule.php?redirect=or_cancellation&target="+target);
   }
});
</script>