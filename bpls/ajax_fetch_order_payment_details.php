<?php
    include "../php/connect.php";
            $order_no = $_POST["order_no"];
                $q = mysqli_query($conn,"SELECT * FROM myeg_data where order_no = '$order_no' ");
                $r = mysqli_fetch_assoc($q);
                $payment_date = $r["transaction_time"];
                ?>
                <table class="table table-bordered">
                    <tr>
                        <td><b>Customer Name:</b> <?php echo $r["customer_name"]; ?></td>
                        <td><b>Order No.:</b> <?php echo $r["order_no"]; ?></td>
                    </tr>
                </table>
                 <table class="table table-bordered">

                <?php
                    // get business
                    $total_amount = 0;
                    $q1 = mysqli_query($conn,"SELECT * from geo_bpls_payment inner JOIN geo_bpls_paid_online on geo_bpls_paid_online.permit_id = geo_bpls_payment.permit_id where order_no = '$order_no' ");
                    while($r1 = mysqli_fetch_assoc($q1)){
                        $permit_id = $r1["permit_id"];
                        $or_no = $r1["or_no"];
                        ?>
                    <tr style="background:#96ff9a; ">
                        <td colspan="2"><b>
                    <span  style="float:left;" > 
                        <label for="">OR Number:</label> <?php echo $r1["or_no"]; ?>
                    </span>  </b> 
                </td>
                    </tr>
                   
                    <!-- get amount paid in business -->
                 <?php
                    $q2 =  mysqli_query($conn,"SELECT * from treasury_transactions where or_num = '$or_no'");
                    $total_amount_per_business = 0;
                     while($r2 = mysqli_fetch_assoc($q2)){
                         $total_amount_per_business += $r2["amount"];
                         $total_amount += $r2["amount"];
                    ?>
                    <tr>
                        <td><?php echo $r2["acc_title"]; ?></td>
                        <td style="text-align:right;">
                        <?php echo number_format($r2["amount"],2); ?>
                    
                    </td>
                    </tr>
                    <?php
                        }
                        ?>
                    <tr>
                        <td>Total Amount:</td>
                        <td style="text-align:right;" > <b> <?php echo number_format($total_amount_per_business,2); ?></b></td>
                    </tr>
                        <?php
                    }
                ?>
                    <tr>
                        <td>General Amount:</td>
                        <td style="text-align:right;" > <b> <?php echo number_format($total_amount,2); ?></b></td>
                    </tr>
                 </table>
           