<?php
session_start();
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
    
    $year = date("Y");
    
    if($_POST["page"] == "entries"){ 
        $sql = "SELECT permit_no, owner_first_name, owner_middle_name, owner_last_name , business_name, status_desc, step_desc, payment_frequency_desc , permit_id, geo_bpls_business.business_id , permit_released_date FROM `geo_bpls_business_permit` inner join geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id inner join geo_bpls_status on geo_bpls_status.status_code = geo_bpls_business_permit.status_code inner join geo_bpls_step on geo_bpls_step.step_code = geo_bpls_business_permit.step_code inner join geo_bpls_payment_frequency on geo_bpls_payment_frequency.payment_frequency_code = geo_bpls_business_permit.payment_frequency_code where permit_for_year = '$year'
";
    }else{

        $from = $_POST["from"];
        $to = $_POST["to"];

         $sql = "SELECT permit_no, owner_first_name, owner_middle_name, owner_last_name , business_name, status_desc, step_desc, payment_frequency_desc , permit_id, geo_bpls_business.business_id, permit_for_year FROM `geo_bpls_business_permit` inner join geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id inner join geo_bpls_status on geo_bpls_status.status_code = geo_bpls_business_permit.status_code inner join geo_bpls_step on geo_bpls_step.step_code = geo_bpls_business_permit.step_code inner join geo_bpls_payment_frequency on geo_bpls_payment_frequency.payment_frequency_code = geo_bpls_business_permit.payment_frequency_code  where  geo_bpls_business_permit.permit_application_date >= '$to'  and geo_bpls_business_permit.permit_application_date <= '$from' and geo_bpls_business_permit.step_code = 'RELEA'  ";
    }

    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    if($_POST["page"] == "entries"){
        $sql ="SELECT permit_no,  owner_first_name , owner_middle_name ,owner_last_name , business_name  , status_desc, step_desc, payment_frequency_desc , permit_id , permit_released_date FROM `geo_bpls_business_permit` inner join geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id inner join geo_bpls_status on geo_bpls_status.status_code = geo_bpls_business_permit.status_code inner join geo_bpls_step on geo_bpls_step.step_code = geo_bpls_business_permit.step_code inner join geo_bpls_payment_frequency on geo_bpls_payment_frequency.payment_frequency_code = geo_bpls_business_permit.payment_frequency_code WHERE 1=1 and permit_for_year = '$year' ";
    }else{

        
        $from = $_POST["from"];
        $to = $_POST["to"];


        $sql = "SELECT permit_no,  owner_first_name , owner_middle_name ,owner_last_name , business_name  , status_desc, step_desc, payment_frequency_desc , permit_id, geo_bpls_business.business_id, permit_for_year FROM `geo_bpls_business_permit` inner join geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id inner join geo_bpls_status on geo_bpls_status.status_code = geo_bpls_business_permit.status_code inner join geo_bpls_step on geo_bpls_step.step_code = geo_bpls_business_permit.step_code inner join geo_bpls_payment_frequency on geo_bpls_payment_frequency.payment_frequency_code = geo_bpls_business_permit.payment_frequency_code WHERE 1=1 and geo_bpls_business_permit.permit_application_date >= '$to'  and geo_bpls_business_permit.permit_application_date <= '$from' and  geo_bpls_business_permit.step_code = 'RELEA' ";


    }
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
        
        // checking if online application
        $ol_application_status = 0;
        $permit_id = $row[8];
        $q9974 = mysqli_query($conn,"SELECT * from geo_bpls_ol_application where permit_id = '$permit_id'");
        
        if(mysqli_num_rows($q9974)>0){
            $ol_application_status++;
        }

        if($row[0] == "closed"){
            
            $subdata[]= "<b style='color:red;'>".$row[0]."</b>"; 
        }else{
            if($ol_application_status >0){
                  $subdata[]= "<b style='color:green;'>".$row[0]."</b> <i style='color:blue; font-size:12px;'>linked Online</i>"; 
            }else{
                  $subdata[]= "<b style='color:green;'>".$row[0]."</b>"; 
            }
          
        }
        $subdata[]= $row[1]." ".$row[2]." ".$row[3];
        $subdata[]= $row[4];
        $subdata[]= $row[5];
        $subdata[]= $row[6];
        $subdata[]= $row[7];
        if($_POST["page"] == "entries"){
            //  <button class='btn btn-info history_btn' title='History'>   <i class='fa fa-history'></i></button> 
              if ($row[0] != "" || $row[0] != null) {
                $aaaa = "<a href='bpls/pdf_excel/business_permit.php?target=" . md5($row[8]) . "' style='color:white;' target='_blank'  class='btn"; 
                    if($row[5] == "Retire"){
                         $aaaa .= " btn-danger";
                    }else{
                         $aaaa .= " btn-info";
                    }
                    $aaaa .= "'  >   RELEASE </a> ";
            }else{
                $aaaa ="";
            }
            
            if($_SESSION["module_permission"] == "Department Head"){
                    if($row[9] == ""){
                        // checking kung bayad na sa
                        $p_id = $row[8];
                        $q1111 = mysqli_query($conn,"SELECT * from geo_bpls_payment where permit_id = '$p_id' ");
                        if(mysqli_num_rows($q1111)==0){
                            $aaaa .= " <button class='btn btn-danger reset_btn' ca_id='".md5($row[8])."' >RESET </button> "; 
                        }
                    }
            }
            $subdata[]= "<div class='btn-group'> 
                        <a href='bplsmodule.php?redirect=business_registration_multistep&target=".md5($row[8])."'  class='btn btn-warning edit_btn' title='Edit'>PROCESS</a> {$aaaa} </div>";
                    //  <a href='bpls/delete_section/bpls_delete_entries.php?target=".md5($row[8])."'  class='btn btn-danger delete_btn' title='Delete'><i class='fa fa-trash'></i></a> 
        }else{

            // renewal
            //  <button class='btn btn-info history_btn' title='History'>   <i class='fa fa-history'></i></button> 


            // bplsmodule.php?redirect=business_renewal&target=ren_".md5($row[8]) . "
            //    bplsmodule.php?redirect=business_renewal&target=ret_".md5($row[8])."
            
            $year_to = $row[10];

            if($year_to == $year){
                $bbb = "";
            }else{
                $bbb = "  <a href='#'  class='btn btn-success renew_btn' ca_business='".  str_replace("'","&#8217;",$row[4])."' ca_target='".md5($row[8])."' title='Renew'>RENEW </a>";
            }
         
                $subdata[] = "
                <div class='btn-group' >
                $bbb
                <a href='bplsmodule.php?redirect=business_registration_multistep&target=".md5($row[8])."'  class='btn btn-warning edit_btn' title='Edit'> PROCESS</a>  
                
                <a href='#'  class='btn btn-dark retire_btn'  ca_business='".
    str_replace("'","&#8217;",$row[4])."' style='background:black !important; color:white;' ca_target='".md5($row[8])."'  title='Retire'>RETIRE</a> 
             </div>   
            ";
           
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
