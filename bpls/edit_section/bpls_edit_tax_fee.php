<?php
        include("../../jomar_assets/myquery_function.php");
        include('../../php/connect.php');

        $tfo_nature_id = $_POST["tfo_nature_id"];
        
        $tfo_nature_q = mysqli_query($conn,"SELECT * from geo_bpls_tfo_nature where tfo_nature_id = '$tfo_nature_id' ");

        $tfo_nature_r = mysqli_fetch_assoc($tfo_nature_q);

        $tfo_arr = explode("-",$tfo_nature_r["revenue_code"]);
        echo '<form method="POST" action="" id="update_tfo_settings_form">
                     <div class="row">
    
                        <div class="col-md-4">
                            <label for="">Revenue Code</label>
                        <input type="text" name="revenue" class="form-control" value="RC" readonly> <input type="hidden" name="tfo_nature_id" class="form-control" value="'.$tfo_nature_id.'" readonly> </div>
                        <div class="col-md-4">
                        <label for=""> Year</label>
                        <input type="number" name="revenue_year" class="form-control" value="'.$tfo_arr[1].'" required></div>
                        <div class="col-md-4">
                            <label for="">Series</label>
                        <input type="number" name="revenue_series" class="form-control" value="'.$tfo_arr[2].'"  required ></div>
                    </div>
        <div class="row">
            <div class="col-md-12">
            <table style="width:100%;">
                <tr>
                    <td>
                        <div class="form-group">
                                <label for="">Business Nature</label>
                                    <select class=" selectpicker form-control" name="nature_id" data-show-subtext="true" data-live-search="true" required>
                                        <option value="">--Select Nature--</option>';
                                        $query = mysqli_query($conn, "SELECT nature_id, nature_desc FROM `geo_bpls_nature`");
                                            while ($row = mysqli_fetch_assoc($query)) { 
                                                $n_id = $row["nature_id"];
                                                $find_nature = mysqli_query($conn,"SELECT nature_id from geo_bpls_tfo_nature where nature_id = $n_id"); 
                                                $find_nature_count = mysqli_num_rows($find_nature);
                                                if($find_nature_count !=0){ }
                                                echo  '<option value="'.$row["nature_id"].'"'; if($tfo_nature_r["nature_id"] == $row["nature_id"]){ echo 'selected'; } echo '>
                                                '.$row["nature_desc"].'  </option>';
                                            
                                        } 
                                echo '</select>
                    </div>
                </td>
                    <td style="width:60px;">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                      <div class="row">
                          <div class="col-md-3">
                             <div class="form-group">
                                <label for="">Tax/Fees</label>
                                    <select name="charges" id="sub_acc_no" class=" selectpicker form-control"   data-show-subtext="true" data-live-search="true" required>
                                        <option value="">--Select Tax/fee--</option>';
                                        $query = mysqli_query($conn, "SELECT `name` as sub_account_title , id as sub_account_no  FROM `geo_bpls_active_tfo` inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_active_tfo.naturecollection_id");
                                        $bb =0;
                                            while ($row = mysqli_fetch_assoc($query)) { 
                                                $sub_account_no = $row["sub_account_no"];

                                                if($sub_account_no == 1010 || $sub_account_no == 1011  || $sub_account_no == 1012  || $sub_account_no == 1013  || $sub_account_no == 1014  || $sub_account_no == 1015 || $sub_account_no == 1016 || $sub_account_no == 1017 || $sub_account_no == 1018 || $sub_account_no == 1019 || $sub_account_no == 1020 || $sub_account_no == 1021){
                                                    $bb++;
                                                    if($bb == 1){
                                                        echo '<option value="'.$row["sub_account_no"].'" '; if($row["sub_account_no"] == $tfo_nature_r["sub_account_no"] ){ echo 'selected'; }  echo '>';
                                                        echo substr(strtoupper($row["sub_account_title"]),0,15);
                                                         echo '</option>';
                                                    }
                                                }else{
                                                    echo '<option value="'.$row["sub_account_no"].'" '; if($row["sub_account_no"] == $tfo_nature_r["sub_account_no"] ){ echo 'selected'; }  echo '>';
                                                 echo $row["sub_account_title"];
                                                  echo '</option>';
                                                }
                                                
                                               
                                        
                                                } 

                                    echo '</select>
                            </div>
                          </div>
                          <div class="col-md-3">
                             <div class="form-group">
                                <label for="">Transaction</label>
                                    <select class="form-control transaction_0" name="transaction"   required>
                                        <option value="">--Select Transaction--</option>
                                        <option value="NEW"'; if($tfo_nature_r["status_code"] == "NEW" ){ echo 'selected'; } echo '>New</option>
                                        <option value="REN" '; if($tfo_nature_r["status_code"] == "REN" ){ echo 'selected'; } echo '>Renew</option>
                                        <option value="RET" '; if($tfo_nature_r["status_code"] == "RET" ){ echo 'selected'; } echo '>Retire</option>
                                        
                                    </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                             <div class="form-group">
                                <label for="">Basis</label>
                                    <select class="form-control" name="basis"  required>
                                        <option value="">--Select Basis--</option>
                                        <option value="C" '; if($tfo_nature_r["basis_code"] == "C" ){ echo 'selected'; } echo ' >Capital Investment</option>
                                        <option value="G" '; if($tfo_nature_r["basis_code"] == "G" ){ echo 'selected'; } echo ' >Gross/Sales</option>
                                        <option value="I" '; if($tfo_nature_r["basis_code"] == "I" ){ echo 'selected'; } echo ' >Inputed Value</option>
                                    </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                                    <label for="">Indicator</label>
                                        <select  name="indicator" class="form-control  indicator_btn_tfo2" required >
                                            <option value="">--Select Indicator--</option>
                                            <option value="F" '; if($tfo_nature_r["indicator_code"] == "F" ){ echo 'selected'; } echo ' >Formula</option>
                                            <option value="R" '; if($tfo_nature_r["indicator_code"] == "R" ){ echo 'selected'; } echo ' >Range</option>
                                            <option value="C" '; if($tfo_nature_r["indicator_code"] == "C" ){ echo 'selected'; } echo ' >Constant</option>
                                        </select>
                                </div>
                          </div>
                      </div>  
                    </td>
                </tr>
                <tr>
                   <td colspan="2">
                       <div class="indicator_contenttfo2">';
                        //cccccccccccccccccccc 
                      if ($tfo_nature_r["indicator_code"] == "F" || $tfo_nature_r["indicator_code"] == "C"){
                            echo " <div class='form-group'><b> Formula:</b> <input type='text'  name='formula' value='".$tfo_nature_r["amount_formula_range"]."' style='width:80%; border:1px solid #e1e3e1;'  required>   </div>";
                        }


                        if ($tfo_nature_r["indicator_code"] == "R"){
                           
                        $r_q = mysqli_query($conn,"SELECT * from geo_bpls_tfo_range where tfo_nature_id = '$tfo_nature_id' ");
                          echo "<table style='width:99%;'><tr><td></td> </tr> ";
                          $r_r1 = 1000;
                        while($r_r = mysqli_fetch_assoc($r_q)){
                            $r_r1++;
                            echo " <tr class='tr_append_edit".$r_r1."' ><td><div class='form-group'>"; 
                            if($r_r1 == 1001){ echo "<label> Range Low </label> "; }
                             echo " <input type='text' class='form-control' name='range_low[]' value='".$r_r["range_low"]."' style='margin-left:2px; width:97%;' required></div></td><td><div class='form-group'>"; 
                             if($r_r1 == 1001){ echo "<label> Range High </label>"; } 
                             
                             echo " <input type='text' class='form-control' name='range_high[]'  value='".$r_r["range_high"]."' style='margin-left:2px; width:97%;'  required></div></td><td><div class='form-group'>";
                             
                             if($r_r1 == 1001){  echo "<label> Range Amount </label>"; }
                             
                             echo " <input type='text' class='form-control' name='range_amount[]'  value='".$r_r["range_amount"]."' style='margin-left:2px; width:97%;' required></div> </div></td> <td>"; 
                                if($r_r1 == 1001){
                                    echo "<button type='button'  style=' margin-top:13px;' class='btn btn-success append_indicator_btn_edit' ca_attr='".$tfo_nature_r["tfo_nature_id"]."'>   <i class='fa fa-plus'> </i>  </button>";
                                }else{
                                    echo "<button type='button' style='margin-bottom:13px;' class='btn btn-danger remove_append_indicator_edit' ca_attr='" . $r_r1 . "' >   <i class='fa fa-minus'> </i>  </button>";
                                }
                            echo "</td> </tr>";
                         }  
                         echo " <tr class='edit_fetch_range_indicator".$tfo_nature_r["tfo_nature_id"]."'> </tr></table>";
                         }
                        // ccccccccccccccccccc
                      echo ' </div>
                   </td>
                </tr>
                <tr class="append_here"></tr>
            </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="button" name="update_tfo_settings"  value="Update" class="btn btn-success pull-right update_tfo_settings">
            </div>
        </div>
</form>';

?>