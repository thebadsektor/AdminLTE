<?php
session_start();

include '../../php/connect.php';
// OWNER ---------------------------------------
$username = $_SESSION["uname"];
$q = mysqli_query($conn, "SELECT module_permission from permission_tbl where uname= '$username' and module = 'MSWD Module' ");
$r = mysqli_fetch_assoc($q);
$module_permission = $r["module_permission"];
if ($module_permission == "Department Head") {
    $limiter = "";
} else {
    $limiter = "disabled";
}

    $request=$_REQUEST;
    $col = array(
        0   =>  'revenue_code',
        1   =>  'nature_desc',
        2   =>  'nature_id',
        3   =>  'nature_id',
      
    );  //create column step_desc table in database
    $year = date("Y");

        $sql = "SELECT DISTINCT nature_desc, geo_bpls_nature.nature_id, geo_bpls_tfo_nature.revenue_code  FROM `geo_bpls_nature` 
inner JOIN geo_bpls_tfo_nature on geo_bpls_tfo_nature.nature_id = geo_bpls_nature.nature_id
inner JOIN geo_bpls_revenue_code on geo_bpls_revenue_code.revenue_code = geo_bpls_tfo_nature.revenue_code where  revenue_code_status = 1";
    

    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
        $sql ="SELECT DISTINCT geo_bpls_nature.nature_desc, geo_bpls_nature.nature_id, geo_bpls_tfo_nature.revenue_code  FROM `geo_bpls_nature` 
inner JOIN geo_bpls_tfo_nature on geo_bpls_tfo_nature.nature_id = geo_bpls_nature.nature_id
inner JOIN geo_bpls_revenue_code on geo_bpls_revenue_code.revenue_code = geo_bpls_tfo_nature.revenue_code where  revenue_code_status = 1 ";

   
    if(!empty($request['search']['value'])){
        $sql.=" AND (geo_bpls_nature.nature_desc Like '%".$request['search']['value']."%' ";
        $sql.=" OR geo_bpls_tfo_nature.revenue_code Like '%".$request['search']['value']."%' ) ";
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
            $nature_id = $row[1];
          
        $subdata[]= $row[2]; 
        $subdata[]= $row[0]; 
        
        // <button class='btn btn-info tax_formula' data-toggle='modal' data-target='#mytaxModal'  data-id='".md5($row[1])."'>TFO 1</button>
        $subdata[] = " <button class='btn btn-success tax_formula2' data-toggle='modal' data-target='#mytaxModal2'  data-id='".md5($row[1])."'>TFO</button>";
        
         // check if nagamit na sa assessment
        if($limiter == ""){
               $subdata[]= "<div class='btn-group' style='width:80px;' > 
                        <a href='#' ca_target ='bpls/delete_section/bpls_delete_tax_fee.php?target=".md5($row[1])."' ca_title='".$row[0]."' class='btn btn-danger delete_btn' title='Delete' ><i class='fa fa-trash'></i></a> 
                    </div>";
        }else{
               $subdata[]= "<div class='btn-group' style='width:80px;' > 
                        <a href='#' class='btn btn-danger ' title='Delete' disabled><i class='fa fa-trash'></i></a> 
                    </div>";
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