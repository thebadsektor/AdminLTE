<?php
//include connection file
include "../../php/connect.php";
include "../../../bower_components/libs/fpdf.php";
include "../../../bower_components/libs/exfpdf.php";
include "../../../bower_components/libs/easyTable.php";

if(isset($_GET["key"]) && isset($_GET["target"])){
$key = $_GET["key"];
include "../../jomar_assets/enc.php";

if(me_decrypt($key) == "GEO-INFOMETRICS-2021-5723409324"){


/* 'P','mm',array(208,102) */
$pdf = new exFPDF();
$pdf->SetMargins(7, 7);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$id = me_decrypt($_GET["target"]);
$q11 = mysqli_query($conn, "SELECT amd_to, amd_from, permit_for_year, civil_status_id, geo_bpls_business.business_id, business_emergency_contact, payment_frequency_code, status_code, step_code, permit_application_date, business_name, geo_bpls_business.barangay_id as b_barangay_id , business_type_code, economic_area_code, economic_org_code, geo_bpls_business.lgu_code as b_lgu_code, occupancy_code, geo_bpls_business.province_code as b_province_code, geo_bpls_business.region_code as b_reg_code, scale_code, sector_code, business_address_street, business_application_date, business_area, business_mob_no, business_tel_no, business_contact_name, business_dti_sec_cda_reg_date, business_dti_sec_cda_reg_no, business_email, business_email, business_emergency_email, business_emergency_mobile, business_employee_resident, business_employee_total,business_tax_incentive, business_tax_incentive_entity, business_tin_reg_no, business_trade_name_franchise, owner_first_name, owner_middle_name, owner_last_name, geo_bpls_owner.barangay_id as o_barangay_id, citizenship_id,gender_code, geo_bpls_owner.lgu_code as o_lgu_code, geo_bpls_owner.province_code as o_province_code, geo_bpls_owner.region_code as o_reg_code, geo_bpls_owner.zone_id as o_zone_id, geo_bpls_owner.owner_address_street, owner_birth_date,owner_email,owner_legal_entity, owner_mobile FROM `geo_bpls_business_permit`
INNER JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id
INNER JOIN geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id
WHERE md5(geo_bpls_business_permit.permit_id) = '$id';
 ");

$r11 = mysqli_fetch_assoc($q11);
$status_code = $r11["status_code"];
$q = mysqli_query($conn, "SELECT status_desc from geo_bpls_status where status_code = '$status_code' ");
$r = mysqli_fetch_assoc($q);
$status_desc = $r["status_desc"];

$mode_of_payment = $r11["payment_frequency_code"];
$q = mysqli_query($conn, "SELECT payment_frequency_desc from geo_bpls_payment_frequency where payment_frequency_code = '$mode_of_payment' ");
$r = mysqli_fetch_assoc($q);
$mode_of_payment = $r["payment_frequency_desc"];

$business_id = $r11["business_id"];

$q = mysqli_query($conn, "SELECT * FROM `geo_bpls_lessor_details` where business_id = '$business_id'");
$r = mysqli_fetch_assoc($q);
$lessor_fullname = $r["fullname"];
$lessor_address = $r["address"];
$lessor_email = $r["email"];
$lessor_mobile = $r["mob_no"];
$lessor_monthly_rental = $r["monthly_rental"];
$q = mysqli_query($conn, "SELECT step_code from geo_bpls_business_permit where md5(permit_id) = '$id'");
$r = mysqli_fetch_assoc($q);
$step_code = $r["step_code"];

$q = mysqli_query($conn, "SELECT step_desc from geo_bpls_step where step_code = '$step_code' ");
$r = mysqli_fetch_assoc($q);
$step_code = $r["step_desc"];

$business_permit_num = "a";
$status = $status_desc;
// from
$transfer = $r11["amd_from"];
// to
$amendment = $r11["amd_to"];

$payment_mode = $mode_of_payment;

$mm = $r11["business_type_code"];
$q = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_type` where business_type_code = '$mm'  ");
$r = mysqli_fetch_assoc($q);
$type_org = $r["business_type_desc"];
$date_app = $r11["permit_application_date"];
$taxpayer = $r11["owner_last_name"] . ", " . $r11["owner_first_name"] . " " . substr($r11["owner_middle_name"], 0, 1);
$busines_name = $r11["business_name"];
$lb = "a";
$barangay_id = $r11["b_barangay_id"];
$q = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as b_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");
$r = mysqli_fetch_assoc($q);

$business_address = $r["b_add"];
$barangay_id = $r11["o_barangay_id"];

$q = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as o_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");
$r = mysqli_fetch_assoc($q);

$owner_add = $r["o_add"];

$cap_gross = "a";
$month_penalty = "a";

$tax_yr = $r11["permit_for_year"];

$grand_total_amount = "a";

$write = new easyTable($pdf, 9, 'width:100%; align:L; font-style:; font-family:arial; border:;');
$write->easyCell('Republic of the Philippines', 'colspan:9;font-style:; align:C; font-size:9; line-height:1;');
$write->printRow();
$write->easyCell('Province of Laguna', 'colspan:9;font-style:; align:C; font-size:10; line-height:1;');
$write->printRow();
$write->easyCell('MUNICIPALITY OF MAJAYJAY', 'colspan:9;font-style:B; align:C; font-size:9; line-height:1;');
$write->printRow();
// $write->easyCell('Tel. No. (042) 317-6269', 'colspan:9;font-style:; align:C; font-size:9; line-height:1;');
// $write->printRow();
$write->easyCell('--ooOOoo--', 'colspan:9;font-style:; align:C; font-size:10; line-height:1;');
$write->printRow();
$write->easyCell('OFFICE OF THE MUNICIPAL TREASURER', 'colspan:9;font-style:B; align:C; font-size:12; line-height:1;');
$write->printRow();
$write->easyCell('_____________________________________________________________________________________________________________', 'colspan:9;font-style:B; align:C; font-size:9; line-height:1;');
$write->printRow();
$write->easyCell('STATEMENT OF ACCOUNT', 'colspan:9;font-style:B; align:C; font-size:12; line-height:1;');
$write->printRow();
$write->easyCell("Mayor's Permit and Business License", 'colspan:9;font-style:; align:C; font-size:11; line-height:1;');
$write->printRow();
$tax_yrs = 'TAX YEAR:  ';
$write->easyCell($tax_yrs . $tax_yr, 'colspan:9;font-style:B; align:C; font-size:11; line-height:1;');
$write->printRow();
$write->endTable();

$write = new easyTable($pdf, 9, 'width:100%; align:L; font-style:; font-family:arial; border:1;');
$write->easyCell('Status :', 'colspan:;font-style:B; align:L; font-size:9; line-height:1;');
$write->easyCell($status, 'colspan:;font-style:; align:C; font-size:8; line-height:1;');
$write->easyCell('Transfer :', 'colspan:;font-style:B; align:L; font-size:9; line-height:1;');
$write->easyCell($transfer, 'colspan:;font-style:; align:C; font-size:8; line-height:1;');
$write->easyCell('Amendment :', 'colspan:;font-style:B; align:L; font-size:8; line-height:1;');
$write->easyCell($amendment, 'colspan:;font-style:; align:C; font-size:8; line-height:1;');
$write->easyCell('Mode of Payment : ', 'colspan:2;font-style:B; align:L; font-size:9; line-height:1;');
$write->easyCell($payment_mode, 'colspan:;font-style:; align:C; font-size:8; line-height:1;');
$write->printRow();
$org_ty = ' Types of Organization : ';
$write->easyCell($org_ty, 'colspan:2;font-style:; align:L; font-size:10; line-height:1;');
$write->easyCell($type_org, 'colspan:3;font-style:; align:L; font-size:10; line-height:1;');
$org_ty2 = ' Date of Applicant : ';
$write->easyCell($org_ty2, 'colspan:2;font-style:; align:L; font-size:10; line-height:1;');
$write->easyCell($date_app, 'colspan:2;font-style:; align:L; font-size:10; line-height:1;');
$write->printRow();
$tacname = '  Name of Taxpayer :  ';
$write->easyCell($tacname, 'colspan:2;font-style:; align:L; font-size:10; line-height:1;');
$write->easyCell($taxpayer, 'colspan:8;font-style:; align:L; font-size:10; line-height:1;');
$write->printRow();
$businame = '  Business Name :   ';
$write->easyCell($businame, 'colspan:2;font-style:; align:L; font-size:10; line-height:1;');
$write->easyCell($busines_name, 'colspan:8;font-style:; align:L; font-size:10; line-height:1;');
$write->printRow();

$busiaddress = '  Business Address :   ';
$write->easyCell($busiaddress, 'colspan:2;font-style:; align:L; font-size:10; line-height:1;');
$write->easyCell($business_address, 'colspan:8;font-style:; align:L; font-size:10; line-height:1;');
$write->printRow();
$onerddress = "  Owner's Address :   ";
$write->easyCell($onerddress, 'colspan:2;font-style:; align:L; font-size:10; line-height:1;');
$write->easyCell($owner_add, 'colspan:8;font-style:; align:L; font-size:10; line-height:1;');
$write->printRow();
$write->endTable();

$write = new easyTable($pdf, 8, 'width:100%; align:L; font-style:; font-family:arial; border:1;');
$write->easyCell('ASSESSMENT', 'colspan:8;font-style:B; align:C; font-size:12; line-height:1;');
$write->printRow();
$write->easyCell('No.', 'colspan:1;font-style:B; align:C; font-size:10; line-height:1;');
$write->easyCell('LOCAL TAXES FEES', 'colspan:5;font-style:B; align:C; font-size:12; line-height:1;');
$write->easyCell('TOTAL', 'colspan:2;font-style:B; align:C; font-size:12; line-height:1;');
$write->printRow();

$total = 0;
$count = 1;
$dot = '.';

// $result = mysqli_query($conn, "SELECT sub_account_no, assessment_tax_due, tfo_desc  FROM `geo_bpls_assessment`
//                             inner join geo_bpls_tfo_nature on  geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id
//                             inner join geo_bpls_tfo on  geo_bpls_tfo.tfo_id = geo_bpls_tfo_nature.sub_account_no
//                             where md5(permit_id) = '$id'") or die("database error:" . mysqli_error($conn));
$result = mysqli_query($conn, "SELECT natureOfCollection_tbl.name as sub_account_title, natureOfCollection_tbl.id as sub_account_no, sum(assessment_tax_due) as assessment_tax_due FROM `geo_bpls_assessment` inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no where md5(permit_id) = '$id' GROUP by natureOfCollection_tbl.name, natureOfCollection_tbl.id ") or die("database error:" . mysqli_error($conn));

$nothing = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    $acc_title = $row['sub_account_title'];
    $amount = $row['assessment_tax_due'];
    $total += $amount;

    $write->easyCell($count++ . $dot, 'colspan:1; align:C; font-style:; font-size:12;');
    $write->easyCell($acc_title, 'colspan:5;');
    $write->easyCell(number_format($amount, 2), 'colspan:2; align:C; font-style:;');
    $write->printRow();
}
$write->easyCell(' TOTAL  ', 'colspan:6; align:C; font-style:;');
$write->easyCell(number_format($total, 2), 'colspan:2; align:C; font-style:;');
$write->printRow();
$write->easyCell(' GRAND TOTAL  :', 'colspan:6; align:R; font-style:B;');
$write->easyCell(number_format($total, 2), 'colspan:2; align:C; font-style:B;');
$write->printRow();
$ors = "";
$q = mysqli_query($conn, " SELECT * FROM `geo_bpls_payment` where md5(permit_id) = '$id' ");
$r_count = mysqli_num_rows($q);
if ($r_count > 0) {
    $total_amount_paid = 0;
    $surcharges = 0;
    while ($r = mysqli_fetch_assoc($q)) {
        $ors .= $r["or_no"] . ", ";
        $surcharges += $r["payment_surcharge"];
        $total_amount_paid += $r["payment_total_amount_paid"];

    }
    if (round(($total_amount_paid - $surcharges)) >= round($total)) {
        $status_pay = "Paid";
    } else {
        $status_pay = "Not Fully Paid";
    }

} else {
    $status_pay = "Unpaid";

}

$write->easyCell('O.R no.', 'colspan:1;font-style:; align:L; font-style:B; font-size:12; line-height:1;');
$write->easyCell($ors, 'colspan:4;font-style:; align:L; font-size:12; line-height:1;');
$write->easyCell('Status', 'colspan:1;font-style:; align:C; font-size:12; line-height:1;');
$write->easyCell($status_pay, 'colspan:2;font-style:; align:C; font-size:12; border:RBT; line-height:1;');
$write->printRow();

$write->endTable(5);

$write = new easyTable($pdf, 12, 'width:100%; align:L; font-style:; font-family:arial; border:;');
$write->easyCell('', 'colspan:; line-height:1;');
$write->easyCell('Assessed by:', 'colspan:5;font-style:; align:C; font-size:12; line-height:1;');
$write->easyCell('', 'colspan:; line-height:1;');
$write->easyCell('Certified Correct:', 'colspan:5;font-style:; align:C; font-size:12; line-height:1;');
$write->printRow();
$write->easyCell('', 'colspan:6;font-style:B; align:C; font-size:12; line-height:1;');
$write->easyCell('', 'colspan:6; font-style:B; align:C; font-size:12; line-height:1;');
$write->printRow();
$write->easyCell('', 'colspan:6;font-style:B; align:C; font-size:12; line-height:1;');
$write->easyCell('', 'colspan:6; font-style:B; align:C; font-size:12; line-height:1;');
$write->printRow();

$write->easyCell('', 'colspan:; line-height:1;');

$firstname = "";
$lastname = " ";
$middlename = "";

$write->easyCell($firstname . ' ' . $middlename . ' ' . $lastname, 'colspan:4;font-style:B; align:C; font-size:12; line-height:1; border:B; border-color:black;');
$write->easyCell('', 'colspan:; line-height:1;');

$write->easyCell('', 'colspan:; line-height:1;');
$write->easyCell('', 'colspan:4; font-style:B; align:C; font-size:12; line-height:1; border:B; border-color:black;');
// $write->easyCell('name', 'colspan:4; font-style:B; align:C; font-size:12; line-height:1; border:B; border-color:black;');
$write->easyCell('', 'colspan:; line-height:1;');

$write->printRow();
$write->easyCell('RCC I', 'colspan:6;font-style:B; align:C; font-size:12; line-height:1;');
$write->easyCell('ICO,MTO', 'colspan:6; font-style:B; align:C; font-size:12; line-height:1;');
$write->printRow();
$write->endTable();

$pdf->Output();
}else{
 echo "No data available";
}
}