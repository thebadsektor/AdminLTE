<div class="panel-group" style="cursor:pointer;">
    <div class="panel panel-default">
        <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
            data-toggle="collapse" href="#collapse112" aria-expanded="true">
            BUSINESS PERMIT AND LICENSING SYSTEM
        </div>
        <div id="collapse112" class="panel-collapse collapse in" aria-expanded="true">
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
                            <td><?php echo  $status_desc; ?></td>
                        </tr>
                        <tr>
                            <td><b>Step:</b></td>
                            <td><?php echo  $step_code; ?></td>
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
            <div class="row" style="margin:2px;">
            
                <div class="col-md-12">
                    <form method="POST" action="bplsmodule.php?redirect=saving_assessment_process">

                        <?php 
              // query check if business is assess or not
               // checking for kung na assess n or hindi assessment page nature
              $q1234 = mysqli_query($conn,"SELECT * FROM `geo_bpls_assessment` where md5(permit_id) = '$id' and assessment_active = 1");
              $q_count1234 = mysqli_num_rows($q1234);
              // checking for kung na assess n or hindi assessment page nature
// -----------------------------------------------------------------------------------------may assessment na
                                    if($q_count1234 >0){
                                ?>
                        <table class="table">

                            <?php

            $q12 = mysqli_query($conn,"SELECT * FROM `geo_bpls_business_permit_nature` where md5(permit_id) = '$id' ");   
            $arr_count3 = mysqli_num_rows($q12);
                                // insert
                                if($arr_count3>0){
                                    $total_tax_due = 0;
                                    $total_count = 0;
                                    while($r12 = mysqli_fetch_assoc($q12)) {
                                    $nature = $r12['nature_id'];
                                    $cap_investment = $r12['capital_investment'];
                                    $gross = $r12['last_year_gross'];

                                        // nature applicaition
                                    $nature_application_type = $r12['nature_application_type'];

                                    $q = mysqli_query($conn,"SELECT nature_desc from geo_bpls_nature where nature_id = '$nature' ");
                                    $r = mysqli_fetch_assoc($q);
                                            ?>
                            <tr style="text-align:center;" class="bg-primary">
                                <td colspan="4"> <?php echo $r["nature_desc"]; ?></td>

                            </tr>
                            <tr>
                                <td><b>TAXES/FEES</b></td>
                                <td><b>BASE VALUE/INPUT</b></td>
                                <td><b>AMOUNT/FORMULA</b></td>
                                <td><b>TAX DUE</b></td>
                            </tr>
                            <?php
                        // tax fee query
                        $q = mysqli_query($conn,"SELECT geo_bpls_tfo_nature.tfo_nature_id, basis_code, geo_bpls_indicator.indicator_code, mode_formula_code, geo_bpls_nature.nature_id, UPPER(geo_bpls_nature.nature_desc) AS nature_desc,  natureOfCollection_tbl.id as sub_account_no , geo_bpls_status.status_code, geo_bpls_tfo_nature.amount_formula_range,   natureOfCollection_tbl.name as sub_account_title FROM `geo_bpls_tfo_nature` INNER JOIN geo_bpls_status on geo_bpls_status.status_code = geo_bpls_tfo_nature.status_code INNER JOIN geo_bpls_nature on geo_bpls_nature.nature_id = geo_bpls_tfo_nature.nature_id INNER JOIN natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no INNER JOIN geo_bpls_indicator on geo_bpls_indicator.indicator_code = geo_bpls_tfo_nature.indicator_code WHERE geo_bpls_status.status_code = '$nature_application_type' and geo_bpls_nature.nature_id = $nature ");
                        $tax_due = 0;
                        while($r =mysqli_fetch_assoc($q)){
                        $total_count++;
                        $sub_account_no = $r["sub_account_no"];
                        ?>
                                <tr>
                                    <td>
                                        <?php
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
                                    // if may assessment na, iseset yung dating value
                                    $tfo_nature_id = $r["tfo_nature_id"];
                                    $q111 = mysqli_query($conn,"SELECT assessment_amount_formula,assessment_base_value_input,assessment_tax_due FROM `geo_bpls_assessment` where md5(permit_id) = '$id' and tfo_nature_id = '$tfo_nature_id' ");
                                    
                                    $r111 = mysqli_fetch_assoc($q111);
                                    $data = $r111["assessment_base_value_input"];
                                    $formula = $r111["assessment_amount_formula"];
                                    $tax_due = $r111["assessment_tax_due"];
                                  
                                ?>
                                    <input type="number" step="0.01"
                                        class="form-control base_input base_input<?php echo $total_count; ?>"
                                        ca_attr="<?php echo $total_count; ?>" value="<?php echo $data; ?>" min="0"
                                        readonly>
                                </td>
                                <td>
                                    <?php
                                                            // echo $r["basis_code"];
                                                            // echo $r["indicator_code"];
                                                        ?>
                                    <input type="text" class="form-control formula<?php echo $total_count; ?>"
                                        value="<?php echo $formula;  ?>" readonly>
                                </td>
                                <td>
                                    <input type="number" step="0.01"
                                        class="form-control  tax_due<?php echo $total_count; ?>"
                                        value="<?php echo $tax_due; ?>" ca_attr="<?php echo $total_count; ?>" min="0"
                                        readonly>
                                    <?php $total_tax_due += $tax_due; ?>
                                </td>
                            </tr>
                            <?php
                         }
                        //  end of nature loop
                          }
                           }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><b>TOTAL TAX DUE </b></td>
                                <td> <input type="number" class="form-control total_tax_due"
                                        value="<?php echo $total_tax_due; ?>" min="0" readonly>
                                </td>
                            </tr>
                        </table>
                        <?php
                                    }else{
// ---------------------------------------------------------------------------wala pang approval and assessment 
                                        ?>
                        <table class="table">
                            <?php
                                     $q12 = mysqli_query($conn,"SELECT * FROM `geo_bpls_business_permit_nature` where md5(permit_id) = '$id' ");   
                                     
                                    $arr_count3 = mysqli_num_rows($q12);
                                // insert
                                if($arr_count3>0){
                                    $total_tax_due = 0;
                                    $total_count = 0;
                                    while($r12 = mysqli_fetch_assoc($q12)) {
                                    $nature = $r12['nature_id'];
                                    $cap_investment = $r12['capital_investment'];
                                    $gross = $r12['last_year_gross'];
                                    $nature_application_type = $r12['nature_application_type'];
                                    
                                    $q = mysqli_query($conn,"SELECT nature_desc from geo_bpls_nature where nature_id = '$nature' ");
                                    $r = mysqli_fetch_assoc($q);
                                            ?>
                            <tr style="text-align:center;" class="bg-primary">
                                <td colspan="4"> <?php echo $r["nature_desc"]; ?></td>

                            </tr>
                            <tr>
                                <td><b>TAXES/FEES</b></td>
                                <td><b>BASE VALUE/INPUT</b></td>
                                <td><b>AMOUNT/FORMULA</b></td>
                                <td><b>TAX DUE</b></td>
                            </tr>
                            <?php

                             $q = mysqli_query($conn,"SELECT geo_bpls_tfo_nature.tfo_nature_id, basis_code, geo_bpls_indicator.indicator_code, mode_formula_code, geo_bpls_nature.nature_id, UPPER(geo_bpls_nature.nature_desc) AS nature_desc, natureOfCollection_tbl.id as sub_account_no , geo_bpls_status.status_code, geo_bpls_tfo_nature.amount_formula_range, natureOfCollection_tbl.name as sub_account_title FROM `geo_bpls_tfo_nature` INNER JOIN geo_bpls_status on geo_bpls_status.status_code = geo_bpls_tfo_nature.status_code INNER JOIN geo_bpls_nature on geo_bpls_nature.nature_id = geo_bpls_tfo_nature.nature_id INNER JOIN natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no INNER JOIN geo_bpls_indicator on geo_bpls_indicator.indicator_code = geo_bpls_tfo_nature.indicator_code WHERE geo_bpls_status.status_code = '$nature_application_type' and geo_bpls_nature.nature_id = $nature ");
                                                $tax_due = 0;
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
                                                eval( '$tax_due = (' . $tax_due. ');' );
                                            }
                                            $if1 ++;
                                        }
                                        // seeting taxdue in range formula
                                        if( $data <= $range_row["range_high"] && $data >= $range_row["range_low"]  ){
                                             $str =  $range_row["range_amount"];
                                            if(strpos($str, "X0") !== false){
                                                $tax_due = str_replace('X0', $data,$range_row["range_amount"]);
                                                eval( '$tax_due = (' . $tax_due. ');' );
                                            }else{
                                                  $tax_due = $range_row["range_amount"];
                                                  eval( '$tax_due = (' . $tax_due. ');' );
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

                                            $formula_result = mysqli_query($conn,"SELECT ".$formula_query." as tax_due from geo_bpls_business where business_id = '$business_id' ");

                                            $formula_row = mysqli_fetch_assoc($formula_result);
                                            $data = $gross;
                                            $tax_due = $formula_row["tax_due"];

                                            }elseif(strpos($str, "X0") !== false){
                                                    $data = $gross;

                                                    $tax_due =  str_replace('X0',$gross,$r["amount_formula_range"]);
                                                     eval( '$tax_due = (' . $tax_due. ');' );
                                            }else{
                                                $data = 0;
                                                $tax_due = 0;
                                            }
                                                    $data = $gross;
                                            }elseif($r["basis_code"] == "C"){
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

                                            $formula_result = mysqli_query($conn,"SELECT ".$formula_query." as tax_due from geo_bpls_business where business_id = '$business_id' ");

                                            $formula_row = mysqli_fetch_assoc($formula_result);
                                            $data = $cap_investment;
                                            $tax_due = $formula_row["tax_due"];
                                            }elseif(strpos($str, "X0") !== false){
                                                    $data = $cap_investment;

                                                    $tax_due =  str_replace('X0',$cap_investment,$r["amount_formula_range"]);
                                                    eval( '$tax_due = (' . $tax_due. ');' );
                                            }
                                            }else{
                                                // echo "inputed";
                                                $data = 0;
                                                $tax_due = 0;
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
                                    <input type="number" name="base_value[]" step="0.01"
                                        class="form-control base_input <?php if($check_discount_countot > 0 ){ if($r["amount_formula_range"] == "X0"){ echo "b_iX0"; }} ?> base_input<?php echo $total_count; ?>"
                                        ca_attr="<?php echo $total_count; ?>" ca_no="<?php echo $tfo_nature_id; ?>" ca_discountdesc="<?php echo $discountdesc1; ?>" ca_discount="<?php echo $discount_amount; ?>" value="<?php echo $data; ?>" min="0" <?php if($r["amount_formula_range"] != "X0" ){ echo "readonly"; } ?> style="font-size:15px; font-weight:bold;">
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
                                        <?php } ?>
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
                                     ?>
                                </td>
                                <td>    
                                
                                    <input type="number" name="tax_due[]" step="0.001"
                                        class="form-control tax_due_c taxdue<?php echo  $tfo_nature_id; ?> tax_due<?php echo $total_count; ?>"
                                        value="<?php echo $tax_due; ?>" ca_attr="<?php echo $total_count; ?>" min="0" <?php if($r["amount_formula_range"] != "X0" ){ echo " "; } ?> style="font-size:15px; font-weight:bold;" readonly>

                                    <input type="hidden" value="<?php echo  $permit_id_dec; ?>" name="permit_id_dec">
                                    <input type="hidden" value="<?php echo  $tfo_nature_id; ?>" name="tfo_nature_id[]">
                                    <?php $total_tax_due += $tax_due; ?>
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

                           
                        <?php
                                }
                                if($q_count1234 >0){
                                    ?>
                        <!-- printable Soa -->
                        <a href="bpls/pdf_excel/soa.php?target=<?php echo $id; ?>" target="_blank" style="width:200px; " title="Statement of Account"> <button type="button" class='btn btn-info pull-right' >  <i class='fa fa-file-pdf-o' style="font-size:20px; "></i></button> </a>
                        <br>
                        <br>
                        <br>
                        <?php
                            }else{
                            ?>
                        <button type="submit" class="btn btn-success pull-right assess_btn" id="assess_btn">
                            Assess
                        </button>
                        <?php } ?>
                          <a href="bpls/pdf_excel/bpls_application.php?target=<?php echo $id; ?>" target="_blank"  class="btn btn-info pull-left">Print</a>

                    </form>
                        
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Nature -->
<!-- Payment Schedule -->

<div class="panel-group" style="cursor:pointer;">
    <div class="panel panel-default">
        <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
            data-toggle="collapse" href="#collapse14322" aria-expanded="true">
            PAYMENT SCHEDULE
        </div>
        <div id="collapse14322" class="panel-collapse collapse in" aria-expanded="true">
            <div class="row" style="margin:2px;">
                <div class="col-md-12">
                    <table class="table" style="text-align:center;">
                        <tr>
                            <td><b>PAYMENT DATE</b></td>
                            <td><b>PAYMENT AMOUNT</b></td>
                        </tr>
                        <?php
                        $qpf = mysqli_query($conn, "SELECT * FROM `geo_bpls_payment_frequency` where payment_frequency_desc = '$mode_of_payment' ");
                        $rpf = mysqli_fetch_assoc($qpf);
                            if ($mode_of_payment == "Annual") {
                                 $q = mysqli_query($conn,"SELECT natureOfCollection_tbl.id as sub_account_no, assessment_tax_due, natureOfCollection_tbl.name as sub_account_title  FROM `geo_bpls_assessment`
                                inner join geo_bpls_tfo_nature on  geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id
                                inner join natureOfCollection_tbl on  natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no
                                where md5(permit_id) = '$id' ");
                                
                                
                                $total_amount = 0;
                                while($r = mysqli_fetch_assoc($q)){
                                    // get all amount to paid
                                    $total_amount += (float) $r["assessment_tax_due"];

                                }
                                ?>
                                <tr>
                                    <td><?php 
                                        $aa1 = "2020-" . $rpf['payment_anndue1'];
                                        $aa = strtotime($aa1);
                                        $bb = date('F d', $aa);
                                        echo $bb;

                                    ?></td>        
                                    <td><?php 

                                    echo number_format($total_amount + $sur + $backtax022, 2);

                                    if($sur != 0 ){
                                        echo " &nbsp; <i>with surcharges(<span style='color:red;'> " . number_format($sur,2) . "</span>)</i>";
                                    }
                                    if($backtax022 != 0 ){
                                        echo " &nbsp; <i>with backtax(<span style='color:red;'> " . number_format($backtax022,2) . "</span>)</i>";
                                    }


                                    
                                    ?></td>        
                                         
                                </tr>
                                <?php
                            }elseif ($mode_of_payment == "Semi-annual") {
                            for($k=1; $k<3; $k++){
                                $q = mysqli_query($conn, "SELECT natureOfCollection_tbl.id as sub_account_no, assessment_tax_due, natureOfCollection_tbl.name as sub_account_title  FROM `geo_bpls_assessment`
                                inner join geo_bpls_tfo_nature on  geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id
                                inner join natureOfCollection_tbl on  natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no
                                where md5(permit_id) = '$id' ");

                                  
                                    $total_amount = 0;
                                  
                                    while($r = mysqli_fetch_assoc($q)){
                                      
                                         $total_amount += (float) $r["assessment_tax_due"] / 2;
                                            
                                        // get all amount to paid
                                    }

                                ?>
                            <tr>
                                    <td><?php 
                                        $aa1 = "2020-" . $rpf['payment_semdue'.$k];
                                        $aa = strtotime($aa1);
                                        $bb = date('F d', $aa);
                                        echo $bb;

                                    ?></td>        
                                    <td><?php 

                                    if($current_quarter == $k){
                                        echo number_format($total_amount + $sur + $backtax022, 2);
                                        if($sur != 0 ){

                                            echo " &nbsp; <i>with surcharges(<span style='color:red;'> " . number_format($sur,2) . "</span>)</i>";
                                        }
                                        if($backtax022 != 0 ){

                                            echo " &nbsp; <i>with backtax(<span style='color:red;'> " . number_format($backtax022,2) . "</span>)</i>";
                                        }
                                    }else{
                                        echo number_format($total_amount, 2);
                                    }
                                        

                                    ?></td>        
                                </tr>
                                <?php
                                }

                            }elseif ($mode_of_payment == "Quarterly") {
                                
                            for($k=1; $k<5; $k++){
                                $q = mysqli_query($conn, "SELECT natureOfCollection_tbl.id as sub_account_no, assessment_tax_due, natureOfCollection_tbl.name  as sub_account_title  FROM `geo_bpls_assessment`
                                inner join geo_bpls_tfo_nature on  geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id
                                inner join natureOfCollection_tbl on  natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no
                                where md5(permit_id) = '$id' ");

                               
                                    $total_amount1 = 0;
                                    while($r = mysqli_fetch_assoc($q)){
                                        $total_amount1 += (float) $r["assessment_tax_due"]/4;
                                        // get all amount to paid
                                    }

                                ?>
                            <tr>
                                    <td><?php 
                                        $aa1 = "2020-" . $rpf['payment_qtrdue'.$k];
                                        $aa = strtotime($aa1);
                                        $bb = date('F d', $aa);
                                        echo $bb;

                                    ?></td>        
                                    <td><?php
                                         if($current_quarter == $k){
                                        echo number_format($total_amount1 + $sur + $backtax022, 2);
                                            if($sur != 0 ){

                                                echo " &nbsp; <i>with surcharges(<span style='color:red;'> " . number_format($sur,2) . "</span>)</i>";
                                            }
                                            if($backtax022 != 0 ){

                                                echo " &nbsp; <i>with backtax(<span style='color:red;'> " . number_format($backtax022,2) . "</span>)</i>";
                                            }
                                        }else{
                                            echo number_format($total_amount1, 2);
                                        }
                                    ?></td>        
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
</div>
<!-- Payment Schedule -->

<!-- end -->
<script>
    

// tax due
$(document).on("change", ".tax_due_c", function() {
    
    var ca_attr = $(this).attr("ca_attr");

    if ($(".formula" + ca_attr).val() == "X0") {
        $(".base_input" + ca_attr).val($(this).val());
    }

    var count = 0;
    var total_due = 0;
    $(".tax_due_c").each(function() {
        total_due += parseFloat($(this).val());
    });
    $(".total_tax_due").val(total_due);
});
// append nature
// base value
$(document).on("change", ".base_input", function() {
    var ca_attr = $(this).attr("ca_attr");

    if ($(".formula" + ca_attr).val() == "X0") {
        $(".tax_due" + ca_attr).val($(this).val());
    }

    var count = 0;
    var total_due = 0;
    $(".tax_due_c").each(function() {
        total_due += parseFloat($(this).val());
    });

    $(".total_tax_due").val(total_due);
});

    // para sa discount pag nag change ng Inputed value
    $(document).on("change",".b_iX0",function(){
        discountdesc = $(this).attr("ca_discountdesc");
        tfo_nature_id = $(this).attr("ca_no");
        active_amount = $(this).val();
        ca_discount = $(this).attr("ca_discount");

        split_discount = ca_discount.split("+");
        ca_discount = ca_discount.replace("D0", active_amount);

        // sa discount description
        split_desc = discountdesc.split("<>");
        split_count = split_desc.length;

        var cont_discount = "";
        discount = 0;
        for(a=0; a<split_count-1; a++){
            int_amount = eval(split_discount[a].replace("D0", active_amount));
            discount += int_amount;
            cont_discount += split_desc[a]+int_amount.toFixed(2);
        }
        new_amount = active_amount - discount;

        $(".discount"+tfo_nature_id).val(discount);
        $(".taxdue"+tfo_nature_id).val(new_amount);
        discountdesc = cont_discount;
        $(".discountdesc"+tfo_nature_id).val(discountdesc);

        // recalculate taxdue

        var count = 0;
        var total_due = 0;
        $(".tax_due_c").each(function() {
            total_due += parseFloat($(this).val());
        });
        total_due = total_due.toFixed(2);

        $(".total_tax_due").val(total_due);
        
    });

    

</script>
