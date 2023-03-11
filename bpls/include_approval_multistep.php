<div class="panel-group" style="cursor:pointer;">
    <div class="panel panel-default">
        <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
            data-toggle="collapse" href="#collapse1a12" aria-expanded="true">
            BUSINESS PERMIT AND LICENSING SYSTEM
        </div>
        <div id="collapse1a12" class="panel-collapse collapse in" aria-expanded="true">
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

<!-- Nature -->

<div class="panel-group" style="cursor:pointer;">
    <div class="panel panel-default">
        <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
            data-toggle="collapse" href="#collapse122" aria-expanded="true">
            BUSINESS NATURE
        </div>
        <div id="collapse122" class="panel-collapse collapse in" aria-expanded="true">
            
        <!-- check kung naka discount sya -->
        <?php
           
            $q04998 = mysqli_query($conn, "SELECT sum(geo_bpls_discount_history.discount_amount) + 0 as rrrr, geo_bpls_discount.discount_name_id  FROM `geo_bpls_discount_history` inner join geo_bpls_discount on geo_bpls_discount.discount_id = geo_bpls_discount_history.discount_id where discount_permit_id = '$permit_id_dec' ");
            $r04998 = mysqli_fetch_assoc($q04998);

            if($r04998["rrrr"] != 0 ){
                 echo ' <div class="alert alert-info"  style="margin:2px;">';
                    echo "<h3>Discounted Amount: &#8369; ".number_format($r04998["rrrr"],2)." </h3>";
                 echo ' </div>';
             }
        ?>
        <!-- =================================== -->
        <!-- =================================== -->
        <!-- =================================== -->
        <div class="row" style="margin:2px;">
            
                <div class="col-md-12">
                    <form method="POST" action="bplsmodule.php?redirect=saving_assessment_process">

                        <?php 
              // query check if business is assess or not
               // checking for kung na assess n or hindi assessment page nature
              $q1234 = mysqli_query($conn,"SELECT * FROM `geo_bpls_assessment` where md5(permit_id) = '$id' and assessment_active = 1");
              $q_count1234 = mysqli_num_rows($q1234);
              // checking for kung na assess n or hindi assessment page nature
                    if($q_count1234 >0){
                        $disabled_status = "disabled" ;   
                    }else{
                        $disabled_status = "" ;   
                    }
                    ?>
                        <table class="table">
                            <?php
                                     $q12 = mysqli_query($conn,"SELECT * FROM `geo_bpls_business_permit_nature` where md5(permit_id) = '$id' ");   
                                    $arr_count3 = mysqli_num_rows($q12);
                                // insert
                                if($arr_count3>0){
                                    $total_tax_due = 0;
                                    $total_count = 0;
                                    $total_surcharges_amount = 0;
                                    while($r12 = mysqli_fetch_assoc($q12)) {
                                    $nature = $r12['nature_id'];
                                    $cap_investment = $r12['capital_investment'];
                                    $gross = $r12['last_year_gross'];
                                    $nature_application_type = $r12['nature_application_type'];
                                    $nature_scale_code = $r12['scale_code'];
                                    
                                    $q = mysqli_query($conn,"SELECT nature_desc from geo_bpls_nature where nature_id = '$nature' ");
                                    $r = mysqli_fetch_assoc($q);
                                    $nature_desc = $r["nature_desc"];
                                            ?>
                            <tr style="text-align:center;" class="bg-primary">
                                <td colspan="4"> <?php echo $nature_desc; ?></td>

                            </tr>
                            <tr>
                                <td><b>TAXES/FEES</b></td>
                                <td><b>BASE VALUE/INPUT</b></td>
                                <td><b>AMOUNT/FORMULA</b></td>
                                <td><b>TAX DUE</b></td>
                            </tr>
                            <?php
                            $total_fee_per_business = 0;
                             $q = mysqli_query($conn,"SELECT geo_bpls_tfo_nature.tfo_nature_id, basis_code, geo_bpls_indicator.indicator_code, mode_formula_code, geo_bpls_nature.nature_id, UPPER(geo_bpls_nature.nature_desc) AS nature_desc, natureOfCollection_tbl.id as sub_account_no , geo_bpls_status.status_code, geo_bpls_tfo_nature.amount_formula_range, natureOfCollection_tbl.name as sub_account_title FROM `geo_bpls_tfo_nature` INNER JOIN geo_bpls_status on geo_bpls_status.status_code = geo_bpls_tfo_nature.status_code INNER JOIN geo_bpls_nature on geo_bpls_nature.nature_id = geo_bpls_tfo_nature.nature_id INNER JOIN natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no INNER JOIN geo_bpls_indicator on geo_bpls_indicator.indicator_code = geo_bpls_tfo_nature.indicator_code WHERE geo_bpls_status.status_code = '$nature_application_type' and geo_bpls_nature.nature_id = $nature ");
                                  $tax_due = 0;
                              $count_of_tax_fess = mysqli_num_rows($q);    
                           if($count_of_tax_fess>0){  
                               while($r =mysqli_fetch_assoc($q)){
                                    $total_count++;

                                                    ?>
                            <tr>
                                <td>
                                    <?php 
                                  
                                    $sub_account_no = $r["sub_account_no"];
                                        // auto assign sa sector+++++++++++++++++++++++++++++++++++++++++++++++++++
                                        $auto_assign_sector = 1;
                                        if($auto_assign_sector == 1){
                                            // para sa gross
                                            if($sub_account_no == 1010 || $sub_account_no == 1011  || $sub_account_no == 1012  || $sub_account_no == 1013  || $sub_account_no == 1014  || $sub_account_no == 1015 || $sub_account_no == 1016 || $sub_account_no == 1017 || $sub_account_no == 1018 || $sub_account_no == 1019 || $sub_account_no == 1020 || $sub_account_no == 1021){
                                                // check sector kung ano ang gross sales auto inc
                                                echo substr(strtoupper($r["sub_account_title"]),0,15);
                                                // changing the value of sub_account/or auto in ID
                                              
                                            }else{
                                                echo strtoupper($r["sub_account_title"]);
                                            }
                                            
                                        }else{
                                            echo strtoupper($r["sub_account_title"]);
                                        }
                                        // auto assign sa sector+++++++++++++++++++++++++++++++++++++++++++++++++++
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    $nature_id = $r["nature_id"];
                                    $tfo_nature_id = $r["tfo_nature_id"];
                                    
                                    // if($_SESSION["uname"]=="admin"){
                                    //     echo "TFO Nature".$tfo_nature_id." ";
                                    //     echo  "Owner_id".$owner_id;
                                    // }
               $invalid_input_detection = 0;                    
               // for Range formula  1 to 19 value
                if( $r["indicator_code"] == "R"  ){

                                        if($r["basis_code"] == "C"){
                                            $data = $cap_investment;
                                        } 
                                        if( $r["basis_code"] == "G"  ){
                                            $data = $gross;
                                        }
                                    //    looping range formula
                                    $count = $r["amount_formula_range"];
                                    // echo $r["amount_formula_range"];
                                    $range_query = mysqli_query($conn,"SELECT range_high, range_low, range_amount  FROM `geo_bpls_tfo_range` where tfo_nature_id = '$tfo_nature_id'");
                                    $if1 = 0;
                                    $if2 = 0;

                                    while($range_row = mysqli_fetch_assoc($range_query)){

                                     // discount condition sa range
                                        
                                        if( $data >= $range_row["range_high"] && $data >= $range_row["range_low"]  ){
                                            if($range_row["range_high"] == "00.0"){
                                                $tax_due = str_replace('X0', $data,$range_row["range_amount"]);
                                                
                                                // checking ng formula gamit ang mysql
                                                $q1235 = mysqli_query($conn,"SELECT ".$tax_due."  as validate_ok from geo_bpls_check_status");
                                                if($q1235){
                                                    $eval = eval( '$tax_due = (' . $tax_due. ');' );
                                                }else{
                                                    // pag mali ang query detected na mali ang formula
                                                    $tax_due = 0;   
                                                    $invalid_input_detection++; 
                                                }
                                              
                                            }
                                            $if1 ++;
                                        }

                                        // seeting taxdue in range formula
                                        if( $data <= $range_row["range_high"] && $data >= $range_row["range_low"]  ){
                                             $str =  $range_row["range_amount"];
                                            if(strpos($str, "X0") !== false){
                                                $tax_due = str_replace('X0', $data,$range_row["range_amount"]);
                                                 // checking ng formula gamit ang mysql
                                                 $q1235 = mysqli_query($conn,"SELECT ".$tax_due."  as validate_ok from geo_bpls_check_status");
                                                 if($q1235){
                                                    eval( '$tax_due = (' . $tax_due. ');' );
                                                 }else{
                                                     // pag mali ang query detected na mali ang formula
                                                     $tax_due = 0;   
                                                     $invalid_input_detection++; 
                                                 }


                                            }else{
                                                  $tax_due = $range_row["range_amount"];
                                                   // checking ng formula gamit ang mysql
                                                 $q1235 = mysqli_query($conn,"SELECT ".$tax_due."  as validate_ok from geo_bpls_check_status");
                                                 if($q1235){
                                                    eval( '$tax_due = (' . $tax_due. ');' );
                                                 }else{
                                                     // pag mali ang query detected na mali ang formula
                                                     $tax_due = 0;   
                                                     $invalid_input_detection++; 
                                                 }
                                            }
                                            $if2++;
                                        }
                                        // seeting taxdue in range formula
                                    }
                                    // di nameet condition sa range kaya 0
                                    if($if1 == 0 && $if2 == 0){
                                        $tax_due =0;
                                    }
                               

            }elseif($r["indicator_code"] == "F" ){

                                            //  tax due of formula without IF
                                                $str = $r["amount_formula_range"];
                                            // para sa renewallllll-----------
                           if($r["basis_code"] == "G"){
                                               if(strpos($str, "IF") !== false){
                                                $arr_explode = explode(')',$r["amount_formula_range"]);
                                                $arr_count = count($arr_explode);
                                                $new_formula = "";
                                            for($a =0; $a<$arr_count; $a++){
                                                if($a == 0){
                                                    $new_formula .= $arr_explode[$a].",0";
                                                    for($a =0; $a<$arr_count-1; $a++){ $new_formula .= ")"; } 
                                                    }
                                                }
                                            $formula_query = str_replace('S0',"`scale_code`",$new_formula);
                                            // query para sa pag check ng scale code
                                            $formula_result = mysqli_query($conn,"SELECT ".$formula_query." as tax_due from geo_bpls_business_permit_nature  where permit_id = '$permit_id_dec' and nature_id = '$nature_id' ");
                                            // query checking ng renewal
                                            if($formula_result){
                                                $data = $gross;
                                                $formula_row = mysqli_fetch_assoc($formula_result);
                                                $tax_due = $formula_row["tax_due"];
                                            }else{
                                                // pag mali ang query detected na mali ang formula
                                                $invalid_input_detection++;
                                            }
                                           
                                            }elseif(strpos($str, "X0") !== false){
                                                    $data = $gross;

                                                    $tax_due =  str_replace('X0',$gross,$r["amount_formula_range"]);
                                                     eval( '$tax_due = (' . $tax_due. ');' );
                                            }else{
                                                $data = 0;
                                                $tax_due = 0;
                                                $invalid_input_detection++;
                                            }
                             $data = $gross;

                          // para sa New Business-----------
                        }elseif($r["basis_code"] == "C"){
                                                // check kung ang formula ay may if else
                                                if(strpos($str, "IF") !== false){
                                                $arr_explode = explode(')',$r["amount_formula_range"]);
                                                $arr_count = count($arr_explode);
                                                $new_formula = "";
                                                for($a =0; $a<$arr_count; $a++){
                                                    if($a == 0){
                                                        $new_formula .= $arr_explode[$a].",0";
                                                        for($a =0; $a<$arr_count-1; $a++){ $new_formula .= ")"; } 
                                                        }
                                                    }
                                                $formula_query = str_replace('S0',"`scale_code`",$new_formula);
                                                
                                                // query para sa pag check ng scale code
                                                $formula_result = mysqli_query($conn,"SELECT ".$formula_query." as tax_due from geo_bpls_business_permit_nature  where permit_id = '$permit_id_dec' and nature_id = '$nature_id' ");
                                                if($formula_result){
                                                    $formula_row = mysqli_fetch_assoc($formula_result);
                                                    $data = $cap_investment;
                                                    $tax_due = $formula_row["tax_due"];
                                                }else{
                                                    // pag mali ang query detected na mali ang formula
                                                    $invalid_input_detection++;
                                                }
                                                
                                                }elseif(strpos($str, "X0") !== false){
                                                    // dito papasok ang inputed value na formula XO
                                                        $data = $cap_investment;

                                                        $tax_due =  str_replace('X0',$cap_investment,$r["amount_formula_range"]);
                                                        eval( '$tax_due = (' . $tax_due. ');' );
                                                        
                                                }
                                            }else{
                                                // echo "inputed";
                                                $data = 0;
                                                $tax_due = 0;
                                                $invalid_input_detection++;
                                            }

                                            // end of formula indicator
        }elseif( $r["indicator_code"] == "C"   ){
                                
            $data = 1;
            $tax_due = $r["amount_formula_range"];
        }
                    $sc_discount = 0;
                    $pwd_discount = 0;
                    $fps_discount = 0;
                    $sp_discount = 0;
                    $ot_discount = 0;
                    $final_discount = 0;
                    $discount_amount ="";
                    $discount_id = 0;
                // check kung ilan uri ng discount meron si person na to
                $q23342 = mysqli_query($conn,"SELECT * FROM `geo_bpls_discounted_business` where permit_id = '$permit_id_dec' ");
                $q23342_count = mysqli_num_rows($q23342);

                    // checking if may active discount sa settings
                    
                    $q0998 = mysqli_query($conn,"SELECT * FROM `geo_bpls_discount_name` where discount_status = 1");
                    $discount_count = mysqli_num_rows($q0998);
                    $without_discount_tax_due = $tax_due;
                   $ot_discount_str = "";
                   $check_discount_countot = 0;
                   $ot_discount_str1 = "";
                    if($discount_count >0){

                        $myloopcouter = 0;
                    while($r0998 = mysqli_fetch_assoc($q0998)){
                        $myloopcouter++;
                        $discount_name_id = $r0998["discount_name_id"];
                        $discount_name = $r0998["discount_name"];
                // check kung this person ay may discounted records
                    $q232 = mysqli_query($conn,"SELECT * FROM `geo_bpls_discounted_business` where  discount_name_id = '$discount_name_id' and permit_id = '$permit_id_dec' ");
                    $q232_count = mysqli_num_rows($q232);
                    if($q232_count > 0){
                    $check_discount_qot = mysqli_query($conn,"SELECT discount_id ,discount_amount,discount_name_id  from geo_bpls_discount where discount_name_id = '$discount_name_id' and sub_account_no = '$sub_account_no' ");
                    $check_discount_countot = mysqli_num_rows($check_discount_qot);

                     // check if may discount sa 
                    if($check_discount_countot >0){
                        $check_discount_rot = mysqli_fetch_assoc($check_discount_qot);
                        $discount_id = $check_discount_rot["discount_id"];
                        // if percentage

                        if(strpos($check_discount_rot["discount_amount"], "D0") == false){
                                if( $myloopcouter > 0 && $myloopcouter != $q23342_count  ){
                                    $connector = " + ";
                                }else{
                                    $connector = " ";
                                }
                            $discount_amount .= $check_discount_rot["discount_amount"].$connector;
                            
                            $ot_discount = str_replace('D0',$without_discount_tax_due,$check_discount_rot["discount_amount"]);
                            eval( '$ot_discount = (' . $ot_discount. ');' );
                            $tax_due = $tax_due - $ot_discount;
                        } else{
                                            //  if fix amount
                            $ot_discount = $check_discount_rot["discount_amount"];
                            $tax_due = $tax_due - $ot_discount;
                        }
                        $ot_discount = number_format($ot_discount,2);
                        $final_discount = $ot_discount;
                        $ot_discount_str .= " ".$discount_name.": ".$ot_discount;
                        $ot_discount_str1 .= " ".$discount_name.": <> "; // for inputed value setup
                    }   
                    }
                  }
                }
                    
                            $discountdesc = $ot_discount_str;
                            $discountdesc1 = $ot_discount_str1;
                                    // discount
                            // if may assessment pero wala pang approval
                            $f_q = mysqli_query($conn, "SELECT assessment_base_value_input, assessment_tax_due FROM `geo_bpls_assessment` WHERE permit_id = '$permit_id_dec' and  tfo_nature_id = '$tfo_nature_id' ");
                            
                              $f_r_count = mysqli_num_rows($f_q);
                            if ($f_r_count > 0) {
                                $f_r = mysqli_fetch_assoc($f_q);
                                // $data = $f_r["assessment_base_value_input"];
                                $tax_due = $f_r["assessment_tax_due"];
                            }
                                    // b_iX0 para sa inputed value pag nag bago ang amount
                                ?>
                                    <input type="number" name="base_value[]" step="0.01" class="form-control base_input <?php if($check_discount_countot > 0 ){ if($r["amount_formula_range"] == "X0"){ echo "b_iX0"; }} ?> base_input<?php echo $total_count; ?>"  ca_attr="<?php echo $total_count; ?>" ca_no="<?php echo $tfo_nature_id; ?>" ca_discountdesc="<?php echo $discountdesc1; ?>" ca_discount="<?php echo $discount_amount; ?>" value="<?php echo $data; ?>" min="0" <?php if($r["amount_formula_range"] != "X0" ){ echo "readonly"; } ?> style="font-size:15px; font-weight:bold;" readonly>
                                   
                                        <?php
                                          if($check_discount_countot > 0 ){ 
                                        ?>
                                        <!-- discount saving input -->
                                        <input type="hidden" name="discount_amount[]" class="discount<?php echo $tfo_nature_id; ?>" value="<?php echo $final_discount; ?>">
                                        <input type="hidden" name="discount_tfo_nature_id[]" value="<?php echo $tfo_nature_id; ?>">
                                        <input type="hidden" name="discount_nature_id[]" value="<?php echo $nature_id; ?>">
                                        <input type="hidden" name="discount_sub_account_no[]" value="<?php echo $sub_account_no; ?>">
                                        <input type="hidden" name="discount_permit_id[]" value="<?php echo $permit_id_dec; ?>">
                                        <input type="hidden" name="discount_id[]" value="<?php echo $discount_id; ?>">
                                        <!-- discount saving input -->
                                        <?php 
                                        }
                               ?>
                                </td>
                                <td>
                                    <?php
                                    $tax_due = str_replace(',','',number_format($tax_due,2));
                                                            // echo $r["basis_code"];
                                                            // echo $r["indicator_code"];
                                        
                                                          
                                      if($check_discount_countot > 0 ){
                                         
                                        ?>
                                        <input type="text" name="formula[]"
                                        class="form-control formula<?php echo $total_count; ?>"
                                        value="<?php echo $r["amount_formula_range"];  ?>" style="width:50%; float:left;font-size:15px; font-weight:bold;" readonly>
                                         <input type="text"  step="0.01"  class="form-control discountdesc<?php echo $tfo_nature_id; ?>"  style="width:49%; float:right; color:green; font-weight:bold; font-size:15px;"  value="<?php echo $discountdesc; ?>" readonly>
                                       
                                        <?php
                                      }else{
                                        ?>
                                        <input type="text" name="formula[]"
                                        class="form-control formula<?php echo $total_count; ?>"
                                        value="<?php echo $r["amount_formula_range"];  ?>" style="font-size:15px; font-weight:bold;" readonly>
                                        <?php
                                      } 
                                    
                                        // alerting if may invalid input sa formula
                                    if($r["amount_formula_range"] != "X0" && $invalid_input_detection >0 ){ 
                                        echo "<b class='small invalid_input_detection_class' style='color:red;'>Invalid type of Formula!!</b>"; 
                                    } 
                                    ?>
                                </td>
                                <td>    
                                
                                    <input type="number" name="tax_due[]" step="0.001"
                                        class="form-control "
                                        value="<?php echo $tax_due; ?>" ca_attr="<?php echo $total_count; ?>" min="0" <?php if($r["amount_formula_range"] != "X0" ){ echo " "; } ?> style="font-size:15px; font-weight:bold;" readonly>

                                    <input type="hidden" value="<?php echo  $permit_id_dec; ?>" name="permit_id_dec">
                                    <input type="hidden" value="<?php echo  $tfo_nature_id; ?>" name="tfo_nature_id[]">
                                    <?php $total_tax_due += $tax_due; ?>
                                </td>
                            </tr>
                            <?php
                            // pag lalagay ng value sa sa total amount per business
                               $total_fee_per_business += $tax_due;
                         }
                         ?>
                            <tr>
                            <td></td>    
                            <td></td>    
                            <td></td>    
                            <td>
                                <?php 
                                    echo strtoupper("<b>".$nature_desc." TOTAL FEES: <span style='color:red;'>".number_format($total_fee_per_business,2)."</span></b>");
                                ?>
                            </td></tr>
                            <!--  sa surcharges -->
                            <!--  sa surcharges -->
                            <!--  sa surcharges -->
                            <?php
                                    $surcharges_amount_per_business =0;
                                    if($sur_counter!=0 && $nature_application_type == "REN"){
                                     $surcharges_amount_per_business = $total_fee_per_business * $surcharges_rate;
                                    //  echo strtoupper("<b>Surcharges: <span style='color:red;'>".number_format($surcharges_amount_per_business,2)."</span></b>");
                                    }
                                    // total surcharges amount
                                    $total_surcharges_amount += $surcharges_amount_per_business;
                            
                         
                        }else{
                            ?>
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-info">
                                        There is No Tax/Fees for <span style="color:red;"><?php echo $nature_desc."->".$status_desc; ?> </span> <br> Go to Settings and click Nature, Tax, Fee and Other Charges and setup your business nature
                                    </div>
                                </td>
                            </tr>
                            <?php
                         }


                          }
                           }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><b>TOTAL TAX DUE </b></td>
                                <td> <input type="text" class="form-control total_tax_due"
                                        value="<?php echo number_format($total_tax_due,2); ?>" style="font-size:15px; font-weight:bold; color:green;" min="0" readonly>
                                </td>
                            </tr>
                        </table>

                    
                    </form>
                        
                </div>
            </div>
        <!-- =================================== -->
        <!-- =================================== -->
        <!-- =================================== -->
        <!-- =================================== -->
        </div>
    </div>
</div>
<!-- Nature -->

<?php
    include "include_payment_schedule.php";
?>



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

                    // echo 
                    $a = str_replace(',','',number_format($check_amount_tax_row["bbb"],2));
                    $b = str_replace(',','',number_format($check_paid_tax_row["total_paid_tax"],2));
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


 <!-- APPROVAL DESICION -->
<div class="panel-group" style="cursor:pointer;">
    <div class="panel panel-default">
        <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
            data-toggle="collapse" href="#collapse182" aria-expanded="true">
           APPROVAL DESICION
        </div>
        <div id="collapse182" class="panel-collapse collapse in" aria-expanded="true">
            <div class="row" style="margin:5px;">
                <div class="col-md-12">
                    <h4><b>Application Status</b></h4>
                </div>
               <div class="col-md-6">
                    <input type="radio" name="approval_dec" class="desicion_btn desicion_btna" ca_attr="desicion_btna" value="1" <?php if ($permit_approved == 1) {echo "checked ";}?>  <?php if ($permit_approved == 1 || $permit_approved == 2  ) {echo " disabled";}?> target="application_status" > <label for="">Approved</label>
               </div>
               <div class="col-md-6">
                    <input type="radio"  name="approval_dec" class="desicion_btn desicion_btnd" value="2" ca_attr="desicion_btnd" <?php if ($permit_approved == 2) {echo "checked ";}?>  <?php if ($permit_approved == 1 || $permit_approved == 2) {echo " disabled";}?> target="application_status"> <label for="">Rejected</label>
               </div>
           </div>
           <div class="row" style="margin:3px;">
               <div class="col-md-12">
                   <textarea class="approval_remarks form-control"  target="application_remarks"><?php echo $r11["permit_approved_remark"]; ?> </textarea>
               </div>
           </div>
        </div>
    </div>
</div>
<!--Approval -->
<script>
    $(document).on("click",".desicion_btn",function(){
        
                var ca_attr = $(this).attr('ca_attr');
                var permit_id = $("#permit_id").val();
                var val = $(this).val();
                var target = $(this).attr("target");
        myalert_success("Approved this business? " );
        $(".s35343_btn").click(function() {
            // ---------
                $.ajax({
                    type:"POST",
                    url:"bpls/ajax_approval_update.php",
                    data:{permit_id:permit_id, val:val,target:target},
                    success:function(result){
                        if(result == "failed"){
                            myalert_warning_af("failed to approve application! please contact admin","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo $id; ?>");
                        }else{
                            if(val == 1){
                                myalert_success_af("Application status changed to approved","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo $id; ?>");
                                $(".step_btn3").attr("step_status","unlock_btn");
                            }else if(val == 2){
                            myalert_success_af("Application status changed to rejected","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo $id; ?>");
                                $(".step_btn3").attr("step_status","lock_btn");
                            }
                        }
                    }

                });
        });
        $(".s64534_btn").click(function() {
            
            if(ca_attr == "desicion_btna" ){
                $(".desicion_btna").prop("checked", false);
                $(".desicion_btnd").prop("checked", false);
            }else{
                 $(".desicion_btna").prop("checked", false);
                $(".desicion_btnd").prop("checked", true);
            }
            setTimeout(function() {
                $('#myModal_alert_s').remove();
                $('.modal-backdrop').remove();
            }, 0);
        });
       
    });
 $(document).on("change",".approval_remarks",function(){
        var permit_id = $("#permit_id").val();
        var val = $(this).val();
        var target = $(this).attr("target");

            $.ajax({
                type:"POST",
                url:"bpls/ajax_approval_update.php",
                data:{permit_id:permit_id, val:val,target:target},
                success:function(result){

                }

            })
    });
</script>