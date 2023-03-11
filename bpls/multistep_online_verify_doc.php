<?php
include('../php/connect.php');

$requirement_id = $_POST["requirement_id"];
$business_id = $_POST["business_id"];
$permit_id = $_POST["permit_id"];

// check if permit_id nag exist o nangaling sa Online


$q66 = mysqli_query($conn,"SELECT * FROM `geo_bpls_ol_application` where permit_id = '$permit_id' ");

$q = mysqli_query($conn, "SELECT * from geo_bpls_business_requirement where business_id = '$business_id' and requirement_id = '$requirement_id' ");

// 
if (mysqli_num_rows($q) > 0) {
    $r = mysqli_fetch_assoc($q);

        if(substr($r["requirement_file"],0,1) == "O"){
            if (strpos($r["requirement_file"], 'jpg') !== false || strpos($r["requirement_file"], 'png') !== false || strpos($r["requirement_file"], 'jpeg') !== false) {
                echo "<img src='https://majayjay.com/eServices/bpls/bpls_files/" . $r["requirement_file"] . "' width='100%'  height='60%' >";
            } else {
                echo '<embed src="https://majayjay.com/eServices/bpls/bpls_files/' . $r["requirement_file"] . '" width="100%" height="400" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">';
            }
        }else{
              // check kung images
            if (strpos($r["requirement_file"], 'jpg') !== false) {
                echo "<img src='bpls/images_file/bpls_requirements/" . $r["requirement_file"] . "' width='100%'  height='60%' >";
            } else {
                echo '<embed src="bpls/images_file/bpls_requirements/' . $r["requirement_file"] . '" width="100%" height="400" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">';
            }
        }
   

} else {
    echo "No uploaded files!";
}
