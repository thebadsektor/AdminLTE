<?php
include '../php/connect.php';

function random_color_part()
{
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}
function random_color()
{
    return random_color_part() . random_color_part() . random_color_part();
}
$data = array();

$query = mysqli_query($conn, "SELECT sum(payment_total_amount_paid) as tot_income, payment_year FROM `geo_bpls_payment` GROUP BY payment_year  
ORDER BY `geo_bpls_payment`.`payment_year` ASC limit 5") or die(mysqli_error());
while ($row = mysqli_fetch_assoc($query)) {
    $color = random_color();
    $data["label"][] = $row['payment_year'];
    $data["data"][] = $row['tot_income'];
    $data["backgroundColor"][] = "#".$color;
    // array_push($data, [
    //     'label' => $row['payment_year'],
    //     'data' => $row['tot_income'],
    //     'backgroundColor' => "#" . $color,
    // ]);
}
$query = mysqli_query($conn, "SELECT count(permit_for_year) as tcount, permit_for_year FROM `geo_bpls_business_permit` WHERE step_code ='RELEA'  GROUP BY permit_for_year  
ORDER BY `permit_for_year` ASC limit 5") or die(mysqli_error());
while ($row = mysqli_fetch_assoc($query)) {
    $color = random_color();
    $data["label2"][] = $row['permit_for_year'];
    $data["data2"][] = $row['tcount'];
    $data["backgroundColor"][] = "#".$color;
    // array_push($data, [
    //     'label' => $row['payment_year'],
    //     'data' => $row['tot_income'],
    //     'backgroundColor' => "#" . $color,
    // ]);
}

$json = json_encode($data);
echo $json;
