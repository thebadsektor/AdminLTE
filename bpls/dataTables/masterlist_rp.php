<?php
include('../../php/connect.php');
// OWNER ---------------------------------------
    $querytext = $_POST["querytext"];

    $request=$_REQUEST;
    $col = array(
        0   =>  'permit_no',
        1   =>  'business_name',
        2   =>  'owner_last_name',
        3   =>  'barangay_id',
        4   =>  'nature_desc',
        5   =>  'scale_desc',
        6   =>  'capital_invesment',
        7   =>  'last_year_gross',
        8   =>  'business_type_code',
        9   =>  'payment_frequency_code',
        10   =>  'status_code',
        11   =>  'permit_no',
        12   =>  'permit_no',
        13   =>  'permit_application_date',
        14   =>  'business_employee_total',
        15   =>  'owner_mobile',
        16   =>  'business_mob_no',
      
    );  //create column step_desc table in database
    $year = date("Y");
    $sql = $querytext;
    $query=mysqli_query($conn,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;
    //Search
        $sql = $querytext." and  1=1 ";

   
    if(!empty($request['search']['value'])){
        $sql.=" AND (permit_no Like '%".$request['search']['value']."%' ";
        $sql.=" OR business_name Like '%".$request['search']['value']."%'";
        $sql.=" OR owner_last_name Like '%".$request['search']['value']."%'";
        $sql.=" OR payment_frequency_code Like '%".$request['search']['value']."%'";
        $sql.=" OR nature_desc Like '%".$request['search']['value']."%'";
        $sql.=" OR status_code Like '%".$request['search']['value']."%'";
        $sql.=" OR permit_application_date Like '%".$request['search']['value']."%' ) ";
    }
    $query=mysqli_query($conn,$sql);
    $totalData=mysqli_num_rows($query);

    //Order
    $sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    $request['start']."  ,".$request['length']."  ";
    $query=mysqli_query($conn,$sql);
    $data=array();

    while($row=mysqli_fetch_array($query)){
        $subdata=array();
            $subdata[]= $row[0]; 
            $subdata[]= utf8_encode($row[1]); 
            $subdata[]= utf8_encode($row[2]); 
            $barangay_id = $row[3];
            $q = mysqli_query($conn, "SELECT CONCAT(barangay_desc,', ', lgu_desc,', ', province_desc) as b_add, lgu_zip from geo_bpls_barangay inner join geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code where geo_bpls_barangay.barangay_id = '$barangay_id' ");
            $r = mysqli_fetch_assoc($q);
            $subdata[]= "BARANGAY " . $r["b_add"]; 
            
            $subdata[]= $row[8]; 
            
            // scale desc
            $subdata[] = $row[16];
            
            $subdata[]= number_format($row[9],2); 
            $subdata[]= number_format($row[10],2); 
            $target = $row[4];
            $q = mysqli_query($conn, "SELECT * FROM `geo_bpls_business_type` where business_type_code = '$target' ");
            $r = mysqli_fetch_assoc($q);
            $subdata[]= $r["business_type_desc"];
            $target = $row[5];
            $q = mysqli_query($conn, "SELECT * FROM     geo_bpls_payment_frequency where payment_frequency_code = '$target' ");
            $r = mysqli_fetch_assoc($q);
            $subdata[]= $r["payment_frequency_desc"];
             if($row[11] == "REN"){
                $subdata[] = "Renew";
            }else{
                $subdata[] = "New";
            }


            $permit_id = $row[7];

            $nature_id = $row[12];
    
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

            $q23232 = mysqli_query($conn, "SELECT sum(assessment_tax_due) as aass FROM `geo_bpls_assessment` inner JOIN geo_bpls_tfo_nature on geo_bpls_tfo_nature.tfo_nature_id = geo_bpls_assessment.tfo_nature_id where geo_bpls_tfo_nature.nature_id = $nature_id and permit_id = '$permit_id' and assessment_active = 1 and geo_bpls_tfo_nature.nature_id = '$nature_id' and (geo_bpls_tfo_nature.sub_account_no = '1010' or geo_bpls_tfo_nature.sub_account_no = '1011' or geo_bpls_tfo_nature.sub_account_no = '1012' or geo_bpls_tfo_nature.sub_account_no = '1013' or  geo_bpls_tfo_nature.sub_account_no = '1014' or geo_bpls_tfo_nature.sub_account_no = '1015' or geo_bpls_tfo_nature.sub_account_no = '1016' or geo_bpls_tfo_nature.sub_account_no = '1017' or geo_bpls_tfo_nature.sub_account_no = '1018' or geo_bpls_tfo_nature.sub_account_no = '1019' or geo_bpls_tfo_nature.sub_account_no = '1020' or geo_bpls_tfo_nature.sub_account_no = '1021' ) ");
            $r2223 = mysqli_fetch_assoc($q23232);
            $BT = $r2223["aass"];
            //=========================
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
            $subdata[] = $BT;
            $subdata[]=  $RF;


            //=========================
            
            //  $permit_id = $row[7];
            // $q_BT = mysqli_query($conn,"SELECT sum(payment_amount) as aaaa from geo_bpls_payment_detail inner join geo_bpls_payment on geo_bpls_payment.payment_id = geo_bpls_payment_detail.payment_id  where permit_id = '$permit_id' and sub_account_no = '4-01-03-030-1' ");
            // $r_BT = mysqli_fetch_assoc($q_BT);
            // $BT = $r_BT["aaaa"];
            // $subdata[] = $BT;
            // $q_RF = mysqli_query($conn,"SELECT sum(payment_amount) as aaaa from geo_bpls_payment_detail inner join geo_bpls_payment on geo_bpls_payment.payment_id = geo_bpls_payment_detail.payment_id  where permit_id = '$permit_id' and sub_account_no != '4-01-03-030-1' ");
            // $r_RF = mysqli_fetch_assoc($q_RF);
            // $subdata[]= $r_RF["aaaa"];

            $subdata[]= $row[6]; 
            $subdata[] = $row[13];
            $subdata[] = $row[14];
            $subdata[] = $row[15];

        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);

?>