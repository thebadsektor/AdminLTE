  <?php
//include connection file
include "../../php/session.php";
include "../../php/connect.php";
include "../../../bower_components/libs/fpdf.php";
include "../../../bower_components/libs/exfpdf.php";
include "../../../bower_components/libs/easyTable.php";

$gross_sub_acc = "4-01-03-030-1";

$id = $_GET["target"];
$q11 = mysqli_query($conn, "SELECT civil_status_id, geo_bpls_business.business_id, business_emergency_contact, payment_frequency_code, status_code, step_code, permit_application_date, business_name, geo_bpls_business.barangay_id as b_barangay_id , business_type_code, economic_area_code, economic_org_code, geo_bpls_business.lgu_code as b_lgu_code, occupancy_code, geo_bpls_business.province_code as b_province_code, geo_bpls_business.region_code as b_reg_code, scale_code, sector_code, business_address_street, business_application_date, business_area, business_mob_no, business_tel_no, business_contact_name, business_dti_sec_cda_reg_date, business_dti_sec_cda_reg_no, business_email, business_email, business_emergency_email, business_emergency_mobile, business_employee_resident, business_employee_total,business_tax_incentive, business_tax_incentive_entity, business_tin_reg_no, business_trade_name_franchise, owner_first_name, owner_middle_name, owner_last_name, geo_bpls_owner.barangay_id as o_barangay_id, citizenship_id,gender_code, geo_bpls_owner.lgu_code as o_lgu_code, geo_bpls_owner.province_code as o_province_code, geo_bpls_owner.region_code as o_reg_code, geo_bpls_owner.zone_id as o_zone_id, geo_bpls_owner.owner_address_street, owner_birth_date,owner_email,owner_legal_entity, owner_mobile FROM `geo_bpls_business_permit`
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

$pdf = new exFPDF('P');
$pdf->SetMargins(4, 0);
// $pdf->SetMargins(4,4); orginal
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);

$l = mysqli_query($conn, "SELECT UPPER (`province`)as province, UPPER (`municipality`)as municipality,UPPER(`region`)FROM `header`");
$d = mysqli_fetch_assoc($l);

$province = $d['province'];
$municipality = $d['municipality'];

$write = new easyTable($pdf, 600, 'width:100%; align:L; font-style:N; font-family:Helvetica; ');

$write->easyCell('', 'colspan:600; paddingY:3;');
$write->printRow();

$write->easyCell('ANNEX 1 (page 1 of 2)', 'colspan:600; align:L; border:1; font-style:B;');
$write->printRow();

$write->easyCell('', 'colspan:600; paddingY:1; border:LR; ');
$write->printRow();

$write->easyCell('APPLICATION FORM FOR BUSINESS PERMIT', 'colspan:600; align:C; border:LR; font-style:B; paddingY:0.5;');
$write->printRow();

$write->easyCell('TAX YEAR 2019', 'colspan:600; align:C; border:LR; paddingY:0.5; font-style:B;');
$write->printRow();

$write->easyCell('MUNICIPALITY OF ' . $municipality . '', 'colspan:600; align:C; border:LRB; font-style:B; paddingY:0.5;');
$write->printRow();

$write->easyCell('INSTRUCTIONS:', 'colspan:600; align:L; border:LR; font-style:B;');
$write->printRow();

$write->easyCell('', 'colspan:10; border:L; paddingY:0.5;');
$write->easyCell('1.', 'colspan:15; font-style:I; paddingY:0.5;');
$write->easyCell('Provide accurate information and print legibly to avoid delays. Incomplete application form will be returned to the applicant', 'colspan:575; align:L; border:R; font-style:I; paddingY:0.5;');
$write->printRow();

$write->easyCell('', 'colspan:10; border:LB;');
$write->easyCell('2.', 'colspan:15; font-style:I; border:B;');
$write->easyCell('Ensure that all documents attached to this form (if any) complete and properly filled out.', 'colspan:575; align:L; border:RB; font-style:I;');
$write->printRow();

$write->easyCell('I.', 'colspan:15; font-style:B; border:LB; paddingY:0.5;');
$write->easyCell('APPLICANT SECTION', 'colspan:585; font-style:B; border:RB; paddingY:0.5;');
$write->printRow();

$write->easyCell('', 'colspan:15; border:LB; paddingY:0.5;');
$write->easyCell('1. BASIC INFORMATION', 'colspan:585; font-style:B; border:RB; paddingY:0.5;');
$write->printRow();

$write->easyCell('', 'colspan:170; paddingY:1; border:LR;');
$write->easyCell('', 'colspan:430; paddingY:1; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:10; border:L;');
$write->easyCell('', 'colspan:10; ');
$write->easyCell('', ' border:L;');
if ($status_desc == "New") {
    $write->easyCell('X', 'colspan:13; border:TB; ');
} else {
    $write->easyCell('', 'colspan:13; border:TB; ');
}
$write->easyCell('', ' border:L; ');
$write->easyCell('New', 'colspan:60;');

$write->easyCell('', ' border:L; ');
if ($status_desc == "Renew") {
    $write->easyCell('X', 'colspan:13; border:TB; ');
} else {
    $write->easyCell('', 'colspan:13; border:TB; ');
}
$write->easyCell('', ' border:L;');
$write->easyCell('Renewal', 'colspan:60; border:R;');

$write->easyCell('Mode of Payment', 'colspan:100; align:R;');
$write->easyCell('', 'colspan:30; ');
$write->easyCell('', ' border:L; ');
if ($mode_of_payment == "Annual") {
    $write->easyCell('X', 'colspan:13; border:TB; ');
} else {
    $write->easyCell('', 'colspan:13; border:TB; ');
}
$write->easyCell('', ' border:L; ');
$write->easyCell('Annually', 'colspan:60;');
$write->easyCell('', 'colspan:30; ');
$write->easyCell('', ' border:L;');
if ($mode_of_payment == "Semi-annual") {
    $write->easyCell('X', 'colspan:13; border:TB; ');
} else {
    $write->easyCell('', 'colspan:13; border:TB; ');
}
$write->easyCell('', ' border:L; ');
$write->easyCell('Semi-Annually', 'colspan:70;');
$write->easyCell('', 'colspan:30; ');
$write->easyCell('', ' border:L; ');
if ($mode_of_payment == "Quarterly") {
    $write->easyCell('X', 'colspan:13; border:TB; ');
} else {
    $write->easyCell('', 'colspan:13; border:TB; ');
}
$write->easyCell('', ' border:L; ');
$write->easyCell('Quarterly', 'colspan:75; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:170; paddingY:1; border:LRB;');
$write->easyCell('', 'colspan:430; paddingY:1; border:RB;');
$write->printRow();

$write->easyCell('Date of Application:' . ' ' . $r11["permit_application_date"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->easyCell('DTI/SEC/CDA Registration No.:' . ' ' . $r11["business_dti_sec_cda_reg_no"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->printRow();

$write->easyCell('TIN No.:', 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->easyCell('DTI/SEC/CDA Registration Date:' . ' ' . $r11["business_dti_sec_cda_reg_date"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->printRow();

$write->easyCell('', 'colspan:600; paddingY:0.5; border:RL;');
$write->printRow();

$write->easyCell('Type of Business:', 'colspan:150; paddingY:1; border:L; font-style:B;');
$write->easyCell('', ' border:L;');
if ($r11["business_type_code"] == "S") {
    $write->easyCell('X', 'colspan:13; border:TB;');
} else {
    $write->easyCell('', 'colspan:13; border:TB;');
}
$write->easyCell('', ' border:L;');
$write->easyCell('Single', 'colspan:80;');
$write->easyCell('', ' border:L;');
if ($r11["business_type_code"] == "P") {
    $write->easyCell('X', 'colspan:13; border:TB;');
} else {
    $write->easyCell('', 'colspan:13; border:TB;');
}
$write->easyCell('', ' border:L;');
$write->easyCell('Partnership', 'colspan:80;');
$write->easyCell('', ' border:L;');
if ($r11["business_type_code"] == "CORP") {
    $write->easyCell('X', 'colspan:13; border:TB;');
} else {
    $write->easyCell('', 'colspan:13; border:TB;');
}
$write->easyCell('', ' border:L;');
$write->easyCell('Corporation', 'colspan:80;');
$write->easyCell('', ' border:L;');
if ($r11["business_type_code"] == "COOP") {
    $write->easyCell('X', 'colspan:13; border:TB;');
} else {
    $write->easyCell('', 'colspan:13; border:TB;');
}
$write->easyCell('', ' border:L;');
$write->easyCell('Cooperative', 'colspan:160; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:600; paddingY:0.5; border:RLB;');
$write->printRow();

$write->easyCell('', 'colspan:600; paddingY:0.5; border:RL;');
$write->printRow();

$write->easyCell('Amendment: ', 'colspan:80; paddingY:1; border:L; font-style:B;');
$write->easyCell('From', ' colspan:70; align:L; font-style:B;');
$write->easyCell('', ' border:L;');
$write->easyCell('', 'colspan:13; border:TB;');
$write->easyCell('', ' border:L;');
$write->easyCell('Single', 'colspan:80;');
$write->easyCell('', ' border:L;');
$write->easyCell('', 'colspan:13; border:TB;');
$write->easyCell('', ' border:L;');
$write->easyCell('Partnership', 'colspan:80;');
$write->easyCell('', ' border:L;');
$write->easyCell('', 'colspan:13; border:TB;');
$write->easyCell('', ' border:L;');
$write->easyCell('Corporation', 'colspan:255; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:600; paddingY:0.5; border:RLB;');
$write->printRow();

$write->easyCell('', 'colspan:600; paddingY:0.5; border:RL;');
$write->printRow();

$write->easyCell('', 'colspan:80; paddingY:1; border:L;');
$write->easyCell('To', ' colspan:70; align:L; font-style:B;');
$write->easyCell('', ' border:L;');
$write->easyCell('', 'colspan:13; border:TB;');
$write->easyCell('', ' border:L;');
$write->easyCell('Single', 'colspan:80;');
$write->easyCell('', ' border:L;');
$write->easyCell('', 'colspan:13; border:TB;');
$write->easyCell('', ' border:L;');
$write->easyCell('Partnership', 'colspan:80;');
$write->easyCell('', ' border:L;');
$write->easyCell('', 'colspan:13; border:TB;');
$write->easyCell('', ' border:L;');
$write->easyCell('Corporation', 'colspan:255; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:600; paddingY:0.5; border:RLB;');
$write->printRow();

$write->easyCell('', 'colspan:600; paddingY:0.5; border:RL;');
$write->printRow();

$write->easyCell('Are you enjoying tax Incentive from any Government Entity?', 'colspan:290; border:L; font-style:B;');
$write->easyCell('', ' border:L;');
if ($r11["business_tax_incentive"] == "0") {
    $write->easyCell('X', 'colspan:13; border:TB;');
} else {
    $write->easyCell('', 'colspan:13; border:TB;');
}
$write->easyCell('', ' border:L;');
$write->easyCell('No', 'colspan:80;');
$write->easyCell('', ' border:L;');
if ($r11["business_tax_incentive"] == "1") {
    $write->easyCell('X', 'colspan:13; border:TB;');
} else {
    $write->easyCell('', 'colspan:13; border:TB;');
}
$write->easyCell('', ' border:L;');
$write->easyCell('Yes, Please specify', 'colspan:200; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:600; paddingY:0.5; border:RLB;');
$write->printRow();

$write->easyCell('Name of Taxpayer/Registrant', 'colspan:600; border:1; align:C;');
$write->printRow();

$write->easyCell('Last Name: ', 'colspan:50; paddingY:0.5; border:LB;');
$write->easyCell($r11["owner_last_name"], 'colspan:150; paddingY:0.5; border:BR;');
$write->easyCell('First Name: ', 'colspan:50; paddingY:0.5; border:LB;');
$write->easyCell($r11["owner_first_name"], 'colspan:150; paddingY:0.5; border:BR;');
$write->easyCell('Middle Name: ', 'colspan:60; paddingY:0.5; border:LB;');
$write->easyCell($r11["owner_middle_name"], 'colspan:140; paddingY:0.5; border:BR;');
$write->printRow();

$write->easyCell('Business Name:', 'colspan:70; border:LB; ');
$write->easyCell($r11["business_name"], 'colspan:530; border:RB; ');
$write->printRow();

$write->easyCell('Trade Name/Franchise:', 'colspan:95; border:LB; ');
$write->easyCell($r11["business_trade_name_franchise"], 'colspan:505; border:RB; ');
$write->printRow();

$write->easyCell('', 'colspan:15; border:L; paddingY:0.5;');
$write->easyCell('2. OTHER INFORMATION', 'colspan:585; font-style:B; border:R; paddingY:0.5;');
$write->printRow();

$write->easyCell('', 'colspan:15; border:LB; paddingY:0.5;');
$write->easyCell('Note: for renewal application, do not fill up this section unless certain information have changes.', 'colspan:585; font-style:B; border:RB; paddingY:0.5;');
$write->printRow();

$barangay_id = $r11["b_barangay_id"];
$q = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as b_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");
$r = mysqli_fetch_assoc($q);
$write->easyCell('Business Address: BARANGAY, ' . $r["b_add"], 'colspan:600; border:1; align:L;');
$write->printRow();
$b_addddd = $r["b_add"];
$write->easyCell('Postal Code: ' . $r["lgu_zip"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->easyCell('Email Address: ' . $r11["business_email"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->printRow();

$write->easyCell('Telephone No.: ' . $r11["business_tel_no"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->easyCell('Mobile No.: ' . $r11["business_mob_no"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->printRow();

$barangay_id = $r11["o_barangay_id"];
$q = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as o_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");
$r = mysqli_fetch_assoc($q);

$write->easyCell('Owners Address: BARANGAY, ' . $r["o_add"], 'colspan:600; border:1; align:L;');
$write->printRow();

$write->easyCell('Postal Code: ' . $r["lgu_zip"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->easyCell('Email Address:' . $r11["owner_email"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->printRow();

$write->easyCell('Telephone No.: ', 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->easyCell('Mobile No.: ' . $r11["owner_mobile"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->printRow();

$write->easyCell('In case of emergency, provide name of contact person:' . $r11["business_emergency_contact"], 'colspan:600; paddingY:1; border:1;');
$write->printRow();

$write->easyCell('Telephone No.: ' . $r11["business_emergency_mobile"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->easyCell('Email Address: ' . $r11["business_emergency_email"], 'colspan:300; paddingY:1; border:1; font-size:7;');
$write->printRow();

$write->easyCell('Busibess Area (in sqm.): ', 'colspan:100; paddingY:0.5; border:LB;');
$write->easyCell($r11["business_area"], 'colspan:100; paddingY:0.5; border:BR;');
$write->easyCell('Total Employees in Establishment: ', 'colspan:140; paddingY:0.5; border:LB;');
$write->easyCell($r11["business_employee_total"], 'colspan:60; paddingY:0.5; border:BR;');
$write->easyCell('No. of Employees Residing with LGU: ', 'colspan:150; paddingY:0.5; border:LB;');
$write->easyCell($r11["business_employee_resident"], 'colspan:50; paddingY:0.5; border:BR;');
$write->printRow();

$write->easyCell('Note: Fill Up Only if Business Place is Rented', 'colspan:600; border:1; font-style:B;');
$write->printRow();

$write->easyCell('Lessors Full Name: ' . $lessor_fullname, 'colspan:600; border:1;');
$write->printRow();

$write->easyCell('Lessors Full Address: ' . $lessor_address, 'colspan:600; border:1;');
$write->printRow();

$write->easyCell('Lessors Telephone/Mobile No.: ' . $lessor_mobile, 'colspan:600; border:1;');
$write->printRow();

$write->easyCell('Lessors Full Email Address: ' . $lessor_email, 'colspan:600; border:1;');
$write->printRow();

$write->easyCell('Monthly Rental: ' . $lessor_monthly_rental, 'colspan:600; border:1;');
$write->printRow();

$write->easyCell('', 'colspan:15; border:L; paddingY:0.5;');
$write->easyCell('3. BUSINESS ACTIVITY', 'colspan:585; font-style:B; border:R; paddingY:0.5;');
$write->printRow();

$write->easyCell('Line of Business', 'colspan:200; border:1; align:C; font-style:B; rowspan:2;');
$write->easyCell('No. of Units', 'colspan:70; border:1; align:C; font-style:B; rowspan:2;');
$write->easyCell('Capitalization', 'colspan:130; border:1; align:C; font-style:B; rowspan:2;');
$write->easyCell('Gross/Sales Receipts (for Renewal)', 'colspan:200; border:1; align:C; font-style:B;');
$write->printRow();

$write->easyCell('Essential', 'colspan:100; border:1; font-style:B; align:C;');
$write->easyCell('Non-Essential', 'colspan:100; font-style:B; border:1; align:C; ');
$write->printRow();
$q12 = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_permit_nature` where md5(permit_id) = '$id' ");
$arr_count3 = mysqli_num_rows($q12);
if ($arr_count3 > 0) {
    while ($r12 = mysqli_fetch_assoc($q12)) {
        $nature = $r12['nature_id'];
        $cap_investment = $r12['capital_investment'];
        $gross = $r12['last_year_gross'];
        $q = mysqli_query($conn, "SELECT nature_desc from geo_bpls_nature where nature_id = '$nature' ");
        $r = mysqli_fetch_assoc($q);

        $write->easyCell($r["nature_desc"], 'colspan:200; border:1; align:C;');
        $write->easyCell('', 'colspan:70; border:1; align:C;');
        if ($status_desc == "New") {
            $write->easyCell($cap_investment, 'colspan:130; border:1; align:C;');
            $write->easyCell('0.00', 'colspan:200; border:1; align:C;');
        } else {
            $write->easyCell('0.00', 'colspan:130; border:1; align:C;');
            $write->easyCell($gross, 'colspan:200; border:1; align:C;');
        }
        $write->printRow();
    }
}

$write->easyCell('', 'colspan:600; paddingY:3; ');
$write->printRow();

$write->easyCell('I DECLARE UNDER PENALTY OF PERJURY that the foregoing information are true based on my personal knowledge and authentic records. Further, I agree to comply with the regulatory requirement and other deficiencies within 30 days from release of the business permit.', 'colspan:600; font-style:B;');
$write->printRow();

$write->easyCell('', 'colspan:600; paddingY:3; ');
$write->printRow();

$write->easyCell('', 'colspan:280; paddingY:0.5; ');
$write->easyCell(strtoupper($r11["owner_first_name"] . " " . $r11["owner_middle_name"] . " " . $r11["owner_last_name"]), 'colspan:270; paddingY:0.5; border:B; align:C;');
$write->easyCell('', 'colspan:50; paddingY:0.5; ');
$write->printRow();

$write->easyCell('', 'colspan:280; paddingY:0.5; ');
$write->easyCell('SIGNATURE OF APPLICANT/TAXPAYER OVER PRINTED NAME', 'colspan:270; paddingY:0.5; align:C;');
$write->easyCell('', 'colspan:50; paddingY:0.5; ');
$write->printRow();

$write->easyCell('', 'colspan:600; paddingY:7; ');
$write->printRow();

$write->easyCell('', 'colspan:280; paddingY:0.5; ');
$write->easyCell('', 'colspan:270; paddingY:0.5; border:B; align:C;');
$write->easyCell('', 'colspan:50; paddingY:0.5; ');
$write->printRow();

$write->easyCell('', 'colspan:280; paddingY:0.5; ');
$write->easyCell('POSITION/TITLE', 'colspan:270; paddingY:0.5; align:C;');
$write->easyCell('', 'colspan:50; paddingY:0.5; ');
$write->printRow();

$write->endTable();

$f_q = mysqli_query($conn, "SELECT count(permit_id) as p_count FROM `geo_bpls_assessment` WHERE md5(permit_id) = '$id' ");
$f_r = mysqli_fetch_assoc($f_q);

if ($f_r["p_count"] > 0) {

    $pdf->AddPage();
    $pdf->SetFont('Helvetica', '', 8.5);

    $write = new easyTable($pdf, 600, 'width:100%; align:L; font-style:N; font-family:Helvetica; ');

    $write->easyCell('', 'colspan:600; paddingY:3;');
    $write->printRow();

    $write->easyCell('ANNEX 1 (page 2 of 2) Application form for Business Permit', 'colspan:600; align:L; border:1; font-style:B;');
    $write->printRow();

    $write->easyCell('II. LGU Section (Do Not Fill Up This Section)', 'colspan:600; align:L; border:1; font-style:B;');
    $write->printRow();

    $write->easyCell('', 'colspan:5; border:LB; paddingY:0.5;');
    $write->easyCell('1. VERIFICATION OF DOCUMENTS', 'colspan:595; font-style:B; border:RB; paddingY:0.5;');
    $write->printRow();

    $write->easyCell('Description', 'colspan:230; border:1; align:C; font-style:B;');
    $write->easyCell('Office/Agency', 'colspan:130; border:1; align:C; font-style:B;');
    $write->easyCell('Yes', 'colspan:60; border:1; align:C; font-style:B;');
    $write->easyCell('No', 'colspan:60; border:1; align:C; font-style:B;');
    $write->easyCell('Not Needed', 'colspan:120; border:1; align:C; font-style:B;');
    $write->printRow();

    $req_q = mysqli_query($conn, "SELECT * from geo_bpls_requirement ");
    while ($req_r = mysqli_fetch_assoc($req_q)) {

        $req_id = $req_r["requirement_id"];
        $q = mysqli_query($conn, "SELECT requirement_id FROM `geo_bpls_business_requirement`
                where business_id = '$business_id' and requirement_id = '$req_id' ");

        $status1 = "";
        $status2 = "";
        $r = mysqli_fetch_assoc($q);
        if ($r["requirement_id"] == $req_r["requirement_id"]) {
            $status1 = "X";
        } else {
            $status2 = "X";
        }

        $write->easyCell('', 'colspan:10; border:LB;');
        $write->easyCell($req_r["requirement_desc"], 'colspan:220; border:RTB; align:L;');
        $write->easyCell('', 'colspan:130; border:1; align:L;');
        $write->easyCell($status1, 'colspan:60; border:1; align:C;');
        $write->easyCell($status2, 'colspan:60; border:1; align:C;');
        $write->easyCell('', 'colspan:120; border:1; align:L;');
        $write->printRow();

    }

    $write->easyCell('', 'colspan:340; border:L;');
    $write->easyCell('Verified by: BPLO', 'colspan:140; align:L; font-style:B;');
    $write->easyCell('', 'colspan:120; border:R;');
    $write->printRow();

    $write->easyCell('', 'colspan:420; border:L; align:L;');
    $write->easyCell('BPLO', 'colspan:160; border:B; paddingY:0; align:C;');
    $write->easyCell('', 'colspan:20; border:R;');
    $write->printRow();

    $write->easyCell('', 'colspan:600; border:LRB;');
    $write->printRow();

    $write->easyCell('', 'colspan:5; border:LB; paddingY:0.5;');
    $write->easyCell('2. ASSESSMENT OF APPLICABLE FEES', 'colspan:595; font-style:B; border:RB; paddingY:0.5;');
    $write->printRow();

    $write->easyCell('Local Taxes', 'colspan:250; border:1; align:C; font-style:B;');
    $write->easyCell('Amount Due', 'colspan:120; border:1; align:C; font-style:B;');
    $write->easyCell('Penalty/Surcharge', 'colspan:130; border:1; align:C; font-style:B;');
    $write->easyCell('Total', 'colspan:100; border:1; align:C; font-style:B;');
    $write->printRow();

    $q = mysqli_query($conn, "SELECT nature_id from geo_bpls_business_permit_nature
                        where md5(permit_id) = '$id' ");
    $total_fee = 0;
    $total_fee_reg = 0;

    while ($r = mysqli_fetch_assoc($q)) {

        // select nature
        $nature_id = $r["nature_id"];

        $q_nature = mysqli_query($conn, "SELECT nature_desc from geo_bpls_nature where nature_id = '$nature_id' ");
        $r_nature = mysqli_fetch_assoc($q_nature);
        $write->easyCell('', 'colspan:5; border:LB; paddingY:0.5;');
        $write->easyCell($r_nature["nature_desc"], 'colspan:595; font-style:B; border:RB; paddingY:0.5;');
        $write->printRow();

        // fix sub account no

        $write->easyCell('', 'colspan:5; border:LB;');
        $write->easyCell('TAX', 'colspan:245; border:TB; align:L; font-style:B;');
        $write->easyCell('', 'colspan:120; border:1;');
        $write->easyCell('', 'colspan:130; border:1;');
        $write->easyCell('', 'colspan:100; border:1;');
        $write->printRow();

        $q0 = mysqli_query($conn, "SELECT assessment_tax_due, natureOfCollection_tbl.name as sub_account_title from geo_bpls_assessment
                        inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.tfo_nature_id =  geo_bpls_assessment.tfo_nature_id
                         inner join natureOfCollection_tbl on natureOfCollection_tbl.id =  geo_bpls_tfo_nature.sub_account_no
                        where md5(geo_bpls_assessment.permit_id) = '$id' and geo_bpls_tfo_nature.nature_id = '$nature_id' and (geo_bpls_tfo_nature.sub_account_no = '1010' or geo_bpls_tfo_nature.sub_account_no = '1011' or geo_bpls_tfo_nature.sub_account_no = '1012' or geo_bpls_tfo_nature.sub_account_no = '1013' or  geo_bpls_tfo_nature.sub_account_no = '1014' or geo_bpls_tfo_nature.sub_account_no = '1015' or geo_bpls_tfo_nature.sub_account_no = '1016' or geo_bpls_tfo_nature.sub_account_no = '1017' or geo_bpls_tfo_nature.sub_account_no = '1018' or geo_bpls_tfo_nature.sub_account_no = '1019' or geo_bpls_tfo_nature.sub_account_no = '1020' or geo_bpls_tfo_nature.sub_account_no = '1021' ) ");


        $r0 = mysqli_fetch_assoc($q0);

        $write->easyCell('', 'colspan:10; border:LB;');
        $write->easyCell(substr(strtoupper($r0["sub_account_title"]),0,15), 'colspan:240; border:TRB; align:L; ');
        $write->easyCell($r0["assessment_tax_due"], 'colspan:120; border:1; align:R;');
        $write->easyCell('', 'colspan:130; border:1; align:R;');
        $write->easyCell('', 'colspan:100; border:1; align:R;');
        $write->printRow();
        if ($r0["assessment_tax_due"] != 0 || $r0["assessment_tax_due"] != 0.00) {
            $total_fee += $r0["assessment_tax_due"];
        }
        $write->easyCell('', 'colspan:5; border:LB;');
        $write->easyCell('REGULATORY FEES AND CHARGES', 'colspan:245; border:TB; align:L; font-style:B;');
        $write->easyCell('', 'colspan:120; border:1;');
        $write->easyCell('', 'colspan:130; border:1;');
        $write->easyCell('', 'colspan:100; border:1;');
        $write->printRow();

        $q2 = mysqli_query($conn, "SELECT natureOfCollection_tbl.id as sub_account_no, assessment_tax_due,natureOfCollection_tbl.name as sub_account_title from geo_bpls_assessment  inner join geo_bpls_tfo_nature on geo_bpls_tfo_nature.tfo_nature_id =  geo_bpls_assessment.tfo_nature_id
                         inner join natureOfCollection_tbl on natureOfCollection_tbl.id =  geo_bpls_tfo_nature.sub_account_no
                        where md5(geo_bpls_assessment.permit_id) = '$id' and geo_bpls_tfo_nature.nature_id = '$nature_id' and (geo_bpls_tfo_nature.sub_account_no != '1010' and geo_bpls_tfo_nature.sub_account_no != '1011' and geo_bpls_tfo_nature.sub_account_no != '1012' and geo_bpls_tfo_nature.sub_account_no != '1013' and  geo_bpls_tfo_nature.sub_account_no != '1014' and geo_bpls_tfo_nature.sub_account_no != '1015' and geo_bpls_tfo_nature.sub_account_no != '1016' and geo_bpls_tfo_nature.sub_account_no != '1017' and geo_bpls_tfo_nature.sub_account_no != '1018' and geo_bpls_tfo_nature.sub_account_no != '1019' and geo_bpls_tfo_nature.sub_account_no != '1020' and geo_bpls_tfo_nature.sub_account_no != '1021' )  ");

        while ($r2 = mysqli_fetch_assoc($q2)) {
            $write->easyCell('', 'colspan:10; border:LB;');
            $write->easyCell($r2["sub_account_title"], 'colspan:240; border:TRB; align:L; ');
            $write->easyCell($r2["assessment_tax_due"], 'colspan:120; border:1; align:R;');
            $write->easyCell('', 'colspan:130; border:1; align:R;');
            $write->easyCell('', 'colspan:100; border:1; align:R;');
            $write->printRow();

            if($r2["assessment_tax_due"] != 0 || $r2["assessment_tax_due"] != 0.00) {
                    $total_fee += $r2["assessment_tax_due"];
                    $total_fee_reg += $r2["assessment_tax_due"];
            }
        }

    }

    $write->easyCell('', 'colspan:600; border:1; paddingY:2;');
    $write->printRow();

    $write->easyCell('TOTAL FEES for LGU', 'colspan:250; border:1; align:R; font-style:B;');
    $write->easyCell(number_format($total_fee, 2), 'colspan:120; border:1; align:R; font-style:B;');
    $write->easyCell('', 'colspan:130; border:1; align:R;');
    $write->easyCell('', 'colspan:100; border:1; align:R;');
    $write->printRow();
    $q00 = mysqli_query($conn,"SELECT * from geo_bpls_bfp_settings where id='1'");
    $r00 = mysqli_fetch_assoc($q00);
    $percentage = $r00["percentage"];
    $percentage_2 = $percentage * 0.01;
    $write->easyCell('FIRE SAFETY INSPECTION FEE ('.$percentage.'%)', 'colspan:250; border:1; align:R; font-style:B;');
    $write->easyCell(number_format($total_fee_reg * $percentage_2, 2), 'colspan:120; border:1; align:R; font-style:B;');
    $write->easyCell('', 'colspan:130; border:1; align:R;');
    $write->easyCell('', 'colspan:100; border:1; align:R;');
    $write->printRow();

    $write->easyCell('', 'colspan:30; border:L;');
    $write->easyCell('Assed by:', 'colspan:150; font-style:B;');
    $write->easyCell('', 'colspan:100;');
    $write->easyCell('FSIS Assessment Approved by: BFP', 'colspan:170; font-style:B;');
    $write->easyCell('', 'colspan:150; border:R;');
    $write->printRow();

    $write->easyCell('', 'colspan:80; border:L;');
    $write->easyCell('', 'colspan:150; border:B; paddingY:0; align:C;');
    $write->easyCell('', 'colspan:200;');
    $write->easyCell('', 'colspan:160; border:B; paddingY:0; align:C;');
    $write->easyCell('', 'colspan:10; border:R;');
    $write->printRow();

    $write->easyCell('', 'colspan:600; border:RLB; paddingY:2;');
    $write->printRow();

    $write->easyCell('', 'colspan:600;');
    $write->printRow();

    $write->easyCell('III. CITY / MUNICIPALITY FIRE STATION SECTION', 'colspan:600; font-style:B;');
    $write->printRow();

    $write->easyCell('', 'colspan:600; paddingY;0.5; border:LRT;');
    $write->printRow();

    $write->easyCell(' ', 'colspan:400; border:L; paddingY:0;');
    $write->easyCell('DATE:', 'colspan:35; font-style:B; paddingY:0;');
    $write->easyCell('', 'colspan:100; border:B; paddingY:0;');
    $write->easyCell('', 'colspan:65; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L;');
    $write->easyCell('APPLICATION NO.', 'colspan:90; font-style:B; paddingY:0;');
    $write->easyCell('', 'colspan:140; border:B; paddingY:0;');
    $write->easyCell('', 'colspan:360; border:R;');
    $write->printRow();

    $write->easyCell('', 'colspan:600; paddingY;0.5; border:LR;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('(TO BE FILLED UP BY APPLICANT/OWNER)', 'colspan:590; font-style:B; paddingY:0; border:R;');
    $write->printRow();

    $write->easyCell('', 'colspan:600; border:LR;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('(TO BE FILLED UP BY APPLICANT/OWNER)', 'colspan:590; font-style:B; paddingY:0; border:R;');
    $write->printRow();

    $write->easyCell('', 'colspan:600; border:LR;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('Name of Applicant/Owner :', 'colspan:130; font-size:9;');
    $write->easyCell(strtoupper($r11["owner_first_name"] . " " . $r11["owner_middle_name"] . " " . $r11["owner_last_name"]), 'colspan:290; font-style:U;');
    $write->easyCell('', 'colspan:170; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('Name of Business :', 'colspan:130; font-size:9;');
    $write->easyCell($r11["business_name"], 'colspan:290; font-style:U;');
    $write->easyCell('', 'colspan:170; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('Total Floor Area :', 'colspan:130; font-size:9;');
    $write->easyCell($r11["business_area"] . " sqm", 'colspan:290; font-style:U;');
    $write->easyCell('', 'colspan:20; paddingY:0;');
    $write->easyCell('Contact No. :', 'colspan:55; paddingY:0;');
    $write->easyCell($r11["business_mob_no"], 'colspan:75; paddingY:0; font-style:U;');
    $write->easyCell('', 'colspan:20; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('Address of Establishment  :', 'colspan:130; font-size:9;');
    $write->easyCell($b_addddd, 'colspan:300; font-style:U;');
    $write->easyCell('', 'colspan:160; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('______________________________', 'colspan:310; font-size:9;');
    $write->easyCell('', 'colspan:180; font-style:U;');
    $write->easyCell('', 'colspan:160; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('Signature of Applicant/Owner:', 'colspan:310; font-size:9;');
    $write->easyCell('', 'colspan:180; font-style:U;');
    $write->easyCell('', 'colspan:160; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('', 'colspan:310; font-size:9;');
    $write->easyCell('', 'colspan:180; font-style:U;');
    $write->easyCell('', 'colspan:160; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('', 'colspan:310; font-size:9;');
    $write->easyCell('', 'colspan:180; font-style:U;');
    $write->easyCell('', 'colspan:160; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('', 'colspan:310; font-size:9;');
    $write->easyCell('', 'colspan:180; font-style:U;');
    $write->easyCell('', 'colspan:160; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('Certified By:', 'colspan:310; font-size:9;');
    $write->easyCell('', 'colspan:100; ');
    $write->easyCell('', 'colspan:180; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('Customer Relations Officer:', 'colspan:310; font-size:9;');
    $write->easyCell('', 'colspan:180; font-style:U;');
    $write->easyCell('', 'colspan:160; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; border:L; paddingY:0;');
    $write->easyCell('Time and Date Received:_____________________________', 'colspan:310; font-size:9;');
    $write->easyCell('', 'colspan:180; font-style:U;');
    $write->easyCell('', 'colspan:160; border:R; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:600; border:LRB;');
    $write->printRow();

    $write->easyCell('', 'colspan:10;  paddingY:0;');
    $write->easyCell('', 'colspan:310; font-size:9;');
    $write->easyCell('', 'colspan:180; font-style:U;');
    $write->easyCell('', 'colspan:160;  paddingY:0;');

    $write->printRow();

    $write->easyCell('', 'colspan:10; paddingY:0;');
    $write->easyCell('', 'colspan:310; font-size:9;');
    $write->easyCell('', 'colspan:300; font-style:U;');
    $write->easyCell('', 'colspan:160; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10;paddingY:0;');
    $write->easyCell('Important Notice: As per Section 12 of the Implementing Rules and regulation of the Fire Code of 2008, certain establishment (e.g building lessors, fire, earthquake and explosion hazard Insurance companies, and vendors of fire fighting equipment, appliances and devices) may be required to pay additional charges and fees other that the Fire Safety Inspection Fees. These shall be collected during inspection or in another process to be communicated by representatives of Bureau of Fire Protection (BFP)', 'colspan:310; font-style:I B; font-size:8;  align:L; colspan:580;
');
    $write->easyCell('', 'colspan:300; font-style:U;');
    $write->easyCell('', 'colspan:160; border:R; paddingY:0;');
    $write->printRow();

    $write->endTable();
    $pdf->Ln();

    $pdf->Ln();

//   $pdf->SetFont("ZapfDingbats","","8");
    //     $pdf->Cell(5,5,'3',0,0);
    //  $pdf->SetFont("arial","","8");

// if($status_desc == "New"){
    //     $pdf->setXY(11,55);
    //     $pdf->Cell(5,5,'X',0,0);
    // }else{
    //     $pdf->setXY(36,55);
    //     $pdf->Cell(5,5,'X',0,0);
    // }
}

$pdf->Output();
