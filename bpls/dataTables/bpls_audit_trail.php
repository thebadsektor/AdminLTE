<?php
include('../../php/connect.php');
// OWNER ---------------------------------------
    
    $request=$_REQUEST;
    $col = array(
        0   =>  'created_at',
        1   =>  'username',
        2   =>  'action',
        3   =>  'description',
       
    );  //create column step_desc table in database
    
        $from = $_POST["from"];
        $to = $_POST["to"];

         $sql = "SELECT `created_at`, `username`, `action`, `description` FROM `geo_bpls_audit_trail` where cast(created_at as date) BETWEEN  '$from' and '$to'  ";
    
        $query=mysqli_query($conn,$sql);

        $totalData=mysqli_num_rows($query);

        $totalFilter=$totalData;

    //Search
        
    $sql = "SELECT   `created_at`, `username`, `action`, `description` FROM `geo_bpls_audit_trail` where cast(created_at as date) BETWEEN '$from' and '$to' ";

    if(!empty($request['search']['value'])){
        $sql.=" AND (uname Like '%".$request['search']['value']."%' ";
        $sql.=" OR created_at Like '%".$request['search']['value']."%' ";
        $sql.=" OR action Like '%".$request['search']['value']."%' ";
        $sql.=" OR description Like '%".$request['search']['value']."%' ) ";
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
       
        $subdata[]= date("F d Y h:i a",strtotime($row[0]));
        $subdata[]= $row[1];
        $subdata[]= $row[2];
        $subdata[]= $row[3];
     
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
