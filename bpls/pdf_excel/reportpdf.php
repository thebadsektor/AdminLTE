<?php
//include connection file
include "../../php/connect.php";
include "../../../bower_components/libs/fpdf.php";
include "../../../bower_components/libs/exfpdf.php";
include "../../../bower_components/libs/easyTable.php";

$condition_status = 0; 
               $condition_string = "WHERE "; 
               $getlink = "?";
                if(isset($_GET["type_report"])){
                    $type_report =  $_GET["type_report"];
                    $getlink .= "type_report=".$type_report;
                }
                 if(isset($_GET["from"]) && isset($_GET["to"])){
                    $from =  $_GET["from"];
                    $to = $_GET["to"];
                   $condition_status++; 
                   $condition_string .= "permit_application_date BETWEEN '".$from."' and '".$to."'";
                    $year_arr = explode('-', $from);
                    $year_now = $year_arr[0];
                }

                if(isset($_GET["from1"]) && isset($_GET["to1"])){
                    $from1 =  $_GET["from1"];
                    $to1 = $_GET["to1"];
                    $condition_status++; 
                    $condition_string .= "permit_released_date BETWEEN '".$from1."' and '".$to1."'";
                    $year_arr = explode('-', $from1);
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

        $q_t = "SELECT permit_no, business_name, CONCAT(owner_first_name,' ',owner_middle_name,' ',owner_last_name) as o_name, geo_bpls_business.barangay_id, business_type_code, payment_frequency_code,  permit_application_date, geo_bpls_business_permit.permit_id, nature_desc, capital_investment, last_year_gross, status_code , geo_bpls_business_permit_nature.nature_id  FROM geo_bpls_business_permit INNER JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id INNER JOIN  geo_bpls_scale on geo_bpls_scale.scale_code = geo_bpls_business.scale_code  INNER JOIN geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id INNER JOIN geo_bpls_business_permit_nature on geo_bpls_business_permit_nature.permit_id = geo_bpls_business_permit.permit_id INNER JOIN geo_bpls_nature on geo_bpls_nature.nature_id = geo_bpls_business_permit_nature.nature_id ". $condition_string." and geo_bpls_business_permit.permit_for_year = '$year_now' and geo_bpls_business_permit.step_code = 'RELEA' ORDER BY geo_bpls_business_permit.permit_no ASC ";
        $q_q = mysqli_query($conn, $q_t);

$pdf = new exFPDF('L','mm',array(215.9,330.2));
//$pdf = new exFPDF('L','mm','Legal');
//$pdf = new exFPDF('P');
$pdf->SetMargins(2,0);
$pdf->AddPage(); 
$pdf->SetFont('Times','',10);
// $pdf->AddFont('oldenglish');

$write=new easyTable($pdf, 110, 'width:100%; align:c; font-style:N; font-family:Arial;');

$write->easyCell($_GET["type_report"],'colspan:100; paddingY:0; border:1; align:C; font-style:B; font-size:12;');

$write->printRow();

$write->easyCell('Permit No','colspan:12; paddingY:0; border:1; align:C; font-style:B;');
$write->easyCell('Business Name','colspan:10; paddingY:0; border:1; align:C; font-style:B;');
$write->easyCell('Owner','colspan:10; paddingY:0; border:1; align:C; font-style:B;');
$write->easyCell('Address','colspan:10; paddingY:0; border:1; align:C; font-style:B;');
$write->easyCell('Nature of Business','colspan:10; paddingY:0; border:1; align:C; font-style:B;');
$write->easyCell('Capital Investment','colspan:10; paddingY:0; border:1; align:C; font-style:B;');
$write->easyCell('Gross Sales','colspan:10; paddingY:0; border:1; align:C; font-style:B;');
$write->easyCell('Ownership','colspan:8; paddingY:0; border:1; align:C; font-style:B;');
$write->easyCell('Payment Mode','colspan:10; paddingY:0; border:1; align:C; font-style:B;');
$write->easyCell('Status','colspan:10; paddingY:0; border:1; align:C; font-style:B;');
$write->easyCell('Application Date','colspan:10; paddingY:0; border:1; align:C; font-style:B;');
$write->printRow();
while($q_r = mysqli_fetch_assoc($q_q)){
$write->easyCell($q_r["permit_no"],'colspan:12; paddingY:0; border:1; align:C; font-size:8;');
$write->easyCell(($q_r["business_name"]),'colspan:10; paddingY:0; border:1; align:C; font-size:8;');
$write->easyCell(($q_r["o_name"]),'colspan:10; paddingY:0; border:1; align:C; font-size:8;');
$barangay_id = $q_r["barangay_id"];
$q = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as b_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");
$r = mysqli_fetch_assoc($q);
$write->easyCell($r["b_add"],'colspan:10; paddingY:0; border:1; align:C; font-size:8;');
        // $permit_id = $q_r["permit_id"];
        // $q = mysqli_query($conn, "SELECT capital_investment, last_year_gross, nature_desc FROM `geo_bpls_business_permit_nature` inner join geo_bpls_nature on geo_bpls_nature.nature_id = geo_bpls_business_permit_nature.nature_id  where permit_id = '$permit_id' ");
        // $q_count = mysqli_num_rows($q);
        // $nature_desc = " ";
        // $cap = 0;
        // $gross = 0;
        // if ($q_count > 0) {
        // $a = 0;
        // while ($r = mysqli_fetch_assoc($q)) {
        //         $a++;
        //         $nature_desc .= $r["nature_desc"];
        //         if ($a != 1 && $q_count != $a) {
        //         $nature_desc .= "/";
        //         }
        //         $cap += $r["capital_investment"];
        //         $gross += $r["last_year_gross"];
        // }
        //         }
        $write->easyCell($q_r["nature_desc"] ,'colspan:10; paddingY:0; border:1; align:C; font-size:8;');
        $write->easyCell(number_format($q_r["capital_investment"],2),'colspan:10; paddingY:0; border:1; align:C; font-size:8;');
        $write->easyCell(number_format($q_r["last_year_gross"],2),'colspan:10; paddingY:0; border:1; align:C; font-size:8;');
                $target =  $q_r["business_type_code"]; 
                        $q = mysqli_query($conn,"SELECT * FROM `geo_bpls_business_type` where business_type_code = '$target' ");
                        $r = mysqli_fetch_assoc($q);
        $write->easyCell($r["business_type_desc"],'colspan:8; paddingY:0; border:1; align:C; font-size:8;');
        $target =  $q_r["payment_frequency_code"]; 
                        $q = mysqli_query($conn,"SELECT * FROM geo_bpls_payment_frequency where payment_frequency_code = '$target' ");
                        $r = mysqli_fetch_assoc($q);
        $write->easyCell($r["payment_frequency_desc"],'colspan:10; paddingY:0; border:1; align:C; font-size:8;');

        if($q_r["status_code"]== "REN"){
             $write->easyCell("Renew",'colspan:10; paddingY:0; border:1; align:C; font-size:8;');
        }else{
            $write->easyCell("New", 'colspan:10; paddingY:0; border:1; align:C; font-size:8;');
        }
        $write->easyCell($q_r["permit_application_date"],'colspan:10; paddingY:0; border:1; align:C; font-size:8;');
        $write->printRow();
        }
        
        $write->endTable();
        $pdf->Ln();
        $pdf->Output();
}
?>