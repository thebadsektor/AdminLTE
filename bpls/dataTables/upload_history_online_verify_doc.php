<?php
include('../php/connect.php');

$requirements_history_id = $_POST["requirements_history_id"];

$q = mysqli_query($conn, "SELECT * from geo_bpls_uploaded_requirements_history where requirements_history_id = '$requirements_history_id' ");

if (mysqli_num_rows($q) > 0) {
    $r = mysqli_fetch_assoc($q);

    if ($r["file_name"] == "") {
        echo "No uploaded files!";
        exit();
        return 0;
    }else{
         // check kung images
        if (strpos($r["file_name"], 'jpg') !== false) {
            echo "<img src='bpls/images_file/bpls_requirements/" . $r["file_name"] . "' width='100%'  height='60%' >";
        } else {
            echo '<embed src="bpls/images_file/bpls_requirements/' . $r["file_name"] . '" width="100%" height="400" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">';
        }
    }


   

} else {
    echo "No uploaded files!";
}
