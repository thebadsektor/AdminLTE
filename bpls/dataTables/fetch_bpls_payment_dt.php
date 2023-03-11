<?php
include('../../php/connect.php');
// OWNER ---------------------------------------
    
    $request=$_REQUEST;
    $col = array(
        0   =>  'permit_no',
        1   =>  'owner_last_name',
        2   =>  'business_name',
        3   =>  'status_desc',
        4   =>  'step_desc',
        5   =>  'payment_frequency_desc',
        6   =>  'permit_id',
    );  //create column step_desc table in database
    $year = $_POST["year"];

   
         $sql = "SELECT permit_no, owner_first_name, owner_middle_name, owner_last_name , business_name, status_desc, step_desc, payment_frequency_desc , permit_id FROM `geo_bpls_business_permit` 
         inner join geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id 
         inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id 
         inner join geo_bpls_status on geo_bpls_status.status_code = geo_bpls_business_permit.status_code 
         inner join geo_bpls_step on geo_bpls_step.step_code = geo_bpls_business_permit.step_code 
         inner join geo_bpls_payment_frequency on geo_bpls_payment_frequency.payment_frequency_code = geo_bpls_business_permit.payment_frequency_code where  geo_bpls_business_permit.permit_for_year = '$year' and permit_approved =1  order by permit_id asc ";

    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
        $sql = "SELECT permit_no,  owner_first_name , owner_middle_name ,owner_last_name , business_name  , status_desc, step_desc, payment_frequency_desc , permit_id FROM `geo_bpls_business_permit` 
        inner join geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id 
        inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id 
        inner join geo_bpls_status on geo_bpls_status.status_code = geo_bpls_business_permit.status_code 
        inner join geo_bpls_step on geo_bpls_step.step_code = geo_bpls_business_permit.step_code 
        inner join geo_bpls_payment_frequency on geo_bpls_payment_frequency.payment_frequency_code = geo_bpls_business_permit.payment_frequency_code 
        WHERE geo_bpls_business_permit.permit_for_year = '$year' and permit_approved =1 and 1=1   ";

    if(!empty($request['search']['value'])){
        $sql.=" AND (permit_no Like '%".$request['search']['value']."%' ";
        $sql.=" OR owner_first_name Like '%".$request['search']['value']."%' ";
        $sql.=" OR owner_middle_name Like '%".$request['search']['value']."%' ";
        $sql.=" OR owner_last_name Like '%".$request['search']['value']."%' ";
        $sql.=" OR business_name Like '%".$request['search']['value']."%' ";
        $sql.=" OR status_desc Like '%".$request['search']['value']."%' ";
        $sql.=" OR step_desc Like '%".$request['search']['value']."%' ";
        $sql.=" OR payment_frequency_desc Like '%".$request['search']['value']."%' ";
        $sql.=" OR permit_id Like '%".$request['search']['value']."%' ) ";
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
        $subdata[]= ($row[0]); 
        $subdata[]= ($row[1]." ".$row[2]." ".$row[3]);
        $subdata[]= ($row[4]);
        $subdata[]= $row[5];
        $subdata[]= $row[6];
        $subdata[]= $row[7];
       
        // check assessment amount
        $permit_id = $row[8];
        $ass_q = mysqli_query($conn,"SELECT sum(assessment_tax_due) as total_tax  FROM `geo_bpls_assessment` where permit_id = '$permit_id' ");

        $paid_q = mysqli_query($conn,"SELECT payment_tax, payment_fee, payment_backtax FROM `geo_bpls_payment` where permit_id = '$permit_id' ");
        
        $backtax = 0;
        $p_fee = 0;
        $p_tax = 0;
        $total_paid = 0;

        $paid_count = mysqli_num_rows($paid_q);
        if($paid_count > 0){
            while($r34 = mysqli_fetch_assoc($paid_q)){
                        if($r34["payment_backtax"] != 0){
                            $backtax_arr = explode('+',$r34["payment_backtax"]);
                            $backtax_arr_count = count($backtax_arr);
                            $backtax += (float)$backtax_arr[1]+(float)$backtax_arr[0];
                        }
                        $p_fee += $r34["payment_fee"];
                        $p_tax += $r34["payment_tax"];
                    }
                    $total_paid = $backtax+ $p_fee+ $p_tax;
        }
        $ass_total = 0;
        
        if(mysqli_num_rows($ass_q) > 0){
            $ass_r = mysqli_fetch_assoc($ass_q);
            $ass_total = number_format((float)$ass_r["total_tax"],2);
        }
        $total_paid = number_format((float)$total_paid,2);

        if($ass_total != $total_paid){
            $subdata[] = "
            <div class='btn-group' >
                
                <a href='bplsmodule.php?redirect=business_registration_multistep&target=".md5($row[8])."&traget_n=tres'  class='btn btn-success' target='blank' title='Edit'><i class='fa fa-money'></i></a> 
            </div>   
            ";
        // ".$ass_total."|".$total_paid."
        }else{
             $subdata[] = "";
        }
        
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