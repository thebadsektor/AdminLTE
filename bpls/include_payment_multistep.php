
<?php
$treasury = "SELECT * from permission_tbl where uname='$username' and module='Treasury Module'";
$treasury_result = mysqli_query($conn, $treasury);
$treasury_count = mysqli_num_rows($treasury_result);
?>

<div class="panel-group" style="cursor:pointer;">
    <div class="panel panel-default">
        <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
            data-toggle="collapse" href="#collapse1aO12" aria-expanded="true">
            BUSINESS PERMIT AND LICENSING SYSTEM
        </div>
        <div id="collapse1aO12" class="panel-collapse collapse in" aria-expanded="true">
            <div class="row" style="margin:2px;">
                <div class="col-md-6">
                   <table class="table">
                        <tr>
                            <td style="width:150px;"><b>Business Name:</b></td>
                            <td> <span class="business_name_mess "> </span> </td>
                        </tr>
                        <tr>
                            <td><b>Business Address:</b></td>
                            <td><?php echo $business_address; ?></span> </td>
                        </tr>
                        <tr>
                            <td style="width:150px;"><b>Owners Name:</b></td>
                            <td> <span class="owners_name_mess "></span> </td>
                        </tr>
                        <tr>
                            <td><b>Owners Address:</b></td>
                            <td><?php echo $owner_address; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <td style="width:150px;"><b>Application Date:</b></td>
                            <td><?php echo $r11["permit_application_date"]; ?></td>
                        </tr>
                        <tr>
                            <td><b>Payment Mode:</b></td>
                            <td><?php echo $mode_of_payment; ?></td>
                        </tr>
                        <tr>
                            <td style="width:150px;"><b>Application Type:</b></td>
                            <td><?php echo $status_desc; ?></td>
                        </tr>
                        <tr>
                            <td><b>Step:</b></td>
                            <td><?php echo $step_code; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- header info -->

<div class="row">
    <div class="col-md-9">
    <!-- Payment Schedule -->
    <!-- Payment Schedule -->
    <?php
     include "include_payment_schedule.php";
    ?>
    <!-- Payment Schedule -->
    <!-- Payment Schedule -->


        <!-- Payment sTATUS  -->
        <div class="panel-group" style="cursor:pointer;">
            <div class="panel panel-default">
                <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
                    data-toggle="collapse"  aria-expanded="true">
                    PAYMENT STATUS
                </div>
                <div  class="panel-collapse collapse in" aria-expanded="true">
                <div class="row" style="margin:2px; margin-top:5px; text-align:center;">

                <?php

            // echo $paid_tax;
            $fully_paid = 0;

            if($mode_of_payment == "Quarterly") {
                // echo $paid_tax."|".$amount_tax;
                $q555 = mysqli_query($conn,"SELECT payment_part  FROM `geo_bpls_payment` where permit_id = '$permit_id_dec' ORDER BY `payment_part` DESC LIMIT 1  ");
                if(mysqli_num_rows($q555)>0){
                    $r555 = mysqli_fetch_assoc($q555);
                    $paid_qtr = $r555["payment_part"];
                }else{
                    $paid_qtr = 0;
                }

                if($paid_qtr >=4){
                    $fully_paid = 1;
                }

                ?>
                <div class="col-md-3" style="<?php if ($paid_qtr >= 1) {echo "background:green;";} else {echo "background:red;";}?> color:white;">
                    <h3>Q1</h3>
                </div>
               <div class="col-md-3" style="<?php if ($paid_qtr >= 2) {echo "background:green;";} else {echo "background:red;";}?> color:white;">
                    <h3>Q2</h3>
                </div>
                <div class="col-md-3" style="<?php if ($paid_qtr >= 3) {echo "background:green;";} else {echo "background:red;";}?> color:white;">
                    <h3>Q3</h3>
                </div>
                <div class="col-md-3" style="<?php if ($paid_qtr >= 4) {echo "background:green;";} else {echo "background:red;";}?> color:white;">
                    <h3>Q4</h3>
                </div>
                <?php

                }elseif($mode_of_payment == "Semi-annual"){
                // echo $paid_tax."|".$amount_tax;

                    $q555 = mysqli_query($conn,"SELECT sum(payment_part) as total_count_paid FROM `geo_bpls_payment` where permit_id = '$permit_id_dec'");
                    if(mysqli_num_rows($q555)>0){
                        $r555 = mysqli_fetch_assoc($q555);
                        $paid_qtr = $r555["total_count_paid"];
                    }else{
                        $paid_qtr = 0;
                    }
                    
                    if($paid_qtr >=2){
                        $fully_paid = 1;
                    }
                ?>
                
                <div class="col-md-6" style="<?php if($paid_qtr >=1 ){ echo "background:green;"; }else{ echo "background:red;"; } ?> color:white;">
                    <h3>Semi-Annual 1</h3>
                </div>
               <div class="col-md-6" style="<?php if ($paid_qtr >=2 ) {echo "background:green;";} else {echo "background:red;";} ?> color:white;">
                    <h3>Semi-Annual 2</h3>
                </div>
                <?php
                
                }else{
                $check_amount_tax = mysqli_query($conn, "SELECT  sum(assessment_tax_due)as bbb FROM `geo_bpls_assessment`  where   permit_id = '$permit_id_dec' ");
                $check_amount_tax_row = mysqli_fetch_assoc($check_amount_tax);

                $check_paid_tax = mysqli_query($conn, "SELECT payment_tax + payment_fee as total_paid_tax FROM `geo_bpls_payment` where    permit_id = '$permit_id_dec'  ");
                $check_paid_tax_row = mysqli_fetch_assoc($check_paid_tax);
                
                if(mysqli_num_rows($check_paid_tax)>0){
                    $a = $check_paid_tax_row["total_paid_tax"];
                }else{
                    $a = 0;
                }
                    // echo 
                    $a = str_replace(',','',number_format($check_amount_tax_row["bbb"],2));
                    $b = str_replace(',','',number_format($a,2));
                    $paid_qtr = 0;
                    if ($a == $b) {
                        $paid_qtr = 1;
                        $fully_paid = 1;
                    }
                    ?>
                <div class="col-md-12" style="<?php if ($paid_qtr >= 1) {echo "background:green;";} else {echo "background:red;";}?> color:white;">
                    <h3>Annual</h3>
                </div>

                <?php
                }
           
          
            ?>

            </div>
                </div>
            </div>
        </div>
        <!-- Payment STATUS -->

        <!-- PAYMENTS HISTORY -->
        <div class="panel-group" style="cursor:pointer;">
            <div class="panel panel-default">
                <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
                    data-toggle="collapse" href="#collapse9182" aria-expanded="true">
                    PAYMENTS HISTORY
                </div>
                <div id="collapse9182" class="panel-collapse collapse in" aria-expanded="true">
                    <table class="table">
                        <tr>
                            <td><b>Date of Payment</b></td>
                            <td><b>OR/Control No</b></td>
                            <td><b>Amount Paid</b></td>
                            <td><b>Received By</b></td>
                            <td> </td>
                        </tr>
                         <?php
            $q = mysqli_query($conn, "SELECT payment_backtax, payment_surcharge, payment_id, or_no, payment_date, payment_total_amount_paid, updated_by FROM `geo_bpls_payment` WHERE md5(permit_id) = '$id'");
            $q_count = mysqli_num_rows($q);
            if ($q_count > 0) {
                while ($r = mysqli_fetch_assoc($q)) {
        ?>
           <tr>
             <td><?php echo $r["payment_date"]; ?></td>
                <td><?php echo $r["or_no"]; ?></td>
                    <td><?php echo $r["payment_total_amount_paid"];
        if ($r["payment_surcharge"] != null) {
            if ($r["payment_surcharge"] != 0) {
                echo " &nbsp; <i>with surcharges(<span style='color:red;'> " . $r["payment_surcharge"] . "</span>)</i>";

            }

        }
        if ($r["payment_backtax"] != null) {
            if ($r["payment_backtax"] != 0) {
                eval( '$backtax = (' . $r["payment_backtax"]. ');' );
                echo " &nbsp; <i>with backtaxes(<span style='color:red;'> " . $backtax . "</span>)</i>";

            }

        }
        ?></td>
                            <td><?php echo $r["updated_by"]; ?></td>
                            <td>
                        <?php 
                        if($treasury_count ==1){
                        ?>
                            <div class="btn-group">
                                <a href="bpls/pdf_excel/51cbpls_or.php?target=<?php echo $r["payment_id"]; ?>&target2=<?php echo $id; ?>" target="_blank"> <button class='btn btn-success' >    <i class='fa fa-file-pdf-o'></i></button> </a>
                            <a href="bpls/pdf_excel/51cbpls_or_data.php?target=<?php echo $r["payment_id"]; ?>&target2=<?php echo $id; ?>" target="_blank"> <button class='btn btn-info' >  <i class='fa fa-file-pdf-o'></i></button> </a>
                            </div>
                         <?php
                            }
                         ?>
                            </td>
                        </tr>
                        <?php

}
}
?>

                    </table>
                </div>
            </div>
        </div>


    </div>
    <?php 


        if($treasury_count == 1){
        if($fully_paid != 1){

            // check if pai as a backtax
            $q565d = mysqli_query($conn,"SELECT * FROM geo_bpls_payment_paid_backtax where permit_id = '$permit_id_dec' ");
            if(mysqli_num_rows($q565d) == 0){
            ?>
        <div class="col-md-3" style="text-align:center;">
            <button class="btn btn-success" style="width:100px; height:100px; margin-top:15px;" title="Proceed to Payment" data-toggle="modal"   data-target="#payments_modal">
                <i class="fa fa-money" style="font-size:50px;"> </i>
            </button>
        </div>
            <?php
            }else{
                ?>
             <div class="col-md-3" style="text-align:center;">
                    <div class="alert alert-info"><h3>This Business is Paid as a backtax</h3></div>
                     <button class="btn btn-success" style="width:100px; height:100px; margin-top:15px;" title="Proceed to Payment" disabled>
                <i class="fa fa-money" style="font-size:50px;"> </i>
                                    </button>
             </div>
                <?php
            }
        }
        }
            ?>


</div>
<!--PAYMENTS HISTORY -->