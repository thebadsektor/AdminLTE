<?php
include('../../php/connect.php');
// OWNER ---------------------------------------
    
    $request=$_REQUEST;
    $col = array(
        0   =>  'permit_no',
        1   =>  'business_name',
        2   =>  'permit_no',
        3   =>  'permit_id',
      
    );  //create column step_desc table in database
    $year = $_POST["year"];
    if($year == ""){
         $year = date("Y");
    }
        $sql = "SELECT permit_no, business_name , geo_bpls_business_permit.permit_no , FORMAT(((SELECT sum(assessment_tax_due) from geo_bpls_assessment where geo_bpls_assessment.permit_id = geo_bpls_business_permit.permit_id ) - ( sum(SUBSTRING_INDEX(payment_backtax,'+',1) + SUBSTRING_INDEX(payment_backtax,'+',-1)) + sum(payment_fee+payment_tax))),2) as unpaid , geo_bpls_payment.permit_id FROM `geo_bpls_business_permit` inner JOIN geo_bpls_payment on geo_bpls_payment.permit_id = geo_bpls_business_permit.permit_id inner JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id where  permit_for_year = '$year' and (step_code = 'PAYME' or step_code = 'RELEA') GROUP BY geo_bpls_payment.permit_id  ";
    
        $query=mysqli_query($conn,$sql);
        $totalData=mysqli_num_rows($query);
        $totalFilter=$totalData;

    //Search
        $sql ="SELECT permit_no, business_name  , FORMAT(((SELECT sum(assessment_tax_due) from geo_bpls_assessment where geo_bpls_assessment.permit_id = geo_bpls_business_permit.permit_id ) - ( sum(SUBSTRING_INDEX(payment_backtax,'+',1) + SUBSTRING_INDEX(payment_backtax,'+',-1)) + sum(payment_fee+payment_tax))),2) as unpaid , geo_bpls_payment.permit_id FROM `geo_bpls_business_permit` inner JOIN geo_bpls_payment on geo_bpls_payment.permit_id = geo_bpls_business_permit.permit_id inner JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id where  permit_for_year = '$year' and (step_code = 'PAYME' or step_code = 'RELEA') GROUP BY geo_bpls_payment.permit_id ";

   
    if(!empty($request['search']['value'])){
        $sql.=" AND (permit_no Like '%".$request['search']['value']."%' ";
        $sql.=" OR business_name Like '%".$request['search']['value']."%' ) ";
    }
    
    $query=mysqli_query($conn,$sql);
    $totalData=mysqli_num_rows($query);

    //Order
    $sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
        $request['start']."  ,".$request['length']."  ";

    $query=mysqli_query($conn,$sql);

    $data=array();

    while($row=mysqli_fetch_array($query)){
          // check if pai as a backtax
          $permit_id_dec = $row[3];
            

            $subdata = array();
            $subdata[] = $row[0];
            $subdata[] = $row[1];

            $q565d = mysqli_query($conn,"SELECT * FROM geo_bpls_payment_paid_backtax where permit_id = '$permit_id_dec' ");
            if(mysqli_num_rows($q565d) == 0){
                     if($row[2] > 0){
                        $subdata[] = $row[2]."(<i style='color:red; font-size:12px;'>Sucharges not included</i>)";
                    // get paid amount
                    }else{
                        $subdata[] = 0.00;
                    } 
            }else{
               
                 $subdata[] = 0.00;
            }
            $subdata[] = "<a href='bplsmodule.php?redirect=business_registration_multistep&target=".md5($row[3])."&t=4'  class='btn btn-danger'> MORE DETAILS </a>";
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