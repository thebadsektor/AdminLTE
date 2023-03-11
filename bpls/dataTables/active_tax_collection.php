<?php
include('../../php/connect.php');
// OWNER ---------------------------------------
    
    $request=$_REQUEST;
    $col = array(
        0   =>  'active_tfo_if',
        1   =>  'chartOfAccountNo',
        2   =>  'chartOfAccountName',
        3   =>  'active_tfo_if',
    );  //create column step_desc table in database
    
         $sql = "SELECT `name` , chartOfAccountNo, chartOfAccountName ,  `active_tfo_if`, id, uniqID FROM `geo_bpls_active_tfo` inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_active_tfo.naturecollection_id ";

        $query=mysqli_query($conn,$sql);

        $totalData=mysqli_num_rows($query);

        $totalFilter=$totalData;

    //Search
        
         $sql = "SELECT  `name` , chartOfAccountNo, chartOfAccountName ,  `active_tfo_if` , id, uniqID  FROM `geo_bpls_active_tfo` inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_active_tfo.naturecollection_id  WHERE 1 = 1 ";

    if(!empty($request['search']['value'])){
        $sql.=" AND (name Like '%".$request['search']['value']."%' ";
        $sql.=" OR chartOfAccountNo Like '%".$request['search']['value']."%' ";
        $sql.=" OR chartOfAccountName Like '%".$request['search']['value']."%' ";
        $sql.=" OR active_tfo_if Like '%".$request['search']['value']."%' ) ";
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
        $subdata[]= $row[1];
        $subdata[]= $row[2];
        $subdata[]= "<button class='btn btn-danger rm_active_tax' ca_target='".md5($row[3])."'>Deactivate</button>";
     
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
