<?php

$gross_sub_acc = "4-01-03-030-1";

// SA onlineeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
// SA onlineeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
// SA onlineeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee
if($type_of_include == "bpls_payment_verification"){
    $sur = 0;

    // select business
    $q864 = mysqli_query($conn," SELECT geo_bpls_ol_application.b_name, geo_bpls_ol_application.permit_id from geo_bpls_ol_application inner join geo_bpls_business_permit on geo_bpls_business_permit.permit_id = geo_bpls_ol_application.permit_id where md5(geo_bpls_ol_application.permit_id) = '$id' ");
    $r864 = mysqli_fetch_assoc($q864);

    //   old business bactaxess
    $q11 = mysqli_query($conn,"SELECT retirement_date_processed, retirement_file, 4PS_status, PWD_status, SP_status, permit_for_year ,geo_bpls_owner.owner_id, geo_bpls_business_permit.permit_approved_remark, geo_bpls_business_permit.permit_approved,permit_id, civil_status_id, geo_bpls_business.business_id, business_emergency_contact, geo_bpls_business_permit.payment_frequency_code, status_code, step_code, permit_application_date, business_name, geo_bpls_business.barangay_id as b_barangay_id , business_type_code, economic_area_code, economic_org_code, geo_bpls_business.lgu_code as b_lgu_code, occupancy_code, geo_bpls_business.province_code as b_province_code, geo_bpls_business.region_code as b_reg_code, scale_code, sector_code, business_address_street, business_application_date, business_area, business_mob_no, business_tel_no, business_contact_name, business_dti_sec_cda_reg_date, business_dti_sec_cda_reg_no, business_email, business_email, business_emergency_email, business_emergency_mobile, business_employee_resident, business_employee_total,business_tax_incentive, business_tax_incentive_entity, business_tin_reg_no, business_trade_name_franchise, owner_first_name, owner_middle_name, owner_last_name, geo_bpls_owner.barangay_id as o_barangay_id, citizenship_id,gender_code, geo_bpls_owner.lgu_code as o_lgu_code, geo_bpls_owner.province_code as o_province_code, geo_bpls_owner.region_code as o_reg_code, geo_bpls_owner.zone_id as o_zone_id, geo_bpls_owner.owner_address_street, owner_birth_date, owner_email,owner_legal_entity, owner_mobile FROM `geo_bpls_business_permit`
    INNER JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id
    INNER JOIN geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id
    WHERE md5(geo_bpls_business_permit.permit_id) = '$id' ");
    
    $r11 = mysqli_fetch_assoc($q11);

    
    // business address

    $permit_id_dec = $r11["permit_id"];
    $status_code = $r11["status_code"];
    $q = mysqli_query($conn,"SELECT status_desc from geo_bpls_status where status_code = '$status_code' ");
    $r = mysqli_fetch_assoc($q);
    $status_desc = $r["status_desc"];
    
    $mode_of_payment_code = $r11["payment_frequency_code"];

    $q = mysqli_query($conn,"SELECT payment_frequency_desc from geo_bpls_payment_frequency where payment_frequency_code = '$mode_of_payment_code' ");
    $r = mysqli_fetch_assoc($q);
    $mode_of_payment = $r["payment_frequency_desc"];

    $business_id = $r11["business_id"];
    $q = mysqli_query($conn,"SELECT step_code from geo_bpls_business_permit where md5(permit_id) = '$id'");
    $r = mysqli_fetch_assoc($q);
    $step_code1 = $r["step_code"];

    $q = mysqli_query($conn,"SELECT step_desc from geo_bpls_step where step_code = '$step_code1' ");
    $r = mysqli_fetch_assoc($q);
    $step_code = $r["step_desc"];
    $permit_application_date = $r11["permit_application_date"];
  // ============================================
  $unpaid_amount1 = 0;
  //  for approval
$permit_approved = $r11["permit_approved"];
// getting backtaxes in same business owner 
$owner_id = $r11["owner_id"];
  // getting permit id

// checking kung paid backtax na
$yeardd = date("Y");
$qq1 = mysqli_query($conn, "SELECT permit_no, permit_id, step_code FROM `geo_bpls_business_permit` where owner_id = '$owner_id' and md5(permit_id) != '$id'  and (permit_for_year != '2017' and permit_for_year != '2018' and permit_for_year != '2019'  and permit_for_year != '2020' and permit_for_year  != '$yeardd' )    ");
$permit_no = "";


while($rr1 = mysqli_fetch_assoc($qq1)){

$step_code_11 = $rr1["step_code"];

// get total Assessment amount
$abc =  $rr1["permit_id"];

$backtax_permit_id = $abc;


$qq2 = mysqli_query($conn, "SELECT sum(assessment_tax_due) as ass_tot FROM `geo_bpls_assessment` where permit_id = '$backtax_permit_id' ");
$q4570 = mysqli_query($conn,"SELECT * FROM `geo_bpls_payment_paid_backtax` where  permit_id = '$backtax_permit_id' ");
if(mysqli_num_rows($q4570) > 0){
  $status = "backtax paid";
}else{
  $status = "backtax unpaid";
}
if($status == "backtax unpaid"){

//   if ($_SESSION["uname"] == "admin") {
//       // echo "SELECT * FROM `geo_bpls_payment_paid_backtax` where  permit_id = '$backtax_permit_id' ";
//           echo $business_id."<br>";
//           echo $id."<br>";
//           echo  $abc."<br>";
//       }


$rr2 = mysqli_fetch_assoc($qq2);           
$qq3 = mysqli_query($conn, "SELECT payment_backtax as payment_backtaxs, sum(payment_surcharge) as payment_surcharges ,sum(payment_total_amount_paid) as paid_tot FROM `geo_bpls_payment` where permit_id = '$abc' ");
  $rr3 = mysqli_fetch_assoc($qq3);
  $sur111 = $rr3["payment_surcharges"];

  // kukunin yung binayaran na backtax ng prev year
  $prev_paid_amount = 0;
  $normal_backtaxt = 0;
  $backtax_arr = explode('+',$rr3["payment_backtaxs"]);
  if(count($backtax_arr) == 3){
      $prev_paid_amount = floatval($backtax_arr[2]);
      $back = floatval($backtax_arr[1]);
  }
  // kukunin yung binayaran na backtax ng current year
  if(count($backtax_arr) == 2){
      $back = floatval($backtax_arr[0]) + floatval($backtax_arr[1]);
  }

  // get surcharges
  $sur111 =0;
  if($sur111 == null){
      $sur111 = 0;
  }
  if($back == null){
      $back = 0;
  }
  
  $ass_to =  $rr2["ass_tot"] * 1;
  $paid_am = (($rr3["paid_tot"] * 1) - ($back + $sur111));

  $paid_am = $paid_am - $prev_paid_amount;
  if($rr2["ass_tot"] > $paid_am){
      
      $unpaid = $rr2["ass_tot"] - $paid_am;
      if($unpaid != "0" && $step_code_11 === "RELEA" ){
          $unpaid_amount1 += $unpaid;
          $permit_no .= $rr1["permit_no"]." &nbsp;";
      }
    }
}
}

$surc_prev_year  = 0;
// unpaid_amount1 is backtax for prev year
if($unpaid_amount1>0 && $status == "backtax unpaid"){
// if($unpaid_amount1==99999999){

      // check if surcharges and penalty  is set in penalty_table
      $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

      $penalty_r = mysqli_fetch_assoc($penalty_q);

      if ($penalty_r["surcharge_on"] == 1) {
          $surcharges_rate = $penalty_r["surcharge_rate"];
      } else {
          $surcharges_rate = 0;
      }

 // check if surcharges is set in onsurcharge_on in penalty_table
   $surc_prev_year = $unpaid_amount1 * $penalty_r["surcharge_rate"];

}else{
  $unpaid_amount1 = 0;
}
// ============================================
// ============================================

   
?>
      
      <tbody id="p_scents">
          <tr style="color:white; background:green;">
                 
                <td colspan="4">
                    <i><?php echo strtoupper($r864["b_name"]); ?></i>
                     <input type="hidden" name="pi[]" value="<?php echo me_encrypt($r864["permit_id"]); ?>">
                    <input type="hidden" name="business_name[]" value="<?php echo me_encrypt($r864["b_name"]); ?>">
                    <input type="hidden" name="payment_mode[]" value="<?php echo me_encrypt($mode_of_payment); ?>">
                </td>
          </tr>
                 <?php
                    $q_payments = mysqli_query($conn, "SELECT natureOfCollection_tbl.id as sub_account_no, sum(assessment_tax_due) as assessment_tax_due FROM `geo_bpls_assessment` inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id inner join natureOfCollection_tbl  on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no where md5(permit_id) = '$id' and assessment_tax_due != 0 GROUP by natureOfCollection_tbl.id ");

        // check 1st payment in quarter
        $check_part1_quarter = mysqli_query($conn,"SELECT payment_date FROM `geo_bpls_payment` where  md5(permit_id) = '$id'  ORDER BY `geo_bpls_payment`.`payment_date` DESC limit 1");
        $check_part1_quarter_row = mysqli_fetch_assoc($check_part1_quarter);
        $check_part1_count = mysqli_num_rows($check_part1_quarter);
        $last_payment_date_arr = explode(" ", $check_part1_quarter_row["payment_date"]);

                
        if ($check_part1_count == 1) {
            //  get last day and f day of latest payment
            $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
            $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
            $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "03" . "-31";
            //  get last day and f day of latest payment
        } elseif ($check_part1_count == 2) {
            //  get last day and f day of latest payment
            $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
            $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
            $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "06" . "-31";
            //  get last day and f day of latest payment
        } elseif ($check_part1_count == 3) {
            //  get last day and f day of latest payment
            $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
            $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
            $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "09" . "-31";
            //  get last day and f day of latest payment
        } elseif ($check_part1_count == 4) {
            //  get last day and f day of latest payment
            $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
            $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
            $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "12" . "-31";
            //  get last day and f day of latest payment
        }

        

        $current_quarter = 0;
        $active_quarter = 0;
        $done_quarter = 0;
        $p_total = 0;
        $gross_tax = 0;
        $sur_counter = 0;
        $backtax = 0;
        $backtax_tax = 0;
        $backtax_fee = 0;
        $advance_payment = 0;
        $total_advance_payment = 0;
        $advances_count = 0;

        $date_now = date("Y-m-d"); 
       while($r_payments = mysqli_fetch_assoc($q_payments)){
        $sub_account_no = $r_payments["sub_account_no"];
        // getting account tittle
        $q454a = mysqli_query($conn,"SELECT natureOfCollection_tbl.name as sub_account_title from natureOfCollection_tbl where id = '$sub_account_no' ");
        $r454a = mysqli_fetch_assoc($q454a);

        // getting nature_id
         $q22a = mysqli_query($conn,"SELECT nature_id from geo_bpls_business_permit_nature where md5(permit_id) = '$id' ");
         $r22a = mysqli_fetch_assoc($q22a);
         $nature_id = $r22a["nature_id"];
                    ?>
                    <tr>
        <?php
     if ($mode_of_payment == "Quarterly") {
        $division_no = 4;
        // Quarter ------------------------------------
        // cheking date of paymemnts
        $p_date_q = mysqli_query($conn, "SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");

        $p_date_r = mysqli_fetch_assoc($p_date_q);
        // cheking date of paymemnts

        // check if surcharges and penalty  is set in penalty_table
        $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

        $penalty_r = mysqli_fetch_assoc($penalty_q);

        if ($penalty_r["surcharge_on"] == 1) {
            $surcharges_rate = $penalty_r["surcharge_rate"];
        } else {
            $surcharges_rate = 0;
        }

        if ($penalty_r["interest_on"] == 1) {
            $penalty_rate = $penalty_r["surcharge_rate"];
        } else {
            $penalty_rate = 0;
        }
            // check if surcharges is set in onsurcharge_on in penalty_table
           $check_part_quarter = mysqli_query($conn, "SELECT payment_part FROM `geo_bpls_payment` WHERE md5(permit_id) = '$id' order by payment_id DESC limit 1 ");

           
            $check_part_quarter_row = mysqli_fetch_assoc($check_part_quarter);
            $paidQTR = $check_part_quarter_row["payment_part"];
            if ($paidQTR == "" || $paidQTR == null || $paidQTR == 0) {
                $paidQTR = 0;
            }
            $m = date("m");
            // important in current quarter 3 for division of year into 4 quarter
            $current_quarter = floor(($m - 1) / 3) + 1;
            
            for ($am = 1; $am < 5; $am++) {
                $year = date("Y");
                $aa1 = $year . "-" . $p_date_r["payment_qtrdue" . $am];

                $date_arr = explode('-', $p_date_r["payment_qtrdue" . $am]);
                $month_start = $year . "-" . $date_arr[0] . "-01";
                // surcharges counter
                if ($am > $paidQTR) {
                    if ($date_now > $aa1) {
                        $sur_counter++;
                    }
                }
                // check what payment quarter
             }
             
            
        ?>
       <td class="abc" colspan="3"  style="width: 70%; font-size: 14px;">
                <?php echo $r454a["sub_account_title"]; ?>
      </td>
       <td class="abc"
    style="width: 25%; text-align:right; font-size: 14px;">
        <?php

            
    $vav = str_replace(',', '', number_format(($r_payments["assessment_tax_due"] / $division_no), 2));
   
        // advance payment algo
            // -----------------------------------------------------------------------------------
            $qtr_fixer = 0;
            // ang $to ay na sa eservices_receiver
            $qtr_count = $current_quarter - $paidQTR;
            if($from>$current_quarter){
                // kelangan mag lagay ng advances bills
                  $qtr_fixer = abs($to - $from);
                  
                  if ($qtr_count > 1) {
                    if ($r_payments["sub_account_no"] == "$gross_sub_acc") {
                        $backtax_tax += $vav * ($qtr_count -1);
                    } else {
                        $backtax_fee += $vav * ($qtr_count -1);
                    }
                    $backtax += $vav * ($qtr_count - 1);
                    $payment_qtr =  $paidQTR + ($qtr_count - 1) + 1;
                }else{
                    $payment_qtr =  $paidQTR +1;
                }
                // pag dadagdag ng advance payment
                $total_advance_payment += $vav * $qtr_fixer;
                $advance_payment = $vav * $qtr_fixer;
                $p_total += $vav;
                // bill amount katumbas ng babayaran per qtr not included all
                $bill_amount = $p_total;
                $total_bill_amount = $vav + $advance_payment;
                
            }else{
                $qtr_fixer = $to - $current_quarter;

                if($qtr_count > 1) {
                    if ($r_payments["sub_account_no"] == "$gross_sub_acc") {
                        $backtax_tax += $vav * ($qtr_count -1);
                    } else {
                        $backtax_fee += $vav * ($qtr_count -1);
                    }
                    $backtax += $vav * ($qtr_count - 1);
                    $payment_qtr =  $paidQTR + ($qtr_count - 1) + 1;
                }else{
                    $payment_qtr =  $paidQTR +1;
                }
                // pag dadagdag ng advance payment
                $total_advance_payment += $vav * $qtr_fixer;
                $advance_payment = $vav * $qtr_fixer;
                $p_total += $vav;
                // bill amount katumbas ng babayaran per qtr not included all
                $bill_amount = $p_total;
                $total_bill_amount = $vav + $advance_payment;
                

            }
            
            // advance payment algo
            // -----------------------------------------------------------------------------------

  
    echo number_format($total_bill_amount, 2);
    ?>
        <!-- Quarter input -->
    <?php
       // encyption of data
        // combination string payment_qtr/sub_account_title/nature_id/amount/sub_account_no/permit_id
        $combination = $payment_qtr ."<>";
        $combination .= $r454a["sub_account_title"] ."<>";
        $combination .= $nature_id ."<>";
        $combination .= $total_bill_amount."<>";
        $combination .= $r_payments["sub_account_no"]."<>";
        $combination .= $r864["permit_id"];
        $combination = me_encrypt($combination);
        echo '<input type="hidden" name="combination_data[]" value="'.$combination.'">';
        // encyption of data
    
    ?>
        </td>
            <!--Quarter input -->
        <?php
// end of if for cheking payment part1
      }elseif ($mode_of_payment == "Semi-annual") {
          
        $division_no = 2;
        // Quarter ------------------------------------
        // cheking date of paymemnts
        $p_date_q = mysqli_query($conn, "SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");

        $p_date_r = mysqli_fetch_assoc($p_date_q);
        // cheking date of paymemnts

        // check if surcharges and penalty  is set in penalty_table
        $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

        $penalty_r = mysqli_fetch_assoc($penalty_q);

        if ($penalty_r["surcharge_on"] == 1) {
            $surcharges_rate = $penalty_r["surcharge_rate"];
        } else {
            $surcharges_rate = 0;
        }

        if ($penalty_r["interest_on"] == 1) {
            $penalty_rate = $penalty_r["surcharge_rate"];
        } else {
            $penalty_rate = 0;
        }
            // check if surcharges is set in onsurcharge_on in penalty_table
           $check_part_quarter = mysqli_query($conn, "SELECT payment_part FROM `geo_bpls_payment` WHERE md5(permit_id) = '$id' order by payment_id DESC limit 1 ");

           
            $check_part_quarter_row = mysqli_fetch_assoc($check_part_quarter);
            $paidQTR = $check_part_quarter_row["payment_part"];
            if ($paidQTR == "" || $paidQTR == null || $paidQTR == 0) {
                $paidQTR = 0;
            }
                    $m = date("m");
                    // important in current quarter 3 for division of year into 4 quarter
                    $current_quarter = floor(($m - 1) / 6) + 1;
                    for ($am = 1; $am < 3; $am++) {
                    $year = date("Y");
                    $aa1 = $year . "-" . $p_date_r["payment_semdue" . $am];

                    $date_arr = explode('-', $p_date_r["payment_semdue" . $am]);
                    $month_start = $year . "-" . $date_arr[0] . "-01";
                    // surcharges counter
                    if ($am > $paidQTR) {
                        if ($date_now > $aa1) {
                            $sur_counter++;
                        }
                    }
                // check what payment quarter
             }
             
            
        ?>
       <td class="abc" colspan="3"  style="width: 70%; font-size: 14px;">
                <?php echo $r454a["sub_account_title"]; ?>
      </td>
       <td class="abc"
    style="width: 25%; text-align:right; font-size: 14px;">
        <?php

            
    $vav = str_replace(',', '', number_format(($r_payments["assessment_tax_due"] / $division_no), 2));
   
        // advance payment algo
            // -----------------------------------------------------------------------------------
            $qtr_fixer = 0;
            // ang $to ay na sa eservices_receiver
            $qtr_count = $current_quarter - $paidQTR;
            if($from>$current_quarter){
                // kelangan mag lagay ng advances bills
                  $qtr_fixer = abs($to - $from);
                  
                  if ($qtr_count > 1) {
                    if ($r_payments["sub_account_no"] == "$gross_sub_acc") {
                        $backtax_tax += $vav * ($qtr_count -1);
                    } else {
                        $backtax_fee += $vav * ($qtr_count -1);
                    }
                    $backtax += $vav * ($qtr_count - 1);
                    $payment_qtr =  $paidQTR + ($qtr_count - 1) + 1;
                }else{
                    $payment_qtr =  $paidQTR +1;
                }
                // pag dadagdag ng advance payment
                $total_advance_payment += $vav * $qtr_fixer;
                $advance_payment = $vav * $qtr_fixer;
                $p_total += $vav;
                // bill amount katumbas ng babayaran per qtr not included all
                $bill_amount = $p_total;
                $total_bill_amount = $vav + $advance_payment;
                
            }else{
                $qtr_fixer = $to - $current_quarter;

                if($qtr_count > 1) {
                    if ($r_payments["sub_account_no"] == "$gross_sub_acc") {
                        $backtax_tax += $vav * ($qtr_count -1);
                    } else {
                        $backtax_fee += $vav * ($qtr_count -1);
                    }
                    $backtax += $vav * ($qtr_count - 1);
                    $payment_qtr =  $paidQTR + ($qtr_count - 1) + 1;
                }else{
                    $payment_qtr =  $paidQTR +1;
                }
                // pag dadagdag ng advance payment
                $total_advance_payment += $vav * $qtr_fixer;
                $advance_payment = $vav * $qtr_fixer;
                $p_total += $vav;
                // bill amount katumbas ng babayaran per qtr not included all
                $bill_amount = $p_total;
                $total_bill_amount = $vav + $advance_payment;
                

            }
            
            // advance payment algo
            // -----------------------------------------------------------------------------------

  
    echo number_format($total_bill_amount, 2);
    ?>
        <!-- Quarter input -->
    <?php
       // encyption of data
        // combination string payment_qtr/sub_account_title/nature_id/amount/sub_account_no/permit_id
        $combination = $payment_qtr ."<>";
        $combination .= $r454a["sub_account_title"] ."<>";
        $combination .= $nature_id ."<>";
        $combination .= $total_bill_amount."<>";
        $combination .= $r_payments["sub_account_no"]."<>";
        $combination .= $r864["permit_id"];
        $combination = me_encrypt($combination);
        echo '<input type="hidden" name="combination_data[]" value="'.$combination.'">';
        // encyption of data
    
    ?>
        </td>
            <!--Quarter input -->
        <?php
// end of if for cheking payment part1
      
      } else {
        // Annual payment

    // check if surcharges and penalty  is set in penalty_table
    $penalty_q = mysqli_query($conn,"SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");
    
    $penalty_r = mysqli_fetch_assoc($penalty_q);

    if($penalty_r["surcharge_on"] == 1){
        $surcharges_rate = $penalty_r["surcharge_rate"];
    }else{
        $surcharges_rate = 0;
    }

    if($penalty_r["interest_on"] == 1){
        $penalty_rate = $penalty_r["surcharge_rate"];
    }else{
        $penalty_rate = 0;
    }
    // check if surcharges is set in onsurcharge_on in penalty_table

    // cheking date of paymemnts
    $p_date_q = mysqli_query($conn,"SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");
    
    $p_date_r = mysqli_fetch_assoc($p_date_q);
        // cheking date of paymemnts
    
$year = date("Y");
$aa1 = $year . "-" . $p_date_r["payment_anndue1"];

// surcharges counter
// fecthing date of not paid quarter
        if ($date_now > $aa1 ){
            $sur_counter++;
        }
     // annual -----------------------------
    ?>
    <td class="abc" colspan="3"  style="width: 70%; font-size: 14px;">
      <?php echo $r454a["sub_account_title"]; ?>
    </td>
    <td class="abc" style="width: 25%; text-align:right; font-size: 14px;">
   <?php
            $mnmn = str_replace(',', '', number_format($r_payments["assessment_tax_due"],2)); 
            $p_total += $mnmn;
            $bill_amount = $mnmn;
            echo number_format($mnmn,2);
    ?>
         <!-- Annual input -->
           <?php
            // encyption of data
            // combination string payment_qtr/sub_account_title/nature_id/amount/sub_account_no
            $combination = "1<>";
            $combination .= $r454a["sub_account_title"] . "<>";
            $combination .= $nature_id . "<>";
            $combination .= $mnmn . "<>";
            $combination .= $r_payments["sub_account_no"]."<>";
            $combination .= $r864["permit_id"];
            $combination = me_encrypt($combination);
            echo '<input type="hidden" name="combination_data[]" value="' . $combination . '">';
            // encyption of data

            ?>
         <!-- Annual input -->

    <?php

    $payment_qtr = 1;
    }
    ?>
    </td>
    </tr>
    <?php
    } 
        // setting Backtaxes
   ?>
   <?php 
         $backtax = str_replace(',','',number_format($backtax,2));


         
    if($backtax>0 || $unpaid_amount1 > 0){
        //   eval( '$backtax_var = (' . $backtax_var. ');' );
        ?>
   <tr>
        <td class="abc" colspan="3" style="width:  70%; font-size: 14px;">
            BACKTAXES 
         </td>
        <td class="abc"  style="width: 25%; text-align:right; font-size: 14px;">
        <?php

          if($unpaid_amount1 != 0){
                $backtax += $unpaid_amount1;
                // update 12522
           ?>
         <input type="hidden"  name="backtax_permit_id[]" class="form-control " value="<?php echo me_encrypt($backtax_permit_id); ?>" >
         <input type="hidden"  name="backtax_amount[]" class="form-control " value="<?php echo me_encrypt($unpaid_amount1); ?>" >
         <?php
                                                            // update 12522
          }

         echo $backtax;
        if ($unpaid_amount1 == 0) {
            $backtax_var = $backtax_tax . " + " . $backtax_fee;
        } else {
            $backtax_var = $backtax_tax . " + " . $backtax_fee . " + " . $unpaid_amount1;
        }
        //   eval( '$backtax_var = (' . $backtax_var. ');' );
        ?>
        <!-- Bakctax input -->
        <input type="hidden"  name="backtax[]" class="form-control backtax_class total_amount_counter" value="<?php echo me_encrypt($backtax_var); ?>" >
        <?php $p_total += $backtax; ?>
    </tr>
<?php  }else{
        ?>
      <input type="hidden"  name="backtax[]" class="form-control backtax_class total_amount_counter" value="<?php echo me_encrypt("0.00"); ?>" >
        <?php
    } ?>
         </td>
            <!-- <tr>
            <td>
                <?php
                    // echo $sur_counter;
                ?>
            </td>
            </tr> -->
            <?php 
             // advance payment surch algo
            // -----------------------------------------------------------------------------------
            if($to>$current_quarter){
                // kelangan mag lagay ng advances bills
                $advances_count = $to - $current_quarter;
                if($mode_of_payment=="Annual"){
                    $advances_count = 0;
                }
            }
            // pagkuha ng amount due, pwede na rin masama bactaxes
            $amount_due = $p_total;
            // -----------------------------------------------------------------------------------      
    //    if ($status_code != "NEW") {
            if($sur_counter != 0 ) {
                $sur = $p_total * $surcharges_rate; 
                // total w/o backtax and surcharges
         
                $clear_amount = $p_total;
                $p_total += $sur;
                if($sur > 0){
                ?>
                <tr>
                    <td class="abc" colspan="3" style="width:  70%; font-size: 14px;">
                        SURCHARGES 
                    </td>
                    <td class="abc" style="width: 25%; text-align:right; font-size: 14px;">
        <!-- Surcharges input -->   <span class="surcharges_class">
                <?php 
                    echo number_format($sur,2);
                ?>
                </span>
                  <input type="hidden" name="surcharges[]" class="form-control  surcharges_class_orig" value="<?php echo me_encrypt($sur); ?>" >
                  <input type="hidden" class="form-control total_amount_counter surcharges_class_hi" value="<?php echo $sur; ?>" >
                  </td>
                </tr>
            <?php }else{
                ?>
                <input type="hidden" name="surcharges[]" class="form-control  surcharges_class_orig" value="<?php echo me_encrypt("0.00"); ?>" >
                <input type="hidden" class="form-control total_amount_counter surcharges_class_hi" value="<?php echo $sur; ?>" >
                <?php
            } } 
            // }else{
                ?>
                <!-- <input type="hidden" name="surcharges[]" class="form-control  surcharges_class_orig" value="<?php //echo me_encrypt("0.00"); ?>" >
                <input type="hidden" class="form-control total_amount_counter surcharges_class_hi" value="<?php //echo $sur; ?>" > -->
                <?php
            // }
             ?>
                </tbody>
                  <input type="hidden" name="amount_due[]" class="form-control" value="<?php echo me_encrypt($amount_due); ?>" >
                  <input type="hidden" name="payment_qtr[]" class="form-control" value="<?php echo me_encrypt($payment_qtr); ?>" >
                  <input type="hidden" name="advance_count[]" class="form-control" value="<?php echo me_encrypt($advances_count); ?>" >
                  <input type="hidden" name="advance_amount[]" class="form-control" value="<?php echo me_encrypt($total_advance_payment); ?>" >
               
        
    <?php           
                        // gagamitin ko sa pag vavalidate ng total amount ng business
                        echo "<#+>".($p_total+$total_advance_payment);
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

 



    }elseif($type_of_include == "fetching_unpdaid"){
       
    $sur = 0;
    $q_payments = mysqli_query($conn, "SELECT natureOfCollection_tbl.id as sub_account_no, sum(assessment_tax_due) as assessment_tax_due FROM `geo_bpls_assessment` inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no where md5(permit_id) = '$id' and assessment_tax_due != 0 GROUP by natureOfCollection_tbl.id ");

    
    //   old business bactaxess
    $q11 = mysqli_query($conn,"SELECT retirement_date_processed, retirement_file, 4PS_status, PWD_status, SP_status, permit_for_year ,geo_bpls_owner.owner_id, geo_bpls_business_permit.permit_approved_remark, geo_bpls_business_permit.permit_approved,permit_id, civil_status_id, geo_bpls_business.business_id, business_emergency_contact, geo_bpls_business_permit.payment_frequency_code, status_code, step_code, permit_application_date, business_name, geo_bpls_business.barangay_id as b_barangay_id , business_type_code, economic_area_code, economic_org_code, geo_bpls_business.lgu_code as b_lgu_code, occupancy_code, geo_bpls_business.province_code as b_province_code, geo_bpls_business.region_code as b_reg_code, scale_code, sector_code, business_address_street, business_application_date, business_area, business_mob_no, business_tel_no, business_contact_name, business_dti_sec_cda_reg_date, business_dti_sec_cda_reg_no, business_email, business_email, business_emergency_email, business_emergency_mobile, business_employee_resident, business_employee_total,business_tax_incentive, business_tax_incentive_entity, business_tin_reg_no, business_trade_name_franchise, owner_first_name, owner_middle_name, owner_last_name, geo_bpls_owner.barangay_id as o_barangay_id, citizenship_id,gender_code, geo_bpls_owner.lgu_code as o_lgu_code, geo_bpls_owner.province_code as o_province_code, geo_bpls_owner.region_code as o_reg_code, geo_bpls_owner.zone_id as o_zone_id, geo_bpls_owner.owner_address_street, owner_birth_date, owner_email,owner_legal_entity, owner_mobile FROM `geo_bpls_business_permit`
    INNER JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id
    INNER JOIN geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id
    WHERE md5(geo_bpls_business_permit.permit_id) = '$id' ");
    
    $r11 = mysqli_fetch_assoc($q11);

    $permit_id_dec = $r11["permit_id"];
    $status_code = $r11["status_code"];
    $q = mysqli_query($conn,"SELECT status_desc from geo_bpls_status where status_code = '$status_code' ");
    $r = mysqli_fetch_assoc($q);
    $status_desc = $r["status_desc"];
    
    $mode_of_payment_code = $r11["payment_frequency_code"];

    $q = mysqli_query($conn,"SELECT payment_frequency_desc from geo_bpls_payment_frequency where payment_frequency_code = '$mode_of_payment_code' ");
    $r = mysqli_fetch_assoc($q);
    $mode_of_payment = $r["payment_frequency_desc"];

    $business_id = $r11["business_id"];
    $q = mysqli_query($conn,"SELECT step_code from geo_bpls_business_permit where md5(permit_id) = '$id'");
    $r = mysqli_fetch_assoc($q);
    $step_code1 = $r["step_code"];

    $q = mysqli_query($conn,"SELECT step_desc from geo_bpls_step where step_code = '$step_code1' ");
    $r = mysqli_fetch_assoc($q);
    $step_code = $r["step_desc"];
    $permit_application_date = $r11["permit_application_date"];
 
    $unpaid_amount1 = 0;
        
            //  for approval
       $permit_approved = $r11["permit_approved"];
        // getting backtaxes in same business owner 
        $owner_id = $r11["owner_id"];
            // getting permit id

        // checking kung paid backtax na
       $yeardd = date("Y");
        $qq1 = mysqli_query($conn, "SELECT permit_no, permit_id, step_code FROM `geo_bpls_business_permit` where owner_id = '$owner_id' and md5(permit_id) != '$id'  and (permit_for_year != '2017' and permit_for_year != '2018' and permit_for_year != '2019'  and permit_for_year != '2020' and permit_for_year  != '$yeardd' )    ");
        $permit_no = "";


        while($rr1 = mysqli_fetch_assoc($qq1)){
        
        $step_code_11 = $rr1["step_code"];

        // get total Assessment amount
        $abc =  $rr1["permit_id"];

        $backtax_permit_id = $abc;

        $qq2 = mysqli_query($conn, "SELECT sum(assessment_tax_due) as ass_tot FROM `geo_bpls_assessment` where permit_id = '$abc' ");

         $q4570 = mysqli_query($conn,"SELECT * FROM `geo_bpls_payment_paid_backtax` where  permit_id = '$backtax_permit_id' ");
        if(mysqli_num_rows($q4570) > 0){
            $status = "backtax paid";
        }else{
            $status = "backtax unpaid";
        }
        if($status == "backtax paid"){
            $unpaid_amount1 = 0;
        }
        $rr2 = mysqli_fetch_assoc($qq2);
           
        $qq3 = mysqli_query($conn, "SELECT sum(payment_backtax) as payment_backtaxs, sum(payment_surcharge) as payment_surcharges ,sum(payment_total_amount_paid) as paid_tot FROM `geo_bpls_payment` where permit_id = '$abc' ");
            $rr3 = mysqli_fetch_assoc($qq3);
            $sur111 = $rr3["payment_surcharges"];
            $back = $rr3["payment_backtaxs"];
            if($sur111 == null){
                $sur111 = 0;
            }
            if($back == null){
                $back = 0;
            }
        
            $ass_to =  $rr2["ass_tot"] * 1;
            $paid_am = (($rr3["paid_tot"] * 1) - ($back + $sur111));
            if($rr2["ass_tot"] > $paid_am){
                $unpaid = $rr2["ass_tot"] - $paid_am;
                if($unpaid != "0" && $step_code_11 === "RELEA"){
                    $unpaid_amount1 += $unpaid;
                }
              }
        }

    
    //   old business bactaxess


    // check 1st payment in querter
    $check_part1_quarter = mysqli_query($conn, "SELECT payment_date FROM `geo_bpls_payment` where  md5(permit_id) = '$id'  ORDER BY `geo_bpls_payment`.`payment_date` ");
    $check_part1_count = mysqli_num_rows($check_part1_quarter);
    $check_part1_quarter_row = mysqli_fetch_assoc($check_part1_quarter);
    $last_payment_date_arr = explode(" ", $check_part1_quarter_row["payment_date"]);
    if ($check_part1_count == 1) {
        //  get last day and f day of latest payment
        $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
        $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
        $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "03" . "-31";
        //  get last day and f day of latest payment
    } elseif ($check_part1_count == 2) {
        //  get last day and f day of latest payment
        $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
        $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
        $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "06" . "-31";
        //  get last day and f day of latest payment
    } elseif ($check_part1_count == 3) {
        //  get last day and f day of latest payment
        $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
        $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
        $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "09" . "-31";
        //  get last day and f day of latest payment
    } elseif ($check_part1_count == 4) {
        //  get last day and f day of latest payment
        $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
        $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
        $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "12" . "-31";
        //  get last day and f day of latest payment
    }

    $check_part_quarter = mysqli_query($conn, "SELECT payment_part FROM `geo_bpls_payment` WHERE md5(permit_id) = '$id' order by payment_id DESC limit 1 ");
    $check_part_quarter_row = mysqli_fetch_assoc($check_part_quarter);

    if ($check_part_quarter_row["payment_part"] == "") {
        $check_part_quarter_row["payment_part"] = 0;
    }
    $currentQTR = $check_part_quarter_row["payment_part"] + 1;

    $current_quarter = 0;
    $active_quarter = 0;
    $done_quarter = 0;
    $p_total = 0;
    $gross_tax = 0;
    $sur_counter = 0;
    $backtax = 0;
    $backtax_tax = 0;
    $backtax_fee = 0;
    $backtax022 = 0;
    $date_now = date("Y-m-d");

    while ($r_payments = mysqli_fetch_assoc($q_payments)) {
    if ($mode_of_payment == "Quarterly") {
        $division_no = 4;
        // Quarter ------------------------------------
        // cheking date of paymemnts
        $p_date_q = mysqli_query($conn, "SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");

        $p_date_r = mysqli_fetch_assoc($p_date_q);
        // cheking date of paymemnts

        // check if surcharges and penalty  is set in penalty_table
        $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

        $penalty_r = mysqli_fetch_assoc($penalty_q);

        if ($penalty_r["surcharge_on"] == 1) {
            $surcharges_rate = $penalty_r["surcharge_rate"];
        } else {
            $surcharges_rate = 0;
        }

        if ($penalty_r["interest_on"] == 1) {
            $penalty_rate = $penalty_r["surcharge_rate"];
        } else {
            $penalty_rate = 0;
        }
        // check if surcharges is set in onsurcharge_on in penalty_table
        $check_part_quarter = mysqli_query($conn, "SELECT payment_part FROM `geo_bpls_payment` WHERE md5(permit_id) = '$id' order by payment_id DESC limit 1 ");
        $check_part_quarter_row = mysqli_fetch_assoc($check_part_quarter);
        $paidQTR = $check_part_quarter_row["payment_part"];
        if ($paidQTR == "" || $paidQTR == null || $paidQTR == 0) {
            $paidQTR = 0;
        }
        $m = date("m");
        // important in current quarter 3 for division of year into 4 quarter
        $current_quarter = floor(($m - 1) / 3) + 1;

        
        for ($am = 1; $am < 5; $am++) {
            $year = date("Y");
            $aa1 = $year . "-" . $p_date_r["payment_qtrdue" . $am];

            $date_arr = explode('-', $p_date_r["payment_qtrdue" . $am]);
            $month_start = $year . "-" . $date_arr[0] . "-01";
            // surcharges counter
            if($am > $paidQTR) {
                if ($date_now > $aa1) {
                    $sur_counter++;
                }
            }
            // check what payment quarter
        }
        $vav = str_replace(',', '', number_format(($r_payments["assessment_tax_due"] / $division_no), 2));
        $qtr_count = $current_quarter - $paidQTR;
        if ($qtr_count > 1) {
            if ($r_payments["sub_account_no"] == "$gross_sub_acc") {
                $backtax_tax += $vav * ($qtr_count - 1);
            } else {
                $backtax_fee += $vav * ($qtr_count - 1);
            }
            $backtax += $vav * ($qtr_count - 1);
            $payment_qtr = $paidQTR + ($qtr_count - 1) + 1;
        } else {
            $payment_qtr = $paidQTR + 1;
        }
        $p_total += $vav;
    } elseif ($mode_of_payment == "Semi-annual") {
        $division_no = 2;
        // Quarter ------------------------------------
        // cheking date of paymemnts
        $p_date_q = mysqli_query($conn, "SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");

        $p_date_r = mysqli_fetch_assoc($p_date_q);
        // cheking date of paymemnts

        // check if surcharges and penalty  is set in penalty_table
        $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

        $penalty_r = mysqli_fetch_assoc($penalty_q);

        if ($penalty_r["surcharge_on"] == 1) {
            $surcharges_rate = $penalty_r["surcharge_rate"];
        } else {
            $surcharges_rate = 0;
        }

        if ($penalty_r["interest_on"] == 1) {
            $penalty_rate = $penalty_r["surcharge_rate"];
        } else {
            $penalty_rate = 0;
        }
        // check if surcharges is set in onsurcharge_on in penalty_table
        $check_part_quarter = mysqli_query($conn, "SELECT payment_part FROM `geo_bpls_payment` WHERE md5(permit_id) = '$id' order by payment_id DESC limit 1 ");
        $check_part_quarter_row = mysqli_fetch_assoc($check_part_quarter);
        $paidQTR = $check_part_quarter_row["payment_part"];
        if ($paidQTR == "" || $paidQTR == null || $paidQTR == 0) {
            $paidQTR = 0;
        }
        $m = date("m");
        // important in current quarter 3 for division of year into 4 quarter
        $current_quarter = floor(($m - 1) / 6) + 1;
        for ($am = 1; $am < 3; $am++) {
            $year = date("Y");
            $aa1 = $year . "-" . $p_date_r["payment_semdue" . $am];

            $date_arr = explode('-', $p_date_r["payment_semdue" . $am]);
            $month_start = $year . "-" . $date_arr[0] . "-01";
            // surcharges counter
            if ($am > $paidQTR) {
                if ($date_now > $aa1) {
                    $sur_counter++;
                }
            }
            // check what payment quarter
        }

        $vav = str_replace(',', '', number_format(($r_payments["assessment_tax_due"] / $division_no), 2));
        $qtr_count = $current_quarter - $paidQTR;
        if ($qtr_count > 1) {
            if ($r_payments["sub_account_no"] == "$gross_sub_acc") {
                $backtax_tax += $vav * ($qtr_count - 1);

            } else {
                $backtax_fee += $vav * ($qtr_count - 1);
            }
            $backtax += $vav * ($qtr_count - 1);
            $payment_qtr = $paidQTR + ($qtr_count - 1) + 1;
        } else {
            $payment_qtr = $paidQTR + 1;
        }
        $p_total += $vav;
    } else {
        // Annual payment
        // check if surcharges and penalty  is set in penalty_table
        $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

        $penalty_r = mysqli_fetch_assoc($penalty_q);

        if ($penalty_r["surcharge_on"] == 1) {
            $surcharges_rate = $penalty_r["surcharge_rate"];
        } else {
            $surcharges_rate = 0;
        }
        if ($penalty_r["interest_on"] == 1) {
            $penalty_rate = $penalty_r["surcharge_rate"];
        } else {
            $penalty_rate = 0;
        }
        // check if surcharges is set in onsurcharge_on in penalty_table
        // cheking date of paymemnts
        $p_date_q = mysqli_query($conn, "SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");

        $p_date_r = mysqli_fetch_assoc($p_date_q);
        // cheking date of paymemnts

        $year = date("Y");
        $aa1 = $year . "-" . $p_date_r["payment_anndue1"];

        // surcharges counter
        // fecthing date of not paid quarter
        if ($date_now > $aa1) {
            $sur_counter++;
        }
        $mnmn = str_replace(',', '', number_format($r_payments["assessment_tax_due"], 2));
        $p_total += $mnmn;
    }

}

  // total w/o backtax and surcharges

     $clear_amount = $p_total;
     
    // setting Backtaxes
    // BACKTAXES
    if($unpaid_amount1 > 0){
        $backtax = $backtax + $unpaid_amount1;
    }
    $backtax022 = str_replace(',', '', number_format($backtax, 2));
    // echo $backtax;---------------------------------------
    $p_total += $backtax;


 //=+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 //=+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 //=+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 //=+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 //=+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 //=+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 //=+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


    }else{

    
    $sur = 0;
    $q_payments = mysqli_query($conn, "SELECT natureOfCollection_tbl.id as sub_account_no, sum(assessment_tax_due) as assessment_tax_due FROM `geo_bpls_assessment` inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no where md5(permit_id) = '$id' and assessment_tax_due != 0 GROUP by natureOfCollection_tbl.id ");

    
    //   old business bactaxess
    $q11 = mysqli_query($conn,"SELECT retirement_date_processed, retirement_file, 4PS_status, PWD_status, SP_status, permit_for_year ,geo_bpls_owner.owner_id, geo_bpls_business_permit.permit_approved_remark, geo_bpls_business_permit.permit_approved,permit_id, civil_status_id, geo_bpls_business.business_id, business_emergency_contact, geo_bpls_business_permit.payment_frequency_code, status_code, step_code, permit_application_date, business_name, geo_bpls_business.barangay_id as b_barangay_id , business_type_code, economic_area_code, economic_org_code, geo_bpls_business.lgu_code as b_lgu_code, occupancy_code, geo_bpls_business.province_code as b_province_code, geo_bpls_business.region_code as b_reg_code, scale_code, sector_code, business_address_street, business_application_date, business_area, business_mob_no, business_tel_no, business_contact_name, business_dti_sec_cda_reg_date, business_dti_sec_cda_reg_no, business_email, business_email, business_emergency_email, business_emergency_mobile, business_employee_resident, business_employee_total,business_tax_incentive, business_tax_incentive_entity, business_tin_reg_no, business_trade_name_franchise, owner_first_name, owner_middle_name, owner_last_name, geo_bpls_owner.barangay_id as o_barangay_id, citizenship_id,gender_code, geo_bpls_owner.lgu_code as o_lgu_code, geo_bpls_owner.province_code as o_province_code, geo_bpls_owner.region_code as o_reg_code, geo_bpls_owner.zone_id as o_zone_id, geo_bpls_owner.owner_address_street, owner_birth_date, owner_email,owner_legal_entity, owner_mobile FROM `geo_bpls_business_permit`
    INNER JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id
    INNER JOIN geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id
    WHERE md5(geo_bpls_business_permit.permit_id) = '$id' ");
    
    $r11 = mysqli_fetch_assoc($q11);

    $permit_id_dec = $r11["permit_id"];
    $status_code = $r11["status_code"];
    $q = mysqli_query($conn,"SELECT status_desc from geo_bpls_status where status_code = '$status_code' ");
    $r = mysqli_fetch_assoc($q);
    $status_desc = $r["status_desc"];
    
    $mode_of_payment_code = $r11["payment_frequency_code"];

    $q = mysqli_query($conn,"SELECT payment_frequency_desc from geo_bpls_payment_frequency where payment_frequency_code = '$mode_of_payment_code' ");
    $r = mysqli_fetch_assoc($q);
    $mode_of_payment = $r["payment_frequency_desc"];

    $business_id = $r11["business_id"];
    $q = mysqli_query($conn,"SELECT step_code from geo_bpls_business_permit where md5(permit_id) = '$id'");
    $r = mysqli_fetch_assoc($q);
    $step_code1 = $r["step_code"];

    $q = mysqli_query($conn,"SELECT step_desc from geo_bpls_step where step_code = '$step_code1' ");
    $r = mysqli_fetch_assoc($q);
    $step_code = $r["step_desc"];
    $permit_application_date = $r11["permit_application_date"];
  // ============================================
// 51ccccccccccccccccccccccccccccccccccccccc receipttt

  $unpaid_amount1 = 0;
  //  for approval
$permit_approved = $r11["permit_approved"];
// getting backtaxes in same business owner 
$owner_id = $r11["owner_id"];
  // getting permit id

// checking kung paid backtax na
$yeardd = date("Y");
$qq1 = mysqli_query($conn, "SELECT permit_no, permit_id, step_code FROM `geo_bpls_business_permit` where owner_id = '$owner_id' and md5(permit_id) != '$id'  and (permit_for_year != '2017' and permit_for_year != '2018' and permit_for_year != '2019'  and permit_for_year != '2020' and permit_for_year  != '$yeardd' )    ");
$permit_no = "";


while($rr1 = mysqli_fetch_assoc($qq1)){

$step_code_11 = $rr1["step_code"];

// get total Assessment amount
$abc =  $rr1["permit_id"];

$backtax_permit_id = $abc;


$qq2 = mysqli_query($conn, "SELECT sum(assessment_tax_due) as ass_tot FROM `geo_bpls_assessment` where permit_id = '$backtax_permit_id' ");
$q4570 = mysqli_query($conn,"SELECT * FROM `geo_bpls_payment_paid_backtax` where  permit_id = '$backtax_permit_id' ");
if(mysqli_num_rows($q4570) > 0){
  $status = "backtax paid";
}else{
  $status = "backtax unpaid";
}
if($status == "backtax unpaid"){

$rr2 = mysqli_fetch_assoc($qq2);           
$qq3 = mysqli_query($conn, "SELECT payment_backtax as payment_backtaxs, sum(payment_surcharge) as payment_surcharges ,sum(payment_total_amount_paid) as paid_tot FROM `geo_bpls_payment` where permit_id = '$abc' ");
  $rr3 = mysqli_fetch_assoc($qq3);
  $sur111 = $rr3["payment_surcharges"];

  // kukunin yung binayaran na backtax ng prev year
  $prev_paid_amount = 0;
  $normal_backtaxt = 0;
  $backtax_arr = explode('+',$rr3["payment_backtaxs"]);
  if(count($backtax_arr) == 3){
      $prev_paid_amount = floatval($backtax_arr[2]);
      $back = floatval($backtax_arr[1]);
  }
  // kukunin yung binayaran na backtax ng current year
  if(count($backtax_arr) == 2){
      $back = floatval($backtax_arr[0]) + floatval($backtax_arr[1]);
  }

  // get surcharges
  $sur111 =0;
  if($sur111 == null){
      $sur111 = 0;
  }
  if($back == null){
      $back = 0;
  }
  
  $ass_to =  $rr2["ass_tot"] * 1;
  $paid_am = (($rr3["paid_tot"] * 1) - ($back + $sur111));

  $paid_am = $paid_am - $prev_paid_amount;
  if($rr2["ass_tot"] > $paid_am){
      
      $unpaid = $rr2["ass_tot"] - $paid_am;
      if($unpaid != "0" && $step_code_11 === "RELEA" ){
          $unpaid_amount1 += $unpaid;
          $permit_no .= $rr1["permit_no"]." &nbsp;";
      }
    }
}
}

$surc_prev_year  = 0;
// unpaid_amount1 is backtax for prev year
if($unpaid_amount1>0 && $status == "backtax unpaid"){
// if($unpaid_amount1==99999999){

      // check if surcharges and penalty  is set in penalty_table
      $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

      $penalty_r = mysqli_fetch_assoc($penalty_q);

      if ($penalty_r["surcharge_on"] == 1) {
          $surcharges_rate = $penalty_r["surcharge_rate"];
      } else {
          $surcharges_rate = 0;
      }

 // check if surcharges is set in onsurcharge_on in penalty_table
   $surc_prev_year = $unpaid_amount1 * $penalty_r["surcharge_rate"];

}else{
  $unpaid_amount1 = 0;
}
// 51ccccccccccccccccccccccccccccccccccccccc receipttt
// ============================================
// ============================================
    //   old business bactaxess


    // check 1st payment in querter
    $check_part1_quarter = mysqli_query($conn, "SELECT payment_date FROM `geo_bpls_payment` where  md5(permit_id) = '$id'  ORDER BY `geo_bpls_payment`.`payment_date` ");
    $check_part1_count = mysqli_num_rows($check_part1_quarter);
    if($check_part1_count > 0){
    $check_part1_quarter_row = mysqli_fetch_assoc($check_part1_quarter);
        $last_payment_date_arr = explode(" ", $check_part1_quarter_row["payment_date"]);
    }

    if ($check_part1_count == 1) {
        //  get last day and f day of latest payment
        $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
        $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
        $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "03" . "-31";
        //  get last day and f day of latest payment
    } elseif ($check_part1_count == 2) {
        //  get last day and f day of latest payment
        $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
        $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
        $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "06" . "-31";
        //  get last day and f day of latest payment
    } elseif ($check_part1_count == 3) {
        //  get last day and f day of latest payment
        $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
        $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
        $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "09" . "-31";
        //  get last day and f day of latest payment
    } elseif ($check_part1_count == 4) {
        //  get last day and f day of latest payment
        $last_payment_date_arr2 = explode("-", $last_payment_date_arr[0]);
        $last_payment_date_arr2_f_day = $last_payment_date_arr2[0] . "-" . $last_payment_date_arr2[1] . "-01";
        $last_payment_date_arr2_l_day = $last_payment_date_arr2[0] . "-" . "12" . "-31";
        //  get last day and f day of latest payment
    }

    $check_part_quarter = mysqli_query($conn, "SELECT payment_part FROM `geo_bpls_payment` WHERE md5(permit_id) = '$id' order by payment_id DESC limit 1 ");
    $check_part_quarter_row = mysqli_fetch_assoc($check_part_quarter);
    if($check_part1_count > 0){
    if ($check_part_quarter_row["payment_part"] == "") {
        $check_part_quarter_row["payment_part"] = 0;
    }
    $currentQTR = $check_part_quarter_row["payment_part"] + 1;
    }
    $current_quarter = 0;
    $active_quarter = 0;
    $done_quarter = 0;
    $p_total = 0;
    $gross_tax = 0;
    $sur_counter = 0;
    $backtax = 0;
    $backtax_tax = 0;
    $backtax_fee = 0;
    $backtax022 = 0;
    $date_now = date("Y-m-d");

    while ($r_payments = mysqli_fetch_assoc($q_payments)) {
    if ($mode_of_payment == "Quarterly") {
        $division_no = 4;
        // Quarter ------------------------------------
        // Quarter ------------------------------------
        // Quarter ------------------------------------
        // Quarter ------------------------------------
        // Quarter ------------------------------------
        // cheking date of paymemnts
        $p_date_q = mysqli_query($conn, "SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");

        $p_date_r = mysqli_fetch_assoc($p_date_q);
        // cheking date of paymemnts

        // check if surcharges and penalty  is set in penalty_table
        $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

        $penalty_r = mysqli_fetch_assoc($penalty_q);

        if ($penalty_r["surcharge_on"] == 1) {
            $surcharges_rate = $penalty_r["surcharge_rate"];
        } else {
            $surcharges_rate = 0;
        }

        if ($penalty_r["interest_on"] == 1) {
            $penalty_rate = $penalty_r["surcharge_rate"];
        } else {
            $penalty_rate = 0;
        }
        // check if surcharges is set in onsurcharge_on in penalty_table
        $check_part_quarter = mysqli_query($conn, "SELECT payment_part FROM `geo_bpls_payment` WHERE md5(permit_id) = '$id' order by payment_id DESC limit 1 ");
        $check_part_quarter_row = mysqli_fetch_assoc($check_part_quarter);
        $paidQTR = $check_part_quarter_row["payment_part"];
        if ($paidQTR == "" || $paidQTR == null || $paidQTR == 0) {
            $paidQTR = 0;
        }
        $m = date("m");
        // important in current quarter 3 for division of year into 4 quarter
        $current_quarter = floor(($m - 1) / 3) + 1;

        
        for ($am = 1; $am < 5; $am++) {
            $year = date("Y");
            $aa1 = $year . "-" . $p_date_r["payment_qtrdue" . $am];

            $date_arr = explode('-', $p_date_r["payment_qtrdue" . $am]);
            $month_start = $year . "-" . $date_arr[0] . "-01";
            // surcharges counter
            if($am > $paidQTR) {
                if ($date_now > $aa1) {
                    $sur_counter++;
                }
            }
            // check what payment quarter
        }
        $vav = str_replace(',', '', number_format(($r_payments["assessment_tax_due"] / $division_no), 2));
        $qtr_count = $current_quarter - $paidQTR;
        if ($qtr_count > 1) {
            if ($r_payments["sub_account_no"] == "$gross_sub_acc") {
                $backtax_tax += $vav * ($qtr_count - 1);
            } else {
                $backtax_fee += $vav * ($qtr_count - 1);
            }
            $backtax += $vav * ($qtr_count - 1);
            $payment_qtr = $paidQTR + ($qtr_count - 1) + 1;
        } else {
            $payment_qtr = $paidQTR + 1;
        }
        $p_total += $vav;
    } elseif ($mode_of_payment == "Semi-annual") { 
        $division_no = 2;
        // Semi Annual ------------------------------------
        // Semi Annual ------------------------------------
        // Semi Annual ------------------------------------
        // Semi Annual ------------------------------------
        // Semi Annual ------------------------------------
        // Semi Annual ------------------------------------
        // cheking date of paymemnts
        $p_date_q = mysqli_query($conn, "SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");

        $p_date_r = mysqli_fetch_assoc($p_date_q);
        // cheking date of paymemnts

        // check if surcharges and penalty  is set in penalty_table
        $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

        $penalty_r = mysqli_fetch_assoc($penalty_q);

        if ($penalty_r["surcharge_on"] == 1) {
            $surcharges_rate = $penalty_r["surcharge_rate"];
        } else {
            $surcharges_rate = 0;
        }

        if ($penalty_r["interest_on"] == 1) {
            $penalty_rate = $penalty_r["surcharge_rate"];
        } else {
            $penalty_rate = 0;
        }
        // check if surcharges is set in onsurcharge_on in penalty_table
        $check_part_quarter = mysqli_query($conn, "SELECT payment_part FROM `geo_bpls_payment` WHERE md5(permit_id) = '$id' order by payment_id DESC limit 1 ");
        $check_part_quarter_row = mysqli_fetch_assoc($check_part_quarter);
        $paidQTR = $check_part_quarter_row["payment_part"];
        if ($paidQTR == "" || $paidQTR == null || $paidQTR == 0) {
            $paidQTR = 0;
        }
        $m = date("m");
        // important in current quarter 3 for division of year into 4 quarter
        $current_quarter = floor(($m - 1) / 6) + 1;
        for ($am = 1; $am < 3; $am++) {
            $year = date("Y");
            $aa1 = $year . "-" . $p_date_r["payment_semdue" . $am];

            $date_arr = explode('-', $p_date_r["payment_semdue" . $am]);
            $month_start = $year . "-" . $date_arr[0] . "-01";
            // surcharges counter
            if ($am > $paidQTR) {
                if ($date_now > $aa1) {
                    $sur_counter++;
                }
            }
            // check what payment quarter
        }

        $vav = str_replace(',', '', number_format(($r_payments["assessment_tax_due"] / $division_no), 2));
        $qtr_count = $current_quarter - $paidQTR;
        if ($qtr_count > 1) {
            if ($r_payments["sub_account_no"] == "$gross_sub_acc") {
                $backtax_tax += $vav * ($qtr_count - 1);

            } else {
                $backtax_fee += $vav * ($qtr_count - 1);
            }
            $backtax += $vav * ($qtr_count - 1);
            $payment_qtr = $paidQTR + ($qtr_count - 1) + 1;
        } else {
            $payment_qtr = $paidQTR + 1;
        }
        $p_total += $vav;
    } else {
        // Annual payment
        // check if surcharges and penalty  is set in penalty_table
        $penalty_q = mysqli_query($conn, "SELECT * from geo_bpls_penalty where  payment_frequency_code = '$mode_of_payment_code' ");

        $penalty_r = mysqli_fetch_assoc($penalty_q);

        if ($penalty_r["surcharge_on"] == 1) {
            $surcharges_rate = $penalty_r["surcharge_rate"];
        } else {
            $surcharges_rate = 0;
        }
        if ($penalty_r["interest_on"] == 1) {
            $penalty_rate = $penalty_r["surcharge_rate"];
        } else {
            $penalty_rate = 0;
        }
        // check if surcharges is set in onsurcharge_on in penalty_table
        // cheking date of paymemnts
        $p_date_q = mysqli_query($conn, "SELECT * from geo_bpls_payment_frequency where  payment_frequency_desc = '$mode_of_payment' ");

        $p_date_r = mysqli_fetch_assoc($p_date_q);
        // cheking date of paymemnts

        $year = date("Y");
        $aa1 = $year . "-" . $p_date_r["payment_anndue1"];

        // surcharges counter
        // fecthing date of not paid quarter
        if ($date_now > $aa1) {
            $sur_counter++;
        }
        $mnmn = str_replace(',', '', number_format($r_payments["assessment_tax_due"], 2));
        $p_total += $mnmn;
    }

}

  // total w/o backtax and surcharges

     $clear_amount = $p_total;
     
// setting Backtaxes
// BACKTAXES
if($unpaid_amount1 > 0){
    $backtax += $unpaid_amount1;
    $backtax_var = $backtax_tax . " + " . $backtax_fee. " + " . $unpaid_amount1;
}else{
    $backtax_var = $backtax_tax . " + " . $backtax_fee;
}
$backtax022 = str_replace(',', '', number_format($backtax, 2));
// echo $backtax;---------------------------------------
$p_total += $backtax;

if($sur_counter != 0){
    //   SURCHARGES
    // <!-- Surcharges input -->
    $sur = $p_total * $surcharges_rate;
    if ($status_code == "NEW") {
        $sur = 0;
    }
    $p_total += $sur;
}

}

?>