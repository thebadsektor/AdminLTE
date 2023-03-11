<?php

// ======================================================================================== assessment
        include('php/connect.php');
     

        include("jomar_assets/input_validator.php");

        // discount saving
        if(isset($_POST["discount_amount"])){
        $discount_amount_count = count($_POST['discount_amount']);
            for ($i = 0; $i < $discount_amount_count; $i++) {
                $discount_amount = $_POST['discount_amount'][$i];
                $discount_tfo_nature_id = $_POST['discount_tfo_nature_id'][$i];
                $discount_nature_id = $_POST['discount_nature_id'][$i];
                $discount_sub_account_no = $_POST['discount_sub_account_no'][$i];
                $discount_permit_id = $_POST['discount_permit_id'][$i];
                $discount_id = $_POST['discount_id'][$i];

                 mysqli_query($conn, "DELETE from geo_bpls_discount_history where discount_id = '$discount_id' and  discount_permit_id = '$discount_permit_id' ");

                mysqli_query($conn, "INSERT INTO `geo_bpls_discount_history`( `discount_amount`, `discount_tfo_nature_id`, `discount_nature_id`, `discount_sub_account_no`, `discount_permit_id`, `discount_id`) VALUES ('$discount_amount','$discount_tfo_nature_id','$discount_nature_id','$discount_sub_account_no','$discount_permit_id','$discount_id') ");
            }
        }

        $tfo_count = count($_POST["tfo_nature_id"]);
        $error = 0;
        $username = $_SESSION['uname'];

        $permit_id = $_POST["permit_id_dec"];
         $f_q = mysqli_query($conn,"SELECT count(permit_id) as p_count FROM `geo_bpls_assessment` WHERE permit_id = '$permit_id' ");
         $f_r = mysqli_fetch_assoc($f_q);

         if ($f_r["p_count"] > 0) {
           mysqli_query($conn,"DELETE FROM `geo_bpls_assessment` where permit_id = '$permit_id' ");   
         }
         $final_tax_due = 0;
        for($a=0; $a<$tfo_count; $a++){
            $tfo_nature_id = $_POST["tfo_nature_id"][$a];
            $base_value = $_POST["base_value"][$a];
            $tax_due = $_POST["tax_due"][$a];
            $formula = $_POST["formula"][$a];

            $final_tax_due += $tax_due;
             $q = mysqli_query($conn,"INSERT INTO `geo_bpls_assessment`(`permit_id`, `tfo_nature_id`, `assessment_active`, `assessment_amount_formula`, `assessment_base_value_input`, `assessment_line`, `assessment_tax_due`, `updated_by`, `updated_date`) VALUES ('$permit_id','$tfo_nature_id','0','$formula','$base_value',null,'$tax_due','$username',now())");
        }
            if($q){
                mysqli_query($conn,"UPDATE `geo_bpls_business_permit` SET step_code = 'APPRO' where permit_id = '$permit_id'  ");
                if(!$q){
                    echo "error855";
                  
                }
            }else{
              $error++;
              echo "error854";
              echo "INSERT INTO `geo_bpls_assessment`(`permit_id`, `tfo_nature_id`, `assessment_active`, `assessment_amount_formula`, `assessment_base_value_input`, `assessment_line`, `assessment_tax_due`, `updated_by`, `updated_date`) VALUES ('$permit_id','$tfo_nature_id','0','$formula','$base_value',null,'$tax_due','$username',now())";

            }

    if($error >0){
        ?>
        <script>
            $(document).ready(function(){
                myalert_danger_af("Failed to assess business!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($permit_id); ?>");
            });
        </script>
        <?php
    }else{
        
                // redirect to multistep
            include 'php/web_connection.php';

            // get uniq ID using permit_id
            $q6544 = mysqli_query($conn,"SELECT uniqID from geo_bpls_ol_application where permit_id = '$permit_id' ");
            $r6544 = mysqli_fetch_assoc($q6544);
            $uniqID = $r6544["uniqID"];

            $q433 = mysqli_query($wconn,"SELECT email from usersacc_tbl inner join geo_bpls_ol_application on geo_bpls_ol_application.customer_id =  usersacc_tbl.usersacc_id where uniqID = '$uniqID' ");
            $r433 = mysqli_fetch_assoc($q433);
            $to = $r433["email"];

            // Update Online Application STEP in web and local server
            mysqli_query($wconn,"UPDATE `geo_bpls_ol_application` SET `step` = 'APPROVAL' where permit_id = '$permit_id' ");
            mysqli_query($conn,"UPDATE `geo_bpls_ol_application` SET `step` = 'APPROVAL' where permit_id = '$permit_id' ");
  

        // get business id
        $q222 = mysqli_query($conn,"SELECT business_name FROM `geo_bpls_business_permit` inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id  where  permit_id = '$permit_id' ");
        $r222 = mysqli_fetch_assoc($q222);
        $business_name = $r222["business_name"];

        // Audit Trail =====================================================================================
        // Audit Trail =====================================================================================
        // Audit Trail =====================================================================================
            $au_username = $_SESSION["uname"];
            $au_action = "Assess";
            $au_desc = "Assessment of Business (".$business_name.") with the final assessment value of ".$final_tax_due;
            mysqli_query($conn,"INSERT INTO `geo_bpls_audit_trail`(`username`, `action`, `description`) VALUES ('$au_username','$au_action','$au_desc') ");
        // Audit Trail =====================================================================================
        // Audit Trail =====================================================================================
        // Audit Trail ===================================================================================== 


  
            ?>
                    <script>
                     $(document).ready(function(){
                         myalert_success_af("Business successfully assess!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($permit_id); ?>");
                     });
                    </script>
               <?php
    }
?>