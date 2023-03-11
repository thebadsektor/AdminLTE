<?php
session_start();
include '../../php/connect.php';
include '../../jomar_assets/enc.php';

// OWNER ---------------------------------------

$request = $_REQUEST;
$col = array(
    0 => 'order_no',
    1 => 'customer_name',
    2 => 'customer_email',
    3 => 'product_description',
    4 => 'transaction_time',
    5 => 'reference_no',
    6 => 'amount',
    7 => 'status',
    8 => 'id',

); //create column step_desc table in database

$sql = "SELECT  `order_no`,`customer_name`, `customer_email`,`product_description`, `transaction_time`, `reference_no`, `amount`,   `status`, id  FROM `myeg_data` where product_description = 'BPLS' ";

$query = mysqli_query($conn, $sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

//Search
$sql = "SELECT  `order_no`,`customer_name`, `customer_email`,`product_description`, `transaction_time`, `reference_no`, `amount`,   `status`, id  FROM `myeg_data` where product_description = 'BPLS' ";

if (!empty($request['search']['value'])) {
    $sql .= " AND (`name` Like '%" . $request['search']['value'] . "%' ";

    $sql .= " OR b_name Like '%" . $request['search']['value'] . "%' ";
    $sql .= " OR status Like '%" . $request['search']['value'] . "%' ) ";
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
    $subdata[] = $row[4];
    $subdata[] = $row[5];
    $subdata[] = $row[6];
    $subdata[] = $row[7];
    
    // check if na update na order payment
    $order_no = $row[0];
    $q6567 = mysqli_query($conn,"SELECT * FROM `geo_bpls_paid_online` where order_no = '$order_no'  ");
    $q6567_count = mysqli_num_rows($q6567);

    if($row[7] == "success"){
    if($q6567_count > 0){
        $subdata[] = "<button  order_no='".$order_no."'  data-toggle='modal' data-target='#modal_view' class='btn btn-info view_btn' >VIEW</button> ";
    }else{
        $subdata[] = "<a href='bplsmodule.php?redirect=order_payment_verification&order_no=".$row[0]."' class='btn btn-warning' >UPDATE</a> ";
    }}else{
        $subdata[] = "<a href='#' class='btn btn-warning' disabled>UPDATE</a> ";
    }
    
    $data[] = $subdata;
}

$json_data = array(
    "draw" => intval($request['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFilter),
    "data" => $data,
);
echo json_encode($json_data);
