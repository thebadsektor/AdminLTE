<?php
//include connection file
include "../../php/connect.php";
include "../../jomar_assets/amount_in_word.php";

include "../../../bower_components/libs/fpdf.php";
include "../../../bower_components/libs/exfpdf.php";
include "../../../bower_components/libs/easyTable.php";

$pdf = new exFPDF('P', 'mm', array(204, 102));
$pdf->SetMargins(8, 7);
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 10);

$test = $_GET['target'];
$id = $_GET['target2'];

$r = mysqli_query($conn, "SELECT * FROM `geo_bpls_payment` WHERE payment_id = '$test'  ");

$data1 = mysqli_fetch_assoc($r);
$or_date = $data1['payment_date'];
$or_num = $data1['or_no'];
$agency = "MTO-Majayjay";
$fund_code = 100;

// get payment mode
$q2222 = mysqli_query($conn,"SELECT payment_frequency_code from geo_bpls_business_permit where  md5(geo_bpls_business_permit.permit_id) = '$id' ");
$r2222 = mysqli_fetch_assoc($q2222);
$payment_freq = $r2222["payment_frequency_code"];
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


            // echo $paid_tax;
            $fully_paid = 0;
            $remark = "";
            if($payment_freq == "QUA") {
                // echo $paid_tax."|".$amount_tax;
                $q555 = mysqli_query($conn,"SELECT payment_part  FROM `geo_bpls_payment` where or_no = '$or_num'   ");
                if(mysqli_num_rows($q555)>0){
                    $r555 = mysqli_fetch_assoc($q555);
                    if($r555["payment_part"] == ""){
                        $paid_qtr = 0;
                    }else{
                        $paid_qtr = $r555["payment_part"];
                    }
                    $md5permit_id = $id;
                }else{
                    $paid_qtr = 0;
                }
                if($paid_qtr >1){
                // check kung ano prev qtr
                    $q23455 = mysqli_query($conn," SELECT payment_part FROM
                    `geo_bpls_payment` where md5(permit_id) = '$md5permit_id' and payment_part < $paid_qtr 
                    ORDER BY `geo_bpls_payment`.`payment_part`  DESC
                    LIMIT 1  ");
                    if(mysqli_num_rows($q23455)>0){
                        $r23455 = mysqli_fetch_assoc($q23455);
                        if($r23455["payment_part"] == ""){
                            $prev_paid_qtr = 1;
                        }else{
                            $prev_paid_qtr = $r23455["payment_part"];
                        }
                    }else{
                        $prev_paid_qtr = 0;
                    }
                    
                }else{
                    $prev_paid_qtr = 0;
                }

                // prev paid qtr
                if ($prev_paid_qtr== 4) {
                    $aaa =  "4rth Quarter";
                }else if ($prev_paid_qtr == 3) {
                    $aaa =  "3rd Quarter";
                }elseif ($prev_paid_qtr == 2) {
                    $aaa =  "2nd Quarter";
                } elseif ($prev_paid_qtr == 1 || $prev_paid_qtr == 0) {
                    $aaa =  "1st Quarter";
                }

                // current paid qtr
                if ($paid_qtr== 4) {
                    $bbb =  "4rth Quarter";
                }else if ($paid_qtr == 3) {
                    $bbb =  "3rd Quarter";
                }elseif ($paid_qtr == 2) {
                    $bbb =  "2nd Quarter";
                } elseif ($paid_qtr == 1) {
                    $bbb =  "1st Quarter";
                }

                if($paid_qtr > 1){
                    // check kung isa lang qtr binayaran
                    if($paid_qtr-$prev_paid_qtr == 1 ){
                        $remark .= $bbb;
                    }else{
                        $prev_paid_qtr++;
                        if ($prev_paid_qtr== 4) {
                            $aaa =  "4rth Quarter";
                        }else if ($prev_paid_qtr == 3) {
                            $aaa =  "3rd Quarter";
                        }elseif ($prev_paid_qtr == 2) {
                            $aaa =  "2nd Quarter";
                        } elseif ($prev_paid_qtr == 1 || $prev_paid_qtr == 0) {
                            $aaa =  "1st Quarter";
                        }
        

                        $remark .= $aaa." to ".$bbb;
                    }
                }else{
                    $remark .= $bbb;
                }

                }elseif($payment_freq == "SEM"){
                    // echo $paid_tax."|".$amount_tax;
                    $q555 = mysqli_query($conn,"SELECT payment_part  FROM `geo_bpls_payment` where or_no = '$or_num'   ");
                    if(mysqli_num_rows($q555)>0){
                        $r555 = mysqli_fetch_assoc($q555);
                        if($r555["payment_part"] == ""){
                            $paid_qtr = 0;
                        }else{
                            $paid_qtr = $r555["payment_part"];
                        }
                        $md5permit_id = $id;
                    }else{
                        $paid_qtr = 0;
                    }
                    if($paid_qtr >1){
                    // check kung ano prev qtr
                        $q23455 = mysqli_query($conn," SELECT payment_part FROM
                        `geo_bpls_payment` where md5(permit_id) = '$md5permit_id' and payment_part < $paid_qtr 
                        ORDER BY `geo_bpls_payment`.`payment_part`  DESC
                        LIMIT 1  ");
                        if(mysqli_num_rows($q23455)>0){
                            $r23455 = mysqli_fetch_assoc($q23455);
                            if($r23455["payment_part"] == ""){
                                $prev_paid_qtr = 1;
                            }else{
                                $prev_paid_qtr = $r23455["payment_part"];
                            }
                        }else{
                            $prev_paid_qtr = 0;
                        }
                        
                    }else{
                        $prev_paid_qtr = 0;
                    }
    
                    // prev paid qtr
                    if($prev_paid_qtr == 2) {
                        $aaa =  "2nd Semi-Annual";
                    } elseif ($prev_paid_qtr == 1 || $prev_paid_qtr == 0) {
                        $aaa =  "1st Semi-Annual";
                    }
    
                    // current paid qtr
                    if($paid_qtr == 2) {
                        $bbb =  "2nd Semi-Annual";
                    } elseif ($paid_qtr == 1) {
                        $bbb =  "1st Semi-Annual";
                    }
                    $bbb = "";
                    if($paid_qtr > 1){
                        // check kung isa lang qtr binayaran
                        if($paid_qtr-$prev_paid_qtr == 1 ){
                            $remark .= $bbb;
                        }else{
                            $prev_paid_qtr++;
                            if($prev_paid_qtr == 2) {
                                $aaa =  "2nd Semi-Annual";
                            } elseif ($prev_paid_qtr == 1 || $prev_paid_qtr == 0) {
                                $aaa =  "1st Semi-Annual";
                            }
            
    
                            $remark .= $aaa." to ".$bbb;
                        }
                    }else{
                        $remark .= $bbb;
                    }
    
    
    
                    }else{
                     $remark = "Annual";
                }
                
           

                $remark = $remark." ".$data1["remarks"];

if ($payment_mode == "CHEC") {
    $qqq = mysqli_query($conn, "SELECT * FROM `geo_bpls_payment_check`  WHERE payment_id = '$test' ");
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
$write->easyCell($or_date = strftime('%h %d, %Y', strtotime($or_date)), 'colspan:2;font-style:; font-size:11; line-height:0.6;');
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
$result = mysqli_query($conn, "SELECT natureOfCollection_tbl.name as sub_account_title, geo_bpls_payment_detail.payment_amount, sub_account_no  FROM `geo_bpls_payment_detail`  inner JOIN natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_payment_detail.sub_account_no WHERE payment_id = '$test'  ");
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
    $write->easyCell(number_format($amount, 2), 'align:R; font-style:; font-family:Helvetica;  line-height:0.9;');
    $write->printRow();
}
// if ($backtax > 0) {
//     $total += $backtax;
//     $write->easyCell('BACKTAXES', 'colspan:3; font-size:9;');
//     $write->easyCell(number_format($backtax, 2), 'align:R; font-style:;font-family:Helvetica;  line-height:0.9;');
//     $write->printRow();
// }

// if ($surcharges > 0) {
//     $total += $surcharges;
//     $write->easyCell('SURCHARGES', 'colspan:3; font-size:9;');
//     $write->easyCell(number_format($surcharges, 2), 'align:R; font-style:; font-family:Helvetica;  line-height:0.9;');
//     $write->printRow();
// }

for ($i = $nothing; $i <= 9; $i++) {
    $write->easyCell('', 'colspan:3; ');
    $write->easyCell('', 'img:../../../bower_components/libs/icons/down_arrow.png, w2, h4; font-size:9.5; font-family:Helvetica; border:; line-height:0.6;');
    $write->printRow();
}
$write->easyCell('   ', 'colspan:3; align:C; font-style:; ');
$write->easyCell(number_format($total, 2), 'align:C; font-style:;');
$write->printRow();

$write->easyCell($remark, 'colspan:4; align:L; font-style:; font-size:11; line-height:0.8;');
$write->printRow();
$write->easyCell('', 'colspan:4; align:L; font-size:10;');
$write->printRow();
/*intval($total);
$ama = explode(".", number_format($total,2))[1];
$amount_word .' ' .$ama .'/100'*/
$y = $pdf->getY();
$write->easyCell("", 'colspan:4; font-style:; align:L; line-height:0.8;');

// convert_number_to_words --------------------------
// numberTowords ------------------------------------

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


// $text = convert_number_to_words($total);
// $text_count = strlen(convert_number_to_words($total));
// $counter = 35;
// if ($text_count < $counter) {
//     $text1 = convert_number_to_words($total);
//     $pdf->setY($y + 2);
//     // $pdf->cell(0, 0, $text1." Pesos Only");
//     $pdf->cell(0, 0, $text1);

//     $pdf->setY($y);
// } else {
//     while (substr($text, $counter, 1) != " ") {
//         $counter++;
//     }
//     $text1 = substr($text, 0, $counter);
//     $bbbbb = $text_count - $counter;

//     $text2 = substr($text, $counter, $bbbbb);

//     $pdf->setY($y + 2);
//     $pdf->cell(0, 0, $text1);
//     $pdf->setY($y);

//     $pdf->setY($y + 5);
//     $pdf->cell(0, 0, $text2);
//     $pdf->setY($y);
// }
// $write->printRow();


    // manual amoun in word pag nag ka problema
    // $pdf->setY($y + 2);
    // $pdf->cell(0, 0,"Two Thousand Eight Hundred Ten Pesos Only");
    // $pdf->setY($y);
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

$q22 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = '51c_receipt'");
$r22 = mysqli_fetch_assoc($q22);
$signatory_name = $r22["signatory_name"];
$signatory_position = $r22["signatory_position"];
$e_signatory = $r22["e_signatory"];

$write->easyCell('', 'colspan:2;');
$write->easyCell('', 'colspan:3; paddingY:3; align:C;');
$write->printRow();


$write->easyCell('', 'colspan:2;');
$write->easyCell(utf8_decode($signatory_name), 'colspan:3; align:C;');
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


$pdf->Output();

