<?php
        include("../../jomar_assets/myquery_function.php");
        include('../../php/connect.php');
        $q = mysqli_query($conn, "SELECT `status` from geo_bpls_sync_status_ol where 1");
        $r = mysqli_fetch_assoc($q);
        $status = $r["status"];
        if ($status == "ON") {
            include '../../php/web_connection.php';
        }
        $settings_name = $_POST["settings_name"];
        $value = $_POST["value"];


      
        if($settings_name == "Citizenship"){
            delete_this($conn,"geo_bpls_citizenship","citizenship_id",$value);
        }
        if($settings_name == "Business Type"){
            delete_this($conn,"geo_bpls_business_type","business_type_code",$value);
        }
        if($settings_name == "Business Scale"){
            delete_this($conn,"geo_bpls_scale","scale_code",$value);
        }
        if($settings_name == "Business Sector"){
            delete_this($conn,"geo_bpls_sector","sector_code",$value);
        }
        if($settings_name == "Business Area"){
            delete_this($conn,"geo_bpls_economic_area","economic_area_code",$value);
        }
        if($settings_name == "Business Organization"){
            delete_this($conn,"geo_bpls_economic_org","economic_org_code",$value);
        }
        if($settings_name == "Occupancy"){
            delete_this($conn,"geo_bpls_occupancy","occupancy_code",$value);
        }
        if($settings_name == "Requirement"){
            delete_this($conn,"geo_bpls_requirement","requirement_id",$value);
        }
        if($settings_name == "Signatory"){
            delete_this($conn,"geo_bpls_signatory","signatory_id",$value);
        }
        if($settings_name == "Zone"){
            delete_this($conn,"geo_bpls_zone","zone_id",$value);
        }
        if($settings_name == "Nature"){
            delete_this($conn,"geo_bpls_nature","nature_id",$value);
        }
        if($settings_name == "Discount Formula") {
            delete_this($conn, "geo_bpls_discount", "discount_id", $value);
         }
         if($settings_name == "Discount Details") {
             delete_this($conn, "geo_bpls_discount_name", "discount_name_id", $value);
          }

        // Delete Online
        if($status == "ON"){
            if($settings_name == "Citizenship"){
            delete_this($wconn,"geo_bpls_citizenship","citizenship_id",$value);
        }
        if($settings_name == "Business Type"){
            delete_this($wconn,"geo_bpls_business_type","business_type_code",$value);
        }
        if($settings_name == "Business Scale"){
            delete_this($wconn,"geo_bpls_scale","scale_code",$value);
        }
        if($settings_name == "Business Sector"){
            delete_this($wconn,"geo_bpls_sector","sector_code",$value);
        }
        if($settings_name == "Business Area"){
            delete_this($wconn,"geo_bpls_economic_area","economic_area_code",$value);
        }
        if($settings_name == "Business Organization"){
            delete_this($wconn,"geo_bpls_economic_org","economic_org_code",$value);
        }
        if($settings_name == "Occupancy"){
            delete_this($wconn,"geo_bpls_occupancy","occupancy_code",$value);
        }
        if($settings_name == "Requirement"){
            delete_this($wconn,"geo_bpls_requirement","requirement_id",$value);
        }
        if($settings_name == "Signatory"){
            delete_this($wconn,"geo_bpls_signatory","signatory_id",$value);
        }
        if($settings_name == "Zone"){
            delete_this($wconn,"geo_bpls_zone","zone_id",$value);
        }
        if($settings_name == "Nature"){
            delete_this($wconn,"geo_bpls_nature","nature_id",$value);
        }
        if($settings_name == "Discount Formula") {
           delete_this($wconn, "geo_bpls_discount", "discount_id", $value);
        }
        if($settings_name == "Discount Details") {
            delete_this($wconn, "geo_bpls_discount_name", "discount_name_id", $value);
         }
        }
?>  