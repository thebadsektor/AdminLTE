
            <style>
                .report_tbl{
                    border:1px solid #8c8c8c;
                    width:100%;
                }
                .report_tbl tr td{
                    border:1px solid #8c8c8c;
                }
            </style>
<div class="box box-primary">
    <div class="box-header">
        <h4> BPLS Reports</h4>
    </div>
    <div class="box-body">
        <?php
            if(isset($_POST["generate_btn"])){
               $condition_status = 0; 
               $condition_string = "WHERE "; 
               $getlink = "?";

                if(isset($_POST["type_report"])){
                    $type_report =  $_POST["type_report"];
                    echo "<h4>".$type_report."</h4>";
                    $getlink .= "type_report=".$type_report;
                }

                if(isset($_POST["year"])){
                    $inputyear =  $_POST["year"];
                    $getlink .= "permit_for_year=".$inputyear;
                    $condition_string .= "geo_bpls_business_permit.permit_for_year  = '".$inputyear."'"; 
                    $condition_status++;
                }
                

                if(isset($_POST["transaction"])){
                    $transaction = $_POST["transaction"];
                    if($transaction == "RET"){
                         $date_filter = "retirement_date_processed";
                    }else{
                         $date_filter = "permit_application_date";
                    }
                }else{
                    $date_filter = "permit_application_date";
                }

                


                if(isset($_POST["from"]) && isset($_POST["to"])){
                   $from =  $_POST["from"];
                   $to = $_POST["to"];
                   $condition_status++; 
                   $condition_string .= $date_filter." BETWEEN '".$from."' and '".$to."'";
                   $getlink .= "&from=".$from;
                   $getlink .= "&to=".$to;
                   $year_arr = explode('-',$from);
                    $year_now = $year_arr[0];
                }

                if(isset($_POST["from1"]) && isset($_POST["to1"])){
                   $from1 =  $_POST["from1"];
                   $to1 = $_POST["to1"];
                   $condition_status++; 
                   $condition_string .= $date_filter." BETWEEN '".$from1."' and '".$to1."'";
                   $getlink .= "&from1=".$from1;
                   $getlink .= "&to1=".$to1;

                   $year_arr = explode('-',$from1);
                    $year_now = $year_arr[0];
                }


                if(isset($_POST["tax_type"])){
                    // echo  $tax_type =  $_POST["tax_type"];
                }
                if(isset($_POST["barangay_id"])){
                      $barangay_id =  $_POST["barangay_id"];
                    if($barangay_id != "All"){
                      if($condition_status != 0)
                        {
                            $condition_string .= " and ";
                        }
                        $condition_string .= "geo_bpls_business.barangay_id  = '".$barangay_id."'";
                    $condition_status++; 
                    }
                   $getlink .= "&barangay_id=".$barangay_id;
                }


                if(isset($_POST["nature_id"])){
                     $nature_id = $_POST["nature_id"];
                    if($nature_id != "All"){
                    if($condition_status != 0)
                    {
                         $condition_string .= " and ";
                    }
                   $condition_string .= "geo_bpls_business_permit_nature.nature_id  = '".$nature_id."'"; 
                   $condition_status++; 
                }
                   $getlink .= "&nature_id=".$nature_id;
                }

                if(isset($_POST["economic_org_code"])){
                    $economic_org_code = $_POST["economic_org_code"];
                   if($economic_org_code != "All"){
                   if($condition_status != 0)
                   {
                        $condition_string .= " and ";
                   }
                  $condition_string .= "geo_bpls_business.economic_org_code  = '".$economic_org_code."'"; 
                  $condition_status++; 
               }
                  $getlink .= "&economic_org_code=".$economic_org_code;
               }

               if(isset($_POST["transaction"])){
                $transaction = $_POST["transaction"];
               if($transaction != "All"){
                   if($condition_status != 0)
                   {
                       $condition_string .= " and ";
                   }
                   $condition_string .= "status_code  = '" . $transaction."'";
                   $condition_status++; 
               }
               $getlink .= "&transaction=".$transaction;
           }

               if(isset($_POST["economic_area_code"])){
                    $economic_area_code = $_POST["economic_area_code"];
                    if($economic_area_code != "All"){
                    if($condition_status != 0)
                    {
                            $condition_string .= " and ";
                    }
                    $condition_string .= "geo_bpls_business.economic_area_code  = '".$economic_area_code."'"; 
                    $condition_status++; 
                }
                    $getlink .= "&economic_area_code=".$economic_area_code;
                }

            if(isset($_POST["scale_code"])){
                $scale_code = $_POST["scale_code"];
                if($scale_code != "All"){
                if($condition_status != 0)
                {
                        $condition_string .= " and ";
                }
                $condition_string .= "geo_bpls_business.scale_code  = '".$scale_code."'"; 
                $condition_status++; 
            }
                $getlink .= "&scale_code=".$scale_code;
            }

            if(isset($_POST["sector_code"])){
                $sector_code = $_POST["sector_code"];
                if($sector_code != "All"){
                if($condition_status != 0)
                {
                        $condition_string .= " and ";
                }
                $condition_string .= "geo_bpls_business.sector_code  = '".$sector_code."'"; 
                $condition_status++; 
            }
                $getlink .= "&sector_code=".$sector_code;
            }
            
            
                


                if(isset($_POST["payment_mode"])){
                     $payment_mode = $_POST["payment_mode"];
                    if($payment_mode != "All"){
                    if($condition_status != 0)
                    {
                        $condition_string .= " and ";
                    }
                     $condition_string .= "payment_frequency_code  = '" . $payment_mode."'";
                     $condition_status++; 
                    $getlink .= "&payment_mode=".$payment_mode;
                }
                }
                if(isset($_POST["business_type"])){
                     $business_type = $_POST["business_type"];
                    if($business_type != "All"){
                   if($condition_status != 0)
                    {
                        $condition_string .= " and ";
                    }
                     $condition_string .= "business_type_code  = '" . $business_type."'";
                     $condition_status++; 
                }
                    $getlink .= "&business_type=".$business_type;
                }
                if(isset($_POST["qtr"])){
                     $qtr = $_POST["qtr"];
                     $condition_status++;
                     
                }
                if($condition_status >0){

                    if($type_report == "Compliance Monitoring Report"){
                        ?>
                            <embed src="bpls/pdf_excel/compliance_monitoring_report.php?qtr=<?php echo $qtr; ?>" width="100%" height="1000" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                        <?php
                    }elseif($type_report == "Compliance Monitoring Report(Date Range)"){
                        ?>
                            <embed src="bpls/pdf_excel/compliance_monitoring_report2.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>" width="100%" height="1000" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                        <?php
                    }elseif($type_report == "Business Master list"){
           
            
            $q_t = "SELECT permit_no, business_name, CONCAT(owner_first_name,' ',owner_middle_name,' ',owner_last_name) as o_name, geo_bpls_business.barangay_id, business_type_code, payment_frequency_code,  permit_application_date, geo_bpls_business_permit.permit_id, nature_desc, capital_investment, last_year_gross, status_code , geo_bpls_business_permit_nature.nature_id, business_employee_total, owner_mobile, business_mob_no, scale_desc FROM geo_bpls_business_permit INNER JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id INNER JOIN  geo_bpls_scale on geo_bpls_scale.scale_code = geo_bpls_business.scale_code INNER JOIN geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id INNER JOIN geo_bpls_business_permit_nature on geo_bpls_business_permit_nature.permit_id = geo_bpls_business_permit.permit_id INNER JOIN geo_bpls_nature on geo_bpls_nature.nature_id = geo_bpls_business_permit_nature.nature_id   ".$condition_string." and geo_bpls_business_permit.permit_for_year = '$year_now' and geo_bpls_business_permit.step_code = 'RELEA' ";
            
            // ORDER BY `geo_bpls_business_permit`.`permit_no` ASC
            // if($_SESSION["uname"] == "admin"){
            // echo $q_t;
            // }
            $q_q = mysqli_query($conn,$q_t);
           
            ?>      
         <a href="bpls/pdf_excel/reportexcel.php<?php echo $getlink ?>" class='btn btn-success' style='margin:2px;'> Generate XLS</a>
         <!-- <a href="bpls/pdf_excel/reportpdf.php<?php echo $getlink ?>" class='btn btn-danger' style='margin:2px;'> Generate PDF</a> -->
         <div style="width:100%; overflow-x:scroll;">

        <table id="bml" class="table table-bordered table-striped " style="width:100%;">
            <thead style="background-color: #3c8dbc;color: white;">
            <tr>
                <td style='width:18%;'>Permit No</td>
                <td>Business Name </td>
                <td>Owner</td>
                <td>Address</td>
                <td>Nature of Business</td>
                <td>Business Scale</td>
                <td>Capital Investment</td>
                <td>Gross Sales</td>
                <td>Ownership</td>
                <td>Payment Mode</td>
                <td>Status</td>
                <td>Business Tax</td>
                <td>Regulatory Fee</td>
                <td>Application Date</td>
                <td>Total Employees</td>
                <td>Owners Contact No.</td>
                <td>Business Contact No.</td>
            </tr>
           </thead>
        </table>
         </div>

        <?php
             echo "<textarea id='querytext' style='visibility:hidden;' >".$q_t."</textarea>";
        ?>
        <script>
        $(document).ready(function(){
           var querytext = $("#querytext").val();
            var dataTable = $('#bml').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "order": [
                    [0, "desc"]
                ],
                "ajax": {
                    url: "bpls/dataTables/masterlist_rp.php",
                    type: "post",
                    data:{"page":"bml",querytext:querytext}
                }
            });
        });

        </script>
        <?php
              }elseif($type_report === "Individual Tax Delinquent List"){
            ?>
      
            <?php
            $year_arr = explode('-',$from);
            $year_now = $year_arr[0];
            $q_t = "SELECT permit_no, business_name , CONCAT(owner_first_name,' ',owner_middle_name,' ',owner_last_name) as o_name , ((SELECT sum(assessment_tax_due) from geo_bpls_assessment where geo_bpls_assessment.permit_id = geo_bpls_business_permit.permit_id ) - ( sum(SUBSTRING_INDEX(payment_backtax,'+',1) + SUBSTRING_INDEX(payment_backtax,'+',-1)) + sum(payment_fee+payment_tax))) as unpaid , geo_bpls_payment.permit_id FROM `geo_bpls_business_permit` inner JOIN geo_bpls_payment on geo_bpls_payment.permit_id = geo_bpls_business_permit.permit_id inner JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id INNER JOIN geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id ".$condition_string."  and (step_code = 'PAYME' or step_code = 'RELEA') GROUP BY geo_bpls_payment.permit_id ";
                        // ORDER BY `geo_bpls_business_permit`.`permit_no` ASC
            $q_q = mysqli_query($conn,$q_t);
           
            ?>      
           <button onclick="exportTableToExcel('tblData', 'Tax Delinquent')"  class='btn btn-success'>Generate Excel</button>
          <input type="button" value="Generate PDF"  class='btn btn-danger'  onclick="createPDF()" />
        <div id="tab">
        <table class="table table-bordered table-striped" id="tblData" >
            <thead >
            <tr>
                <td class='bg-primary'>Permit No</td>
                 <td class='bg-primary'>Business Name </td>
                 <td class='bg-primary'>Owner</td>
                 <td class='bg-primary'>Tax Delinquent</td>
            </tr>
           </thead>
            <?php
            $unpaid_total = 0;
                while($r22 = mysqli_fetch_assoc($q_q)){
                    if($r22["unpaid"] >0){
                        $permit_id_dec = $r22["permit_id"];
                        $q565d = mysqli_query($conn,"SELECT * FROM geo_bpls_payment_paid_backtax where permit_id = '$permit_id_dec' ");
                        if(mysqli_num_rows($q565d) == 0){

                        $unpaid_total +=$r22["unpaid"];
                    ?>
                <tr>
                    <td><?php echo $r22["permit_no"]; ?></td>
                    <td><?php echo $r22["business_name"]; ?></td>
                    <td><?php echo $r22["o_name"]; ?></td>
                    <td><?php echo number_format($r22["unpaid"],2); ?></td>
                </tr>
                    <?php
                    }
                    }
                }
            ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="float:right;"><b>Total Delinquent Tax:</b></td>
                    <td><p style="color:red"><?php echo $unpaid_total; ?></p></td>
                </tr>
        </table>
            </div>
        <?php
                      
            }elseif($type_report === "Business Scale count"){
                // get all business scale 
                ?>
          <button onclick="exportTableToExcel('tblData', 'Business Scale count')"  class='btn btn-success'>Generate Excel</button>
          <input type="button" value="Generate PDF"  class='btn btn-danger' onclick="createPDF()" />
                <?php
                echo "<div id='tab'><table class='table table-bordered table-striped' id='tblData'> ";
                $q54465 = mysqli_query($conn,"SELECT * from geo_bpls_scale");
                echo "<thead>
                        <tr>
                            <td class='bg-primary'>BUSINESS SCALE</td>
                            <td  class='bg-primary'>SCALE COUNT</td>
                        </tr>
                    </thead>";

                while($r54465 = mysqli_fetch_assoc($q54465)){
                    $scale_code = $r54465["scale_code"];
                    $scale_desc = $r54465["scale_desc"];

                  
                    echo "<tr>";
                    $q766 = mysqli_query($conn,"SELECT permit_id FROM `geo_bpls_business_permit` INNER JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id $condition_string and scale_code = '$scale_code'  and permit_no != '' and status_code != 'RET' ");
                                            
                    $scale_count = mysqli_num_rows($q766);
                    echo "<td> $scale_desc</td>";
                    echo "<td style='font-weight:bold;'> $scale_count </td>";
                    echo "</tr>";
                }
                echo "</table> </tab>";
            }
        }
            // show report
            }else{
                ?>
 <!-- search config report  -->
        <div class="row">
            <div class="col-md-12">
                <center>
            <form method='POST' action=''>
                    <table style=" text-align:left;">
                        <tr>
                            <td >
                                <div class="form-group">
                                    <select name="type_report" class="form-control" id="type_report">
                                        <option>Select Report</option>
                                        <option>Business Master list</option>
                                        <!-- <option disabled>Business With/Without Permit</option> -->
                                        <option value="Compliance Monitoring Report" >Compliance Monitoring Report(Quarter)</option>
                                        <option value="Compliance Monitoring Report(Date Range)">Compliance Monitoring Report(Date Range)</option>
                                        <!-- <option disabled>Number of Business Per Nature</option> -->
                                        <!-- <option>Collection Summary</option> -->
                                        <!-- <option disabled>Comparative Annual Report</option> -->
                                        <option>Individual Tax Delinquent List</option>
                                        <option>Business Scale count</option>
                                        <!-- <option disabled>Notice of Business Tax Collection</option> -->
                                    </select>
                                </div>
                            </td>
                        </tr>
                       
                    </table>
            
                    <table style="500px; margin-top:10px;  text-align:left;">
                        <tbody class="fetch_tr">
                        
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan='4'>   <button type="submit" name='generate_btn' class='form-control btn btn-success' style='margin-top:5px;'> Generate </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

            </form>
                </center>
            </div>
        </div>
    <!-- search config report  -->
                <?php
            }
        ?>
   


    </div>
</div>
 <script>

    $(document).on("change","#type_report",function(){
        var val = $(this).val();
        if(val == "Select Report"){
            $(".fetch_tr").html("");
        }else if(val == "Business Master list"){

            // <tr> <td><label>Type:</label></td> <td colspan='3' ><div class='form-group'><select class='form-control' name='tax_type' required><option>All</option><option>Tax</option> <option>Regulatory Fee</option> <option>Other Charges</option>  </select> </div> </td> </tr>
            $(".fetch_tr").html("<tr> <td> <label> Date: &nbsp; &nbsp; </label> </td> <td> <div class='form-group'> <input type='date' class='form-control' name='from1' required> </div></td><td><label> &nbsp; To: &nbsp; &nbsp;</label></td><td> <div class='form-group'> <input type='date' class='form-control' name='to1' required>  </div></td> </tr>          <tr> <td colspan='1'><label>Barangay: </label></td> <td colspan='3'><div class='form-group'> <select class=' selectpicker form-control' name='barangay_id' data-live-search='true' required><option>All</option> <?php $q = mysqli_query($conn,"SELECT * FROM `geo_bpls_barangay` where lgu_code = 'MAJ'");  while($r = mysqli_fetch_assoc($q)){ ?> <option value='<?php echo $r["barangay_id"];  ?>'><?php echo $r["barangay_desc"];  ?></option> <?php } ?> </select> </div> </td>  </tr> <tr><td><label>Business Nature</label> </td> <td colspan='3'><div class='form-group'><select class=' selectpicker form-control ' data-live-search='true' name='nature_id' required><option>All</option> <?php $q1 = mysqli_query($conn,"SELECT nature_id, nature_desc FROM geo_bpls_nature ");  while($r1 = mysqli_fetch_assoc($q1)){ ?> <option value='<?php echo $r1["nature_id"];  ?>'><?php echo $r1["nature_desc"];  ?></option> <?php } ?> </select> </div></td></tr> <tr> <td><label>Transaction:</label></td><td colspan='3'><div class='form-group'> <select class='form-control' name='transaction' required><option value='All'>All</option><option value='NEW'>New</option> <option value='REN'>Renew</option> <option value='RET'>Retire</option>  </select> </div></td></tr> <tr> <td><label>Payment Mode:</label></td><td colspan='3'><div class='form-group'> <select class='form-control' name='payment_mode' required><option value='All'>All</option><option value='ANN'>Annual</option> <option value='SEM'>Semi-Annual</option> <option value='QUA'>Quarterly</option>  </select> </div></td></tr>       <tr> <td><label>Business Organization:</label></td><td colspan='3'><div class='form-group'> <select class='form-control' name='economic_org_code' required><option value='All'>All</option><?php $q2 = mysqli_query($conn,"SELECT `economic_org_code`, `economic_org_desc` FROM `geo_bpls_economic_org`");  while($r2 = mysqli_fetch_assoc($q2)){ ?> <option value='<?php echo $r2["economic_org_code"];  ?>'><?php echo $r2["economic_org_desc"];  ?></option> <?php } ?>  </select> </div></td></tr>         <tr> <td><label>Business Area:</label></td><td colspan='3'><div class='form-group'> <select class='form-control' name='economic_area_code' required><option value='All'>All</option> <?php $q2 = mysqli_query($conn,"SELECT `economic_area_code`, `economic_area_desc` FROM `geo_bpls_economic_area`");  while($r2 = mysqli_fetch_assoc($q2)){ ?> <option value='<?php echo $r2["economic_area_code"];  ?>'><?php echo $r2["economic_area_desc"];  ?></option> <?php } ?> </select> </div></td></tr>         <tr> <td><label>Business Scale:</label></td><td colspan='3'><div class='form-group'> <select class='form-control' name='scale_code' required> <option value='All'>All</option>  <?php $q2 = mysqli_query($conn,"SELECT `scale_code`, `scale_desc` FROM `geo_bpls_scale` ");  while($r2 = mysqli_fetch_assoc($q2)){ ?> <option value='<?php echo $r2["scale_code"];  ?>'><?php echo $r2["scale_desc"];  ?></option> <?php } ?>   </select> </div></td></tr>          <tr> <td><label>Business Sector:</label></td><td colspan='3'><div class='form-group'> <select class='form-control' name='sector_code' required> <option value='All'>All</option>  <?php $q2 = mysqli_query($conn,"SELECT `sector_code`, `sector_desc` FROM `geo_bpls_sector`");  while($r2 = mysqli_fetch_assoc($q2)){ ?> <option value='<?php echo $r2["sector_code"];  ?>'><?php echo $r2["sector_desc"];  ?></option> <?php } ?>   </select> </div></td></tr>              <tr><td><label>Business Type</label> </td> <td colspan='3'><div class='form-group'><select class=' selectpicker form-control ' data-live-search='true' name='business_type' required><option>All</option> <?php $q2 = mysqli_query($conn,"SELECT business_type_code , business_type_desc FROM geo_bpls_business_type ");  while($r2 = mysqli_fetch_assoc($q2)){ ?> <option value='<?php echo $r2["business_type_code"];  ?>'><?php echo $r2["business_type_desc"];  ?></option> <?php } ?> </select> </div></td></tr>       ");
        }else if(val == "Compliance Monitoring Report"){
             $(".fetch_tr").html("<tr> <td><label> Quarter:</label> </td> <td colspan='3' style='width:400px;'> <select name='qtr' class='form-control' > <option value='1q'>1st Quarter</option> <option value='2q'>2nd Quarter</option> <option value='3q'>3rd Quarter</option> <option value='4q'>4th Quarter</option> </select> </td></tr>")
        }else if(val == "Compliance Monitoring Report(Date Range)"){
             $(".fetch_tr").html("<tr> <td> <label> Date: &nbsp; &nbsp; </label> </td> <td> <div class='form-group'> <input type='date' class='form-control' name='from' required> </div></td><td><label> &nbsp; To: &nbsp; &nbsp;</label></td><td> <div class='form-group'> <input type='date' class='form-control' name='to' required>  </div></td> </tr>  ")
        }else if(val == "Individual Tax Delinquent List"){
             $(".fetch_tr").html("<tr> <td> <label>Application Date: &nbsp; &nbsp; </label> </td> <td> <div class='form-group'> <input type='date' class='form-control' name='from' required> </div></td><td><label> &nbsp; To: &nbsp; &nbsp;</label></td><td> <div class='form-group'> <input type='date' class='form-control' name='to' required>  </div></td> </tr>  ")
        }else if(val == "Business Scale count"){
             $(".fetch_tr").html("   <tr> <td colspan='1'><label>Barangay: &nbsp; &nbsp; </label></td> <td colspan='3'><div class='form-group'> <select class=' selectpicker form-control' data-width='200px' data-live-search='true' name='barangay_id' required><option>All</option> <?php $q = mysqli_query($conn,"SELECT * FROM `geo_bpls_barangay` where lgu_code = 'MAJ'");  while($r = mysqli_fetch_assoc($q)){ ?> <option value='<?php echo $r["barangay_id"];  ?>'><?php echo $r["barangay_desc"];  ?></option> <?php } ?> </select> </div> </td>  </tr>  <tr> <td> <label> Application Date: &nbsp; &nbsp; </label> </td> <td> <div class='form-group'> <input type='date' class='form-control' name='from1' required> </div></td><td><label> &nbsp; To: &nbsp; &nbsp;</label></td><td> <div class='form-group'> <input type='date' class='form-control' name='to1' required>  </div></td> </tr>   ");
        }else{
               $(".fetch_tr").html("<tr> <td> <label> Date: &nbsp; &nbsp; </label> </td> <td> <div class='form-group'> <input type='date' class='form-control' name='from' required> </div></td><td><label> &nbsp; To: &nbsp; &nbsp;</label></td><td> <div class='form-group'> <input type='date' class='form-control' name='to' required>  </div></td> </tr>          <tr> <td colspan='1'><label>Barangay: </label></td> <td colspan='3'><div class='form-group'> <select class=' selectpicker form-control' data-live-search='true' name='barangay_id' required><option>All</option> <?php $q = mysqli_query($conn,"SELECT * FROM `geo_bpls_barangay` where lgu_code = 'MAJ'");  while($r = mysqli_fetch_assoc($q)){ ?> <option value='<?php echo $r["barangay_id"];  ?>'><?php echo $r["barangay_desc"];  ?></option> <?php } ?> </select> </div> </td>  </tr> <tr> <td><label>Type:</label></td> <td colspan='3' ><div class='form-group'><select class='form-control' name='tax_type' required><option>All</option><option>Tax</option> <option>Regulatory Fee</option> <option>Other Charges</option>  </select> </div> </td> </tr>");
        }

        $(".selectpicker").selectpicker("refresh");
    });

</script>

<script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>

<script>
    function createPDF() {
        var sTable = document.getElementById('tab').innerHTML;

        var style = "<style>";
        style = style + "table {width: 100%;font: 17px Calibri;}";
        style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
        style = style + "padding: 2px 3px;text-align: center;}";
        style = style + "</style>";
        // CREATE A WINDOW OBJECT.
        var win = window.open('', '', 'height=700,width=700');
        win.document.write('<html><head>');
        // win.document.write('<title>Profile</title>');   // <title> FOR PDF HEADER.
        win.document.write(style);          // ADD STYLE INSIDE THE HEAD TAG.
        win.document.write('</head>');
        win.document.write('<body>');
        win.document.write(sTable);         // THE TABLE CONTENTS INSIDE THE BODY TAG.
        win.document.write('</body></html>');

        win.document.close(); 	// CLOSE THE CURRENT WINDOW.

        win.print();    // PRINT THE CONTENTS.
    }

    function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>