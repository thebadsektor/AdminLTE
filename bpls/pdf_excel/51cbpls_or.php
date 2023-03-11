<?php
//include connection file
include "../../php/connect.php";
include "../../jomar_assets/amount_in_word.php";
include "../../../bower_components/libs/fpdf.php";
include "../../../bower_components/libs/exfpdf.php";
include "../../../bower_components/libs/easyTable.php";

$pdf = new exFPDF('P', 'mm', array(230, 102));
$pdf->SetMargins(7, 7);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$test = $_GET['target'];
$id = $_GET['target2'];

$q = mysqli_query($conn, "SELECT * FROM `geo_bpls_payment` WHERE payment_id = '$test'  ") or die("database error:" . mysqli_error($conn));

$data1 = mysqli_fetch_assoc($q);

$or_date = strftime('%h %d, %Y', strtotime($data1['payment_date']));
$or_num = $data1['or_no'];
// $agency = $data1['agency'];
$agency = "MTO-Majayjay";
$fund_code = 100;
if ($data1["payor"] == null) {
    $o_q = mysqli_query($conn, "SELECT owner_first_name,owner_last_name, owner_middle_name FROM `geo_bpls_business_permit`
                inner JOIN geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id
                where md5(geo_bpls_business_permit.permit_id) = '$id' ");
    $o_r = mysqli_fetch_assoc($o_q);
    $or_payor = strtoupper($o_r["owner_last_name"] . ", " . $o_r["owner_first_name"] . " " . substr($o_r["owner_middle_name"], 0, 1));
} else {
    $or_payor = $data1["payor"];
}
// $amount_word   = $data1['amount_word'];

$payment_mode = $data1["payment_mode_code"];
$remark = $data1["remarks"];

if ($payment_mode == "CHEC") {
    $qqq = mysqli_query($conn,"SELECT * FROM `geo_bpls_payment_check`  WHERE payment_id = '$test' ");
    $rrr = mysqli_fetch_assoc($qqq);
    $drawee_check = $rrr['check_name'];
    $num_check = $rrr['check_no'];
    $date_check = $rrr['check_issue_date'];

} else {
    $drawee_check = "";
    $num_check = "";
    $date_check = "";
}

if ($payment_mode == "MONE") {
    $qqq = mysqli_query($conn, "SELECT * FROM `geo_bpls_payment_check`  WHERE payment_id = '$test' ");
    $rrr = mysqli_fetch_assoc($qqq);

    $num_order = $rrr['check_no'];
    $date_order = $rrr['check_issue_date'];

} else {
    $num_order = "";
    $date_order = "";
}

// check surcharges
$surcharges = $data1["payment_surcharge"];
eval('$backtax_var = (' . $data1["payment_backtax"] . ');');
$backtax = $backtax_var;

$write = new easyTable($pdf, 6, 'width:100; align:L; font-style:; font-family:arial; border:1;');
$write->easyCell('Certified True Copy', 'colspan:6;font-style:; align:C; font-size:12; line-height:0.6;');
$write->printRow();
$write->easyCell('', 'colspan:; img:../../../bower_components/libs/icons/logo_transparent.png, w20, h22; align:C;');
$write->easyCell('Official Receipt of the Republic of the Phillippines ' . 'OFFICE OF THE TREASURER PROVINCE OF LAGUNA', 'colspan:4;font-style:B; align:C; font-size:8; line-height:1.2;');
$write->easyCell('', 'colspan:; img:../../../bower_components/libs/icons/capitol_laguna.jpg, w20, h22; align:C;');
$write->printRow();
$write->endTable();

$write = new easyTable($pdf, 4, 'width:100; align:L; font-style:; font-family:arial; border:1;');
$write->easyCell('Accountable form No. 51. Revised January 1992', 'colspan:2;font-style:; font-size:9; line-height:1;');
$write->easyCell('Revised January 1992', 'colspan:2;font-style:; align:C; font-size:9; line-height:1;');
$write->printRow();
$dat = 'Date :';
$dats = 'PGL N. :';
$write->easyCell($dat . $or_date, 'colspan:2;font-style:; font-size:12; line-height:1.5;');
$write->easyCell($dats . $or_num, 'colspan:2;font-style:; align:C; font-size:12; line-height:1.5;');
$write->printRow();
$write->easyCell($agency, 'colspan:3;font-style:; font-size:12; line-height:0.6;');
$write->easyCell($fund_code, 'font-style:; font-size:12; line-height:0.6;');
$write->printRow();
$write->easyCell($or_payor, 'colspan:4;font-style:B; font-size:12; line-height:0.6;');
$write->printRow();
$write->easyCell('', 'colspan:4;font-style:B; font-size:12; padding:1;');
$write->printRow();
$write->easyCell('Nature of Collection', 'colspan:2;font-style:B; align:C; font-size:12; line-height:1;');
$write->easyCell('Account Code', 'colspan:;font-style:B; align:C; font-size:10; line-height:1.2;');
$write->easyCell('Amount', 'colspan:;font-style:B; align:C; font-size:11; line-height:2;');
$write->printRow();

$total = 0;
// change later
$result = mysqli_query($conn, "SELECT natureOfCollection_tbl.name as sub_account_title, geo_bpls_payment_detail.payment_amount, sub_account_no FROM `geo_bpls_payment_detail`  inner JOIN natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_payment_detail.sub_account_no WHERE payment_id = '$test'  ") or die("database error:" . mysqli_error($conn));
$nothing = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    $sub_account_no = $row["sub_account_no"];
    if($sub_account_no == 1010 || $sub_account_no == 1011  || $sub_account_no == 1012  || $sub_account_no == 1013  || $sub_account_no == 1014  || $sub_account_no == 1015 || $sub_account_no == 1016 || $sub_account_no == 1017 || $sub_account_no == 1018 || $sub_account_no == 1019 || $sub_account_no == 1020 || $sub_account_no == 1021){
        // check sector kung ano ang gross sales auto inc
     $acc_title = substr(strtoupper($row["sub_account_title"]),0,15);
    }else{
    $acc_title = strtoupper($row['sub_account_title']);

    }
    // $quant = $row['quant'];
    // $item_amt = $row['item_amt'];
    $amount = $row['payment_amount'];
    $total += $amount;
    $write->easyCell($acc_title, 'colspan:3; font-size:9;');
    $write->easyCell(number_format($amount, 2), 'align:C; font-style:B;');
    $write->printRow();
}
// if ($backtax > 0) {
//     $total += $backtax;
//     $write->easyCell('BACKTAXES', 'colspan:3;');
//     $write->easyCell(number_format($backtax, 2), 'align:C; font-style:B;');
//     $write->printRow();
// }

// if ($surcharges > 0) {
//     $total += $surcharges;
//     $write->easyCell('SURCHARGES', 'colspan:3;');
//     $write->easyCell(number_format($surcharges, 2), 'align:C; font-style:B;');
//     $write->printRow();
// }

for ($i = $nothing; $i <= 9; $i++) {
    $write->easyCell('', 'colspan:3; ');
    $write->easyCell('', 'img:../../../bower_components/libs/icons/down_arrow.png, w2, h4; align:C;');
    $write->printRow();
}
$write->easyCell('  TOTAL  ', 'colspan:3; align:C; font-style:B;');
$write->easyCell(number_format($total, 2), 'align:C; font-style:B;');
$write->printRow();

$write->easyCell('Amount in Words', 'colspan:4; align:L; font-style:B; font-size:7; border:1;');

$write->printRow();

$y = $pdf->getY();

$write->easyCell(" ", 'colspan:4; align:L; font-style:; font-size:10; paddingY:3;');

$text = AmountInWords($total);
$text_count = strlen(AmountInWords($total));
$counter = 35;
if ($text_count <= $counter) {
    $text1 = AmountInWords($total);
    $pdf->setY($y + 2);
    $pdf->cell(0, 0, $text1);
    $pdf->setY($y);
} else {
    while (substr($text, $counter, 1) != " ") {
        $counter++;
            if($text_count == $counter && substr($text, $counter, 1) != " "){
                break;
            }
    }
    $text1 = substr($text, 0, $counter);
    $bbbbb = $text_count - $counter;

    $text2 = substr($text, $counter, $bbbbb);

    $pdf->setY($y + 2);
    $pdf->cell(0, 0, $text1);
    $pdf->setY($y);

    $pdf->setY($y + 5);
    $pdf->cell(0, 0, $text2);
    $pdf->setY($y);
}
$write->printRow();


$write->easyCell('Remarks', 'colspan:4; align:L; font-style:B; font-size:7; border:1;');
$write->printRow();
$write->easyCell($remark, 'colspan:4; align:L; font-size:10;');
$write->printRow();
$write->endTable();

$write = new easyTable($pdf, 10, 'width:100; align:L; font-style:B; font-family:arial; border:;');
if ($payment_mode == 'CASH') {
    $write->easyCell('', 'img:../../../bower_components/libs/icons/checked_box.png, w5, h4; align:C;');
} else {
    $write->easyCell('', 'img:../../../bower_components/libs/icons/box.png, w5, h4; align:C;');
}
$write->easyCell('Cash', 'colspan:2; font-style:B; font-family:arial; font-size:9;');
$write->easyCell('Drawee Bank', 'colspan:3; font-style:B; font-family:arial; font-size:8;  border:1;');
$write->easyCell('Number', 'colspan:2; font-style:B; align:C; font-family:arial; font-size:9;  border:1;');
$write->easyCell('Date', 'colspan:2; font-style:B; align:C; font-family:arial; font-size:9;  border:1;');
$write->printRow();
if ($payment_mode == 'CHEC') {
    $write->easyCell('', 'img:../../../bower_components/libs/icons/checked_box.png, w5, h4; align:C;');
} else {
    $write->easyCell('', 'img:../../../bower_components/libs/icons/box.png, w5, h4; align:C;');
}
$write->easyCell('Check', 'colspan:2; font-style:B; font-family:arial; font-size:9;');

if ($drawee_check != '') {
    $write->easyCell($drawee_check, 'colspan:3; font-style:B; font-family:arial; font-size:8;  border:1;');
} else {
    $write->easyCell('', 'colspan:3; font-style:B; font-family:arial; font-size:8;  border:1;');
}

if ($num_check != '') {
    $write->easyCell($num_check, 'colspan:2; font-style:B; align:C; font-family:arial; font-size:8;  border:1;');
} else {
    $write->easyCell('', 'colspan:2; font-style:B; align:C; font-family:arial; font-size:9;  border:1;');
}

if ($date_check != '') {
    $write->easyCell($date_check, 'colspan:2; font-style:B; align:C; font-family:arial; font-size:7;  border:1;');
} else {
    $write->easyCell('', 'colspan:2; font-style:B; align:C; font-family:arial; font-size:7;  border:1;');
}

$write->printRow();
if ($payment_mode == 'money_order') {
    $write->easyCell('', 'img:../../../bower_components/libs/icons/checked_box.png, w5, h4; align:C;');
} else {
    $write->easyCell('', 'img:../../../bower_components/libs/icons/box.png, w5, h4; align:C;');
}
$write->easyCell('Money Order', 'colspan:5; font-style:B; font-family:arial; font-size:9;');

if ($num_order != '') {
    $write->easyCell($num_order, 'colspan:2; font-style:B; align:C; font-family:arial; font-size:8;  border:1;');
} else {
    $write->easyCell('', 'colspan:2; font-style:B; align:C; font-family:arial; font-size:8;  border:1;');
}

if ($date_order != '') {
    $write->easyCell($date_order, 'colspan:2; font-style:B; align:C; font-family:arial; font-size:7;  border:1;');
} else {
    $write->easyCell('', 'colspan:2; font-style:B; align:C; font-family:arial; font-size:7;  border:1;');
}

$write->printRow();
$write->endTable();

$write = new easyTable($pdf, 10, 'width:100; align:L; font-style:; font-family:arial; border:;');
$write->easyCell('Received the amount atated above', 'colspan:10; align:L; font-style:B; font-size:7; border:;');
$write->printRow();

$write->easyCell('', 'colspan:4; align:L; font-size:10; border:;');
//  mysqli_query($conn, "SELECT");
$write->easyCell('', 'colspan:6; font-style:B; align:C; font-size:10; border:;');
$write->printRow();

$write->easyCell('', 'colspan:10; paddingY:3;');
$write->printRow();


$q22 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = '51c_receipt'");
$r22 = mysqli_fetch_assoc($q22);
$signatory_name = $r22["signatory_name"];
$signatory_position = $r22["signatory_position"];
$e_signatory = $r22["e_signatory"];



$write->easyCell('', 'colspan:4; paddingY:0;');
$write->easyCell(utf8_decode($signatory_name), 'colspan:6; paddingY:0; align:C;');
$write->printRow();

$write->easyCell('', 'colspan:4; paddingY:0;');
$write->easyCell('Cashier Officer', 'colspan:6; align:C; font-size:8; paddingY:0;');
$write->printRow();

$write->easyCell('', 'colspan:10; paddingY:0.5;');
$write->printRow();

$write->easyCell('NOTE.', 'colspan:2; align:L; font-style:B; font-size:10; border:1;');
$write->easyCell('Write the number and date of this receipt on the back of check money order received.', 'colspan:8; align:L; font-style:B; font-size:8; border:1;');
$write->printRow();
$write->endTable(5);

$pdf->Output();
