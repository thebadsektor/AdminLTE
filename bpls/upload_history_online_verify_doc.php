<?php
session_start();

$requirements_history_id = $_POST["requirements_history_id"];
$transaction_status = $_POST["transaction_status"];
$filename = $_POST["filename"];

if($transaction_status == 2 ){
    include('../php/connect.php');

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


   $filename = $r["file_name"];

} else {
    echo "No uploaded files!";

}
}else{
  
    include '../php/web_connection.php';
    $q = mysqli_query($wconn, "SELECT * from geo_bpls_business_requirement_ol where requirement_file = '$filename' ");
    
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
        $filename = $r["requirement_file"];
        // check kung images
        if (strpos($r["requirement_file"], 'jpg') !== false) {
            echo "<img src='https://majayjay.com/eServices/bpls/bpls_files/" . $r["requirement_file"] . "' width='100%'  height='60%' >";
        } else {
            echo '<embed src="https://majayjay.com/eServices/bpls/bpls_files/' . $r["requirement_file"] . '" width="100%" height="400" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">';
        }
    
    } else {
        echo "No uploaded files!";
    }
    
}


   // Audit Trail =====================================================================================
    // Audit Trail =====================================================================================
    // Audit Trail =====================================================================================
    $au_username = $_SESSION["uname"];
    $au_action = "View Files";
    $au_desc = "View Uploaded Documents with the filename of >".$filename;
    mysqli_query($conn,"INSERT INTO `geo_bpls_audit_trail`(`username`, `action`, `description`) VALUES ('$au_username','$au_action','$au_desc') ");
// Audit Trail =====================================================================================
// Audit Trail =====================================================================================
// Audit Trail ===================================================================================== 

