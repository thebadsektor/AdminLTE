
<?php
        include("../../jomar_assets/myquery_function.php");
        include('../../php/connect.php');
        $q = mysqli_query($conn, "SELECT `status` from geo_bpls_sync_status_ol where 1");
        $r = mysqli_fetch_assoc($q);
        $status = $r["status"];
        
        if($status == "ON") {
            include '../../php/web_connection.php';
        }

        $target = $_GET["target"];
        
$q55 = mysqli_query($conn, "SELECT tfo_nature_id,indicator_code from geo_bpls_tfo_nature where md5(nature_id) = '$target'");
while ($r55 = mysqli_fetch_assoc($q55)) {
    $tfo_nature_id = $r55["tfo_nature_id"];
    if ($r55["indicator_code"] == "R") {
        mysqli_query($conn, "DELETE FROM `geo_bpls_tfo_range` WHERE tfo_nature_id = '$tfo_nature_id'");
        mysqli_query($conn, "DELETE FROM `geo_bpls_tfo_nature` WHERE tfo_nature_id = '$tfo_nature_id'");
        if($status== "ON"){
            mysqli_query($wconn, "DELETE FROM `geo_bpls_tfo_nature` WHERE tfo_nature_id = '$tfo_nature_id'");
        }
    } else {
        mysqli_query($conn, "DELETE FROM `geo_bpls_tfo_nature` WHERE tfo_nature_id = '$tfo_nature_id'");
         if($status== "ON"){
           mysqli_query($wconn, "DELETE FROM `geo_bpls_tfo_nature` WHERE tfo_nature_id = '$tfo_nature_id'");
        }
    }
}

    mysqli_query($conn, "DELETE FROM `geo_bpls_nature` WHERE md5(nature_id) = '$target'");

    if($status == "ON"){
        mysqli_query($wconn, "DELETE FROM `geo_bpls_nature` WHERE md5(nature_id) = '$target'");
    }
        
?>

 <script>
    alert("Tax/Fee Successfully Deleted!");
    // window.location.replace("../../bplsmodule.php?redirect=tax_fees");
 </script>