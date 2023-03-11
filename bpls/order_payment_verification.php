<?php
include "jomar_assets/curl_fn.php";
include "jomar_assets/enc.php";
$order_no = $_GET["order_no"];

// check if na update na order payment
    $q6567 = mysqli_query($conn,"SELECT * FROM `geo_bpls_paid_online` where order_no = '$order_no'  ");
    $q6567_count = mysqli_num_rows($q6567);
    if($q6567_count > 0){
        ?>
        <script>
            alert("This Online payment is already updated!");
            location.replace("bplsmodule.php?redirect=online_payment_transaction");
        </script>
        <?php
    }
?>
<div class="box">
 
    <div class="box-body">
        <div class="row">
            <div class="col-md-12"> 
                <form method="POST" action="" id="update_or_form">
                <h3>Online Payment</h3> 
                <?php
                    $enc_pass = me_encrypt($uniq_password);
                    $url = $hostname . '/eServices/bpls/bpls_curl_receiver.php';
                    $data = array('task' => 'GET_ORDER_PAYMENT_DETAILS', 'enc_pass' => $enc_pass, 'order_no' => $order_no);
                    $res = c_s_req($data, $url, $enc_pass);
                    if($res == "0"){
                        ?>
                        <script>
                            location.replace("bplsmodule.php?redirect=order_payment_verification&order_no=<?php echo $order_no; ?>");
                        </script>
                        <?php
                    }else{
                    echo $res;
                    }
                ?>
                    <input type="hidden" id="cashier" value="<?php echo $_SESSION["uname"]; ?>">
                    <input type="submit" name="save_or" id="save_or" class="btn-success btn pull-right" value="UPDATE">
                </form>
            </div>
        </div>
    </div>
</div>

<script> 
    $(document).on('click','#save_or',function(){
        if(confirm("Do you want to update this online payment transaction?")){
        }else{
            event.preventDefault();
        }
    });

        // auto fill on change owners
$(document).on("change",".or_num",function(){
    var or_num = $(this).val();
    var cashier = $("#cashier").val();

    $.ajax({
        type: 'POST',
        url: 'bpls/or_validation.php',
        dataType:'JSON',
        data: {
            cashier: cashier,
            or_num: or_num
        },
         success: function(result) {
            if(result == 1){
                $("#save_or").prop("disabled",true);
                myalert_danger_af("This OR is not assign for you!","nothing");
            }else if(result == 2){
                $("#save_or").prop("disabled",true);
                myalert_danger_af("This OR is already used!","nothing");
            }else{
                $("#save_or").prop("disabled",false);
            }
        }
    });
});
</script>

<?php
    if(isset($_POST["save_or"])){
        
        include 'php/web_connection.php';
        $permit_id_count =  count($_POST["permit_id"]);
        $details_permit_id_count = count($_POST["details_permit_id"]);

        $error =0;
        for($a=0; $a<$permit_id_count; $a++){
            
                $permit_id = me_decrypt($_POST["permit_id"][$a]);
                $order_no = me_decrypt($_POST["order_no"][$a]);
                $or_no = $_POST["or_no"][$a];
                // for records at pang validate ng paid permit if online
                mysqli_query($conn,"INSERT INTO `geo_bpls_paid_online`(`order_no`, `permit_id`, `or_no`, `status`) VALUES ('$order_no','$permit_id','$or_no',0)");
                
                $backtax_permit_id = me_decrypt($_POST["permit_id23"][$a]);
                $backtax_amount = me_decrypt($_POST["backtax_amount23"][$a]);
                 if($backtax_permit_id != "no_backtax"){
                      // save paid backtaxes
                mysqli_query($conn, "INSERT INTO `geo_bpls_payment_paid_backtax`( `permit_id`, `backtax_amount`) VALUES ('$backtax_permit_id','$backtax_amount')");
                 }

                $payment_mode_code = me_decrypt($_POST["payment_mode_code"][$a]);
                $payment_backtax = me_decrypt($_POST["payment_backtax"][$a]);
                $payment_date = me_decrypt($_POST["payment_date"][$a]);
                $payment_fee = me_decrypt($_POST["payment_fee"][$a]);
                $payment_part = me_decrypt($_POST["payment_part"][$a]);
                $payment_surcharge = me_decrypt($_POST["payment_surcharge"][$a]);
                $payment_tax = me_decrypt($_POST["payment_tax"][$a]);
                $payment_total_amount_due = me_decrypt($_POST["payment_total_amount_due"][$a]);
                $payment_total_amount_paid = me_decrypt($_POST["payment_total_amount_paid"][$a]);
                $payment_year = me_decrypt($_POST["payment_year"][$a]);
                $payor = me_decrypt($_POST["payor"][$a]);
                $remarks = $_POST["remarks"][$a];
                $remarks = me_decrypt($remarks);
                $payment_desc = "";
                $penalty = "";
                $username = $_SESSION["uname"];
                $datetime = date("Y-m-d h:i:s");
                // save para sa payment
                $q = mysqli_query($conn,"INSERT INTO `geo_bpls_payment`( `or_no`, `permit_id`, `payment_mode_code`, `payment_backtax`, `payment_date`, `payment_desc`, `payment_fee`, `payment_part`, `payment_penalty`, `payment_surcharge`, `payment_tax`, `payment_total_amount_due`, `payment_total_amount_less`, `payment_total_amount_paid`, `payment_year`, `payor`, `remarks`, `updated_by`) VALUES ('$or_no','$permit_id','$payment_mode_code','$payment_backtax','$payment_date','$payment_desc','$payment_fee','$payment_part','$penalty','$payment_surcharge','$payment_tax','$payment_total_amount_due',null,'$payment_total_amount_paid','$payment_year','$payor','$remarks','$username') ");
                 
                $or_date = date("Y-m-d h:i:s");

                $q = mysqli_query($conn,"INSERT INTO `treasury_tbl`( `or_date`, `or_num`, `agency`, `fund_code`, `or_payor`, `payment_mode`, `order_no`, `drawee_check`, `num_check`, `date_check`, `num_order`, `date_order`, `status`, `department`, `remark`,  `payor_money`, `user_acc`, `created_at`, `edit_at`) VALUES ('$or_date','$or_no','Majayjay','100','$payor','cash','','','','','','','active','BPLS','$remarks','$payment_total_amount_paid','$username','$datetime','$datetime') ");

                if(!$q){
                  $error++;
                }
                //  getting last save id
            $q_id = mysqli_query($conn,"SELECT payment_id FROM `geo_bpls_payment` where or_no = '$or_no' ");
            $r_id = mysqli_fetch_assoc($q_id);
            $payment_id = $r_id["payment_id"];
            for($b=0; $b<$details_permit_id_count; $b++){
                $details_permit_id = me_decrypt($_POST["details_permit_id"][$b]);
                if($details_permit_id == $permit_id){
                    $nature_id = me_decrypt($_POST["nature_id"][$b]);
                    $sub_account_no = me_decrypt($_POST["sub_account_no"][$b]);
                    $sub_account_title = mysqli_real_escape_string($conn,me_decrypt($_POST["sub_account_title"][$b]));
                    $payment_amount = me_decrypt($_POST["payment_amount"][$b]);
                    $payment_type_code = me_decrypt($_POST["payment_type_code"][$b]);
                    
                    // save para sa payment details
                    $q = mysqli_query($conn, "INSERT INTO `geo_bpls_payment_detail`( `nature_id`, `payment_id`, `payment_type_code`, `sub_account_no`, `payment_amount`, `updated_by`, `updated_date`) VALUES ('$nature_id','$payment_id','$payment_type_code','$sub_account_no','$payment_amount','$username','$datetime' ) ");
                        // get uniqID 
                        $q0009 = mysqli_query($conn,"SELECT uniqID FROM `natureOfCollection_tbl` where id = '$sub_account_no'  ");
                        if(mysqli_num_rows($q0009)>0){
                                $r0009 = mysqli_fetch_assoc($q0009);
                                $uniqID = $r0009["uniqID"];
                        }else{
                            $uniqID = $sub_account_no;
                        }
                    mysqli_query($conn, "INSERT INTO `treasury_transactions`( `acc_title`, `acc_codes`, `quant`, `item_amt`, `amount`, `or_num`, `user_acc`, `created_at`) VALUE ('$sub_account_title','$uniqID',0,0,'$payment_amount','$or_no','$username','$datetime' )");

                    if($q){
                    }else{
                        echo "INSERT INTO `geo_bpls_payment_detail`( `nature_id`, `payment_id`, `payment_type_code`, `sub_account_no`, `payment_amount`, `updated_by`, `updated_date`) VALUES ('$nature_id','$payment_id','$payment_type_code','$sub_account_no','$payment_amount','$username','$datetime' ) ";
                      $error++;
                    }
                }
            }
            include 'php/web_connection.php';
              // Update Online Application in web and localserver STEP
              mysqli_query($wconn, "UPDATE `geo_bpls_ol_application` SET `step` = 'RELEASE' where permit_id = '$permit_id' ");
              mysqli_query($conn, "UPDATE `geo_bpls_ol_application` SET `step` = 'RELEASE' where permit_id = '$permit_id' ");
              mysqli_query($conn, "UPDATE `geo_bpls_business_permit` SET `step_code` = 'RELEA' where permit_id = '$permit_id' ");
        }

        if($error >0){
            echo "error";
        }else{
                ?>
                <script>
                    alert("Updating OR number in online payment has been completed");
                    location.replace("bplsmodule.php?redirect=online_payment_transaction");
                </script>
                <?php
        }

    }
?>
    