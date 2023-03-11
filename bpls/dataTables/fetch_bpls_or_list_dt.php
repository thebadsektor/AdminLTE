<?php
include('../../php/connect.php');
// OWNER ---------------------------------------
    
    $request=$_REQUEST;
    $col = array(
        0   =>  'or_num',
        1   =>  'created_at',
        2   =>  'or_payor',
        3   =>  'payor_money',
        4   =>  'id',
      
    );  //create column step_desc table in database

   $status = $_POST["status"];

    if($status == "active_or"){
         $status = "active";
    }else{
         $status = "bpls_cancel";
    }
   
    $from = $_POST["from"];
    $to = $_POST["to"];

    $sql = "SELECT or_num,created_at,or_payor,payor_money,id FROM `treasury_tbl` where `status` = '$status' and department = 'BPLS' and created_at >= '$to'  and created_at <= '$from' ";

    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql = "SELECT or_num,created_at,or_payor,payor_money,id FROM `treasury_tbl` where `status` = '$status' and department = 'BPLS' and created_at >= '$to'  and created_at <= '$from'  and 1=1 ";

    if(!empty($request['search']['value'])){
        $sql.=" AND (or_num Like '%".$request['search']['value']."%' ";
        $sql.=" OR created_at Like '%".$request['search']['value']."%' ";
        $sql.=" OR or_payor Like '%".$request['search']['value']."%' ";
        $sql.=" OR payor_money Like '%".$request['search']['value']."%' ) ";
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

        $subdata[] = $row[0];
        $subdata[] = $row[1];
        $subdata[] = $row[2];
        $subdata[] = $row[3];
            $or_no = $row[0];
            $or_year = substr($row[1],0,4);
            
        $q000 = mysqli_query($conn,"SELECT payment_id FROM `geo_bpls_payment` where payment_year = '$or_year'  and or_no = '$or_no'   ");
        $r000 = mysqli_fetch_assoc($q000);
        $payment_id = $r000["payment_id"];
        if($status != "bpls_cancel"){
            $subdata[] = " <div class='btn-group' ><a href='bpls/pdf_excel/51cbpls_or.php?target=".$payment_id."&target2=".md5($payment_id)."' class='btn btn-success' target='_blank' > <i class='fa fa-file-pdf-o'></i></a>
            <a href='bpls/pdf_excel/51cbpls_or_data.php?target=".$payment_id."&target2=".md5($payment_id)."' class='btn btn-info' target='_blank'>  <i class='fa fa-file-pdf-o'></i> </a>
            <a href='#'  class='btn btn-danger void_btn' title='Cancel' ca_target='".md5($row[4])."' ><i class='fa fa-ban'></i></a> </div> ";
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