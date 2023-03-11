<?php
// ======================================================================================== saving application
        include('php/connect.php');
        include 'php/web_connection.php';

        include("jomar_assets/input_validator.php");

        
        $or = $_POST["or_no"];  
        $or_date = $_POST["or_date"];  
        $permit_id = $_POST["permit_id"];  

        // get business id
        $q222 = mysqli_query($conn,"SELECT business_name FROM `geo_bpls_business_permit` inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id  where  permit_id = '$permit_id' ");
        $r222 = mysqli_fetch_assoc($q222);
        $business_name = $r222["business_name"];


        $payment_mode_code = $_POST["payment_mode"];  
        $payment_date = date("Y-m-d h:i:s");
        $payment_desc = "";
        $payment_fee = $_POST["payment_fee"];  
        $payment_part = $_POST["payment_part"];  
        $payment_tax = $_POST["payment_tax"];   
        $payment_backtax = $_POST["backtax"];
        $surcharges = $_POST["surcharges"];
        $penalty = $_POST["penalty"];   
        $payment_total_amount_due = $_POST["payment_total_amount_due"]; 
        $payment_total_amount_paid = $_POST["payment_total_amount_paid"];
        $payment_total_amount_change = $_POST["payment_total_amount_change"];
        $sector_code  = $_POST["sector_code"];
        $payor_money = $payment_total_amount_paid;
        $datetime = date("Y-m-d h:i:s");
        if($payment_total_amount_paid > $payment_total_amount_due ){
          $payment_total_amount_paid -=  $payment_total_amount_change;
        }
        $payment_year = $_POST["year"];
        $payor = validate_str($conn,$_POST["payor"]);
        

          // update 12522
        if(isset($_POST["backtax_permit_id"])){
          $backtax_permit_id = $_POST["backtax_permit_id"];
          $backtax_amount = $_POST["backtax_amount"];

          $q = mysqli_query($conn, "INSERT INTO `geo_bpls_payment_paid_backtax`( `permit_id`, `backtax_amount`) VALUES ('$backtax_permit_id','$backtax_amount') ");
        }
        // update 12522
        
         // Update Online Application in web and localserver STEP
                mysqli_query($wconn, "UPDATE `geo_bpls_ol_application` SET `step` = 'RELEASE' where permit_id = '$permit_id' ");
                mysqli_query($conn, "UPDATE `geo_bpls_ol_application` SET `step` = 'RELEASE' where permit_id = '$permit_id' ");

          $remarks = $_POST["remark"];
          $username = $_SESSION['uname'];
  

             $q = mysqli_query($conn,"INSERT INTO `geo_bpls_payment`( `or_no`, `permit_id`, `payment_mode_code`, `payment_backtax`, `payment_date`, `payment_desc`, `payment_fee`, `payment_part`, `payment_penalty`, `payment_surcharge`, `payment_tax`, `payment_total_amount_due`, `payment_total_amount_less`, `payment_total_amount_paid`, `payment_year`, `payor`, `remarks`, `updated_by`) VALUES ('$or','$permit_id','$payment_mode_code','$payment_backtax','$payment_date','$payment_desc','$payment_fee','$payment_part','$penalty','$surcharges','$payment_tax','$payment_total_amount_due',null,'$payment_total_amount_paid','$payment_year','$payor','$remarks','$username') ");

              if(!$q){
                $error++;
                echo "error001";
                echo "INSERT INTO `geo_bpls_payment`( `or_no`, `permit_id`, `payment_mode_code`, `payment_backtax`, `payment_date`, `payment_desc`, `payment_fee`, `payment_part`, `payment_penalty`, `payment_surcharge`, `payment_tax`, `payment_total_amount_due`, `payment_total_amount_less`, `payment_total_amount_paid`, `payment_year`, `payor`, `remarks`, `updated_by`) VALUES ('$or','$permit_id','$payment_mode_code','$payment_backtax','$payment_date','$payment_desc','$payment_fee','$payment_part','$penalty','$surcharges','$payment_tax','$payment_total_amount_due',null,'$payment_total_amount_paid','$payment_year','$payor','$remarks','$username') ";
              }

            //  getting last save id
            // SELECT payment_id FROM `geo_bpls_payment` ORDER BY `geo_bpls_payment`.`payment_id` DESC limit 1
            $q_id = mysqli_query($conn,"SELECT payment_id FROM `geo_bpls_payment` where or_no = '$or'");
            $r_id = mysqli_fetch_assoc($q_id);
            $target_id = $r_id["payment_id"];
            $error = 0;
               if(isset($_POST["normal"])){
            $fee_count = count($_POST["normal"]);

            for($a = 0; $a<$fee_count; $a++){
              
            $normal = $_POST["normal"][$a];
            $sub_account_no = $_POST["sub_account_no"][$a];
            $nature = $_POST["nature"][$a];
              if($normal != 0){

               // change id and uniqID of  gross base in sector
               if($sub_account_no == 1010 || $sub_account_no == 1011  || $sub_account_no == 1012  || $sub_account_no == 1013  || $sub_account_no == 1014  || $sub_account_no == 1015 || $sub_account_no == 1016 || $sub_account_no == 1017 || $sub_account_no == 1018 || $sub_account_no == 1019 || $sub_account_no == 1020 || $sub_account_no == 1021){
                // changing the value of sub_account/or auto in ID
                   
                if($sector_code == 1){ $sub_account_no = 1010;  } // 1	MANUFACTURING ok
                if($sector_code == 2){ $sub_account_no = 1011;  } // 2	ELECTRONIC	
                if($sector_code == 3){ $sub_account_no = 1012;  } // 3	CONSTRUCTION	
                if($sector_code == 4){ $sub_account_no = 1013;  }  // 4	SERVICES	
                if($sector_code == 5){ $sub_account_no = 1014;  }  // 5	WHOLESALER ok
                if($sector_code == 6){ $sub_account_no = 1015;  }  // 6	RETAILER ok
                if($sector_code == 7){ $sub_account_no = 1016;  }  // 7	DEALER	
                if($sector_code == 8){ $sub_account_no = 1017;  }  // 8	FRANCHISE	
                if($sector_code == 9){ $sub_account_no = 1018;  }  // 9	REAL ESTATE	
                if($sector_code == 10){ $sub_account_no = 1019;  }  // 10	AGRICULTURE
                if($sector_code == 11){ $sub_account_no = 1020;  }  // 11	POWER PLANT	
                if($sector_code == 12){ $sub_account_no = 1021;  }  // 12	OUTSOURCING	
            }

                $q_find = mysqli_query($conn,"SELECT natureOfCollection_tbl.`name` as sub_account_title , natureOfCollection_tbl.`uniqID` as sub_account_no FROM natureOfCollection_tbl   where id = '$sub_account_no' ");
                $r_find = mysqli_fetch_assoc($q_find);
                
               $sub_account_title = validate_str($conn,$r_find["sub_account_title"]);
               $id_in_natureOfCollection = validate_str($conn,$r_find["sub_account_no"]);


              // treasury transaction
                mysqli_query($conn, "INSERT INTO `treasury_transactions`( `acc_title`, `acc_codes`, `quant`, `item_amt`, `amount`, `or_num`, `user_acc`, `created_at`) VALUE ('$sub_account_title','$id_in_natureOfCollection',0,0,'$normal','$or','$username','$datetime' )");


                $q = mysqli_query($conn, "INSERT INTO `geo_bpls_payment_detail`( `nature_id`, `payment_id`, `payment_type_code`, `sub_account_no`, `payment_amount`, `updated_by`, `updated_date`) VALUES ('$nature','$target_id','NORM','$sub_account_no','$normal','$username','$datetime' ) ");
                if($q){
                }else{
                  $error++;
                }
              }
           }
           }
          
          if($_POST["surcharges"] != 0){
              $q = mysqli_query($conn, "INSERT INTO `geo_bpls_payment_detail`( `nature_id`, `payment_id`, `payment_type_code`, `sub_account_no`, `payment_amount`, `updated_by`, `updated_date`) VALUES (' $nature','$target_id','SURC','$surc_sub_acc','$surcharges','$username','$datetime' )");

              // save surcharges in treasury _transaction
              mysqli_query($conn, "INSERT INTO `treasury_transactions`( `acc_title`, `acc_codes`, `quant`, `item_amt`, `amount`, `or_num`, `user_acc`, `created_at`) VALUE ('SURCHARGES','1002022062809203590',0,0,'$surcharges','$or','$username','$datetime' )");


              if($q){
              }else{
                $error++;
              }
         }

         eval( '$payment_backtax = (' . $payment_backtax. ');' );

        if($payment_backtax != 0){
         

            $q = mysqli_query($conn, "INSERT INTO `geo_bpls_payment_detail`( `nature_id`, `payment_id`, `payment_type_code`, `sub_account_no`, `payment_amount`, `updated_by`, `updated_date`) VALUES ('$nature','$target_id','BACK','$backtax_sub_acc','$payment_backtax','$username','$datetime' )");

             // save backtax in treasury _transaction
              mysqli_query($conn, "INSERT INTO `treasury_transactions`( `acc_title`, `acc_codes`, `quant`, `item_amt`, `amount`, `or_num`, `user_acc`, `created_at`) VALUE ('BACKTAXES','1002022062809203591',0,0,'$payment_backtax','$or','$username','$datetime' )");

              if($q){
              }else{
                $error++;
              }
         }
            if($q){
                mysqli_query($conn,"UPDATE `geo_bpls_business_permit` SET step_code = 'RELEA' where permit_id = '$permit_id'  ");
            }else{
              $error++;
            }

      // if check
            if ($payment_mode_code == "CHEC") {
              $check_date = $_POST["date_check"];
              $drawee_check = $_POST["drawee_check"];
              $num_check = $_POST["num_check"];
              
              
            $q = mysqli_query($conn, "INSERT INTO `geo_bpls_payment_check`(`check_status_code`, `payment_id`, `check_amount`, `check_issue_date`, `check_date_clear`, `check_date_create`, `check_name`, `check_no`, `check_remark`, `updated_by` ) VALUES (null,'$target_id','$payment_total_amount_due','$check_date',null,null,'$drawee_check','$num_check','$remarks','$username')"); 
             if($q){
              }else{
                $error++;
              }

            // insert treasury
            $q = mysqli_query($conn, "INSERT INTO `treasury_tbl`( `or_date`, `or_num`, `agency`, `fund_code`, `or_payor`, `payment_mode`, `order_no`, `drawee_check`, `num_check`, `date_check`, `num_order`, `date_order`, `status`, `department`, `remark`, `payor_money`, `user_acc`, `created_at`, `edit_at`) VALUES ('$or_date','$or','Majayjay','100','$payor','cash','','$drawee_check','$num_check','$check_date','','','active','BPLS','$remarks','$payor_money','$username','$datetime','$datetime') ");

        }
            if ($payment_mode_code == "MONE") {
              $num_order = $_POST["num_order"];
              $date_order = $_POST["date_order"];
              
            mysqli_query($conn, "INSERT INTO `geo_bpls_payment_check`(`check_status_code`, `payment_id`, `check_amount`, `check_issue_date`, `check_date_clear`, `check_date_create`, `check_name`, `check_no`, `check_remark`, `updated_by` ) VALUES (null,'$target_id','$payor_money','$date_order',null,null,'','$num_order','$remarks','$username')"); 
            // insert treasury

            $q = mysqli_query($conn, "INSERT INTO `treasury_tbl`( `or_date`, `or_num`, `agency`, `fund_code`, `or_payor`, `payment_mode`, `order_no`,  `drawee_check`, `num_check`, `date_check`, `num_order`, `date_order`, `status`, `department`, `remark`,  `payor_money`, `user_acc`, `created_at`, `edit_at`) VALUES ('$or_date','$or','Majayjay','100','$payor','cash','','','','','$num_order','$date_order','active','BPLS','$remarks','$payor_money','$username','$datetime','$datetime') ");




        }elseif($payment_mode_code == "CASH"){
           // treasury_tbl

// insert treasury

        $q = mysqli_query($conn,"INSERT INTO `treasury_tbl`( `or_date`, `or_num`, `agency`, `fund_code`, `or_payor`, `payment_mode`, `order_no`, `drawee_check`, `num_check`, `date_check`, `num_order`, `date_order`, `status`, `department`, `remark`,  `payor_money`, `user_acc`, `created_at`, `edit_at`) VALUES ('$or_date','$or','Majayjay','100','$payor','cash','','','','','','','active','BPLS','$remarks','$payor_money','$username','$datetime','$datetime') ");

        }

        
           // Audit Trail =====================================================================================
                // Audit Trail =====================================================================================
                // Audit Trail =====================================================================================
                $au_username = $_SESSION["uname"];
                $au_action = "Payments";
                $au_desc = "Payments of Business ".$business_name." with a total payments of ".$payment_total_amount_due." and OR number of ".$or;
                mysqli_query($conn,"INSERT INTO `geo_bpls_audit_trail`(`username`, `action`, `description`) VALUES ('$au_username','$au_action','$au_desc') ");
            // Audit Trail =====================================================================================
            // Audit Trail =====================================================================================
            // Audit Trail ===================================================================================== 


     if($error >0){
        ?>
                     <script>
                     $(document).ready(function(){
                         myalert_danger_af("Failed to pay business permit!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($permit_id); ?>");
                     });
                    </script>
                <?php
    }else{
                // redirect to multistep
               ?>
                    <script>
                     $(document).ready(function(){
                         myalert_success_af("Business permit successfully paid!","bplsmodule.php?redirect=business_registration_multistep&target=<?php echo md5($permit_id); ?>");
                     });
                    </script>
               <?php
    }
?>