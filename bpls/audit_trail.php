<div class="box box-primary">
    <div class="box-header">
        
   <form method="POST" action="">
        <?php
        if (isset($_POST["to"])) {
            $form = $_POST["to"];
        } else {
            $aavv = date("Y");
            $form = $aavv."-"."01-01";
        }
        if (isset($_POST["from"])) {
            $to = $_POST["from"];
        } else {
        $aavv = date("Y");
        $to = $aavv . "-" . "12-31";
        }
        ?>
    <input type="hidden" class="status" name="status" value="<?php echo $status; ?>">
        <div class="row" style="background:#b8b8b8; margin:0px; margin-bottom:25px;">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">From</label>
                <input type="date" class="form-control from" name="from" value="<?php echo $from; ?>" >
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                <label for="">To</label>
                <input type="date" class="form-control to" name="to" value="<?php echo $to; ?>" >
                </div>
            </div>
            <div class="col-md-4">
             <div class="form-group">
                <label for=""> &nbsp; &nbsp; </label>
                    <input type="submit" class="form-control btn btn-primary" name="range_btn" value="Filter">
                </div>
            </div>
        </div>
    </form>
    </div>
    <div class="box-body">

        <table id="tbl_1" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>Datetime</th>
                    <th>Username</th>
                    <th>Action</th>
                    <th>Description</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
   
$(document).ready(function(){
    var year_to = $(".to").val();
    var year_from = $(".from").val();
    var dataTable = $('#tbl_1').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            url: "bpls/dataTables/bpls_audit_trail.php",
            type: "post",
            data:{"to":year_to,"from":year_from},
        }
    });
});
</script>