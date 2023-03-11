<div class="box">
    <div class="box-header">
        
    </div>
    <div class="box-body">


        <table id="bpls_payment_dt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>Permit Number</th>
                    <th>Owner</th>
                    <th>Business</th>
                    <th>Application Type</th>
                    <th>Step</th>
                    <th>Payment Mode</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
<input type="hidden" class="year1111" value="<?php echo $_GET["year"]; ?>" >
<script>
$(document).ready(function(){

    var year = $(".year1111").val();
    var dataTable = $('#bpls_payment_dt').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [
            [1, "asc"]
        ],
        "ajax": {
            url: "bpls/dataTables/fetch_bpls_payment_dt.php",
            type: "post",
            data:{"year":year}
        }
    });
});
</script>