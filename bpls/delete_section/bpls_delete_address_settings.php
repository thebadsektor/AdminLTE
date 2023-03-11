<?php
        include("../../jomar_assets/myquery_function.php");
        include('../../php/connect.php');

        $target = $_GET["target"];
        $value = $_GET["val"];

        if($target == "REG"){
            delete_this($conn,"geo_bpls_region","region_code",$value);
            ?>
        <script>
            alert("Region Successfully Deleted!");
            window.location.replace("../../bplsmodule.php?redirect=address_settings");
        </script>
        <?php
        }
       
        if($target == "PROV"){
            delete_this($conn,"geo_bpls_province","province_code",$value);
            ?>
        <script>
            alert("Province Successfully Deleted!");
            window.location.replace("../../bplsmodule.php?redirect=address_settings");
        </script>
        <?php
        }

        if($target == "LGU"){
            delete_this($conn,"geo_bpls_lgu","lgu_code",$value);
            ?>
        <script>
            alert("LGU Successfully Deleted!");
            window.location.replace("../../bplsmodule.php?redirect=address_settings");
        </script>
        <?php
        }

        if($target == "BRGY"){
            delete_this($conn,"geo_bpls_barangay","barangay_id",$value);
            ?>
        <script>
            alert("Barangay Successfully Deleted!");
            window.location.replace("../../bplsmodule.php?redirect=address_settings");
        </script>
        <?php
        }
?>  