<?php
session_start();
include('../../php/web_connection.php');
include '../../jomar_assets/enc.php';

// OWNER ---------------------------------------
    
    $request=$_REQUEST;
    $col = array(
        0   =>  'lname',
        1   =>  'b_name',
        2   =>  'step',
        3   =>  'status',
        4   =>  'id',

    );  //create column step_desc table in database


        $sql = "SELECT id, lname, b_name, step, status, uniqID,customer_id,permit_id, mname,fname FROM `geo_bpls_ol_application` ";
  

    $query=mysqli_query($wconn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
        $sql ="SELECT id, lname, b_name, step, status, uniqID,customer_id,permit_id, mname,fname FROM `geo_bpls_ol_application` ";
    
    if(!empty($request['search']['value'])){
        $sql.=" AND (`lname` Like '%".$request['search']['value']."%' ";
        $sql .= " OR mname Like '%" . $request['search']['value'] . "%' ";
        $sql .= " OR fname Like '%" . $request['search']['value'] . "%' ";
        $sql.=" OR b_name Like '%".$request['search']['value']."%' ";
        $sql.=" OR status Like '%".$request['search']['value']."%' ) ";
    }
    $query=mysqli_query($wconn,$sql);
    $totalData=mysqli_num_rows($query);

    //Order
    $sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
        $request['start']."  ,".$request['length']."  ";

    $query=mysqli_query($wconn,$sql);

    $data=array();

    while($row=mysqli_fetch_array($query)){
        $subdata=array();
        $subdata[]= $row[9]." ".$row[8]." ".$row[1];
        $subdata[]= $row[2];
        
        $uniqID = $row[5];
        $permit_id = $row[7];
        if ($row[3] == "REQUIREMENTS APPROVAL") {
            // check if all upload requirements is valid
            $q1 = mysqli_query($wconn, "SELECT * FROM `geo_bpls_business_requirement_ol` where uniqID = '$uniqID' ");
            $pending = 0;
            $decline = 0;
            while ($r1 = mysqli_fetch_assoc($q1)) {
                if ($r1["requirement_status"] == 0) {
                    $pending++;
                }
                if ($r1["requirement_status"] == 2) {
                    $decline++;
                }
            }
            //  checking kung may business application na
            $q2 = mysqli_query($wconn, "SELECT * from geo_bpls_business_permit_ol where uniqID = '$uniqID' ");
            if (mysqli_num_rows($q2) > 0) {
                if ($pending == 0 && $decline == 0) {
                    $subdata[]=  '<span class="badge  bg-info" style="font-size:12px; background:#f74b45 !important;">APPLICATION APPROVAL</span>';
                     // application status
                    if($row[4] == "APPROVED"){
                        $subdata[]=  '<span class="label  bg-green" style="font-size:12px;">APPROVED</span>';
                    }elseif($row[4] == "PENDING"){
                        $subdata[]=  '<span class="label  bg-orange" style="font-size:12px;">PENDING</span>';
                    }else{
                        $subdata[]=  '<span class="label  bg-red" style="font-size:12px;">DISAPPROVED</span>';
                    }
                    // application approval redirection
                    $subdata[] = '<a href="bplsmodule.php?redirect=OAV2&a='.$uniqID.'" class="btn btn-warning"> APPLICATION APPROVAL PROCESS </a>';
                } else {
                    $subdata[]=  '<span class="badge  bg-info" style="font-size:12px; background:#a39e9e !important;">REQUIREMENTS APPROVAL</span>';
                     // application status
                    if($row[4] == "APPROVED"){
                        $subdata[]=  '<span class="label  bg-green" style="font-size:12px;">APPROVED</span>';
                    }elseif($row[4] == "PENDING"){
                        $subdata[]=  '<span class="label  bg-orange" style="font-size:12px;">PENDING</span>';
                    }else{
                        $subdata[]=  '<span class="label  bg-red" style="font-size:12px;">DISAPPROVED</span>';
                    }
                    // req approval redirection
                    $subdata[] = '<a href="bplsmodule.php?redirect=OAV&a='.$row[5].'&b='.me_encrypt(md5($row[0])).'" class="btn btn-warning"> REQUIREMENTS APPROVAL PROCESS </a>';
                    
                }
            } else {
                if($pending == 0 && $decline == 0) {
                    $uniqID = $row[5];
                    $q8765 = mysqli_query($wconn,"SELECT * FROM `geo_bpls_ol_renewal` where uniqID = '$uniqID' ");
                    if(mysqli_num_rows($q8765)>0){
                        $subdata[]=  '<span class="badge  bg-info" style="font-size:12px; background:#f74b45 !important;">WAITING FOR RENEWAL APPROVAL</span>';
                    }else{
                        $subdata[]=  '<span class="badge  bg-info" style="font-size:12px; background:#f74b45 !important;">FILING BUSINESS APPLICATION</span>';
                    }

                    

                     // application status
                    if($row[4] == "APPROVED"){
                        $subdata[]=  '<span class="label  bg-green" style="font-size:12px;">APPROVED</span>';
                    }elseif($row[4] == "PENDING"){
                        $subdata[]=  '<span class="label  bg-orange" style="font-size:12px;">PENDING</span>';
                    }else{
                        $subdata[]=  '<span class="label  bg-red" style="font-size:12px;">DISAPPROVED</span>';
                    }
                    // req approval redirection
                    $subdata[] = '<a href="bplsmodule.php?redirect=OAV&a='.$row[5].'&b='.me_encrypt(md5($row[0])).'" class="btn btn-warning"> REQUIREMENTS APPROVAL PROCESS </a>';

                } else {
                    $subdata[]=  '<span class="badge  bg-info" style="font-size:12px; background:#a39e9e !important;">REQUIREMENTS APPROVAL</span>';
                     // application status
                if($row[4] == "APPROVED"){
                    $subdata[]=  '<span class="label  bg-green" style="font-size:12px;">APPROVED</span>';
                 }elseif($row[4] == "PENDING"){
                    $subdata[]=  '<span class="label  bg-orange" style="font-size:12px;">PENDING</span>';
                 }else{
                    $subdata[]=  '<span class="label  bg-red" style="font-size:12px;">DISAPPROVED</span>';
                 }
                    // req approval redirection
                    $subdata[] = '<a href="bplsmodule.php?redirect=OAV&a='.$row[5].'&b='.me_encrypt(md5($row[0])).'" class="btn btn-warning"> REQUIREMENTS APPROVAL PROCESS </a>';
                }
            }
            } elseif ($row[3] == "ASSESSMENT") {
                $subdata[]=  '<span class="badge  bg-primary" style="font-size:12px;  background:#58bfb5 !important; " >ASSESSMENT</span>';
                 // application status
                 if($row[4] == "APPROVED"){
                    $subdata[]=  '<span class="label  bg-green" style="font-size:12px;">APPROVED</span>';
                 }elseif($row[4] == "PENDING"){
                    $subdata[]=  '<span class="label  bg-orange" style="font-size:12px;">PENDING</span>';
                 }else{
                    $subdata[]=  '<span class="label  bg-red" style="font-size:12px;">DISAPPROVED</span>';
                 }
                 // multistep redirection
                 $subdata[] = '<a href="bplsmodule.php?redirect=business_registration_multistep&target='.md5($permit_id).'" class="btn btn-warning"> ONE-STOP-SHOP PROCESS </a>';
            } elseif ($row[3] == "APPLICATION APPROVAL") {
                $subdata[] = '<span class="badge  bg-info" style="font-size:12px; background:#f74b45 !important;">APPLICATION APPROVAL</span>';

                 // application status
                 if($row[4] == "APPROVED"){
                    $subdata[]=  '<span class="label  bg-green" style="font-size:12px;">APPROVED</span>';
                 }elseif($row[4] == "PENDING"){
                    $subdata[]=  '<span class="label  bg-orange" style="font-size:12px;">PENDING</span>';
                 }else{
                    $subdata[]=  '<span class="label  bg-red" style="font-size:12px;">DISAPPROVED</span>';
                 }
                 // multistep redirection
               $subdata[] = '<a href="bplsmodule.php?redirect=OAV2&a=' . $uniqID . '" class="btn btn-warning"> APPLICATION APPROVAL PROCESS </a>';


            } elseif ($row[3] == "APPROVAL") {
                $subdata[]=  '<span class="badge  bg-primary" style="font-size:12px; background:#d6d131 !important; ">APPROVAL</span>';
                 // application status
                 if($row[4] == "APPROVED"){
                    $subdata[]=  '<span class="label  bg-green" style="font-size:12px;">APPROVED</span>';
                 }elseif($row[4] == "PENDING"){
                    $subdata[]=  '<span class="label  bg-orange" style="font-size:12px;">PENDING</span>';
                 }else{
                    $subdata[]=  '<span class="label  bg-red" style="font-size:12px;">DISAPPROVED</span>';
                 }
                 // multistep redirection
                 $subdata[] = '<a href="bplsmodule.php?redirect=business_registration_multistep&target='.md5($permit_id).'" class="btn btn-warning">  ONE-STOP-SHOP PROCESS </a>';
            } elseif ($row[3] == "PAYMENTS") {
                $subdata[]=  '<span class="badge  bg-primary" style="font-size:12px;">PAYMENTS</span>';
                 // application status
                 if($row[4] == "APPROVED"){
                    $subdata[]=  '<span class="label  bg-green" style="font-size:12px;">APPROVED</span>';
                 }elseif($row[4] == "PENDING"){
                    $subdata[]=  '<span class="label  bg-orange" style="font-size:12px;">PENDING</span>';
                 }else{
                    $subdata[]=  '<span class="label  bg-red" style="font-size:12px;">DISAPPROVED</span>';
                 }
                 // multistep redirection
                 $subdata[] = '<a href="bplsmodule.php?redirect=business_registration_multistep&target='.md5($permit_id).'" class="btn btn-warning">  ONE-STOP-SHOP PROCESS </a>';
            } elseif ($row[3] == "RELEASE") {
                $subdata[]=  '<span class="badge  bg-success" style="font-size:12px;">RELEASE</span>';
                // application status
                if($row[4] == "APPROVED"){
                    $subdata[]=  '<span class="label  bg-green" style="font-size:12px;">APPROVED</span>';
                 }elseif($row[4] == "PENDING"){
                    $subdata[]=  '<span class="label  bg-orange" style="font-size:12px;">PENDING</span>';
                 }else{
                    $subdata[]=  '<span class="label  bg-red" style="font-size:12px;">DISAPPROVED</span>';
                 }
                 // multistep redirection
                 $subdata[] = '<a href="bplsmodule.php?redirect=business_registration_multistep&target='.md5($permit_id).'" class="btn btn-warning">  ONE-STOP-SHOP PROCESS </a>';
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
