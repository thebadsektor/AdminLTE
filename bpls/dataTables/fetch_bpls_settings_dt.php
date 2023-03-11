<?php
session_start();
include '../../php/connect.php';
$settings_name = $_POST["settings_name"];

$username = $_SESSION["uname"];
$q = mysqli_query($conn, "SELECT module_permission from permission_tbl where uname= '$username' and module = 'MSWD Module' ");
$r = mysqli_fetch_assoc($q);
$module_permission = $r["module_permission"];
if ($module_permission == "Department Head") {
    $limiter = "";
} else {
    $limiter = "disabled";
}

// OWNER ---------------------------------------
if($settings_name == "Citizenship"){
    
    $request=$_REQUEST;
    $col = array(
        0   =>  'citizenship_id',
        1   =>  'citizenship_desc',
    );  //create column like table in database

    $sql ="SELECT `citizenship_id`, `citizenship_desc` FROM `geo_bpls_citizenship`";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT `citizenship_id`, `citizenship_desc` FROM `geo_bpls_citizenship` WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (citizenship_id Like '".$request['search']['value']."%' ";
        $sql.=" OR citizenship_desc Like '".$request['search']['value']."%' ) ";

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
        $subdata[]=$row[1];
        
        $alert_title = $row[1];

        $subdata[]= "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."' $limiter ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."'><i class='fa fa-edit'></i></button> </div>";

        
        
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Business Type"){
    // BUSINESSS
    $request=$_REQUEST;
    $col = array(
        0   =>  'business_type_code',
        1   =>  'business_type_desc',
        2   =>  'tax_exemption',
        3   =>  'business_type_code',

    );  //create column like table in database

    $sql ="SELECT `business_type_code`, `business_type_desc`, `tax_exemption` FROM `geo_bpls_business_type`";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT `business_type_code`, `business_type_desc`, `tax_exemption` FROM `geo_bpls_business_type` WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (business_type_code Like '%".$request['search']['value']."%' ";
        $sql.=" OR business_type_desc Like '%".$request['search']['value']."%'  ";
        $sql.=" OR tax_exemption Like '%".$request['search']['value']."%' ) ";

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
        
        $subdata[]=$row[1]; 
        $subdata[]=$row[2];
        $subdata[]=$row[0];
        
        $alert_title = $row[1];
        $subdata[]= "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."' $limiter ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."'><i class='fa fa-edit'></i></button> </div>"; 
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Business Scale"){
    // BUSINESSS
    $request=$_REQUEST;
    $col = array(
        0   =>  'scale_code',
        1   =>  'scale_desc',
    );  //create column like table in database

    $sql ="SELECT `scale_code`, `scale_desc` FROM `geo_bpls_scale`  ";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT `scale_code`, `scale_desc` FROM `geo_bpls_scale` WHERE 1=1 ";
    if(!empty($request['search']['value'])){
        $sql.=" AND (scale_code Like '".$request['search']['value']."%' ";
        $sql.=" OR scale_desc Like '".$request['search']['value']."%' ) ";

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

        $subdata[]=$row[0]; 
        $subdata[]=$row[1]; 
        $alert_title = $row[1];
        $subdata[]= "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."' $limiter ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."'><i class='fa fa-edit'></i></button> </div>";  
    
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Business Sector"){
    // BUSINESSS
    $request=$_REQUEST;
    $col = array(
        0   =>  'sector_code',
        1   =>  'sector_desc',
    );  //create column like table in database

    $sql ="SELECT `sector_code`, `sector_desc` FROM `geo_bpls_sector`";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT `sector_code`, `sector_desc` FROM `geo_bpls_sector` WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (sector_code Like '".$request['search']['value']."%' ";
        $sql.=" OR sector_desc Like '".$request['search']['value']."%' ) ";

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
        
        $subdata[]=$row[1]; 
        $alert_title = $row[1];
        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."' $limiter ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."'><i class='fa fa-edit'></i></button> </div>";
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Business Area"){
    // BUSINESSS
    $request=$_REQUEST;
    $col = array(
        0   =>  'economic_area_code',
        1   =>  'economic_area_desc',
        2   =>  'economic_area_code',

    );  //create column like table in database

    $sql ="SELECT `economic_area_code`, `economic_area_desc` FROM `geo_bpls_economic_area`";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT `economic_area_code`, `economic_area_desc` FROM `geo_bpls_economic_area` WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (economic_area_code Like '".$request['search']['value']."%' ";
        $sql.=" OR economic_area_desc Like '".$request['search']['value']."%' ) ";

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
        $subdata[]=$row[0]; 
        $subdata[]=$row[1]; 
        $alert_title = $row[1];
        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."' $limiter ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."'><i class='fa fa-edit'></i></button> </div>";
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Business Organization"){
    // BUSINESSS
    $request=$_REQUEST;
    $col = array(
        0   =>  'economic_org_code',
        1   =>  'economic_org_desc',
        2   =>  'economic_org_code',

    );  //create column like table in database

    $sql ="SELECT `economic_org_code`, `economic_org_desc` FROM `geo_bpls_economic_org`";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT `economic_org_code`, `economic_org_desc` FROM `geo_bpls_economic_org` WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (economic_org_code Like '".$request['search']['value']."%' ";
        $sql.=" OR economic_org_desc Like '".$request['search']['value']."%' ) ";

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
        
        $subdata[]=$row[0]; 
        $subdata[]=$row[1]; 
        $alert_title = $row[1];
        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."' $limiter ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."'><i class='fa fa-edit'></i></button> </div>";
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Occupancy"){
    // BUSINESSS
    $request=$_REQUEST;
    $col = array(
        0   =>  'occupancy_code',
        1   =>  'occupancy_desc',
        2   =>  'occupancy_code',
    );  //create column like table in database

    $sql ="SELECT `occupancy_code`, `occupancy_desc` FROM `geo_bpls_occupancy`";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT `occupancy_code`, `occupancy_desc` FROM `geo_bpls_occupancy` WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (economic_org_code Like '".$request['search']['value']."%' ";
        $sql.=" OR occupancy_desc Like '".$request['search']['value']."%' ) ";

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
        
        $subdata[]=$row[0]; 
        $subdata[]=$row[1]; 
        $alert_title = $row[1];
        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."' $limiter ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."'><i class='fa fa-edit'></i></button> </div>"; 
    
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Tax, Fee and other charges"){
    // BUSINESSS Permit -------------------------
    $request=$_REQUEST;
    $col = array(
        0   =>  'occupancy_code',
        1   =>  'occupancy_desc',
    );  //create column like table in database

    $sql ="SELECT `occupancy_code`, `occupancy_desc` FROM `geo_bpls_occupancy`";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT `occupancy_code`, `occupancy_desc` FROM `geo_bpls_occupancy` WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (economic_org_code Like '".$request['search']['value']."%' ";
        $sql.=" OR occupancy_desc Like '".$request['search']['value']."%' ) ";

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
        
        $subdata[]=$row[0]; 
        $subdata[]=$row[1]; 
    
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Requirement"){
    // BUSINESSS Permit -------------------------
    $request=$_REQUEST;
    $col = array(
        0   =>  'requirement_desc',
        1   =>  'reference_module',
        2   =>  'requirement_default',
        3   =>  'requirement_id',

    );  //create column like table in database

    $sql ="SELECT `requirement_id`, `requirement_default`, `requirement_desc` , reference_module FROM `geo_bpls_requirement`";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT `requirement_id`, `requirement_default`, `requirement_desc`, reference_module FROM `geo_bpls_requirement` WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (requirement_id Like '".$request['search']['value']."%' ";
        $sql.=" OR requirement_default Like '".$request['search']['value']."%'  ";
        $sql.=" OR requirement_desc Like '".$request['search']['value']."%' ) ";

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
        
        $subdata[]=$row[2]; 
        $subdata[] = $row[3];

        if($row[1] == 0){
            $subdata[]= "<span class='text-success'>Activated</span>"; 
        }else{
            $subdata[]= "<span class='text-danger'>Deactivated</span>"; 
        }
      

        $alert_title = $row[2];
        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."' $limiter ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[0])."'><i class='fa fa-edit'></i></button> </div>"; 
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Nature"){
    // BUSINESSS Permit -------------------------
    $request=$_REQUEST;
    $col = array(
        0   =>  'nature_desc',
        1   =>  'nature_id',

    );  //create column like table in database

    $sql ="SELECT `nature_desc`, `nature_id` FROM `geo_bpls_nature`";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT `nature_desc`, `nature_id`FROM `geo_bpls_nature` WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (nature_id Like '".$request['search']['value']."%' ";
        $sql.=" OR nature_desc Like '".$request['search']['value']."%' ) ";

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
        
        $subdata[]=$row[0]; 
        
        $alert_title = $row[0];
        $subdata[] = "<div class='btn-group' > <button type='button' class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[1])."' $limiter ><i class='fa fa-trash'></i></button> <button  type='button' class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[1])."'><i class='fa fa-edit'></i></button> </div>"; 
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Penalty (Interest/Surcharges)"){
    // BUSINESSS Permit -------------------------
    $request=$_REQUEST;
    $col = array(
        0   =>  'payment_frequency_code',
        1   =>  'interest_activate',
        2   =>  'interest_mode',
        3   =>  'interest_on',
        4   =>  'interest_rate',
        5   =>  'penalty_remark',
        6   =>  'renewal_date',
        7   =>  'surcharge_mode',
        8   =>  'surcharge_on',
        9   =>  'surcharge_rate',
    );  //create column like table in database

    $sql ="SELECT  `payment_frequency_code`, `interest_activate`, `interest_mode`, `interest_on`, `interest_rate`, `penalty_remark`, `renewal_date`, `surcharge_mode`, `surcharge_on`, `surcharge_rate` FROM `geo_bpls_penalty`  ";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT  `payment_frequency_code`, `interest_activate`, `interest_mode`, `interest_on`, `interest_rate`, `penalty_remark`, `renewal_date`, `surcharge_mode`, `surcharge_on`, `surcharge_rate` FROM `geo_bpls_penalty`   WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (payment_frequency_code Like '".$request['search']['value']."%' ";
        $sql.=" OR interest_activate Like '".$request['search']['value']."%'  ";
        $sql.=" OR interest_mode Like '".$request['search']['value']."%'  ";
        $sql.=" OR interest_on Like '".$request['search']['value']."%'  ";
        $sql.=" OR penalty_remark Like '".$request['search']['value']."%'  ";
        $sql.=" OR renewal_date Like '".$request['search']['value']."%'  ";
        $sql.=" OR surcharge_mode Like '".$request['search']['value']."%'  ";
        $sql.=" OR surcharge_on Like '".$request['search']['value']."%' ";
        $sql.=" OR surcharge_rate Like '".$request['search']['value']."%' ) ";

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
        
        if($row[0] == "SEM" ){ 
            $subdata[]= "Semi-annual"; 
        }elseif($row[0] == "ANN" ){
            $subdata[]= "Annual"; 
        }elseif($row[0] == "QUA" ){
            $subdata[]= "Quarterly"; 
        }
        $subdata[]=$row[1]; 
        $subdata[]=$row[2]; 
        $subdata[]=$row[3]; 
        $subdata[]=$row[4]; 
        $subdata[]=$row[5]; 
        $subdata[]=$row[6]; 
        $subdata[]=$row[7]; 
        $subdata[]=$row[8]; 
        $subdata[]=$row[9]; 
    
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Signatory"){
    // BUSINESSS Permit -------------------------
    $request=$_REQUEST;
    $col = array(
        0   =>  'signatory_name',
        1   =>  'signatory_office',
        2   =>  'signatory_position',
        3   =>  'signatory_id',
    );  //create column like table in database

    $sql ="SELECT  `signatory_name`, `signatory_office`, `signatory_position`,signatory_id FROM `geo_bpls_signatory`   ";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT  `signatory_name`, `signatory_office`, `signatory_position`,signatory_id FROM `geo_bpls_signatory`   WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (signatory_name Like '".$request['search']['value']."%' ";
        $sql.=" OR signatory_office Like '".$request['search']['value']."%'  ";
        $sql.=" OR signatory_position Like '".$request['search']['value']."%' ) ";

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
        $subdata[]=$row[0]; 
        $subdata[]=$row[1]; 
        $subdata[]=$row[2]; 
        $alert_title = $row[0];
        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".$row[3]."' $limiter ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".$row[3]."'><i class='fa fa-edit'></i></button> </div>"; 
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Zone"){
    // BUSINESSS Permit -------------------------
    $request=$_REQUEST;
    $col = array(
        0   =>  'barangay_id',
        1   =>  'garbage_zone',
        2   =>  'zone_desc',
        3   =>  'zone_id',
    );  //create column like table in database

    $sql ="SELECT  `barangay_id`, `garbage_zone`, `zone_desc`,`zone_id` FROM `geo_bpls_zone`  ";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT  `barangay_id`, `garbage_zone`, `zone_desc`,`zone_id` FROM `geo_bpls_zone`   WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND (barangay_id Like '".$request['search']['value']."%' ";
        $sql.=" OR garbage_zone Like '".$request['search']['value']."%'  ";
        $sql.=" OR zone_desc Like '".$request['search']['value']."%'  ";
        $sql.=" OR zone_id Like '".$request['search']['value']."%' ) ";

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
        
     
        $subdata[]=$row[0]; 
        $subdata[]=$row[1]; 
        $subdata[]=$row[2]; 
        $alert_title = $row[2];
        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".$row[3]."' $limiter ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".$row[3]."'><i class='fa fa-edit'></i></button> </div>"; 
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Discount Details"){
    // BUSINESSS Permit -------------------------
    $request=$_REQUEST;
    $col = array(
        0   =>  'discount_name',
        1   =>  'discount_date',
        2   =>  'discount_status',
        3   =>  'discount_name_id',
    );  //create column like table in database

    $sql ="SELECT `discount_name`, `discount_date`, `discount_status`,`discount_name_id` FROM `geo_bpls_discount_name` ";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql =" SELECT `discount_name`, `discount_date`, `discount_status`,`discount_name_id` FROM `geo_bpls_discount_name` WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND ( discount_name Like '".$request['search']['value']."%' ";
        $sql.=" OR discount_date Like '".$request['search']['value']."%'  ";
        $sql.=" OR discount_status Like '".$request['search']['value']."%'  ";
        $sql.=" OR discount_name_id Like '".$request['search']['value']."%' ) ";

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
        
     
        $subdata[]=$row[0]; 
        $subdata[]=$row[1]; 
        if($row[2] == 1){
            $subdata[] = "
                    <select class='discount_selection_set' id='".md5($row[3])."'> 
                        <option value='1' selected> Activate </option>
                        <option value='0'> Deactivate </option>
                    </select>" ; 
        }else{
            $subdata[] = "
                    <select class='discount_selection_set' id='".md5($row[3])."'> 
                        <option value='1' > Activate </option>
                        <option value='0' selected> Deactivate </option>
                    </select>" ; 
        }

        $alert_title = $row[0];

        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[3])."' $limiter ><i class='fa fa-trash'></i></button>  </div>"; 
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}elseif($settings_name == "Discount Formula"){
    // BUSINESSS Permit -------------------------
    $request=$_REQUEST;
    $col = array(
        0   =>  'discount_name',
        1   =>  'discount_amount',
        2   =>  'sub_account_title',
        3   =>  'discount_id',
    );  //create column like table in database

    $sql ="SELECT `discount_name`, `discount_amount`, natureOfCollection_tbl.id as sub_account_no, `nature_id`  ,discount_id, natureOfCollection_tbl.name as sub_account_title FROM `geo_bpls_discount` inner join geo_bpls_discount_name on geo_bpls_discount_name.discount_name_id = geo_bpls_discount.discount_name_id inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_discount.sub_account_no ";
    $query=mysqli_query($conn,$sql);

    $totalData=mysqli_num_rows($query);

    $totalFilter=$totalData;

    //Search
    $sql ="SELECT `discount_name`, `discount_amount`, natureOfCollection_tbl.id as sub_account_no, `nature_id`  ,discount_id, natureOfCollection_tbl.name as sub_account_title FROM `geo_bpls_discount` inner join geo_bpls_discount_name on geo_bpls_discount_name.discount_name_id = geo_bpls_discount.discount_name_id inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_discount.sub_account_no WHERE 1=1";
    if(!empty($request['search']['value'])){
        $sql.=" AND ( discount_name Like '".$request['search']['value']."%' ";
        $sql.=" OR discount_name Like '".$request['search']['value']."%'  ";
        $sql.=" OR sub_account_title Like '".$request['search']['value']."%' ) ";

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
        
     
        $subdata[]=$row[0]; 
        $subdata[]=$row[1]; 
        $subdata[]=$row[5]; 

        $alert_title = $row[0];

        $subdata[] = "<div class='btn-group' > <button class='btn btn-danger delete_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[4])."' $limiter ><i class='fa fa-trash'></i></button> <button class='btn btn-warning edit_btn' data-alert-title='".$alert_title."' data-settings-name='".$settings_name."' data-value='".md5($row[4])."'><i class='fa fa-edit'></i></button> </div>"; 
        $data[]=$subdata;
    }

    $json_data=array(
        "draw"              =>  intval($request['draw']),
        "recordsTotal"      =>  intval($totalData),
        "recordsFiltered"   =>  intval($totalFilter),
        "data"              =>  $data
    );
    echo json_encode($json_data);
}

?>
