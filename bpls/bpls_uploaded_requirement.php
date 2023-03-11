<div class="box box-primary">
    <div class="box-header">
      List of Uploaded Business Requirements
    </div>
    <div class="box-body">
        <table id="bpls_entries_dt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>Filename</th>
                    <th>Owner</th>
                    <th>Business</th>
                    <th>Document Type</th>
                    <th>Transaction Status</th>
                    <th>Date of Application</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

 
                    <!-- view doc Modal -->
                    <div class="modal fade" id="view_doc" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <!-- body start -->
                                            <div class="fetch_view_doc"> </div>
                                    <!-- body end -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger pull-left"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                  <!-- view doc Modal -->
<script>

$(document).ready(function(){
    var dataTable = $('#bpls_entries_dt').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            url: "bpls/dataTables/upload_docs_history.php",
            type: "post",
            data:{"page":"entries"}
        }
    });
});

$(document).on("click",".view_doc_btn",function(){
    requirements_history_id = $(this).attr("requirements_history_id");
    transaction_status = $(this).attr("transaction_status");
    filename = $(this).attr("filename");
    
		$.ajax({
			method:"POST",
			url:"bpls/upload_history_online_verify_doc.php",
			data:{requirements_history_id:requirements_history_id, transaction_status:transaction_status, filename:filename},
			success:function(result){
				$(".fetch_view_doc").html(result);
			}
		});
	});

</script>