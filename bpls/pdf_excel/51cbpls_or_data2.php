<?php
//include connection file
unlink("../images_file/or_receipt.pdf");

include "../../php/connect.php";
include "../../jomar_assets/amount_in_word.php";

include "../../../bower_components/libs/fpdf.php";
include "../../../bower_components/libs/exfpdf.php";
include "../../../bower_components/libs/easyTable.php";



$pdf = new exFPDF('P', 'mm', array(204, 102));
$pdf->SetMargins(8, 7);
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 10);


$i_n = $_POST['datus'];
parse_str($i_n,$arr);


$or_date =1;
$or_num = 1;
$agency = "MTO-Majayjay";
$fund_code = 100;

    $or_payor = $arr["payor"];
    // $amount_word   = $data1['amount_word'];


$amount_word = $arr["amount_word"];

$payment_mode = $arr["payment_mode"];
$remark = $arr["remark"];

if ($payment_mode == "CHEC") {
    $drawee_check = $arr["drawee_check"];
    $num_check = $arr["num_check"];
    $date_check = $arr["date_check"];
} else {
    $drawee_check = "";
    $num_check = "";
    $date_check = "";
}

if ($payment_mode == "MONEY_ORDER") {
    $num_order = $arr["num_order"];
    $date_order = $arr["date_order"];

} else {
    $num_order = "";
    $date_order = "";
}
// check surcharges
$surcharges = $arr["surcharges"];
eval('$backtax_var = (' . $arr["backtax"] . ');');
$backtax = $backtax_var;

$user_acc = $_SESSION['uname'];


$pdf->Ln(20);
$pdf->Ln(22);

$write = new easyTable($pdf, 4, 'width:100; align:L; font-style:; font-family:Helvetica; border:;');
$write->easyCell('', 'colspan:4;font-style:; font-size:11; line-height:0.6;');
$write->printRow(); /*
$write->easyCell('', 'colspan:4;font-style:; font-size:11; line-height:0.6;');
$write->printRow();*//*
$write->easyCell('', 'colspan:4;font-style:; font-size:11; line-height:0.6;');
$write->printRow();
$write->easyCell('', 'colspan:4;font-style:; font-size:11; line-height:0.6;');
$write->printRow();
$write->easyCell('', 'colspan:4;font-style:; font-size:11; line-height:0.6;');
$write->printRow();*/
$write->easyCell( strftime('%h %d, %Y' , strtotime($arr["or_date"])), 'colspan:2;font-style:; font-size:11; line-height:0.6;');
$write->easyCell('', 'colspan:2;font-style:; align:C; font-size:11; line-height:0.6;');
$write->printRow();
$write->easyCell('', 'colspan:4;font-style:; font-size:11; line-height:0.6;');
$write->printRow(); /*
$write->easyCell('', 'colspan:4;font-style:; font-size:11; line-height:0.6;');
$write->printRow();*/
$write->easyCell($agency, 'colspan:3;font-style:; align:C; font-size:11; line-height:0.6;');
$write->easyCell($fund_code, 'font-style:; align:C; font-size:11; line-height:0.6;');
$write->printRow();
$write->easyCell('', 'colspan:4;font-style:; font-size:11; line-height:0.6;');
$write->printRow(); /*
$write->easyCell('', 'colspan:4;font-style:; font-size:11; line-height:0.6;');
$write->printRow();*/
$write->easyCell($or_payor, 'colspan:4;font-style:; align:C; font-size:11; line-height:0.6;');
$write->printRow();
$write->endTable();

$pdf->Ln(6);
$total = 0;
$write = new easyTable($pdf, 4, 'width:100; align:L; border:; line-height:0.6;');
$total = 0;

if(isset($arr['desc'])) {
    $arr_count = count($arr['desc']);

    for ($ff = 0; $ff < $arr_count; $ff++) {
        $acc_title = $arr['desc'][$ff];
        $amount = $arr['normal'][$ff]; /*$acc_title*/
        $total += $amount;
        $write->easyCell($acc_title, 'colspan:3;  font-style:; font-family:Helvetica;  line-height:0.9;');
        $write->easyCell(number_format($amount, 2), 'align:R; font-style:; font-family:Helvetica;  line-height:0.9;');
        $write->printRow();
    }
}

// if ($backtax > 0) {
//     $total += $backtax;
//     $write->easyCell('BACKTAXES', 'colspan:3;');
//     $write->easyCell(number_format($backtax, 2), 'align:R; font-style:;');
//     $write->printRow();
// }

if ($surcharges > 0) {
    $total += $surcharges;
    $write->easyCell('SURCHARGES', 'colspan:3; align:L; font-style:;');
    $write->easyCell(number_format($surcharges, 2), 'align:R; font-style:;');
    $write->printRow();
}

for ($i = $arr_count; $i <= 9; $i++) {
    $write->easyCell('', 'colspan:3; ');
    $write->easyCell('', 'img:../../../bower_components/libs/icons/down_arrow.png, w2, h4; align:C;');
    $write->printRow();
}

$write->easyCell(' ', 'colspan:3; align:C; font-style:; ');
$write->easyCell(number_format($total, 2), 'align:C; font-style:;');
$write->printRow();

$write->easyCell($remark, 'colspan:4; align:R; font-style:; font-size:11; line-height:0.8;');
$write->printRow();
$write->easyCell('', 'colspan:4; align:L; font-size:10;');
$write->printRow();
$y = $pdf->getY();
$write->easyCell("", 'colspan:4; font-style:; align:L; line-height:0.8;');

$num = number_format($total, 2, ".", ",");
$num_arr = explode(".", $num);
$wholenum = $num_arr[0];
$decnum = $num_arr[1];
    
    
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
        if ($text_count == $counter && substr($text, $counter, 1) != " ") {
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

// $write->easyCell($decnum . '/100', 'colspan:4; font-style:; align:L; line-height:0.8;');
// $write->printRow();


$write->endTable(5);

$write = new easyTable($pdf, 5, 'width:200; align:L; font-style:; font-family:Helvetica;');
if ($payment_mode == 'cash') {
    $write->easyCell('CASH', 'w5, h8; align:C;');
} else {
    $write->easyCell('', 'align:C;');
}
$write->easyCell('', 'colspan:2; font-style:; font-family:Helvetica; font-size:9;');
$write->easyCell('', 'img:../../../bower_components/libs/icons/blank.png, w2, h4; align:C;');

$write->easyCell('', 'colspan:5; paddingY:5;');
$write->printRow();

$write->easyCell('', 'colspan:2;');
$write->easyCell('MARIE FRANCIA ESTRELLA', 'colspan:3; align:C;');
$write->printRow();

if ($payment_mode == 'check') {
    $write->easyCell('', 'img:../../../bower_components/libs/icons/check.png, w5, h4; align:C;');
} else {
    $write->easyCell('', 'align:C;');
}
$write->easyCell('', 'colspan:2; font-style:; font-family:Helvetica; font-size:9;');

if ($drawee_check != '') {
    $write->easyCell($drawee_check, 'colspan:3; font-style:; font-family:Helvetica; font-size:8;  border:;');
} else {
    $write->easyCell('', 'img:../../../bower_components/libs/icons/blank.png, w2, h4; align:C;');
}

if ($num_check != '') {
    $write->easyCell($num_check, 'colspan:2; font-style:; align:C; font-family:Helvetica; font-size:8;  border:;');
} else {
    $write->easyCell('', 'colspan:2; font-style:; align:C; font-family:Helvetica; font-size:9;  border:;');
}

if ($date_check != '') {
    $write->easyCell($date_check, 'colspan:2; font-style:; align:C; font-family:Helvetica; font-size:7;  border:;');
} else {
    $write->easyCell('', 'colspan:2; font-style:; align:C; font-family:Helvetica; font-size:7;  border:;');
}

$write->printRow();
if ($payment_mode == 'money_order') {
    $write->easyCell('', 'img:../../../bower_components/libs/icons/check.png, w5, h4; align:C;');
} else {
    $write->easyCell('', 'align:C;');
}
$write->easyCell('', 'colspan:5; font-style:; font-family:Helvetica; font-size:9;');

if ($num_order != '') {
    $write->easyCell($num_order, 'colspan:2; font-style:; align:C; font-family:Helvetica; font-size:8;  border:;');
} else {
    $write->easyCell('', 'img:../../../bower_components/libs/icons/blank.png, w2, h4; align:C;');
}

if ($date_order != '') {
    $write->easyCell($date_order, 'colspan:2; font-style:; align:C; font-family:Helvetica; font-size:7;  border:;');
} else {
    $write->easyCell('', 'colspan:2; font-style:; align:C; font-family:Helvetica; font-size:7;  border:;');
}

$write->printRow();
$write->endTable(2);

$write = new easyTable($pdf, 4, 'width:100; align:L; border:; line-height:0.6; paddingY:0;');
$write->easyCell('', 'colspan:; font-style:; align:R; line-height:0.8;');
$write->easyCell('', 'colspan:3; font-style:; align:C; line-height:0.8;');
$write->printRow();
$write->easyCell('', 'colspan:; font-style:; align:R; line-height:0.8;');
$write->easyCell('', 'colspan:3; font-style:; align:C; line-height:0.8;');
$write->printRow();
$write->endTable(2);
$path = "../images_file/or_receipt.pdf";
$pdf->Output($path, 'F');

