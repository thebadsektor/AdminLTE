<?php
    session_start();
    include('../php/connect.php');
    include("../jomar_assets/input_validator.php");
    
    $val = $_POST["val"];
    $target = $_POST["target"];

    if($target == "REG"){
        $q = mysqli_query($conn,"SELECT * from geo_bpls_province where region_code = '$val' ");
        echo "<option value='' > --Select Province--</option>";
        while($r = mysqli_fetch_assoc($q)){
            ?>
             <option value="<?php echo $r["province_code"];  ?>"> <?php echo $r["province_desc"];  ?></option>  
            <?php
        }
    }

    if($target == "PROV"){
        $q = mysqli_query($conn,"SELECT * from geo_bpls_lgu where province_code = '$val' ");
        echo "<option value='' > --Select LGU--</option>";
        while($r = mysqli_fetch_assoc($q)){
            ?>
             <option value="<?php echo $r["lgu_code"];  ?>"> <?php echo $r["lgu_desc"];  ?></option>  
            <?php
        }
    }

?>