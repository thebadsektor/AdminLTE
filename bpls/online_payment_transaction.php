<div class="box">
    <div class="box-header">
       <h4> BUSINESS PAID ONLINE</h4>
    </div>
    <div class="box-body">


        <table id="bpls_entries_dt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th>Order ID</th>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Product Description</th>
                    <th>Transation Time</th>
                    <th>Reference Number</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th style='width:17.5%;'>Action</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
<!-- Modal -->
<div id="modal_view" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header  bg-success">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">ONLINE PAYMENT</h4>
      </div>
      <div class="modal-body">
        <div class="fetch_here">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- The Modal -->


<script>



$(document).on("click",".view_btn",function(){
    order_no =  $(this).attr("order_no");
    $.ajax({
        type: 'POST',
        url: 'bpls/ajax_fetch_order_payment_details.php',
        dataType:'HTML',
        data: {
            order_no: order_no
        },
         success: function(result) {
                $(".fetch_here").html(result);
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
            url: "bpls/dataTables/ol_payment_transaction.php",
            type: "post",
            data:{"page":"entries"}
        }
    });
});
</script>