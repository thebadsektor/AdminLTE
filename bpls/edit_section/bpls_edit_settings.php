<?php
        include('../../php/connect.php');

        $settings_name = $_POST["settings_name"];
        $value = $_POST["value"];

        if($settings_name == "Citizenship"){
            $query = mysqli_query($conn,"SELECT * from geo_bpls_citizenship where MD5(citizenship_id) = '$value' ");

            $row = mysqli_fetch_assoc($query);
            echo "
            <div class='box-body' style='background:#e6e6e6;'>
                <form method='POST' action=''>
                    <div class='form-group'>
                        <label>Citizenship</label>
                        <input type='text' name='i1_e' value='".$row['citizenship_desc']."' class='form-control' required>
                        <input type='hidden' name='hi1_e' value='".$value."' >
                    </div>
                    <div class='form-group'>
                        <button type='submit' name='citizenship_btn_e'  class='btn btn-success pull-right'>Update</button>
                    </div>
                </form>
            </div>
            ";
        }
        
        if($settings_name == "Business Type"){
            $query = mysqli_query($conn,"SELECT * from geo_bpls_business_type where MD5(business_type_code) = '$value' ");

            $row = mysqli_fetch_assoc($query);
            echo ' <div class="box-body" style="background:#e6e6e6;"> <form method="POST" action=""> <input type="hidden" name="hi1_e" value="'.$value.'" > <div class="form-group"> <label for="">Business Type</label> <input type="text" name="i1_e" value="'.$row["business_type_desc"].'" class="form-control" required>     </div>              <div class="form-group"> <label for="">Tax Exemption</label> <input type="number" name="i2_e" value="'.$row["tax_exemption"].'" class="form-control" required> </div>         <div class="form-group"> <label for="">Code</label> <input type="text" name="i3_e" class="form-control" value="'.$row["business_type_code"].'" required> </div>          <div class="form-group"> <input type="submit" class="btn btn-success pull-right " value="Update" name="businesstype_btn_e"  >    </div>   </form></div> ';
        }

        if($settings_name == "Business Scale"){
            $query = mysqli_query($conn,"SELECT * from geo_bpls_scale where MD5(scale_code) = '$value' ");

            $row = mysqli_fetch_assoc($query);
            echo ' <div class="box-body" style="background:#e6e6e6;"> <form method="POST" action=""> <input type="hidden" name="hi1_e" value="'.$value.'" > <div class="form-group"> <label for="">Business Scale</label> <input type="text" name="i1_e" value="'.$row["scale_desc"].'" class="form-control" required>     </div>                <div class="form-group"> <input type="submit" class="btn btn-success pull-right " value="Update" name="businessscale_btn_e"  >    </div>   </form></div> ';
        }

        if($settings_name == "Business Sector"){
            $query = mysqli_query($conn,"SELECT * from geo_bpls_sector where MD5(sector_code) = '$value' ");

            $row = mysqli_fetch_assoc($query);
            echo ' <div class="box-body" style="background:#e6e6e6;"> <form method="POST" action=""> <input type="hidden" name="hi1_e" value="'.$value.'" > <div class="form-group"> <label for="">Business Scale</label> <input type="text" name="i1_e" value="'.$row["sector_desc"].'" class="form-control" required>     </div>                <div class="form-group"> <input type="submit" class="btn btn-success pull-right " value="Update" name="businesssector_btn_e"  >    </div>   </form></div> ';
        }

        if($settings_name == "Business Area"){
            $query = mysqli_query($conn,"SELECT * from geo_bpls_economic_area where MD5(economic_area_code) = '$value' ");

            $row = mysqli_fetch_assoc($query);
            echo ' <div class="box-body" style="background:#e6e6e6;"> <form method="POST" action=""> <input type="hidden" name="hi1_e" value="'.$value.'" > <div class="form-group"> <label for="">Business Area</label> <input type="text" name="i1_e" value="'.$row["economic_area_desc"].'" class="form-control" required>     </div>         <div class="form-group"> <label for="">Business Area Code</label> <input type="text" name="i2_e" value="'.$row["economic_area_code"].'" class="form-control" required></div>             <div class="form-group"> <input type="submit" class="btn btn-success pull-right " value="Update" name="businessarea_btn_e"  >    </div>   </form></div> ';
        }

        if($settings_name == "Business Organization"){
            $query = mysqli_query($conn,"SELECT * from geo_bpls_economic_org where MD5(economic_org_code) = '$value' ");

            $row = mysqli_fetch_assoc($query);
            echo ' <div class="box-body" style="background:#e6e6e6;"> <form method="POST" action=""> <input type="hidden" name="hi1_e" value="'.$value.'" > <div class="form-group"> <label for="">Business Area</label> <input type="text" name="i1_e" value="'.$row["economic_org_desc"].'" class="form-control" required>     </div>         <div class="form-group"> <label for="">Business Area Code</label> <input type="text" name="i2_e" value="'.$row["economic_org_code"].'" class="form-control" required></div>             <div class="form-group"> <input type="submit" class="btn btn-success pull-right " value="Update" name="businessorg_btn_e"  >    </div>   </form></div> ';
        }

        if($settings_name == "Occupancy"){
            $query = mysqli_query($conn,"SELECT * from geo_bpls_occupancy where MD5(occupancy_code) = '$value' ");

            $row = mysqli_fetch_assoc($query);
            echo ' <div class="box-body" style="background:#e6e6e6;"> <form method="POST" action=""> <input type="hidden" name="hi1_e" value="'.$value.'" > <div class="form-group"> <label for="">Business Area</label> <input type="text" name="i1_e" value="'.$row["occupancy_desc"].'" class="form-control" required>     </div>         <div class="form-group"> <label for="">Business Area Code</label> <input type="text" name="i2_e" value="'.$row["occupancy_code"].'" class="form-control" required></div>             <div class="form-group"> <input type="submit" class="btn btn-success pull-right " value="Update" name="occupancy_btn_e"  >    </div>   </form></div> ';
        }

        if($settings_name == "Requirement"){
            $query = mysqli_query($conn,"SELECT * from geo_bpls_requirement where MD5(requirement_id) = '$value' ");

            $row = mysqli_fetch_assoc($query);
            echo ' <div class="box-body" style="background:#e6e6e6;"> <form method="POST" action=""> <input type="hidden" name="hi1_e" value="'.$value.'" > <div class="form-group"> <label for="">Requirements</label> <input type="text" name="i1_e" value="'.$row["requirement_desc"].'" class="form-control" required>     </div>         <div class="form-group"> <label for="">Status</label>
            <select  name="i2_e" class="form-control" required>
                <option value="">--Select Status--</option>
                <option value="0" >Activate</option>
                <option value="1" >Deactivate</option>
            </select>
            </div>  <div class="form-group"> <label> Reference Module</label>
            <select name="i3_e" class="form-control">   
                <option '; if($row["reference_module"] == "BPLS Module" ){ echo "selected"; } echo '>BPLS Module</option>  
                <option  '; if($row["reference_module"] == "Engineering Module" ){ echo "selected"; } echo '>Engineering Module</option> 
                <option  '; if($row["reference_module"] == "CTC Module" ){ echo "selected"; } echo '>CTC Module</option>    
                <option  '; if($row["reference_module"] == "RPT Module" ){ echo "selected"; } echo '>RPT Module</option>  
                <option  '; if($row["reference_module"] == "No Reference Module" ){ echo "selected"; } echo '>No Reference Module</option>  
            </select> 
            </div>   <div class="form-group"> <input type="submit" class="btn btn-success pull-right " value="Update" name="requirement_btn_e"  >    </div>   </form></div> ';
        }

        if($settings_name == "Signatory"){
            $query = mysqli_query($conn,"SELECT * from geo_bpls_signatory where MD5(signatory_id) = '$value' ");

            $row = mysqli_fetch_assoc($query);
            echo ' <div class="box-body" style="background:#e6e6e6;"> <form method="POST" action=""> <input type="hidden" name="hi1_e" value="'.$value.'" > <div class="form-group"> <label for="">Signatory Name</label> <input type="text" name="i1_e" value="'.$row["signatory_name"].'" class="form-control" required>     </div>      <div class="form-group"> <label for="">Signatory Office</label> <input type="text" name="i2_e" value="'.$row["signatory_office"].'" class="form-control" required></div>          <div class="form-group"> <label for="">Signatory Position</label> <input type="text" name="i3_e" value="'.$row["signatory_position"].'" class="form-control" required>     </div>     <div class="form-group"> <input type="submit" class="btn btn-success pull-right " value="Update" name="signatory_btn_e"  >    </div>   </form></div> ';
        }

        if($settings_name == "Nature"){
            $query = mysqli_query($conn,"SELECT * from geo_bpls_nature where MD5(nature_id  ) = '$value' ");

            $row = mysqli_fetch_assoc($query);
            echo ' <div class="box-body" style="background:#e6e6e6;"> <form method="POST" action=""> <input type="hidden" name="hi1_e" value="'.$value.'" > <div class="form-group"> <label for="">Nature Name</label> <input type="text" name="i1_e" value="'.$row["nature_desc"].'" class="form-control" required>     </div>      <div class="form-group"> </div>     <div class="form-group"> <input type="submit" class="btn btn-success pull-right " value="Update" name="nature_btn_e"  >    </div>   </form></div> ';
        }

        if($settings_name == "Zone"){
            $query = mysqli_query($conn,"SELECT * from geo_bpls_zone where MD5(zone_id) = '$value' ");

            $row = mysqli_fetch_assoc($query);
            echo ' <div class="box-body" style="background:#e6e6e6;"> <form method="POST" action=""> 
            
            <input type="hidden" name="hi1_e" value="'.$value.'" >  
            
            <div class="form-group"> <label for="">Barangay</label> 
             <select  name="i1_e" class="form-control" required>
                <option>Sample</option>
                 </select>  </div>      
             
             <div class="form-group"> <label for="">Garbage Zone</label> <input type="text" name="i2_e" value="'.$row["garbage_zone"].'" class="form-control" required></div>          
             
             <div class="form-group"> <label for="">Zone Desc</label> <input type="text" name="i3_e" value="'.$row["zone_desc"].'" class="form-control" required>     </div>     
             
             <div class="form-group"> <input type="submit" class="btn btn-success pull-right " value="Update" name="signatory_btn_e"  >    </div>   </form></div> ';
        }
?>