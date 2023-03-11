<?php 
include 'php/web_connection.php';
?>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
        
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><?php echo date("Y"); ?> Income</span>
               <span class="info-box-number">
                   <?php
                $year = date("Y");
                $bplos = mysqli_query($conn, "SELECT sum(payment_total_amount_paid) as bpls_amount FROM `geo_bpls_payment` where payment_year = '$year' ");
                $bpls_amo = mysqli_fetch_assoc($bplos);
                $bpls_income = $bpls_amo['bpls_amount'];
                echo "<div style='float:right; font-size:1.3em;'>".number_format($bpls_income, 2)."</div>";
                ?>
               </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red">  <span class="fa fa-building"></span></span>
              <?php
                      $year = date("Y");
              ?>
            <div class="info-box-content">
              <span class="info-box-text"> <?php echo $year; ?> Unpaid Amount</span>
              <span class="info-box-number">
                <?php
                $sql = "SELECT ((SELECT sum(assessment_tax_due) from geo_bpls_assessment where geo_bpls_assessment.permit_id = geo_bpls_business_permit.permit_id ) - ( sum(SUBSTRING_INDEX(payment_backtax,'+',1) + SUBSTRING_INDEX(payment_backtax,'+',-1)) + sum(payment_fee+payment_tax))) as unpaid FROM `geo_bpls_business_permit` inner JOIN geo_bpls_payment on geo_bpls_payment.permit_id = geo_bpls_business_permit.permit_id inner JOIN geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id where permit_for_year = '$year' and (step_code = 'PAYME' or step_code = 'RELEA') GROUP BY geo_bpls_payment.permit_id";
                $query=mysqli_query($conn,$sql);
                $unpaid_total = 0;
                if(mysqli_num_rows($query)>0){
                  while($r = mysqli_fetch_assoc($query)){
                    $unpaid_total += $r["unpaid"];
                  }
                echo $unpaid_total;
                }
                ?>
              </span>
              <b><a href="bplsmodule.php?redirect=receivables">Check</a></b>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><img src="../dist/img/online.png" width="45px" height="45px" style="margin-right:3px;" alt=""></span>

            <div class="info-box-content">
              <span class="info-box-text">Online Application</span>
              <span class="info-box-number">
                       <?php
                  $query = mysqli_query($wconn, "SELECT count(*) as ss FROM `geo_bpls_ol_application` where step = 'APPLICATION APPROVAL'") or die(mysqli_error());
                  $row = mysqli_fetch_assoc($query);
                  echo  $row["ss"];
                ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12"  style="cursor:pointer;">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><img src="../dist/img/release.png" width="45px" height="45px" style="margin-right:3px;" alt=""></span>

            <div class="info-box-content ">
              <span class="info-box-text">For Release</span>
              <span class="info-box-number">
                <?php
                  $query = mysqli_query($conn, "SELECT count(*) as ss FROM `geo_bpls_business_permit` where permit_no is null and step_code = 'RELEA'") or die(mysqli_error());
                  $row = mysqli_fetch_assoc($query);
                  echo  $row["ss"];
                ?>
              </span>
              <b><a href="#"  data-toggle="modal" data-target="#for_release" >View</a></b>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
</div>
<div class="row">
    <div class="col-md-12">
       <div class="box box-primary ">
        <div class="box-header">
             <h4>Business Income</h4>
        </div>
          <div class="box-body">
              <canvas id="myChart1" width="400" height="115"></canvas>
          </div>
      </div>
    </div>
</div>

<!-- Modal -->
<div id="for_release" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Releasing</h4>
      </div>
      <div class="modal-body">
            
                <?php
                    $qw = mysqli_query($conn,"SELECT permit_no, owner_first_name, owner_middle_name, owner_last_name , business_name, status_desc, step_desc, payment_frequency_desc , permit_id, geo_bpls_business.business_id FROM `geo_bpls_business_permit` inner join geo_bpls_owner on geo_bpls_owner.owner_id = geo_bpls_business_permit.owner_id inner join geo_bpls_business on geo_bpls_business.business_id = geo_bpls_business_permit.business_id inner join geo_bpls_status on geo_bpls_status.status_code = geo_bpls_business_permit.status_code inner join geo_bpls_step on geo_bpls_step.step_code = geo_bpls_business_permit.step_code inner join geo_bpls_payment_frequency on geo_bpls_payment_frequency.payment_frequency_code = geo_bpls_business_permit.payment_frequency_code where permit_no is null and geo_bpls_business_permit.step_code = 'RELEA' ");

                    if(mysqli_num_rows($qw)> 0){
                      echo '<table  class="table ">
                      <tr class="bg-primary">
                          <td>Business Name</td>
                          <td>Owner</td>
                          <td>Application Type</td>
                          <td>Payment Mode</td>
                          <td>Action</td>
                      </tr>';
                    while($rw = mysqli_fetch_assoc($qw)){
                        ?>
                 <tr>
                    <td><?php echo $rw["business_name"];?></td>
                    <td><?php echo $rw["owner_first_name"]."".$rw["owner_middle_name"]." ".$rw["owner_last_name"];  ?></td>
                    <td><?php echo $rw["status_desc"];?></td>
                    <td><?php echo $rw["payment_frequency_desc"];?></td>
                    <td>
                        <a href='bpls/pdf_excel/business_permit.php?target=<?php echo md5($rw["permit_id"]); ?>'  target="_blank" class="btn btn-info" >   RELEASE </a>
                    </td>
                </tr>
                        <?php
                    }
                    echo '</table>';
                  }else{
                    echo "<h3>No Permit for Release!</h3>";
                  }
                ?>
              
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    <script>
     $(function () {
      // addData(myChart, '# of Votes 2017', '#ff0000', [16, 14, 8]);
       var dset = [];
      $.ajax({
         type:'POST',
         url:'bpls/ajax_dash_chart.php',
         datatype:"HTML",
         success:function(JSONObject){
              JSONObject = jQuery.parseJSON(JSONObject);
            // count the length of the converted jsonobject
                 data = JSONObject.data;
                 label = JSONObject.label;
                 data2 = JSONObject.data2;
                 label2 = JSONObject.label2;
                  new Chart(document.getElementById("myChart1"), {
                    type: 'line',
                    data: {
                        labels: label,
                        datasets: [{ 
                            data: data,
                            label: "Income",
                            borderColor: "#3e95cd",
                            fill: false
                        }, { 
                            data: data2,
                            label: "Business Registered",
                            borderColor: "#32d426",
                            fill: false
                        },
                        ]
                    },
                    options: {
                        title: {
                        display: true,
                        text: 'Majayjay Business Status'
                        }
                    }
                    });
         }
      });

    });

    </script>

    