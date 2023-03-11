<div class="box box-primary">
    <div class="box-header">
        Online Business Application
    </div>
    <div class="box-body">
        <table id="bpls_entries_dt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>Owner</th>
                    <th>Business</th>
                    <th>Step</th>
                    <th>Application Status</th>
                    <th style='width:16%;'>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="myModal_req" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Requirement</h4>
      </div>
      <div class="modal-body">
        <div class="req_stat">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
    $(document).on("click",".btn_eye_status",function(){
        ca_uniqID = $(this).attr("ca_uniqID");
          $.ajax({
            type:'POST',
            url:'eboss/ajax_fetch_req_status.php',
            data:{ca_uniqID:ca_uniqID},
            success:function(result){
                $(".req_stat").html(result)
            }
        });
    });


$(document).ready(function(){
    var dataTable = $('#bpls_entries_dt').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            url: "bpls/dataTables/ol_entries.php",
            type: "post",
            data:{"page":"entries"}
        }
    });
});
</script>