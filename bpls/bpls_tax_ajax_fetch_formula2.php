<?php
include '../php/connect.php';
include "../jomar_assets/input_validator.php";

$id =  $_POST["id"];

$q234_q = mysqli_query($conn, "SELECT * from geo_bpls_nature where md5(nature_id) = '$id' ");
$q234_r = mysqli_fetch_assoc($q234_q);

echo "<div class='box box-primary'>
    <div class='box-header bg-primary' style='color:white;'> ";
echo "<h3>".$q234_r["nature_desc"]."</h3>";
    echo "</div>
    <div class='box-body'>";
    

$q = mysqli_query($conn, "SELECT natureOfCollection_tbl.name as sub_account_title, nature_id, tfo_nature_id, natureOfCollection_tbl.id as sub_account_no, status_code, basis_code, geo_bpls_indicator.indicator_code , amount_formula_range from  geo_bpls_tfo_nature  inner join natureOfCollection_tbl on natureOfCollection_tbl.id = geo_bpls_tfo_nature.sub_account_no inner join geo_bpls_indicator on geo_bpls_indicator.indicator_code = geo_bpls_tfo_nature.indicator_code   where md5(nature_id) = '$id' ORDER BY status_code ASC");

$q_count = mysqli_num_rows($q);

if($q_count > 0){
    
echo "  <table class='table' style='width:100%;' >
            <tr style='font-weight:bold; '>
               <td>Tax/Fee </td>
               <td>Transaction</td>
               <td>Basis</td>
               <td>Indicator</td>
               <td  style='width:30% !important'>Formula</td>
               <td style='width:15%;'>Action</td>
            </tr>
            ";
            
    while ($r = mysqli_fetch_assoc($q)) {
            echo "<tr class='tr_rm".$r["tfo_nature_id"]."'>
                <td>"; 

            $sub_account_no = $r["sub_account_no"];
            if($sub_account_no == 1010 || $sub_account_no == 1011  || $sub_account_no == 1012  || $sub_account_no == 1013  || $sub_account_no == 1014  || $sub_account_no == 1015 || $sub_account_no == 1016 || $sub_account_no == 1017 || $sub_account_no == 1018 || $sub_account_no == 1019 || $sub_account_no == 1020 || $sub_account_no == 1021){
                // check sector kung ano ang gross sales auto inc
                echo substr(strtoupper($r["sub_account_title"]),0,15);
                // changing the value of sub_account/or auto in ID
            }else{
                echo strtoupper($r["sub_account_title"]);
            }


                echo "</td>
                <td> ";
                     if ($r["status_code"] == "NEW") {
                        $transaction = "<b style='color:green'>New</b>";
                    }elseif ($r["status_code"] == "REN") {
                        $transaction = "<b style='color:blue' >Renew</b>";
                    }elseif ($r["status_code"] == "RET") {
                        $transaction = "<b style='color:red' >Renew</b>";
                    }
                    echo $transaction;
                echo "</td>
                <td>";
                         if ($r["basis_code"] == "C") {
                        $basis_code = "Capital Investment";
                    }elseif ($r["basis_code"] == "G") {
                        $basis_code = "Gross/Sales";
                    }elseif ($r["basis_code"] == "I") {
                       $basis_code =  "Inputed Value";
                    }
                    echo $basis_code;
                echo "</td>
                <td>";
                     if ($r["indicator_code"] == "R") {
                        $indicator = "Range";
                    }elseif ($r["indicator_code"] == "F") {
                        $indicator = "Formula";
                    }elseif ($r["indicator_code"] == "C") {
                       $indicator =  "Constant";
                    }
                    echo $indicator;
                echo "</td>
                <td> <textarea class='form-control' readonly> ".$r["amount_formula_range"]." </textarea></td>
                <td><div class='btn-group' > 
                <button class='btn btn-warning edit_tfo_btn' ca_id='".$r["tfo_nature_id"]."' ><i class='fa fa-edit'></i></button>
                <button class='btn btn-danger delete_tfo_btn' ca_title='".$r["sub_account_title"]." in ".$q234_r["nature_desc"]."'  ca_id='".$r["tfo_nature_id"]."'><i class='fa fa-trash'></i></button> 
                 </div> </td>
            </tr>";
    }
echo "</table>";
}


// box body end
echo "</div>
</div>";

?>