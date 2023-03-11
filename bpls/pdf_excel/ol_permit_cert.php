<?php
$key = $_GET["key"];
include "../../jomar_assets/enc.php";
if(isset($_GET["key"]) && isset($_GET["target"])){
if(me_decrypt($key) == "GEO-INFOMETRICS-2021-5723409324"){

//include connection file
include "../../php/connect.php";
include "../../../bower_components/libs/fpdf.php";
include "../../../bower_components/libs/exfpdf.php";
include "../../../bower_components/libs/easyTable.php";

$uniq_id = me_decrypt($_GET['target']);

// check if new, renew and retire
$qwww = mysqli_query($conn, "SELECT status_code FROM geo_bpls_business_permit where md5(permit_id) = '$uniq_id' ");

$rwww = mysqli_fetch_assoc($qwww);

$q11 = mysqli_query($conn, "SELECT retirement_date, permit_released_date,  permit_no, geo_bpls_business_permit.permit_approved_remark, geo_bpls_business_permit.permit_approved,permit_id, civil_status_id, geo_bpls_business.business_id, business_emergency_contact, geo_bpls_business_permit.payment_frequency_code, status_code, step_code, permit_application_date, business_name, geo_bpls_business.barangay_id as b_barangay_id , business_type_code, economic_area_code, economic_org_code, geo_bpls_business.lgu_code as b_lgu_code, occupancy_code, geo_bpls_business.province_code as b_province_code, geo_bpls_business.region_code as b_reg_code, scale_code, sector_code, business_address_street, business_application_date, business_area, business_mob_no, business_tel_no, business_contact_name, business_dti_sec_cda_reg_date, business_dti_sec_cda_reg_no, business_email, business_email, business_emergency_email, business_emergency_mobile, business_employee_resident, business_employee_total,business_tax_incentive, business_tax_incentive_entity, business_tin_reg_no, business_trade_name_franchise, owner_first_name, owner_middle_name, owner_last_name, geo_bpls_owner.barangay_id as o_barangay_id, citizenship_id,gender_code, geo_bpls_owner.lgu_code as o_lgu_code, geo_bpls_owner.province_code as o_province_code, geo_bpls_owner.region_code as o_reg_code, geo_bpls_owner.zone_id as o_zone_id, geo_bpls_owner.owner_address_street, owner_birth_date, owner_email,owner_legal_entity, owner_mobile FROM `geo_bpls_business_permit`
INNER JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id
INNER JOIN geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id
WHERE md5(geo_bpls_business_permit.permit_id) = '$uniq_id';
 ");

$r11 = mysqli_fetch_assoc($q11);

if ($rwww["status_code"] != "RET") {

    $q2222 = mysqli_query($conn, "SELECT nature_desc FROM `geo_bpls_business_permit_nature` inner join geo_bpls_nature on geo_bpls_nature.nature_id = geo_bpls_business_permit_nature.nature_id where md5(permit_id) = '$uniq_id' ");

    $r_count = mysqli_num_rows($q2222);
    $pdf = new exFPDF('L', 'mm', array(210, 297));
    $pdf->SetMargins(5, 10, 5, 10);
    $pdf->SetAutoPageBreak(true, 4);

// get nature

    $aa = 0;
    $ff = 0;
    while ($r2222 = mysqli_fetch_assoc($q2222)) {
        $ff++;
        $nature = $r2222["nature_desc"];

        $pdf->AddPage();

        $pdf->SetFont('Helvetica', '', 9);

        $write = new easyTable($pdf, 100, 'width:100%; height:100%; font-style:N; font-family:times; font-weight:100;
');
// $pdf->Image('../../bpls/images_file/vf_mbp.jpg', 0, 0, 295.96, 210.5);

        $year = date("Y");
        // generate_permit no

        if ($r11["permit_no"] == null) {
            // nano business declare scale code is 14
            $nano_scale_code = 14;
            // not nano
            if ($nano_scale_code != $r11["scale_code"]) {
                $q = mysqli_query($conn, "SELECT SUBSTRING(permit_no,16,20) ,  permit_no FROM `geo_bpls_business_permit`
                inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id
                where permit_no != '' and scale_code != $nano_scale_code and permit_for_year = '2021'  ORDER BY SUBSTRING(permit_no,16,20) DESC LIMIT 1");
                $r = mysqli_fetch_assoc($q);

                $r_count = mysqli_num_rows($q);
                if ($r_count > 0) {
                    $latest_permit_no = $r["permit_no"];
                    $latest_permit_no_arr = explode("-", $latest_permit_no);

                    
                    if ($ff == 1) {
                    $invID = ($latest_permit_no_arr[3] * 1) + 1;
                    $invID = str_pad($invID, 4, '0', STR_PAD_LEFT);
                    $permit_no = $latest_permit_no_arr[0] . "-" . $latest_permit_no_arr[1] . "-" . date("Y") . "-" . $invID;

                        $q = mysqli_query($conn, "UPDATE geo_bpls_business_permit SET permit_no = '$permit_no' where md5(permit_id) = '$uniq_id' ");
                    }
                } else {
                    $permit_no = "iLGU-BPLS-" . date("Y") . "-0001";
                    $q = mysqli_query($conn, "UPDATE geo_bpls_business_permit SET permit_no = '$permit_no' where md5(permit_id) = '$uniq_id' ");

                }
            } else {
                $q = mysqli_query($conn, "SELECT SUBSTRING(permit_no,16,20) ,  permit_no FROM `geo_bpls_business_permit`
            inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id
            where permit_no != '' and scale_code = $nano_scale_code and permit_for_year = '2021'  ORDER BY SUBSTRING(permit_no,18,20) DESC LIMIT 1");
                $r = mysqli_fetch_assoc($q);

                $r_count = mysqli_num_rows($q);
                if ($r_count > 0) {
                    $latest_permit_no = $r["permit_no"];
                    $latest_permit_no_arr = explode("-", $latest_permit_no);

                    $invID = ($latest_permit_no_arr[4] * 1) + 1;
                    $invID = str_pad($invID, 4, '0', STR_PAD_LEFT);

                    $permit_no = $latest_permit_no_arr[0] . "-" . $latest_permit_no_arr[1] . "-" . date("Y") . "-A-" . $invID;

                    $q = mysqli_query($conn, "UPDATE geo_bpls_business_permit SET permit_no = '$permit_no' where md5(permit_id) = '$uniq_id' ");

                } else {
                    $permit_no = "iLGU-BPLS-" . date("Y") . "-A-" . "0001";
                    $q = mysqli_query($conn, "UPDATE geo_bpls_business_permit SET permit_no = '$permit_no' where md5(permit_id) = '$uniq_id' ");

                }

            }
        } else {
            $permit_no = $r11["permit_no"];
        }

        $status_code = $r11["status_code"];
        $q = mysqli_query($conn, "SELECT status_desc from geo_bpls_status where status_code = '$status_code' ");
        $r = mysqli_fetch_assoc($q);
        $status_desc = strtoupper($r["status_desc"]);

        $barangay_id = $r11["b_barangay_id"];

        $write->easyCell('', 'colspan:100; paddingY:7;');
        $write->printRow();

        $write->easyCell("BUSINESS/MAYOR'S PERMIT", 'colspan:100; paddingY:0; align:C; font-style:B; font-size:17;');
        $write->printRow();

        $write->easyCell('is hereby granted to', 'colspan:100; paddingY:5; font-style:I; align:C;');
        $write->printRow();

        $write->easyCell('', 'colspan:100; paddingY:2;');
        $write->printRow();

        $write->easyCell(str_replace("&amp;", "&", strtoupper(utf8_decode($r11["business_name"]))), 'colspan:100; paddingY:0; font-style:BU; align:C; font-size:17;');
        $write->printRow();

        $q = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as b_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");

        $r = mysqli_fetch_assoc($q);

        $write->easyCell('BARANGAY, ' . $r["b_add"], 'colspan:100; paddingY:0; font-style:I; align:C; font-size:10;');
        $write->printRow();

        $write->easyCell('', 'colspan:100; paddingY:2;');
        $write->printRow();

        $write->easyCell('', 'colspan:25; paddingY:0;');
        $write->easyCell('to conduct/ operate/ engage/ maintain business pursuant to the Revised Revenue Code of the Municipality of Majayjay described below', 'colspan:50; paddingY:0; font-style:I; align:C; font-size:10;');
        $write->easyCell('', 'colspan:25; paddingY:0;');
        $write->printRow();

        $write->easyCell('', 'colspan:100; paddingY:2;');
        $write->printRow();

        $write->easyCell($permit_no, 'colspan:100; paddingY:0; font-style:B; align:C; font-size:17;');
        $write->printRow();

        $write->easyCell('', 'colspan:100; paddingY:1;');
        $write->printRow();

        $write->easyCell('Owner', 'colspan:100; paddingY:0; align:C; font-style:I;');
        $write->printRow();

        $write->easyCell(strtoupper(utf8_decode($r11["owner_first_name"])) . " " . strtoupper(utf8_decode($r11["owner_last_name"])), 'colspan:100; paddingY:1; font-style:B; align:C;');
        $write->printRow();
        $barangay_id = $r11["o_barangay_id"];

        $q = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as o_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");

        $r = mysqli_fetch_assoc($q);
        $write->easyCell("BARANGAY " . $r["o_add"], 'colspan:100; paddingY:0; align:C; font-style:I; font-size:10;');
        $write->printRow();

        $write->easyCell('', 'colspan:100; paddingY:1;');
        $write->printRow();

        $write->easyCell('Status of Business', 'colspan:100; paddingY:0; align:C; font-style:I;');
        $write->printRow();

        $write->easyCell($status_desc, 'colspan:100; paddingY:1; font-style:B; align:C; font-size:12;');
        $write->printRow();

        $write->easyCell('', 'colspan:100; paddingY:1;');
        $write->printRow();

//  $nature
        $write->easyCell('Nature of Business', 'colspan:100; paddingY:0; align:C; font-style:I;');
        $write->printRow();

        $write->easyCell($nature, 'colspan:100; paddingY:1; font-style:B; align:C; font-size:12;');
        $write->printRow();

        $write->easyCell('', 'colspan:100; paddingY:2;');
        $write->printRow();

        if ($r11["permit_released_date"] == null) {
            $date = date('l jS \of F Y');
            // updating release date
            $date1 = date("Y-m-d");
            mysqli_query($conn, "UPDATE geo_bpls_business_permit SET permit_released_date = '$date1' where md5(permit_id) = '$uniq_id' ");
        } else {
            $aa = strtotime($r11["permit_released_date"]);
            $date = date('l jS \of F Y', $aa);
        }

        // Friday, 4th day of September 2020
        $write->easyCell('Given this ' . $date . '  at Majayjay, Laguna Philippines.', 'colspan:100; paddingY:0; align:C; font-style:I;');
        $write->printRow();

        $write->easyCell('', 'colspan:100; paddingY:5;');
        $write->printRow();

        $write->easyCell('Approved:', 'colspan:55; paddingY:0; font-style:I; align:R;');
        $write->easyCell('', 'colspan:35; paddingY:0; ');
        $write->printRow();

        $write->easyCell('', 'colspan:100; paddingY:2;');
        $write->printRow();

        $write->easyCell('', 'colspan:57; paddingY:0;');
        $write->easyCell('', 'colspan:25; paddingY:0; align:C;');
        $write->easyCell('', 'colspan:18; paddingY:0;');
        $write->printRow();

        $write->easyCell('', 'colspan:52; paddingY:0;');
        $write->easyCell('HON. CARLO INVINZOR B. CLADO', 'colspan:35; paddingY:0; align:C; font-style:B; font-size:12;');
        $write->easyCell('', 'colspan:18; paddingY:0;');
        $write->printRow();

        $pdf->Image('../../bpls/images_file/sig.png', 180, 130, 42.96, 22.5);

        $write->easyCell('', 'colspan:57; paddingY:0;');
        $write->easyCell('MUNICIPAL MAYOR', 'colspan:25; paddingY:0; align:C; font-style:I; font-size:12;');
        $write->easyCell('', 'colspan:18; paddingY:0;');
        $write->printRow();

// GET latest OR
        $q = mysqli_query($conn, "SELECT or_no, payment_total_amount_paid from geo_bpls_payment where md5(permit_id) = '$uniq_id' ORDER BY payment_id DESC limit 1 ");

        $r = mysqli_fetch_assoc($q);
        $or_no = $r["or_no"];
        $or_no_amount = $r["payment_total_amount_paid"];

        $write->easyCell('', 'colspan:15; paddingY:0;');
        $write->easyCell('OR No. :', 'colspan:8; paddingY:0; font-size:10;');
        $write->easyCell($or_no, 'colspan:77; paddingY:0; font-style:B; font-size:10;');
        $write->printRow();

        $write->easyCell('', 'colspan:15; paddingY:0;');
        $write->easyCell('Amount Paid :', 'colspan:8; paddingY:0; font-size:10;');
        $write->easyCell(number_format($or_no_amount, 2), 'colspan:77; paddingY:0; font-style:B; font-size:10;');
        $write->printRow();

        $write->easyCell('', 'colspan:15; paddingY:0;');
        $write->easyCell('Siries :', 'colspan:8; paddingY:0; font-size:10;');

        $arr_exp = explode('-', $permit_no);

        $write->easyCell($arr_exp["2"], 'colspan:77; paddingY:0; font-style:B; font-size:10;');
        $write->printRow();

        $write->easyCell('', 'colspan:15; paddingY:0;');
        $write->easyCell('VALID UP TO DECEMBER 31, ' . $arr_exp["2"], 'colspan:85; paddingY:0; font-style:B; font-size:10; font-style:B;');
        $write->printRow();

        $write->endTable();
        $pdf->Ln();

    }

    $pdf->Output();
} else {
// for retire ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    $date1 = date("Y-m-d h:i:s");
    if ($r11["retirement_date"] == null || $r11["retirement_date"] == "") {
        mysqli_query($conn, "UPDATE geo_bpls_business_permit SET permit_no = 'closed',retirement_date = '$date1' where md5(permit_id) = '$uniq_id' ");
        $retirement_date = $date1;
    } else {
        $retirement_date = $r11["retirement_date"];
    }

    $pdf = new exFPDF('P');
    $pdf->SetMargins(6, 6);
    $pdf->AddPage();
    $pdf->SetFont('Times', '', 13);
// $pdf->AddFont('oldenglishn');

    $l = mysqli_query($conn, "SELECT  (`province`)as province, (`municipality`)as municipality,(`region`)FROM `header`");
    $d = mysqli_fetch_assoc($l);

    $province = $d['province'];
    $municipality = $d['municipality'];

    $write = new easyTable($pdf, 100, 'width:100%; align:c; font-style:N; font-family:Arial;  font-size:12');

    $write->easyCell('', 'colspan:6; paddingY:0; rowspan:5;');
    $write->easyCell('', 'img:../../../dist/img/logo.png, align:R; colspan:12; paddingY:0; rowspan:5;');
    $write->easyCell('Republic of the Philippines', 'colspan:64; paddingY:0; align:C;');
    $write->easyCell('', 'colspan:18; paddingY:0; rowspan:5;');
    $write->printRow();

    $write->easyCell('Province of ' . $province . '', 'colspan:64; paddingY:0; align:C;');
    $write->printRow();

    $write->easyCell('Municipality of ' . $municipality . '', 'colspan:64; paddingY:0.5; align:C;');
    $write->printRow();

    $write->easyCell('BUSINESS PERMITS AND LICENSING OFFICE (BPLO)', 'colspan:64; paddingY:0; align:C; font-style:B;');
    $write->printRow();

    $write->easyCell('OFFICE OF THE MUNICIPAL TREASURER', 'colspan:64; paddingY:0; align:C; font-style:B;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:4;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:0.5; border:2; bgcolor:#6495ED;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:3;');
    $write->printRow();

    $write->easyCell('CERTIFICATE OF RETIREMENT', 'colspan:100; paddingY:0; align:C; font-style:B;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:3;');
    $write->printRow();

    $write->easyCell('', 'colspan:9; paddingY:0;');
    $write->easyCell('Business Name', 'colspan:30; paddingY:0;');
    $write->easyCell(':', 'colspan:3; align:R; paddingY:0; font-size:13;');
    $write->easyCell($r11["business_name"], 'colspan:45; paddingY:0; border:B;');
    $write->easyCell('', 'colspan:13; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:2;');
    $write->printRow();

    $write->easyCell('', 'colspan:9; paddingY:0;');
    $write->easyCell('Business Address', 'colspan:30; paddingY:0;');
    $write->easyCell(':', 'colspan:3; align:R; paddingY:0; font-size:13;');

    $barangay_id = $r11["b_barangay_id"];

    $q = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as b_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");

    $r = mysqli_fetch_assoc($q);

    $write->easyCell('' . $r["b_add"] . '', 'colspan:45; paddingY:0; border:B;');
    $write->easyCell('', 'colspan:13; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:2;');
    $write->printRow();

    $write->easyCell('', 'colspan:9; paddingY:0;');

    $write->easyCell('Name of Owner', 'colspan:30; paddingY:0;');
    $write->easyCell(':', 'colspan:3; align:R; paddingY:0; font-size:13;');
    $write->easyCell($r11["owner_first_name"] . " " . $r11["owner_middle_name"] . " " . $r11["owner_last_name"], 'colspan:45; paddingY:0; border:B;');
    $write->easyCell('', 'colspan:13; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:2;');
    $write->printRow();
    $barangay_id = $r11["o_barangay_id"];

    $q = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as o_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");

    $r = mysqli_fetch_assoc($q);

    $write->easyCell('', 'colspan:9; paddingY:0;');
    $write->easyCell('Owner Address', 'colspan:30; paddingY:0;');
    $write->easyCell(':', 'colspan:3; align:R; paddingY:0; font-size:13;');
    $write->easyCell($r["o_add"], 'colspan:45; paddingY:0; border:B;');
    $write->easyCell('', 'colspan:13; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:2;');
    $write->printRow();
    $q = mysqli_query($conn, "SELECT or_no, payment_total_amount_paid from geo_bpls_payment where md5(permit_id) = '$uniq_id' ORDER BY payment_id DESC limit 1 ");

    $r = mysqli_fetch_assoc($q);
    $or_no = $r["or_no"];
    $or_no_amount = $r["payment_total_amount_paid"];

    $write->easyCell('', 'colspan:9; paddingY:0;');
    $write->easyCell('Last Official Receipt Issued', 'colspan:30; paddingY:0;');
    $write->easyCell(':', 'colspan:3; align:R; paddingY:0; font-size:13;');
    $write->easyCell($or_no, 'colspan:45; paddingY:0; border:B;');
    $write->easyCell('', 'colspan:13; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:2;');
    $write->printRow();

    $write->easyCell('', 'colspan:9; paddingY:0;');
    $write->easyCell('Amount Paid', 'colspan:30; paddingY:0;');
    $write->easyCell(':', 'colspan:3; align:R; paddingY:0; font-size:13;');
    $write->easyCell($or_no_amount, 'colspan:45; paddingY:0; border:B;');
    $write->easyCell('', 'colspan:13; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:3;');
    $write->printRow();

    $write->easyCell('', 'colspan:18; paddingY:0;');
    $write->easyCell('THIS IS TO CERTIFY THAT AS PER RECORD', 'colspan:55; align:J; font-style:B; paddingY:0; font-size:12;');
    $write->easyCell(' the above ', 'colspan:11; align:J; paddingY:0; font-size:13;');
    $write->easyCell('', 'colspan:16; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; paddingY:0;');
    $write->easyCell('mentioned Business Establishment has been closed since  ', 'colspan:74; align:J; paddingY:0;');
    $write->easyCell('', 'colspan:16; paddingY:0;');
    $write->printRow();
    $aa = strtotime($retirement_date);
    $bb = date('F d, Y', $aa);

    $write->easyCell('', 'colspan:10; paddingY:0;');
    $write->easyCell($bb, 'colspan:25; paddingY:0; border:B;');
    $write->easyCell('.', 'colspan:65; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:3;');
    $write->printRow();

    $write->easyCell('', 'colspan:18; paddingY:0;');
    $write->easyCell('This certification is being issued upon the request of', 'colspan:66; align:J; paddingY:0;');
    $write->easyCell('', 'colspan:16; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; paddingY:0;');
    $write->easyCell('', 'colspan:28; paddingY:0; border:B;');
    $write->easyCell('for whatever legal purpose this may serve ', 'colspan:46; paddingY:0; align:J;');
    $write->easyCell('', 'colspan:16; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; paddingY:0;');
    $write->easyCell('him / her best.', 'colspan:15; align:J; paddingY:0;');
    $write->easyCell('', 'colspan:75; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:3;');
    $write->printRow();

    $write->easyCell('', 'colspan:18; paddingY:0;');

    $aa = strtotime($retirement_date);
// $date111 = date('l jS \of F Y', $aa);
    $date112 = date('jS', $aa);
    $date113 = date('F ', $aa);
    $date114 = date('Y', $aa);

    $write->easyCell('Issued this', 'colspan:12; align:J; paddingY:0;');
    $write->easyCell($date112, 'colspan:6; paddingY:0; border:B; align:C;');
    $write->easyCell('day of', 'colspan:8; align:J; paddingY:0;');
    $write->easyCell($date113, 'colspan:14; paddingY:0; border:B; align:C;');
    $write->easyCell(',', 'colspan:5; align:J; paddingY:0;');
    $write->easyCell($date114, 'colspan:6; paddingY:0; border:B; align:C;');
    $write->easyCell('at ' . $municipality . ',', 'colspan:15; paddingY:0; align:J;');
    $write->easyCell('', 'colspan:16; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; paddingY:0;');
    $write->easyCell('' . $province . '.', 'colspan:15; align:J; paddingY:0;');
    $write->easyCell('', 'colspan:75; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:5;');
    $write->printRow();

    $write->easyCell('', 'colspan:48; paddingY:0;');
    $write->easyCell('MARIE FRANCIA F. ESTRELLA', 'colspan:34; paddingY:0; align:C; font-size:12; font-style:B;');
    $write->easyCell('', 'colspan:18; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:48; paddingY:0;');
    $write->easyCell('Municipal Treasurer', 'colspan:34; paddingY:0; align:C; ');
    $write->easyCell('', 'colspan:18; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:5;');
    $write->printRow();

    $write->easyCell('', 'colspan:48; paddingY:0;');
    $write->easyCell('MARICEL V. GRANADA', 'colspan:34; paddingY:0; align:C; font-size:12; font-style:B;');
    $write->easyCell('', 'colspan:18; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:48; paddingY:0;');
    $write->easyCell('BPLO - Designate', 'colspan:34; paddingY:0; align:C; ');
    $write->easyCell('', 'colspan:18; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:1;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; paddingY:0;');
    $write->easyCell('Verified as per Record:', 'colspan:90; paddingY:0;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:5;');
    $write->printRow();

    $write->easyCell('', 'colspan:10; paddingY:0;');
    $write->easyCell('KATHERINE G. PESTIO', 'colspan:90; paddingY:0; font-style:B; font-size:12;');
    $write->printRow();

    $write->easyCell('', 'colspan:14; paddingY:0;');
    $write->easyCell('Collection Clerk  ', 'colspan:86; paddingY:0;');
    $write->printRow();

    $write->easyCell('Noted by:', 'colspan:100; paddingY:1; align:C;');
    $write->printRow();

    $write->easyCell('', 'colspan:100; paddingY:6;');
    $write->printRow();

    $write->easyCell('CARLO INVINZOR B. CLADO, MDMG', 'colspan:100; paddingY:0; font-style:B; font-size:12; align:C;');
    $write->printRow();

    $write->easyCell('Municipal Mayor', 'colspan:100; paddingY:0; align:C;');
    $write->printRow();

    $write->endTable();
    $pdf->Ln();
    $pdf->Output();
}
}else{
 echo "No data available";
}
}
