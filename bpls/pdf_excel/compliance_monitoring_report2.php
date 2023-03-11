<?php
//include connection file

// utf8 problem ----------------------------------------------------------------------------------
include "../../php/connect.php";
include "../../../bower_components/libs/fpdf.php";
include "../../../bower_components/libs/exfpdf.php";
include "../../../bower_components/libs/easyTable.php";

$pdf = new exFPDF('P', 'mm', array(215.9, 330.2));
//$pdf = new exFPDF('L','mm','Legal');
//$pdf = new exFPDF('P');
$pdf->SetMargins(9, 0);
$pdf->AddPage();
$pdf->SetFont('Times', '', 10);
// $pdf->AddFont('oldenglish');
$from = $_GET["from"];
$to = $_GET["to"];

$l = mysqli_query($conn, "SELECT  UPPER (`province`)as province, UPPER (`municipality`)as municipality,(`region`)FROM `header`");
$d = mysqli_fetch_assoc($l);

$province = $d['province'];
$municipality = $d['municipality'];

$write = new easyTable($pdf, 100, 'width:100%; align:c; font-style:N; font-family:arial;
');

$write->easyCell('', 'colspan:100; paddingY:2; border:B;');
$write->printRow();

$write->easyCell('', 'colspan:88; paddingY:0; border:L;');
$write->easyCell('BPLS M& Form 1', 'colspan:12; paddingY:0; border:R; font-style:B; font-size:7;');
$write->printRow();

$write->easyCell('', 'img:../../../dist/logo/dilg2.png, align:C; colspan:8; paddingY:0; border:L; rowspan:2;');
$write->easyCell('BPLS COMPLIANCE MONITORING REPORT', 'colspan:80; paddingY:0; align:C; font-style:B; font-size:11;');
$write->easyCell('', 'colspan:12; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('(per DILG-DTI-DICT JMC No. 01. Series of 2016)', 'colspan:80; paddingY:0; align:C;');
$write->easyCell('', 'colspan:12; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:25; paddingY:0; border:L;');
$write->easyCell('As of', 'colspan:8; paddingY:0; align:R;');
$write->easyCell('2nd QUARTER OF 2020 (April, May, June)', 'colspan:55; paddingY:0; font-style:BU;');
$write->easyCell('', 'colspan:12; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:1; border:LR;');
$write->printRow();

$write->easyCell('LGU:', 'colspan:7; paddingY:0; border:L; font-size:10;');
$write->easyCell('' . $municipality . '', 'colspan:20; paddingY:0; font-size:10; font-style:BU;');
$write->easyCell('PROVINCE:', 'colspan:61; paddingY:0; align:R; font-size:10;');
$write->easyCell('' . $province . '', 'colspan:12; paddingY:0; font-size:10; font-style:BU; border:R; align:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:2; border:LRB;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:1; border:LR;');
$write->printRow();

$write->easyCell('I. Compliance to Revised BPLS Standards', 'colspan:100; paddingY:0; border:LRB; font-style:BI;');
$write->printRow();

$write->easyCell('Parameter', 'colspan:32; paddingY:0; border:1; align:C;');
$write->easyCell('New Business Permit', 'colspan:16; paddingY:0; border:1; align:C;');
$write->easyCell('Business Permit Renewal', 'colspan:16; paddingY:0; border:1; align:C;');
$write->easyCell('Remarks, if any', 'colspan:36; paddingY:0; border:1; align:C;');
$write->printRow();

$write->easyCell('1. Use of unified form (Y or N)', 'colspan:32; paddingY:0.5; border:1; font-style:B; font-size:9;');
$write->easyCell('Y', 'colspan:16; paddingY:0.5; border:1; align:C; font-size:9; font-style:B;');
$write->easyCell('Y', 'colspan:16; paddingY:0.5; border:1; align:C; font-size:9; font-style:B;');
$write->easyCell('', 'colspan:36; paddingY:0.5; border:1; align:C; font-size:9; font-style:B;');
$write->printRow();

$write->easyCell('2. Number of steps', 'colspan:32; paddingY:0; border:LRT; font-style:B; font-size:9;');
$write->easyCell('', 'colspan:16; paddingY:0; border:LRT;');
$write->easyCell('', 'colspan:16; paddingY:0; border:LRT;');
$write->easyCell('', 'colspan:36; paddingY:0; border:LRT; align:C; font-size:9; font-style:B;');
$write->printRow();

$write->easyCell('', 'colspan:1; paddingY:0; border:LB; font-size:9; font-style:B;');
$write->easyCell('(involving business applicants)', 'colspan:31; paddingY:0; border:RB; font-style:B; font-size:9;');
$write->easyCell('3', 'colspan:16; paddingY:0; border:LRB; font-size:9; font-style:B; align:C;');
$write->easyCell('3', 'colspan:16; paddingY:0; border:LRB; font-size:9; font-style:B; align:C;');
$write->easyCell('', 'colspan:36; paddingY:0; border:LRB; align:C; font-size:9; font-style:B;');
$write->printRow();

$write->easyCell('3. Number of signatories', 'colspan:32; paddingY:0.5; border:1; font-style:B; font-size:9;');
$write->easyCell('1', 'colspan:16; paddingY:0.5; border:1; align:C; font-size:9; font-style:B;');
$write->easyCell('1', 'colspan:16; paddingY:0.5; border:1; align:C; font-size:9; font-style:B;');
$write->easyCell('', 'colspan:36; paddingY:0.5; border:1; align:C; font-size:9; font-style:B;');
$write->printRow();

$write->easyCell('4. Processing time (number of days)', 'colspan:32; paddingY:0.5; border:1; font-style:B; font-size:9;');
$write->easyCell('2-DAY', 'colspan:16; paddingY:0.5; border:1; align:C; font-size:9; font-style:B;');
$write->easyCell('1-DAY', 'colspan:16; paddingY:0.5; border:1; align:C; font-size:9; font-style:B;');
$write->easyCell('', 'colspan:36; paddingY:0.5; border:1; align:C; font-size:9; font-style:B;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:1; border:LR;');
$write->printRow();

$write->easyCell('II. Implementation of LGU Complementary Reforms', 'colspan:100; paddingY:0; border:LRB; font-style:BI;');
$write->printRow();

$write->easyCell('1. Documentary Requirements attached to the Unified Form:', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:5; paddingY:0; border:L;');
$write->easyCell('a. Proof of Business Registration', 'colspan:70; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:5; paddingY:0; border:L;');
$write->easyCell('b. Basis for computing taxes, fees and charges', 'colspan:70; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:5; paddingY:0; border:L;');
$write->easyCell('c. Occupancy permit (if local laws require post-audit, occupancy permit shall not be required', 'colspan:70; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:7; paddingY:0; border:L;');
$write->easyCell('prior to registration)', 'colspan:93; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:5; paddingY:0; border:L;');
$write->easyCell('d. Lease of Contract (if business is leasing space)', 'colspan:70; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:5; paddingY:0; border:L;');
$write->easyCell('e. Barangay Clearance', 'colspan:70; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:5; paddingY:0; border:L;');
$write->easyCell('f. Other documents required, please specify', 'colspan:70; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:7; paddingY:0; border:L;');
$write->easyCell('* SANITARY PERMIT', 'colspan:20; paddingY:0; border:B; ');
$write->easyCell('* ZONING CERTIFICATE', 'colspan:22; paddingY:0; border:B; ');
$write->easyCell('', 'colspan:51; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:7; paddingY:0; border:L;');
$write->easyCell('* FIRE SAFETY CERTIFICATE', 'colspan:27; paddingY:0; border:B; ');
$write->easyCell('* POLICE CLEARANCE', 'colspan:22; paddingY:0; border:B; ');
$write->easyCell('', 'colspan:44; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:2; border:LRB;');
$write->printRow();

$write->easyCell('2. Setting-up/Establishment of Business-One-Stop-Shop (BOSS)', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:2; paddingY:0; border:L;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('BOSS for frontline services dealing with clients', 'colspan:69; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:2; paddingY:0; border:L;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Back-end operation hidden from public', 'colspan:69; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LRB;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('3. Conduct of Joint Inspection Team (JIT)', 'colspan:75; paddingY:0; border:L;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:2; paddingY:0; border:L;');
$write->easyCell('If Yes, what are the local departments and NGAs involved in the joint inspection?', 'colspan:98; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:2; paddingY:0; border:L;');
$write->easyCell('BPLO/M.O, RHU, BOFP, ENGINEERING, PNP, MPDC, MTO', 'colspan:98; paddingY:0; border:R; font-size:9; font-style:BU;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LRB;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('4. Automation/Computerization of business permitting and licensing system', 'colspan:75; paddingY:0; border:L;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:2; paddingY:0; border:L;');
$write->easyCell('If Yes, please indicate extend of automation/computerization', 'colspan:98; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:2; paddingY:0; border:L;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Online Application', 'colspan:69; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:2; paddingY:0; border:L;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Electronic means (e-mail, etc) of providing business with Tax Payment (TOP)', 'colspan:69; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:2; paddingY:0; border:L;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Online payments/online means of accepting payments', 'colspan:69; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('', 'colspan:2; paddingY:0; border:L;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Online means via courier service transmitting business permit and other clearance', 'colspan:69; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LRB;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:1; border:LRT;');
$write->printRow();

$write->easyCell('II. LGU support of BPLS Streamlining', 'colspan:100; paddingY:0; border:LRB; font-style:BI;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('1. Issuance of legal framework in support of BPLS streamlining', 'colspan:75; paddingY:0; border:L;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('2. Creation of TWG on BPLS streamlining', 'colspan:75; paddingY:0; border:L;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('3. Budget allocation of BPLS streamlining and automation', 'colspan:75; paddingY:0; border:L;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('4. Other reforms, if any', 'colspan:18; paddingY:0; border:L;');
$write->easyCell('', 'colspan:50; paddingY:0; border:B;');
$write->easyCell('', 'colspan:7; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('Y', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:2; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('', 'colspan:1; paddingY:0;');
$write->easyCell('N', 'colspan:3; paddingY:0; font-style:B;');
$write->easyCell('', 'colspan:9; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:2; paddingY:0.5; border:L;');
$write->easyCell('-', 'colspan:66; paddingY:0.5; border:B;');
$write->easyCell('', 'colspan:32; paddingY:0.5; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LRB;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:1; border:LRT;');
$write->printRow();
$query1_t = "SELECT count(permit_id) AS t_count FROM `geo_bpls_business_permit` WHERE permit_released_date BETWEEN '$from' and '$to' and geo_bpls_business_permit.step_code = 'RELEA'";

$query1 = mysqli_query($conn, $query1_t);
$q11 = mysqli_fetch_assoc($query1);

$query2_t = "SELECT sum(payment_total_amount_paid) as t_amount from geo_bpls_payment  WHERE date(cast(payment_date as date)) BETWEEN '$from' and '$to' ";
$query2 = mysqli_query($conn, $query2_t);
$q22 = mysqli_fetch_assoc($query2);

$write->easyCell('IV. Data on business population and revenue fron business', 'colspan:70; paddingY:0; border:LB; font-style:BI;');

$comulative_str = " ";
$comulative_business_count = " ";
$comulative_business_collection = " ";

$qt1 = "SELECT count(permit_id) AS t_count FROM `geo_bpls_business_permit` WHERE permit_released_date BETWEEN '$from' and '$to' and geo_bpls_business_permit.step_code = 'RELEA'";

$query11 = mysqli_query($conn, $qt1);
$qqq11 = mysqli_fetch_assoc($query11);

$qt2 = "SELECT sum(payment_total_amount_paid) as t_amount from geo_bpls_payment  WHERE date(cast(payment_date as date)) BETWEEN '$from' and '$to' ";
$query22 = mysqli_query($conn, $qt2);
$qqq22 = mysqli_fetch_assoc($query22);

$comulative_str .= " ";
$comulative_business_count = $qqq11["t_count"];
$comulative_business_collection = "PHP " . number_format($qqq22["t_amount"], 2);

$write->easyCell($comulative_str, 'colspan:30; paddingY:0; border:RB; font-style:BI; align:R; font-size:8;');
$write->printRow();

$write->easyCell('1. Total number of business Establishment registered in', 'colspan:41; paddingY:0; border:LT;');
$write->easyCell(date("Y") . '  (' . $q11["t_count"] . ')', 'colspan:20; paddingY:0; font-size:9; font-style:B; border:B;');
$write->easyCell($comulative_business_count, 'colspan:20; paddingY:0; font-size:9; font-style:B; align:R; border:B;');
$write->easyCell('', 'colspan:19; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LRB;');
$write->printRow();

$write->easyCell('2. Total amount of collections from business taxes, fees and charges', 'colspan:50; paddingY:0; border:LT;');
$write->easyCell('PHP ' . number_format($q22["t_amount"], 2), 'colspan:20; paddingY:0; border:B; font-size:9; font-style:B; ');
$write->easyCell($comulative_business_collection, 'colspan:25; paddingY:0; font-size:9; font-style:B; align:R; border:B;');
$write->easyCell('', 'colspan:5; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LRB;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:1; border:LRT;');
$write->printRow();

$write->easyCell('V. Structure of BPLO', 'colspan:100; paddingY:0; border:LRB; font-style:BI;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('1. Employment Status:', 'colspan:25; paddingY:0; border:L;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('Permanent', 'colspan:20; paddingY:0;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('Non-Permanent', 'colspan:49; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('2. Structure Level:', 'colspan:25; paddingY:0; border:L;');
$write->easyCell('', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('Department Head', 'colspan:20; paddingY:0;');
$write->easyCell('3', 'colspan:3; paddingY:0; border:1; font-style:B; font-family:ZapfDingbats; align:C;');
$write->easyCell('below Department Head', 'colspan:49; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LRB;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:1; border:LRT;');
$write->printRow();

$write->easyCell('VI. Attested by:', 'colspan:100; paddingY:0; border:LRB; font-style:BI;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('Prepared/Submitted by:', 'colspan:50; paddingY:0; border:L;');
$write->easyCell('Noted by:', 'colspan:50; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:3; border:LR;');
$write->printRow();

$q22 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = 'compliance_monitoring_report_s1'");
$r22 = mysqli_fetch_assoc($q22);
$signatory_name1 = $r22["signatory_name"];
$signatory_position1 = $r22["signatory_position"];
$e_signatory1 = $r22["e_signatory"];

$q22 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = 'compliance_monitoring_report_s2'");
$r22 = mysqli_fetch_assoc($q22);
$signatory_name2 = $r22["signatory_name"];
$signatory_position2 = $r22["signatory_position"];
$e_signatory2 = $r22["e_signatory"];


$write->easyCell( utf8_decode($signatory_name1),'colspan:50; paddingY:0; border:L; font-style:BI;');
$write->easyCell(utf8_decode($signatory_name2) ,'colspan:50; paddingY:0; border:R; font-style:BI;');
$write->printRow();

$write->easyCell('','colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell(utf8_decode($signatory_position1),'colspan:50; paddingY:0; border:L; font-size:9;');
$write->easyCell(utf8_decode($signatory_position2),'colspan:50; paddingY:0; border:R; font-size:9;');
$write->printRow();



$write->easyCell('', 'colspan:100; paddingY:0.5; border:LR;');
$write->printRow();

$write->easyCell('Date:', 'colspan:5; paddingY:0; border:L; fon t-style:B; font-size:9;');
$write->easyCell('', 'colspan:20; paddingY:0; border:B; font-size:9;');
$write->easyCell('', 'colspan:75; paddingY:0; border:R;');
$write->printRow();

$write->easyCell('', 'colspan:100; paddingY:1; border:LRB;');
$write->printRow();

$write->endTable();
$pdf->Ln();
$pdf->Output();
