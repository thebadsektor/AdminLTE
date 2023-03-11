<?php
include('../../php/connect.php');
// OWNER ---------------------------------------
    $querytext = $_POST["querytext"];

    $request=$_REQUEST;
    $col = array(
        0   =>  'permit_no',
        1   =>  'business_name',
        2   =>  'owner_last_name',
        4   =>  'owner_last_name',
      
    );  //create column step_desc table in database
    $year = date("Y");
    $sql = $querytext;
    $query=mysqli_query($conn,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;
    //Search
        $sql = $querytext;

   
    if(!empty($request['search']['value'])){
        $sql.=" AND (permit_no Like '%".$request['search']['value']."%' ";
        $sql.=" OR business_name Like '%".$request['search']['value']."%'";
        $sql.=" OR owner_last_name Like '%".$request['search']['value']."%'";
        $sql.=" OR permit_no Like '%".$request['search']['value']."%' ) ";
    }
    $query=mysqli_query($conn,$sql);
    $totalData=mysqli_num_rows($query);

    //Order
    $sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    $request['start']."  ,".$request['length']."  ";
    $query=mysqli_query($conn,$sql);
    $data=array();

    while($row=mysqli_fetch_array($query)){
        if($row[3] > 0){
        $subdata=array();
            $subdata[]= $row[0]; 
            $subdata[]= ($row[1]); 
            $subdata[]= ($row[2]); 
            $subdata[]= ($row[3]); 
        $data[]=$subdata;
        }
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);

?>