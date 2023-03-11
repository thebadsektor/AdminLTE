<?php
include('../../php/connect.php');
// OWNER ---------------------------------------
    
    $request=$_REQUEST;
    $page = $_POST["page"];

    if($page == "reg"){
            $col = array(
        0   =>  'region_code',
        1   =>  'region_desc',
        2   =>  'psg_code',
        3   =>  'region_code',
    );  //create column step_desc table in database
    }

    if($page == "prov"){
            $col = array(
        0   =>  'province_code',
        1   =>  'region_desc',
        2   =>  'province_desc',
        3   =>  'psg_code',
        4   =>  'province_code',
    );  //create column step_desc table in database
    }

    if($page == "lgu"){
            $col = array(
        0   =>  'lgu_code',
        1   =>  'geo_bpls_lgu.province_code',
        2   =>  'psg_code',
        3   =>  'lgu_desc',
        4   =>  'lgu_zip',
        5   =>  'lgu_code',
    );  //create column step_desc table in database
    }

    if($page == "brgy"){
            $col = array(
        0   =>  'lgu_desc',
        1   =>  'barangay_desc',
        2   =>  'psg_code',
        3   =>  'barangay_id',
    );  //create column step_desc table in database
    }


    if($page == "reg"){
        $sql = "SELECT `region_code`, `region_desc`, `psg_code` FROM `geo_bpls_region` ";
    $query=mysqli_query($conn,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;
    //Search
        $sql ="SELECT `region_code`, `region_desc`, `psg_code` FROM `geo_bpls_region`   WHERE 1=1 ";

   
    if(!empty($request['search']['value'])){
        $sql.=" AND (region_code Like '%".$request['search']['value']."%' ";
        $sql.=" OR region_desc Like '%".$request['search']['value']."%' ) ";
    }
    }

     if($page == "prov"){
        $sql = "SELECT `region_desc`, `province_code`,  `province_desc`, geo_bpls_province.`psg_code` FROM `geo_bpls_province` inner join geo_bpls_region on geo_bpls_region.region_code = geo_bpls_province.region_code ";
    $query=mysqli_query($conn,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;
    //Search
        $sql ="SELECT `region_desc`, `province_code`,  `province_desc`, geo_bpls_province.`psg_code` FROM `geo_bpls_province` inner join geo_bpls_region on geo_bpls_region.region_code = geo_bpls_province.region_code  WHERE 1=1 ";

   
    if(!empty($request['search']['value'])){
        $sql.=" AND (province_code Like '%".$request['search']['value']."%' ";
        $sql.=" OR region_desc Like '%".$request['search']['value']."%'";
        $sql.=" OR psg_code Like '%".$request['search']['value']."%'";
        $sql.=" OR province_desc Like '%".$request['search']['value']."%' ) ";
    }
    }

     if($page == "lgu"){
        $sql = "SELECT `lgu_code`, `province_desc`, geo_bpls_lgu.`psg_code`, `lgu_desc`, `lgu_zip` FROM `geo_bpls_lgu` inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code ";
    $query=mysqli_query($conn,$sql);
    $totalData=mysqli_num_rows($query);
    $totalFilter=$totalData;
    //Search
        $sql ="SELECT `lgu_code`, `province_desc`, geo_bpls_lgu.`psg_code`, `lgu_desc`, `lgu_zip` FROM `geo_bpls_lgu` inner join geo_bpls_province on geo_bpls_province.province_code = geo_bpls_lgu.province_code WHERE 1=1 ";
   
    if(!empty($request['search']['value'])){
        $sql.=" AND (lgu_code Like '%".$request['search']['value']."%' ";
        $sql.=" OR province_desc Like '%".$request['search']['value']."%'";
        $sql.=" OR psg_code Like '%".$request['search']['value']."%'";
        $sql.=" OR lgu_desc Like '%".$request['search']['value']."%'";
        $sql.=" OR lgu_zip Like '%".$request['search']['value']."%' ) ";
    }
    }
    
    if ($page == "brgy") {
    $sql = "SELECT `lgu_desc`, `barangay_desc`, geo_bpls_barangay.`psg_code`, barangay_id FROM `geo_bpls_barangay` INNER JOIN geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code ";
    $query = mysqli_query($conn, $sql);
    $totalData = mysqli_num_rows($query);
    $totalFilter = $totalData;
    //Search
    $sql = "SELECT `lgu_desc`, `barangay_desc`, geo_bpls_barangay.`psg_code`, barangay_id FROM `geo_bpls_barangay` INNER JOIN geo_bpls_lgu on geo_bpls_lgu.lgu_code = geo_bpls_barangay.lgu_code WHERE 1=1 ";

    if (!empty($request['search']['value'])) {
        $sql .= " AND (lgu_desc Like '%" . $request['search']['value'] . "%' ";
        $sql .= " OR barangay_desc Like '%" . $request['search']['value'] . "%'";
        $sql .= " OR psg_code Like '%" . $request['search']['value'] . "%' ) ";
    }
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
    
    if($page == "reg"){
        $subdata[]= ($row[0]); 
        $subdata[]= ($row[1]); 
        $subdata[] = ($row[2]);
        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' ca_target ='bpls/delete_section/bpls_delete_address_settings.php?target=REG&val=".md5($row[0])."'  ca_title='".str_replace("'","&#8217;",($row[1]))."' ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' ca_loc='REG' ca_title='".str_replace("'","&#8217;",($row[1]))."' ca_data='".md5($row[0])."' ><i class='fa fa-edit'></i></button> </div>";
    }
    
    if($page == "prov"){
        $subdata[]= ($row[0]); 
        $subdata[]= ($row[1]); 
        $subdata[] = ($row[2]);
        $subdata[] = ($row[3]);
        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' ca_target ='bpls/delete_section/bpls_delete_address_settings.php?target=PROV&val=".md5($row[1])."'  ca_title='".str_replace("'","&#8217;",($row[2]))."' > <i class='fa fa-trash'></i></button><button class='btn btn-warning edit_btn' ca_loc='PROV' ca_title='".str_replace("'","&#8217;",($row[2]))."' ca_data='".md5($row[1])."' ><i class='fa fa-edit'></i></button> </div>";
    }
    
    if($page == "lgu"){
        $subdata[] = ($row[0]); 
        $subdata[] = ($row[1]); 
        $subdata[] = ($row[2]);
        $subdata[] = ($row[3]);
        $subdata[] = ($row[4]);
        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' ca_target ='bpls/delete_section/bpls_delete_address_settings.php?target=LGU&val=".md5($row[0])."'  ca_title='".str_replace("'","&#8217;",($row[3]))."' ><i class='fa fa-trash'></i></button><button class='btn btn-warning edit_btn' ca_loc='LGU' ca_title='".str_replace("'","&#8217;",($row[3]))."' ca_data='".md5($row[0])."' ><i class='fa fa-edit'></i></button>  </div>";
    }

    if($page == "brgy"){
        $subdata[] = ($row[0]); 
        $subdata[] = ($row[1]); 
        $subdata[] = ($row[2]);
        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' ca_target ='bpls/delete_section/bpls_delete_address_settings.php?target=BRGY&val=".md5($row[3])."'  ca_title='".str_replace("'","&#8217;",($row[1]))."' ><i class='fa fa-trash'></i></button><button class='btn btn-warning edit_btn' ca_loc='BRGY' ca_title='".str_replace("'","&#8217;",($row[1]))."' ca_data='".md5($row[3])."' ><i class='fa fa-edit'></i></button> </div>";
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