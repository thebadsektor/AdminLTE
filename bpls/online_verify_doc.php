<?php
include '../php/web_connection.php';
$r_id = $_POST["r_id"];
$uniqID = $_POST["uniqID"];
$br_id = $_POST["br_id"];

$q = mysqli_query($wconn, "SELECT * from geo_bpls_business_requirement_ol where md5(business_requirement_id) = '$br_id' and  md5(requirement_id) = '$r_id' and uniqID = '$uniqID' ");

if (mysqli_num_rows($q) > 0) {
    $r = mysqli_fetch_assoc($q);

    if ($r["requirement_file"] == "") {
        echo "No uploaded files!";
        exit();
        return 0;
    }

    if ($r["requirement_status"] == 0) {
        echo '<div class="row">
                <div class="col-md-12">
                    ' . $r["comment"] . '
                </div>
        </div>';
    } elseif ($r["requirement_status"] == 2) {
        if($r["comment"] != ""){
             echo '<div class="row">
                <div class="col-md-12">
                <label>Comments:</label>
                <div class="alert alert-danger">
                    ' . $r["comment"] . '
                </div>
                </div>
        </div>';
        }
    }

    // check kung images
    if (strpos($r["requirement_file"], 'jpg') !== false) {
        echo "<img src='https://majayjay.com/eServices/bpls/bpls_files/" . $r["requirement_file"] . "' width='100%'  height='60%' >";
    } else {
        echo '<embed src="https://majayjay.com/eServices/bpls/bpls_files/' . $r["requirement_file"] . '" width="100%" height="400" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">';
    }

} else {
    echo "No uploaded files!";
}
