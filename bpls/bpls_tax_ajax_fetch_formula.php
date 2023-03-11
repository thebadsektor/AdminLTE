<?php
include '../php/connect.php';
include "../jomar_assets/input_validator.php";

$id =  $_POST["id"];

$q234_q = mysqli_query($conn, "SELECT * from geo_bpls_nature where md5(nature_id) = '$id' ");
$q234_r = mysqli_fetch_assoc($q234_q);

echo "<div class='box box-primary'>
    <div class='box-header'>";
echo "<h3>".$q234_r["nature_desc"]."</h3>";
    
    echo "</div>

    <div class='box-body'>";
    

$q = mysqli_query($conn, "SELECT nature_id, tfo_nature_id, natureOfCollection_tbl.id as sub_account_no, status_code, basis_code, geo_bpls_indicator.indicator_code , amount_formula_range from  geo_bpls_tfo_nature  inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no inner join geo_bpls_indicator on geo_bpls_indicator.indicator_code = geo_bpls_tfo_nature.indicator_code   where md5(nature_id) = '$id' ORDER BY status_code ASC");

$q_count = mysqli_num_rows($q);

if($q_count > 0){
echo "<table class='' style='width:100%;' ><tr style='font-weight:bold; '>
               <td>Tax/Fee </td>
               <td>Transaction</td>
               <td>Basis</td>
               <td>Indicator</td>
               <td> <button type='button'  class='btn btn-success edit_append_tax_fees'  style='margin:4px;' disabled >   <i class='fa fa-plus'> </i>  </button></td>
            </tr>
            <tr class='edit_append_tax_fee'>
            </tr>
            ";
            
    while ($r = mysqli_fetch_assoc($q)) {

            $status = $r["status_code"];


             // // check kung nagamit na sa assessment
                    $tfo_n_id = $r["tfo_nature_id"];
                    $checking_q = mysqli_query($conn,"SELECT tfo_nature_id FROM `geo_bpls_assessment` where tfo_nature_id = $tfo_n_id");
                    $checking_count = mysqli_num_rows($checking_q);

                    if(0 >0){
                    // if($checking_count >0){
                        $disabled ="disabled";
                        $readonly ="readonly";
                    }else{
                        $readonly ="";
                        $disabled ="";
                    }

                    if(0>0){
                    // if($checking_count >0){
                       
        echo "<input type='hidden' name='nature_id' value='".$r["nature_id"]."'>";
        echo "<tr  class='edit_tr".$r["tfo_nature_id"]."' >
                    <td style='width:250px;'>";
                        
                    echo '<input type="hidden" name="tfo_nature_id[]"  value="'.$r["tfo_nature_id"].'">';
                       $query = mysqli_query($conn, "SELECT `name` as sub_account_title , `id` as sub_account_no FROM `geo_bpls_active_tfo` inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_active_tfo.naturecollection_id ");
                           while ($row = mysqli_fetch_assoc($query)) {

                            if ($r["sub_account_no"] == $row["sub_account_no"]) {
                            echo '  <input type="text"  class="form-control" value="' . $row["sub_account_title"] . '"  readonly>  <input type="hidden" name="transaction[]" class="form-control" value="' . $row["sub_account_no"] . '"  > ';

                                } 
                                } 
                            

                    //  
                    if ($r["status_code"] == "NEW") {
                        $transaction = "New";
                    }elseif ($r["status_code"] == "REN") {
                        $transaction = "Renew";
                    }

                    echo "</td>
                    <td style='width:250px;'>" ;
                    echo '  <input type="text"  class="form-control" value="'.$transaction.'"  readonly> <input type="hidden" name="transaction[]" class="form-control" value="'.$r["status_code"].'" >';

                    if ($r["basis_code"] == "C") {
                        $basis_code = "Capital Investment";
                    }elseif ($r["basis_code"] == "G") {
                        $basis_code = "Gross/Sales";
                    }elseif ($r["basis_code"] == "I") {
                       $basis_code =  "Inputed Value";
                    }
                    
                    echo "</td>
                    <td style='width:250px;' >";
                       echo '<input type="text"  class="form-control" value="'.$basis_code.'"  readonly> <input type="hidden" name="basis[]" class="form-control" value="'.$r["basis_code"].'"> ';

                    if ($r["indicator_code"] == "R") {
                        $indicator = "Range";
                    }elseif ($r["indicator_code"] == "F") {
                        $indicator = "Formula";
                    }elseif ($r["indicator_code"] == "C") {
                       $indicator =  "Constant";
                    }

                    echo "</td>
                    <td style='width:250px;' >";
                       echo '<input type="text" class="form-control" value="'.$indicator.'"  readonly> <input type="hidden" name="indicator[]" class="form-control" value="'.$r["indicator_code"].'"  > ';
                    echo "</td><td>";
                    }else{
                        
        echo "<input type='hidden' name='nature_id' value='".$r["nature_id"]."'>";
        echo "<tr  class='edit_tr".$r["tfo_nature_id"]."' >
                    <td style='width:250px;'>";
                        
                    echo '
                    <select class=" selectpicker form-control edit_sub_acc_no_class" id="edit_sub_acc_no_class'.$r["tfo_nature_id"].'" ca_attr="'.$r["tfo_nature_id"].'" name="charges[]" data-show-subtext="true" data-live-search="true"  data-width="250px" required>
                                        <option value="">--Select Nature--</option> ';
                                        $query = mysqli_query($conn, "SELECT `name` as sub_account_title , `id` as sub_account_no FROM `geo_bpls_active_tfo` inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_active_tfo.naturecollection_id  ");
                                            while ($row = mysqli_fetch_assoc($query)) {

                                            echo '<option value="'.$row["sub_account_no"].'"'; if ($r["sub_account_no"] == $row["sub_account_no"]) {echo "selected";} echo '>';
                                                echo $row["sub_account_title"]; 
                                            echo '</option>';
                                        } 
                                echo '</select>';

                    //  
                    
                    echo "</td>
                    <td style='width:250px;'>" ;
                     
                    echo ' <select class="form-control transaction_edit transaction_edit'.$r["tfo_nature_id"].'" name="transaction[]" ca_attr="'.$r["tfo_nature_id"].'" required>
                            <option value="NEW" '; if ($r["status_code"] == "NEW") {echo "selected";}
                    echo '>New</option>
                           <option value="REN" '; if ($r["status_code"] == "REN") {echo "selected";}
                    echo '>Renew</option>
                             </select>';

                        
                    
                    echo "</td>
                    <td style='width:250px;' >";
                       echo '<select class="form-control" name="basis[]"  required>
                                        <option value="C" '; if ($r["basis_code"] == "C") {echo "selected";}
                    echo '>Capital Investment</option>
                                        <option value="G" '; if ($r["basis_code"] == "G") {echo "selected";}
                    echo '>Gross/Sales</option>
                                        <option value="I" '; if ($r["basis_code"] == "I") {echo "selected";}
                    echo '>Inputed Value</option>
                                    </select>';

                    echo "</td>
                    <td style='width:250px;' >";
                       echo '<select  name="indicator[]" class="form-control edit_indicator_btn" ca_attr="'.$r["tfo_nature_id"].'" required >
                                            <option value="F"  '; if ($r["indicator_code"] == "F") {echo "selected";}
                    echo ' >Formula</option>
                                            <option value="R"  '; if ($r["indicator_code"] == "R") {echo "selected";}
                    echo ' >Range</option>
                                            <option value="C"  '; if ($r["indicator_code"] == "C") {echo "selected";}
                    echo ' >Constant</option>
                                        </select>';
                    
                    echo "</td><td>";
                    }


                   
                        echo " <button type='button' class='btn btn-danger remove_tax_fee_edit'  ca_attr='" . $r["tfo_nature_id"] . "'  style='margin:4px;' ".$disabled."  >  <i class='fa fa-minus'> </i>  </button>";


                    echo "</td>
                </tr>
                <tr  class='edit_tr".$r["tfo_nature_id"]." edit_indicator_content".$r["tfo_nature_id"]." '>
                    <td colspan='5' >"; 
                        if ($r["indicator_code"] == "F"){
                            echo " <div class='form-group'><b> Formula:</b> <input type='text'  name='formula[]' value='".$r["amount_formula_range"]."' ".$readonly." style='width:80%; border:1px solid #e1e3e1;'  required>  <input type='hidden' name='formula_transaction[]' class='formula_transaction".$r["tfo_nature_id"]."' value='".$status."'>  <input type='hidden'  name='formula_charges[]' class='formula_charges".$r["tfo_nature_id"]."' value='".$r["sub_account_no"]."'>  </div>";
                            
                            echo '<input type="hidden" name="tfo_nature_id[]"  value="'.$r["tfo_nature_id"].'">';
                        }

                        if ($r["indicator_code"] == "C"){
                            echo "<div class='form-group'><b> Constant: </b> <input type='text' style='width:80%; border:1px solid #e1e3e1;'  name='constant[]' value='".$r["amount_formula_range"]."' ".$readonly." required>  <input type='hidden' name='constant_transaction[]' class='constant_transaction".$r["tfo_nature_id"]."' value='".$status."'> <input type='hidden' name='constant_charges[]' class='constant_charges".$r["tfo_nature_id"]."' value='".$r["sub_account_no"]."'>  </div>";
                            echo '<input type="hidden" name="tfo_nature_id[]"  value="' . $r["tfo_nature_id"] . '">';

                        }

                        if ($r["indicator_code"] == "R"){
                           
                        $tfo_id = $r["tfo_nature_id"];
                    
                        $r_q = mysqli_query($conn,"SELECT * from geo_bpls_tfo_range where tfo_nature_id = '$tfo_id' ");
                          echo "<table style='width:99%;'><tr><td></td> </tr> ";
                          $r_r1 = 1000;
                        while($r_r = mysqli_fetch_assoc($r_q)){
                            $r_r1++;
                            echo " <tr class='tr_append_edit".$r_r1."' ><td><div class='form-group'>"; 
                            if($r_r1 == 1001){ echo "<label> Range Low </label> "; }
                            
                             echo " <input type='hidden'  name='range_charges[]' class='range_charges".$r["tfo_nature_id"]."' value='".$r["sub_account_no"]."'> <input type='hidden' name='range_transaction[]'class='range_transaction".$r["tfo_nature_id"]."' value='".$status."'> <input type='text' class='form-control' name='range_low[]' value='".$r_r["range_low"]."' style='margin-left:2px; width:97%;' required></div></td><td><div class='form-group'>"; 
                             if($r_r1 == 1001){ echo "<label> Range High </label>"; } 
                             
                             echo " <input type='text' class='form-control' name='range_high[]'  value='".$r_r["range_high"]."' style='margin-left:2px; width:97%;'  required></div></td><td><div class='form-group'>";
                             
                             if($r_r1 == 1001){  echo "<label> Range Amount </label>"; }
                             
                             echo " <input type='text' class='form-control' name='range_amount[]'  value='".$r_r["range_amount"]."' style='margin-left:2px; width:97%;' required></div> </div></td> <td>"; 
                                if($r_r1 == 1001){
                                    echo "<button type='button'  style=' margin-top:13px;' class='btn btn-success append_indicator_btn_edit append_indicator_btn_edit".$r["tfo_nature_id"]."' ca_attr='".$r["tfo_nature_id"]."' sub_acc_no='".$r["sub_account_no"]."'>   <i class='fa fa-plus'> </i>  </button>";
                                }else{
                                    echo "<button type='button' style='margin-bottom:13px;' class='btn btn-danger remove_append_indicator_edit' ca_attr='" . $r_r1 . "' >   <i class='fa fa-minus'> </i>  </button>";
                                }
                            echo "</td> </tr>";
                         }  
                         echo " <tr class='edit_fetch_range_indicator".$r["tfo_nature_id"]."'> </tr></table>";
                            echo '<input type="hidden" name="tfo_nature_id[]"  value="'.$r["tfo_nature_id"].'">';
                         }
                     

                    echo "</td>
                </tr>
                
                ";
    }
echo "</table>";
}


// box body end
echo "</div>
</div>";

?>