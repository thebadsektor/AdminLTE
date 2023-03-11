<?php
session_start();
include '../../php/connect.php';
include '../../jomar_assets/enc.php';

// OWNER ---------------------------------------

$request = $_REQUEST;
$col = array(
    0 => 'file_name',
    1 => 'owner_name',
    2 => 'business_name',
    3 => 'docs_type',
    4 => 'transaction_status',
    5 => 'date_application',
    6 => 'requirements_history_id',
    7 => 'file_name',
); //create column step_desc table in database

$sql = "SELECT `file_name`, `owner_name`, `business_name`, `docs_type`, `transaction_status`, `date_application` , `requirements_history_id`, `file_name`  FROM `geo_bpls_uploaded_requirements_history` ";

$query = mysqli_query($conn, $sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

//Search
$sql = "SELECT `file_name`,`owner_name`, `business_name`, `docs_type`, `transaction_status`,  `date_application` , `requirements_history_id` , `file_name`  FROM `geo_bpls_uploaded_requirements_history` where 1=1 ";

if (!empty($request['search']['value'])) {
    $sql .= " AND (`business_name` Like '%" . $request['search']['value'] . "%' ";
    $sql .= " OR docs_type Like '%" . $request['search']['value'] . "%' ";
    $sql .= " OR file_name Like '%" . $request['search']['value'] . "%' ";
    $sql .= " OR date_application Like '%" . $request['search']['value'] . "%' ";
    $sql .= " OR owner_name Like '%" . $request['search']['value'] . "%' ) ";
}

$query = mysqli_query($conn, $sql);
$totalData = mysqli_num_rows($query);

//Order
$sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "  LIMIT " .
    $request['start'] . "  ," . $request['length'] . "  ";

$query = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($query)) {
    $subdata = array();

    $subdata[] = $row[0];
    $subdata[] = $row[1];
    $subdata[] = $row[2];
    $subdata[] = $row[3];
    if($row[4] == 2){
        $subdata[] = "Local Uploading";

    }else{
        $subdata[] = "Online Uploading";
    }
    $subdata[] = $row[5];
    $subdata[] = '<button type="button" class="btn btn-info  view_doc_btn" style="margin-top:5px;"  filename="'.$row[7].'" transaction_status="'.$row[4].'" requirements_history_id="'.$row[6].'"   data-toggle="modal" data-target="#view_doc" > view</button>';
    $data[] = $subdata;
}

$json_data = array(
    "draw" => intval($request['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFilter),
    "data" => $data,
);
echo json_encode($json_data);
