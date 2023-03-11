<?php
include("../../jomar_assets/myquery_function.php");
include('../../php/connect.php');

    $ca_loc = $_POST["ca_loc"];
    $ca_data = $_POST["ca_data"];

    if($ca_loc == "REG"){
        $q = mysqli_query($conn,"SELECT * from geo_bpls_region where md5(region_code) ='$ca_data' ");
        $r = mysqli_fetch_assoc($q);
        echo '<form method="POST" action="" >
                    <div class="form-group">
                        <label for="">Region Code:</label>
                        <input type="text" class="form-control" name="reg_code" value="'.$r["region_code"].'" required>
                        <input type="hidden" class="form-control" name="reg_code1" value="'.$r["region_code"].'" required>
                    </div>
                    <div class="form-group">
                        <label for="">Region Desc:</label>
                        <input type="text" class="form-control" name="reg_desc" value="'.$r["region_desc"].'" required>
                    </div>
                    <div class="form-group">
                         <label for="">Psg Code:</label>
                        <input type="text" class="form-control" name="psg_code" value="'.$r["psg_code"].'" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="form-control btn btn-success" value="Update" name="up_reg_btn" >
                    </div>         
   </form>';
    }

    if($ca_loc == "PROV"){
        $q = mysqli_query($conn,"SELECT * from geo_bpls_province where md5(province_code) = '$ca_data' ");
        $r = mysqli_fetch_assoc($q);
        echo '<form method="POST" action="">
                             <div class="form-group">
                                    <label for="">Region:</label>
                                   <select name="reg_code" id="reg_in_prov" class="form-control selectpicker" required>
                                        <option value="">--Select Region--</option>';
                                            $q2 = mysqli_query($conn,"SELECT * from geo_bpls_region");
                                            while($r2 = mysqli_fetch_assoc($q2)){
                                                echo '<option value="'.$r2["region_code"].'" '; if($r2["region_code"] == $r["region_code"] ){ echo 'selected'; } echo '>'.$r2["region_desc"].'  </option>';
                                            }
                                   echo '</select>
                             </div>
                             <div class="form-group">
                                    <label for="">Province Code:</label>
                                    <input type="text" class="form-control" name="prov_code" value="'.$r["province_code"].'" required>
                                    <input type="hidden" class="form-control" name="prov_code1" value="'.$r["province_code"].'" required>
                             </div>
                             <div class="form-group">
                                    <label for="">Province Desc:</label>
                                    <input type="text" class="form-control" name="prov_desc"  value="'.$r["province_desc"].'" required>
                             </div>
                             <div class="form-group">
                                    <label for="">Psg Code:</label>
                                    <input type="text" class="form-control" name="psg_code"  value="'.$r["psg_code"].'" required>
                             </div>
                             <div class="form-group">
                                    <input type="submit" class="form-control btn btn-success"  name="up_prov_btn"  value="Update" >
                             </div>         
                        </form>';
    }

  if($ca_loc == "LGU"){
    $q1 = mysqli_query($conn, "SELECT * from geo_bpls_lgu where md5(lgu_code) = '$ca_data' ");
    $r1 = mysqli_fetch_assoc($q1);

    echo '<form method="POST" action="">
                             <div class="form-group">
                                    <label for="">Province:</label>
                                   <select name="prov_code" class="form-control selectpicker" id="prov_in_lgu" required>
                                        <option value="">--Select Province--</option>';
                                            $q = mysqli_query($conn,"SELECT * from 	geo_bpls_province");
                                            while($r = mysqli_fetch_assoc($q)){
                                            ?>
                                           <option value="<?php echo $r["province_code"];  ?>" <?php if($r1["province_code"] == $r["province_code"] ){ echo 'selected'; } ?> > <?php echo $r["province_desc"];  ?>  </option>
                                            <?php
                                            }
                                  echo ' </select>
                             </div>
                             <div class="form-group">
                                    <label for="">LGU Code:</label>
                                    <input type="text" class="form-control" name="lgu_code" value="'.$r1["lgu_code"].'" required>
                                     <input type="text" class="form-control" name="lgu_code1" value="'.$r1["lgu_code"].'" required>
                             </div>
                             <div class="form-group">
                                    <label for="">LGU Desc:</label>
                                    <input type="text" class="form-control" name="lgu_desc" value="'.$r1["lgu_desc"].'" required>
                             </div>
                             <div class="form-group">
                                    <label for="">Psg Code:</label>
                                    <input type="text" class="form-control" name="psg_code"  value="'.$r1["psg_code"].'" required>
                             </div>
                             <div class="form-group">
                                    <label for="">LGU zip:</label>
                                    <input type="text" class="form-control" name="lgu_zip"  value="'.$r1["lgu_zip"].'"   required>
                             </div>
                             <div class="form-group">
                                    <input type="submit" class="form-control btn btn-success"  name="up_lgu_btn"  value="Update" >
                             </div>         
                        </form>';
  }  
if($ca_loc == "BRGY"){

    $q1 = mysqli_query($conn, "SELECT * from geo_bpls_barangay where md5(barangay_id) = '$ca_data' ");
    $r1 = mysqli_fetch_assoc($q1);

  echo '<form method="POST" action="">
                             <div class="form-group">
                                    <label for="">Province:</label>
                                   <select name="prov_code" class="form-control selectpicker" id="prov_in_brgy_u" >
                                       <option value="">--Select Province--</option>';
                                            $q = mysqli_query($conn,"SELECT * from 	geo_bpls_province");
                                            while($r = mysqli_fetch_assoc($q)){
                                                ?>
                                            <option value="<?php echo $r["province_code"];  ?>"  > <?php echo $r["province_desc"];  ?>  </option>
                                                <?php
                                            }
                                   echo '</select>
                             </div>
                             <div class="form-group">
                                    <label for="">Lgu:</label>
                                   <select name="lgu_code" class="form-control selectpicker" id="lgu_in_brgy_u" required>
                                        <option value="">--Select Province First--</option>';
                                    $q22 = mysqli_query($conn,"SELECT * from geo_bpls_lgu");
                                            while($r22 = mysqli_fetch_assoc($q22)){
                                                ?>
                                            <option value="<?php echo $r22["lgu_code"];  ?>" <?php if($r1["lgu_code"] == $r22["lgu_code"] ){ echo 'selected'; } ?> > <?php echo $r22["lgu_desc"];  ?>  </option>
                                                <?php
                                            }
                                   echo '</select>
                             </div>
                             <div class="form-group">
                                    <label for="">Barangay Desc:</label>
                                    <input type="text" class="form-control" name="brgy_desc" value="'.$r1["barangay_desc"].'" required>
                                    <input type="hidden" class="form-control" name="barangay_id" value ="'.$r1["barangay_id"].'"  required>
                             </div>
                             <div class="form-group">
                                    <label for="">Psg Code:</label>
                                    <input type="text" class="form-control" name="psg_code" value ="'.$r1["psg_code"].'" required>
                             </div>
                             
                             <div class="form-group">
                                    <input type="submit" class="form-control btn btn-success"  name="up_brgy_btn" value="Update" >
                             </div>         
                        </form>';
  }
?>