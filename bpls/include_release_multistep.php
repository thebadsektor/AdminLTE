<div class="panel-group" style="cursor:pointer;">
    <div class="panel panel-default">
        <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
            data-toggle="collapse" href="#collapse1aO125" aria-expanded="true">
            BUSINESS PERMIT AND LICENSING SYSTEM
        </div>
        <div id="collapse1aO125" class="panel-collapse collapse in" aria-expanded="true">
            <div class="row" style="margin:2px;">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <td style="width:150px;"><b>Business Name:</b></td>
                            <td> <span class="business_name_mess "> </span> </td>
                        </tr>
                        <tr>
                            <td><b>Business Address:</b></td>
                            <td><span class="business_add_mess "></span> </td>
                        </tr>
                        <tr>
                            <td style="width:150px;"><b>Owners Name:</b></td>
                            <td> <span class="owners_name_mess "></span> </td>
                        </tr>
                        <tr>
                            <td><b>Owners Address:</b></td>
                            <td><span class="owners_add_mess "></span></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <td style="width:150px;"><b>Application Date:</b></td>
                            <td><?php echo $r11["permit_application_date"]; ?></td>
                        </tr>
                        <tr>
                            <td><b>Payment Mode:</b></td>
                            <td><?php echo $mode_of_payment; ?></td>
                        </tr>
                        <tr>
                            <td style="width:150px;"><b>Application Type:</b></td>
                            <td><?php echo $status_desc; ?></td>
                        </tr>
                        <tr>
                            <td><b>Step:</b></td>
                            <td><?php echo $step_code; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- header info -->

<div class="row" style="margin:30px; text-align:center;">
    <div class="col-md-12">
             <a href="bpls/pdf_excel/business_permit.php?target=<?php echo $id; ?>" style="color:white;" target="_blank">
             <button class="btn btn-info" style="width:100px; height:100px; margin-top:15px;" >
            <i class="fa fa-file" style="font-size:50px;"> </i>
            </a> 
         </button>  
    </div>
</div>