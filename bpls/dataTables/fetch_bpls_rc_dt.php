<?php
include('../../php/connect.php');
// OWNER ---------------------------------------
    
    $request=$_REQUEST;
    $col = array(
        0   =>  'revenue_code',
        1   =>  'revenue_code_status',
    );  //create column step_desc table in database
    $year = date("Y");

        $sql = "SELECT  `revenue_code`, `revenue_code_status` FROM `geo_bpls_revenue_code` ";

    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
        $sql ="SELECT  `revenue_code`, `revenue_code_status`FROM `geo_bpls_revenue_code` WHERE 1=1";
   
    if(!empty($request['search']['value'])){
        $sql.=" AND (revenue_code Like '%".$request['search']['value']."%' ";
        $sql.=" OR revenue_code_status Like '%".$request['search']['value']."%' ) ";
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

        if( $row[1] == 0){
            $subdata[] = "<select class='form-control rc_btn' ca_rc='".$row[0]."' style='background:#ad2a21 !important;
 color: #fafafa;'>
                            <option value='1'> ON </option>
                            <option value='0' selected> OFF </option>
                         </select>";
        }else{
            $subdata[] = "<select class='form-control rc_btn' ca_rc='".$row[0]."' style='background:#13801a !important;
 color: #fafafa;'>
                            <option value='1' selected> ON </option>
                            <option value='0' > OFF </option>
                        </select>";

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