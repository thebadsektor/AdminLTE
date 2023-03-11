<?php
include '../../php/connect.php';

               $condition_status = 0; 
               $condition_string = "WHERE "; 
               $getlink = "?";
                if(isset($_GET["type_report"])){
                    $type_report =  $_GET["type_report"];
                    $getlink .= "type_report=".$type_report;
                }
               
                $transaction = $_GET["transaction"];
                if($transaction == "RET"){
                     $date_filter = "retirement_date_processed";
                }else{
                     $date_filter = "permit_application_date";
                }
 
 
                 if(isset($_GET["from"]) && isset($_GET["to"])){
                    $from =  $_GET["from"];
                    $to = $_GET["to"];
                    $condition_status++; 
                    $condition_string .= $date_filter." BETWEEN '".$from."' and '".$to."'";
                    $getlink .= "&from=".$from;
                    $getlink .= "&to=".$to;
                    $year_arr = explode('-',$from);
                     $year_now = $year_arr[0];
                 }
 
                 if(isset($_GET["from1"]) && isset($_GET["to1"])){
                    $from1 =  $_GET["from1"];
                    $to1 = $_GET["to1"];
                    $condition_status++; 
                    $condition_string .= $date_filter." BETWEEN '".$from1."' and '".$to1."'";
                    $getlink .= "&from1=".$from1;
                    $getlink .= "&to1=".$to1;
 
                    $year_arr = explode('-',$from1);
                     $year_now = $year_arr[0];
                 }


                if(isset($_GET["tax_type"])){
                    // echo  $tax_type =  $_GET["tax_type"];
                }
                if(isset($_GET["barangay_id"])){
                      $barangay_id =  $_GET["barangay_id"];
                    if($barangay_id != "All"){
                      if($condition_status != 0)
                        {
                            $condition_string .= " and ";
                        }
                        $condition_string .= "geo_bpls_business.barangay_id  = '".$barangay_id."'";
                    $condition_status++; 
                    }
                }
                if(isset($_GET["nature_id"])){
                     $nature_id = $_GET["nature_id"];
                    if($nature_id != "All"){
                    if($condition_status != 0)
                    {
                         $condition_string .= " and ";
                    }
                   $condition_string .= "geo_bpls_business_permit_nature.nature_id  = '".$nature_id."'"; 
                   $condition_status++; 
                }
                }

                
                if(isset($_GET["economic_org_code"])){
                    $economic_org_code = $_GET["economic_org_code"];
                   if($economic_org_code != "All"){
                   if($condition_status != 0)
                   {
                        $condition_string .= " and ";
                   }
                  $condition_string .= "geo_bpls_business.economic_org_code  = '".$economic_org_code."'"; 
                  $condition_status++; 
               }
               }

               if(isset($_GET["economic_area_code"])){
                    $economic_area_code = $_GET["economic_area_code"];
                    if($economic_area_code != "All"){
                    if($condition_status != 0)
                    {
                            $condition_string .= " and ";
                    }
                    $condition_string .= "geo_bpls_business.economic_area_code  = '".$economic_area_code."'"; 
                    $condition_status++; 
                }
                }

            if(isset($_GET["scale_code"])){
                $scale_code = $_GET["scale_code"];
                if($scale_code != "All"){
                if($condition_status != 0)
                {
                        $condition_string .= " and ";
                }
                $condition_string .= "geo_bpls_business.scale_code  = '".$scale_code."'"; 
                $condition_status++; 
            }
            }
            
            if(isset($_GET["sector_code"])){
                $sector_code = $_GET["sector_code"];
                if($sector_code != "All"){
                if($condition_status != 0)
                {
                        $condition_string .= " and ";
                }
                $condition_string .= "geo_bpls_business.sector_code  = '".$sector_code."'"; 
                $condition_status++; 
            }
            }
            


                if(isset($_GET["transaction"])){
                     $transaction = $_GET["transaction"];
                    if($transaction != "All"){
                    if($condition_status != 0)
                    {
                        $condition_string .= " and ";
                    }
                     $condition_string .= "status_code  = '" . $transaction."'";
                     $condition_status++; 
                }
                }
                if(isset($_GET["payment_mode"])){
                     $payment_mode = $_GET["payment_mode"];
                    if($payment_mode != "All"){

                    if($condition_status != 0)
                    {
                        $condition_string .= " and ";
                    }
                     $condition_string .= "payment_frequency_code  = '" . $payment_mode."'";
                     $condition_status++; 
                }
                }
                if(isset($_GET["business_type"])){
                     $business_type = $_GET["business_type"];
                    if($business_type != "All"){
                   if($condition_status != 0)
                    {
                        $condition_string .= " and ";
                    }
                     $condition_string .= "business_type_code  = '" . $business_type."'";
                     $condition_status++; 
                }
                }
             

            if($_GET["type_report"] == "Business Master list"){

            
                $q_t = "SELECT permit_no, business_name, CONCAT(owner_first_name,' ',owner_middle_name,' ',owner_last_name) as o_name, geo_bpls_business.barangay_id, business_type_code, payment_frequency_code,  permit_application_date, geo_bpls_business_permit.permit_id, nature_desc, capital_investment, last_year_gross, status_code , geo_bpls_business_permit_nature.nature_id, business_employee_total , owner_mobile, business_mob_no, scale_desc  FROM geo_bpls_business_permit INNER JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id INNER JOIN  geo_bpls_scale on geo_bpls_scale.scale_code = geo_bpls_business.scale_code  INNER JOIN geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id INNER JOIN geo_bpls_business_permit_nature on geo_bpls_business_permit_nature.permit_id = geo_bpls_business_permit.permit_id INNER JOIN geo_bpls_nature on geo_bpls_nature.nature_id = geo_bpls_business_permit_nature.nature_id   " . $condition_string . " and geo_bpls_business_permit.permit_for_year = '$year_now' and geo_bpls_business_permit.step_code = 'RELEA' ORDER BY geo_bpls_business_permit.permit_no ASC ";
                $q_q = mysqli_query($conn, $q_t);
                // echo $q_t;
                header("Content-Type: application/xls");
                header("Content-Disposition: attachment; filename=".$type_report.".xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo '<table border="1" style="font-family:arial;">';
                      echo '<tr>
                                <th>Permit No</th>
                                <th>Business Name </th>
                                <th>Owner</th>
                                <th>Address</th>
                                <th>Nature of Business</th>
                                <th>Business Scale</th>
                                <th>Capital Investment</th>
                                <th>Gross Sales</th>
                                <th>Ownership</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                                <th>Business tax</th>
                                <th>Regulatory fee</th>
                                <th>Application Date</th>
                                <th>Total Employees</th>
                                <th>Owners Contact No.</th>
                                <th>Business Contact No.</th>
                            </tr>';
                while($q_r = mysqli_fetch_assoc($q_q)){
                   ?>
                <tr  style='text-align:center; '>
                    <td> <?php echo $q_r["permit_no"]; ?> </td>
                    <td> <?php echo utf8_decode(strtoupper($q_r["business_name"])); ?> </td>
                    <td> <?php echo utf8_decode(strtoupper($q_r["o_name"])); ?> </td>
                    <td> <?php 
                    $barangay_id = $q_r["barangay_id"];
                    $q = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as b_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");
                    $r = mysqli_fetch_assoc($q);
                    echo "BARANGAY ".$r["b_add"]; ?> 
                    </td>
                    <td> <?php echo $q_r["nature_desc"]; ?> </td>
                    <td> <?php echo $q_r["scale_desc"]; ?> </td>
                    <td> <?php echo number_format($q_r["capital_investment"],2); ?> </td>
                    <td>  <?php echo number_format($q_r["last_year_gross"],2); ?> </td>
                    <td> 
                    <?php
                     $target =  $q_r["business_type_code"]; 
                    $q = mysqli_query($conn,"SELECT * FROM `geo_bpls_business_type` where business_type_code = '$target' ");
                    $r = mysqli_fetch_assoc($q);
                    echo $r["business_type_desc"];
                    ?> 
                    </td>
                    <td> 
                        <?php 
                    $target =  $q_r["payment_frequency_code"]; 
                    $q = mysqli_query($conn,"SELECT * FROM  geo_bpls_payment_frequency where payment_frequency_code = '$target' ");
                    $r = mysqli_fetch_assoc($q);
                    echo $r["payment_frequency_desc"];

                        ?>
                     </td>
                     <td>
                        <?php
                             if($q_r["status_code"]== "REN"){
                                echo "Renew";
                            }else{
                                echo  "New";
                            }
                        ?>
                     </td>
                     <?php
                    $permit_id = $q_r["permit_id"];
                    $nature_id = $q_r["nature_id"];
                     //  -----------------------------

                    // check kung anong payment mode at ilan qtr ang binayaran
                    $q848d = mysqli_query($conn,"SELECT payment_frequency_code FROM `geo_bpls_business_permit` where permit_id = '$permit_id' ");
                    $r848d = mysqli_fetch_assoc($q848d);
                    $payment_frequency_code = $r848d["payment_frequency_code"];

                    $q348d = mysqli_query($conn,"SELECT payment_part FROM `geo_bpls_payment` where permit_id = '$permit_id' ");
                    $payment_part = 0;
                    while($r348d = mysqli_fetch_assoc($q348d)){
                        if($r348d["payment_part"] == ""){
                            $r348d["payment_part"] = 0;
                        }
                        $payment_part += $r348d["payment_part"];
                    }
                //  -----------------------------
                
                    $q23232 = mysqli_query($conn, "SELECT sum(assessment_tax_due) as aass FROM `geo_bpls_assessment` inner JOIN geo_bpls_tfo_nature on geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id where geo_bpls_tfo_nature.nature_id = $nature_id and permit_id = '$permit_id' and assessment_active = 1 and  (geo_bpls_tfo_nature.sub_account_no = '1010' or geo_bpls_tfo_nature.sub_account_no = '1011' or geo_bpls_tfo_nature.sub_account_no = '1012' or geo_bpls_tfo_nature.sub_account_no = '1013' or  geo_bpls_tfo_nature.sub_account_no = '1014' or geo_bpls_tfo_nature.sub_account_no = '1015' or geo_bpls_tfo_nature.sub_account_no = '1016' or geo_bpls_tfo_nature.sub_account_no = '1017' or geo_bpls_tfo_nature.sub_account_no = '1018' or geo_bpls_tfo_nature.sub_account_no = '1019' or geo_bpls_tfo_nature.sub_account_no = '1020' or geo_bpls_tfo_nature.sub_account_no = '1021' ) ");
                    $r2223 = mysqli_fetch_assoc($q23232);

                    $BT = $r2223["aass"];

                    $q23232z = mysqli_query($conn, "SELECT sum(assessment_tax_due) as aass1 FROM `geo_bpls_assessment` inner JOIN geo_bpls_tfo_nature on geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id where geo_bpls_tfo_nature.nature_id = $nature_id and permit_id = '$permit_id' and assessment_active = 1 and (geo_bpls_tfo_nature.sub_account_no != '1010' and geo_bpls_tfo_nature.sub_account_no != '1011' and geo_bpls_tfo_nature.sub_account_no != '1012' and geo_bpls_tfo_nature.sub_account_no != '1013' and  geo_bpls_tfo_nature.sub_account_no != '1014' and geo_bpls_tfo_nature.sub_account_no != '1015' and geo_bpls_tfo_nature.sub_account_no != '1016' and geo_bpls_tfo_nature.sub_account_no != '1017' and geo_bpls_tfo_nature.sub_account_no != '1018' and geo_bpls_tfo_nature.sub_account_no != '1019' and geo_bpls_tfo_nature.sub_account_no != '1020' and geo_bpls_tfo_nature.sub_account_no != '1021' )  ");
                    $r2223z = mysqli_fetch_assoc($q23232z);
                    $RF = $r2223z["aass1"];

                    if($payment_frequency_code == "SEM"){
                        if($payment_part == 1){
                            $BT = $BT / 2;
                            $RF = $RF / 2;
                        }
                    }
                    if($payment_frequency_code == "QUA"){
                        if($payment_part == 1){
                            $BT = $BT / 4;
                            $RF = $RF / 4;
                        }

                        if($payment_part == 2){
                            $BT = $BT / 2;
                            $RF = $RF / 2;
                        }

                        if($payment_part == 3){
                            $BT = $BT / 4;
                            $RF = $RF / 4;
                            $BT = $BT * 3;
                            $RF = $RF * 3;
                        }
                      
                    }
                    

                    // $permit_id = $q_r["permit_id"];
                    // $q_BT = mysqli_query($conn, "SELECT sum(payment_amount) as aaaa from geo_bpls_payment_detail inner join geo_bpls_payment on geo_bpls_payment.payment_id = geo_bpls_payment_detail.payment_id  where permit_id = '$permit_id' and sub_account_no = '4-01-03-030-1' ");
                    // $r_BT = mysqli_fetch_assoc($q_BT);
                    // $BT = $r_BT["aaaa"];
                    // $q_RF = mysqli_query($conn, "SELECT sum(payment_amount) as aaaa from geo_bpls_payment_detail inner join geo_bpls_payment on geo_bpls_payment.payment_id = geo_bpls_payment_detail.payment_id  where permit_id = '$permit_id' and sub_account_no != '4-01-03-030-1' ");
                    // $r_RF = mysqli_fetch_assoc($q_RF);
                    // $RF = $r_RF["aaaa"];
                     ?>
                     <td> <?php echo $BT; ?> </td>
                     <td>  <?php echo $RF; ?> </td>
                    <td> <?php echo $q_r["permit_application_date"]; ?> </td>
                    <td> <?php echo $q_r["business_employee_total"]; ?> </td>
                    <td> <?php echo $q_r["owner_mobile"]; ?> </td>
                    <td> <?php echo $q_r["business_mob_no"]; ?> </td>
                </tr>
                   <?php 
                }
                echo '</table>';
        }
?>
