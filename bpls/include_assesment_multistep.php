<div class="panel-group" style="cursor:pointer;">
    <div class="panel panel-default">
        <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
            data-toggle="collapse" href="#collapse112" aria-expanded="true">
            BUSINESS PERMIT AND LICENSING SYSTEM
        </div>
        <div id="collapse112" class="panel-collapse collapse in" aria-expanded="true">
            <div class="row" style="margin:2px;">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <td style="width:150px;"><b>Business Name:</b></td>
                            <td> <span class="business_name_mess "> </span> </td>
                        </tr>
                        <tr>
                            <td><b>Business Address:</b></td>
                            <td><?php echo $business_address; ?></span> </td>
                        </tr>
                        <tr>
                            <td style="width:150px;"><b>Owners Name:</b></td>
                            <td> <span class="owners_name_mess "></span> </td>
                        </tr>
                        <tr>
                            <td><b>Owners Address:</b></td>
                            <td><?php echo $owner_address; ?></td>
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
                            <td><?php echo  $status_desc; ?></td>
                        </tr>
                        <tr>
                            <td><b>Step:</b></td>
                            <td><?php echo  $step_code; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- header info -->

<!-- Nature -->

<div class="panel-group" style="cursor:pointer;">
    <div class="panel panel-default">
        <div class="panel-heading" style="color:white; text-align:center; background:#343536; padding:2px;"
            data-toggle="collapse" href="#collapse122" aria-expanded="true">
            BUSINESS NATURE
        </div>
        <div id="collapse122" class="panel-collapse collapse in" aria-expanded="true">
        <!-- =================================== -->
        <!-- =================================== -->
        <!-- =================================== -->
        <?php
             include "include_assessment_processing.php";
        ?>
        <!-- =================================== -->
        <!-- =================================== -->
        <!-- =================================== -->
        <!-- =================================== -->
        </div>
    </div>
</div>
<!-- Nature -->

<?php
    include "include_payment_schedule.php";
?>

<!-- end -->
<script>
    

// tax due
$(document).on("change", ".tax_due_c", function() {
    
    var ca_attr = $(this).attr("ca_attr");

    if ($(".formula" + ca_attr).val() == "X0") {
        $(".base_input" + ca_attr).val($(this).val());
    }

    var count = 0;
    var total_due = 0;
    $(".tax_due_c").each(function() {
        total_due += parseFloat($(this).val());
    });
    $(".total_tax_due").val(total_due);
});
// append nature
// base value
$(document).on("change", ".base_input", function() {
    var ca_attr = $(this).attr("ca_attr");

    if ($(".formula" + ca_attr).val() == "X0") {
        $(".tax_due" + ca_attr).val($(this).val());
    }

    var count = 0;
    var total_due = 0;
    $(".tax_due_c").each(function() {
        total_due += parseFloat($(this).val());
    });

    $(".total_tax_due").val(total_due);
});

    // para sa discount pag nag change ng Inputed value
    $(document).on("change",".b_iX0",function(){
        discountdesc = $(this).attr("ca_discountdesc");
        tfo_nature_id = $(this).attr("ca_no");
        active_amount = $(this).val();
        ca_discount = $(this).attr("ca_discount");

        split_discount = ca_discount.split("+");
        ca_discount = ca_discount.replace("D0", active_amount);

        // sa discount description
        split_desc = discountdesc.split("<>");
        split_count = split_desc.length;

        var cont_discount = "";
        discount = 0;
        for(a=0; a<split_count-1; a++){
            int_amount = eval(split_discount[a].replace("D0", active_amount));
            discount += int_amount;
            cont_discount += split_desc[a]+int_amount.toFixed(2);
        }
        new_amount = active_amount - discount;

        $(".discount"+tfo_nature_id).val(discount);
        $(".taxdue"+tfo_nature_id).val(new_amount);
        discountdesc = cont_discount;
        $(".discountdesc"+tfo_nature_id).val(discountdesc);

        // recalculate taxdue

        var count = 0;
        var total_due = 0;
        $(".tax_due_c").each(function() {
            total_due += parseFloat($(this).val());
        });
        total_due = total_due.toFixed(2);

        $(".total_tax_due").val(total_due);
        
    });

    
    $(document).ready(function(){
        var a = 0; 
        $(".invalid_input_detection_class").each(function(){
            a++;
        });
       if(a>0){
            $("#assess_btn").prop("disabled",true);
       }else{
        $("#assess_btn").prop("disabled",false);
       }
    }); 

</script>
