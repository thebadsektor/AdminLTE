<!-- <script src="../bower_components/ajax/jquery.min.js"></script> -->
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.2.0/jspdf.umd.min.js"></script>
<style type="text/css" media="print">
@media print {
    .nav-tabs-custom {
        display: none;
    }

    .main-footer {
        display: none;
    }

    #not-printable {
        display: none;
    }

    header nav,
    footer {
        display: none;
    }
}

body {
    margin: none;
    /*0cm, 0cm, 0cm, 0cm*/
    font: 10pt Arial, Arial, Times, serif;
    line-height: 1;
}
}
</style>
<style type="text/css">
.index_bgimage {
    background: url("./../dist/receipt/Standard_OR.jpg") no-repeat;
    opacity: 50%;
}

.zoom {
    transition: transform .2s;
    /* Animation */
    margin: 0 auto;
}

.zoom:hover {
    transform: scale(1);

    /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}

b {
    margin: none;
    padding: none;
    font-family: Arial, Arial;
}
</style>
<!--  -->
<style type="text/css">
#OR_style {
    width: 335px;
    font-size: 14px;
    padding-left: 10px;
}

table td {
    width: 100%;
    vertical-align: top;
    border-collapse: collapse;
    margin: 0;
    border: black solid 0px;
}
</style>
<!--  -->

<style type="text/css">
.input_style {
    border: #e4e4e4 solid 0px;
    padding: none;
    margin: none;
    text-align: center;
    color: black;
    font-weight: bold;
}

td.data_li {
    height: 12px;
    padding: 1px;
    font-size: .9em;
    font-weight: bold;
    border: black solid 0px;
}

.cuttext {
    text-overflow: ellipsis;
    overflow: hidden;
    width: 250px;
    white-space: nowrap;
}
</style>
<div class="row">
    <?php 
    $id = $_POST["target"];
    $mode_of_payment = $_POST["mode_of_payment"];
  ?>
</div>
<div class="row" >
    <div class="col-md-12">
        <div class="col-md-6" style="background-color: white;">
            <div class="box-body index_bgimage">
                <br>
                <div id="OR_style" style="margin-left: 10px">

                    <table style="width:100%">
                        <tr>
                            <td style="height:37px;padding-top:83px;"><span
                                    style="margin-left:175px;font-size:24px;position:relative;padding-bottom:50px;"
                                    id="not-printable"><?php echo $_POST["or_num"]; ?></span></td>
                        </tr>
                        <tr>
                            <td style="height:4px;vertical-align:middle;"><span
                                    style="margin-left:160px;font-weight:bold;">&nbsp;</span></td>
                        </tr>
                        <tr>
                            <td style="height:28px;vertical-align:middle;"><span
                                    style="margin-left:160px;font-weight:bold;"><?php echo strftime('%h %d, %Y' , strtotime($_POST["or_date"])); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:50px;">
                                <table>
                                    <tr>
                                        <td style="height:28px;vertical-align:middle;"><span
                                                style="margin-left:40px;font-size:14px;font-weight:bold;"
                                                id="not-printable"><?php echo $_POST["agency"]; ?></span></td>
                                        <td
                                            style="height:28px;width:60px;vertical-align:middle;font-weight:bold; margin-left: 10px;">
                                            &nbsp;&nbsp;&nbsp;<?php echo $_POST["fund_code"]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                    <tr>
                                        <td style="height:20px;vertical-align:middle;" colspan="2"><span
                                                style="white-space:nowrap;margin-left:40px;font-size:14px;font-weight:bold; padding-top: 5px;"><?php echo $_POST["or_payor"]; ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:4px;vertical-align:middle;"><span
                                    style="margin-left:160px;font-weight:bold;">&nbsp;</span></td>
                        </tr>
                        <tr>
                            <td style="height:210px;">
                                <table style="margin-top:38px;width:320px; margin-left: 5px;">

                       <?php
                         $total_amount = 0;
                             $tax = 0;
                             $fee = 0;
                            $permit_id_dec = $_POST["permit_num"];
                            // checking in querter if paid the first quarter
                            if(isset($_POST["normal"])){
                            $fee_count = count($_POST["normal"]);
                            for($a = 0; $a<$fee_count; $a++){
                                // fee  and tax
                                // change later
                                // 1 for gross sales
                                if( $_POST["sub_account_no"][$a] == "4-01-03-030-1" ){
                                    $tax += (float)$_POST["normal"][$a];
                                }else{
                                    $fee += (float) $_POST["normal"][$a];
                                }
                         ?>
                                    <tr>
                                        <td class="data_li" style="padding-left: 1px; font-weight: bold;" colspan="3">
                                            <div class="cuttext"> <?php echo $_POST["desc"][$a]; ?></div>
                                        </td>
                                        <td class="data_li" style="text-align:right; font-weight: bold;">
                                             <?php echo $_POST["normal"][$a]; 
                                                $total_amount += (float)$_POST["normal"][$a];
                                             ?>
                                        </td>
                                    </tr>
                        <?php
                            }
                            }
                            // setting backtax ---------------------
                            if(isset($_POST["backtax"])){
                             eval( '$backtax_var = (' . $_POST["backtax"]. ');' );
                                    if($backtax_var != 0 || $backtax_var != "0" || $backtax_var != 0.00 || $backtax_var != "0.00" ) {
                             ?>
                                    <tr>
                                        <td class="data_li" style="padding-left: 1px; font-weight: bold;" colspan="3">
                                            <div class="cuttext"> BACKTAXES</div>
                                        </td>
                                        <td class="data_li" style="text-align:right; font-weight: bold;">
                                             <?php
                                                    $abn = str_replace(',','',number_format($backtax_var,2));
                                                    echo number_format($abn,2);
                                                $total_amount += (float)str_replace(',','',number_format($backtax_var,2));;
                                             ?>
                                        </td>
                                    </tr>
                             <?php   
                             }
                            }
                            if(isset($_POST["surcharges"])){
                             ?>
                                    <tr>
                                        <td class="data_li" style="padding-left: 1px; font-weight: bold;" colspan="3">
                                            <div class="cuttext"> SURCHARGES</div>
                                        </td>
                                        <td class="data_li" style="text-align:right; font-weight: bold;">
                                             <?php 
                                                 $vvvv = str_replace(',','',number_format($_POST["surcharges"],2));
                                                    echo number_format($vvvv,2);
                                           
                                                $total_amount += (float)$vvvv;
                                             ?>
                                        </td>
                                    </tr>
                             <?php   
                            }
                        ?>
                        <tr>
                            <td class="data_li" style="padding-left: 1px; font-weight: bold;" colspan="4">
                                <div class="cuttext"> </div>
                            </td>
                        </tr>
                    </table>
                    </td>
                    </tr>
                    <tr>
                        <td style="height:20px; vertical-align:middle; text-align: right;"><span
                                style="margin-right:5px;font-size:14px;font-weight:bold;"><?php echo number_format($total_amount,2); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="320px"
                            style="height:20px; padding-top: 8px; vertical-align:middle; padding-left:2px;">
                            &nbsp;<b><?php echo AmountInWords($total_amount); ?> </b></td>
                    </tr>
                    <tr>
                        <td style="height:10px; vertical-align:middle; "><span
                                style="margin-left:160px;font-weight:bold; padding-bottom: 30px;">&nbsp;
                                <!-- a -->
                            </span></td>
                    </tr>
                    <tr>
                        <td
                            style="height:20px;<?php  if ($_POST["payment_mode"] == "cash") { echo 'padding-top:18px;'; } ?> ">
                            <span style="margin-left:10px;font-size:14px;font-weight:bold">
                                <?php 
                        if($_POST["payment_mode"] == "cash"){
                          ?>
                                <i class="fa fa-check" style="font-size1.2em;"></i>
                                <?php
                        }
                      ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="height:20px;<?php  if ($_POST["payment_mode"] == "check") { echo 'padding-top:20px;'; } ?> ">
                            <span style="margin-left:10px;font-size:14px;font-weight:bold">
                                <?php
                          if ($_POST["payment_mode"] == "check") {
                              ?>
                                <i class="fa fa-check" style="font-size1.2em;"></i>
                                <?php
                          }
                          ?>
                            </span>
                            <span style="margin-left:72px;font-size:14px;font-weight:bold">
                                <?php
                        if ($_POST["payment_mode"] == "check") {
                          echo $_POST["drawee_check"];
                        }
                        ?>
                            </span>
                            <span style="margin-left:47px;font-size:14px;font-weight:bold">
                                <?php
                          if ($_POST["payment_mode"] == "check") {
                              echo $_POST["num_check"];
                          }
                          ?>
                            </span>
                            <span style="margin-left:35px;font-size:14px;font-weight:bold">
                                <?php
                            if ($_POST["payment_mode"] == "check") {
                                echo $_POST["date_check"];
                            }
                            ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="height:20px;<?php  if ($_POST["payment_mode"] == "money_order") { echo 'padding-top:20px;'; } ?> ">
                            <span style="margin-left:10px;font-size:14px;font-weight:bold; "><?php
                            if ($_POST["payment_mode"] == "money_order") {
                                ?>
                                <i class="fa fa-check" style="font-size1.2em;"></i>
                                <?php
                            }
                            ?></span>
                            <span style="margin-left:150px; font-size:14px;font-weight:bold">
                                <?php
                        if ($_POST["payment_mode"] == "money_order") {
                            echo $_POST["num_order"];

                        }
                        ?>
                            </span>
                            <span style="margin-left:20px;font-size:14px;font-weight:bold">
                                <?php
                              if ($_POST["payment_mode"] == "money_order") {
                                  echo $_POST["date_order"];

                              }
                              ?>
                            </span>
                        </td>
                    </tr>

                    </tr>
                    <td style="height:10px;margin-bottom: 30px;"><span
                            style="margin-left:160px;font-weight:bold;">&nbsp;</span></td>
                    </tr>
                    <tr>
                        <td style="height:60px;vertical-align:bottom;">
                            <div
                                style="margin:0;padding:0;margin-left:120px;margin-top:0px;font-size:14px;font-weight:bold">

                                <center>
                                    <b><small>
                                            <u>&nbsp;
                                                name
                                                &nbsp;
                                            </u> </small></b>
                                    <!-- <br>
                       <small>Cashier Officer</small> -->
                                </center>

                            </div>
                        </td>
                    </tr>
                    </table>
                    <br>
                    <br>
                    <br>

                </div>
            </div>
        </div><!-- end mo-6 -->

        <div class="col-md-6" id="not-printable" style="background-color: white;">
            <script TYPE="text/javascript">
            calculate = function() {
                var ttl_amount = document.getElementById('ttl_amount').value;
                var pay = document.getElementById('pay').value;
                document.getElementById('change').value = (parseFloat(pay) - parseFloat(ttl_amount)).toFixed(2);
            }
            </script>
            <br>
            <button id="print_this" class="btn btn-info form-control" style="font-size: 1.5em; font-weight: bold; ">Print OR</button>
            <h2><i class="fa fa-calculator fa-2x"></i> Calculator </h2>
            <br>
            <form method="POST" action="bplsmodule.php?redirect=payment_saving" id="payment_form">
               
                  
                <?php   
                if(isset($_POST["payment_qtr"])){
                    $p_p = $_POST["payment_qtr"];
                }else{
                    $p_p = "";
                }
                        $penalty = 0;
                        if(isset($_POST["surcharges"])){
                            $surcharges = $_POST["surcharges"];
                        }else{
                            $surcharges = 0;
                        }
                        if(isset($_POST["backtax"])){
                            $backtax = $_POST["backtax"];
                        }else{
                            $backtax = 0;
                        }
                        $year = date("Y");
                        $payment_total_amount_due = $tax + $fee;
                         if(isset($_POST["normal"])){
                            $fee_count = count($_POST["normal"]);
                            for($a = 0; $a<$fee_count; $a++){
                                 
                            $_POST["normal"][$a]; 
                          ?>
                            <input type="hidden" name="desc[]" value="<?php echo $_POST["desc"][$a]; ?>">
                            <input type="hidden" name="nature[]" value="<?php echo $_POST["nature"][$a]; ?>">
                            <input type="hidden" name="normal[]" value="<?php echo $_POST["normal"][$a]; ?>">
                            <input type="hidden" name="sub_account_no[]" value="<?php echo $_POST["sub_account_no"][$a]; ?>">
                          <?php
                            }
                            }
                        ?>
                <input type="hidden" name="amount_word" value="<?php echo AmountInWords($total_amount); ?>">
                <input type="hidden" name="or_date" value="<?php echo $_POST["or_date"]; ?>">
                <input type="hidden" name="or_no" value="<?php echo $_POST["or_num"]; ?>">
                <input type="hidden" name="permit_id" value="<?php echo $permit_id_dec; ?>">
               

                     <?php  
                        if($_POST["payment_mode"] == "cash"){ 
                    ?>
                         <input type="hidden" name="payment_mode"   value="CASH">
                    <?php
                        }else if($_POST["payment_mode"] == "check"){
                      ?>
                         <input type="hidden" name="payment_mode"   value="CHEC">
                         <input type="hidden" name="drawee_check"   value="<?php echo $_POST["drawee_check"]; ?>">
                         <input type="hidden" name="num_check"   value="<?php echo $_POST["num_check"]; ?>">
                         <input type="hidden" name="date_check"   value="<?php echo $_POST["date_check"]; ?>">
                         <!-- <input type="hidden" name="payment_mode"   value="CHEC"> -->
                    <?php
                      }else if($_POST["payment_mode"] == "money_order"){
                      ?>
                         <input type="hidden" name="payment_mode"   value="MONE">
                         <input type="hidden" name="num_order"   value="<?php echo $_POST["num_order"]; ?>">
                         <input type="hidden" name="date_order"   value="<?php echo $_POST["date_order"]; ?>">
                         <!-- <input type="hidden" name="payment_mode"   value="CHEC"> -->
                    <?php
                      }

                         // update 12522
                      if(isset($_POST["backtax_permit_id"])){
                          ?>
                            <input type="hidden" name="backtax_permit_id" value="<?php echo $_POST["backtax_permit_id"]; ?>">
                            <input type="hidden" name="backtax_amount" value="<?php echo $_POST["backtax_amount"]; ?>">
                          <?php
                     }
                     // update 12522
                     
                 ?>

                <input type="hidden" name="surcharges" value="<?php echo $surcharges; ?>">
                <input type="hidden" name="sector_code" value="<?php echo $_POST["sector_code"]; ?>">
                <input type="hidden" name="backtax" value="<?php echo $backtax; ?>">
                <input type="hidden" name="penalty" value="<?php echo $penalty; ?>">
                <input type="hidden" name="payment_part" value="<?php echo $p_p; ?>">
                <input type="hidden" name="payment_tax" value="<?php echo $tax; ?>">
                <input type="hidden" name="payment_fee" value="<?php echo $fee; ?>">
                <input type="hidden" name="payor" value="<?php echo $_POST["or_payor"]; ?>">
                <input type="hidden" name="remark" value="<?php echo  $_POST["remark"]; ?>">
                <input type="hidden" name="year" value="<?php echo $year; ?>">
                <div class="form-group">
                <label for="ttl_amount" style="font-size: 1.3em;">Total Amount </label>
                <input type="number" name="payment_total_amount_due" class="form-control" id="amount" value="<?php echo $total_amount;?>"   style="font-size: 1.5em; font-weight: bold; text-align: right;" readonly>
                </div>
                <div class="form-controlform-group">
                    <label for="pay" style="font-size: 1.3em;">Payment</label>
                    <input type="number" name="payment_total_amount_paid" class="form-control" id="pay" onblur="calculate()" style="font-size: 1.5em; font-weight: bold; text-align: right;">
                </div>
                <br>
                <div class="form-group">
                    <label for="" style="font-size: 1.3em;">Change</label>
                    <input type="number"  name="payment_total_amount_change"  class="form-control" id="change"
                        style="font-size: 1.5em; font-weight: bold; text-align: right;" readonly>
                </div>
                <div class="form-group">

                    <input type="button" id="pay_saving" class="form-control btn btn-success" value="Pay"
                        style="font-size: 1.5em; font-weight: bold; ">
                </div>
            </form>
            <br><br>
        </div>
    </div>
</div>

<script type="text/javascript">

$(document).on("keyup","#pay",function(){
      var pay = $(this).val();
      var amount = $("#amount").val();

      if(parseFloat(amount) < parseFloat(pay)){
        var change = parseFloat(pay) - parseFloat(amount);
        $("#change").val((change).toFixed(2));
      }else{
            $("#change").val(0);
            
      }

});

    $(document).on("click","#pay_saving",function(){
        
      var pay = $("#pay").val();
      var amount = $("#amount").val();

      if(parseFloat(amount) <= parseFloat(pay)){
            $(this).prop("disabled",true);
            $("#payment_form").submit();
      }else{
            myalert_warning_af("Payment must be greater than equal to "+amount,"nothing");
      }

});


    $(document).on("click","#print_this",function(){
        var datus = $("#payment_form").serialize();
        $.ajax({
            type:"POST",
            url:"bpls/pdf_excel/51cbpls_or_data2.php",
            data:{datus:datus},
            success:function(result){
                window.open("bpls/images_file/or_receipt.pdf");
            }
        })
    });


function myFunction() {
    window.print();
}

function printDiv(print_doc) {
    var printContents = document.getElementById(print_doc).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print_doc();

    document.body.innerHTML = originalContents;
     window.print();
}

    
</script>
