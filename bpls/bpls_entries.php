<div class="box">
    <div class="box-header">
        
    </div>
    <div class="box-body">


        <table id="bpls_entries_dt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th style='width:15%;' >Permit Number</th>
                    <th>Owner</th>
                    <th>Business</th>
                    <th>Application Type</th>
                    <th>Step</th>
                    <th>Payment Mode</th>
                    <th style='width:17.5%;'>Action</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
<script>
$(document).ready(function(){
    var dataTable = $('#bpls_entries_dt').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            url: "bpls/dataTables/fetch_bpls_entries_dt.php",
            type: "post",
            data:{"page":"entries"}
        }
    });

   
});
$(document).on("click",".reset_btn",function(){
    ca_id = $(this).attr("ca_id");
    if(confirm("Are you sure do you want to reset this business")){

    }
    $.ajax({
        method:"POST",
        url:"bpls/ajax_reset_business.php",
        data:{ca_id:ca_id},
        success:function(result){
            if(result == 0){
                alert("Business Successfully reset");
                location.replace("bplsmodule.php?redirect=business_entries");
            }else{
                alert("Failed to reset Business");
                location.replace("bplsmodule.php?redirect=business_entries");
            }
        }
    })
});
</script>