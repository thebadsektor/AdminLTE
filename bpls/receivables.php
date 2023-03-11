<div class="box">
    <div class="box-header">
        <h4>Unpaid Business</h4> 
        <form action="" method="POST">
           <div class="form-group">
                <label for="">Year</label>
                 <select class="year">
                        <option value="">SELECT YEAR</option>
                     <?php
                        $q003 = mysqli_query($conn,"SELECT DISTINCT permit_for_year FROM `geo_bpls_business_permit`");
                        while($r003 = mysqli_fetch_assoc($q003)){
                            ?>
                                <option <?php if(isset($_GET["year"])){ if($_GET["year"] == $r003["permit_for_year"] ){ echo "selected"; } } ?>><?php echo $r003["permit_for_year"]; ?></option>
                            <?php
                        }
                     ?>
                </select>
                <script>
                    $(document).on("change",".year",function(){
                        year = $(this).val()
                        location.replace("bplsmodule.php?redirect=receivables&year="+year);
                    })
                </script>
           </div>
        </form>
    </div>
    <div class="box-body">

        <table id="rec_dt" class="table table-bordered table-striped" style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
                <tr>
                    <th style='width:15%;' >PERMIT NO</th>
                    <th>BUSINESS NAME</th>
                    <th>UNPAID AMOUNT</th>
                    <th>ACTION</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
<script>
$(document).ready(function(){

    year = $(".year").val();
    var dataTable = $('#rec_dt').DataTable({
        "processing": true,
        "serverSide": true,
         "pageLength" : 100,
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            url: "bpls/dataTables/fetch_bpls_receivables_dt.php",
            type: "post",
            data:{"page":"entries","year":year}
        }
    });
});
</script>