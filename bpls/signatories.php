<div class="box box-primary">
    <div class="box-body">
<!-- ========================================================= -->

        <h2>Business Permit Signatories</h2>

        <?php
            $q0 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = 'business_permit'");
            $r0 = mysqli_fetch_assoc($q0);
            $signatory_name = $r0["signatory_name"];
            $signatory_position = $r0["signatory_position"];
            $e_signatory = $r0["e_signatory"];
            $esig_status = $r0["esig_status"];
        ?>
        <form method="POST" action=""  enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for=""> Position: </label>
                    <input type="text" name="sig_position" class="form-control" value="<?php echo $signatory_position; ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for=""> Name: </label>
                    <input type="text" name="sig_name" class="form-control" value="<?php echo $signatory_name; ?>">
                </div>
            </div>
        <?php 
            if($e_signatory == ""){
        ?>
            <div class="col-md-3">
                <div class="form-group">
                    <label for=""> E-sig File: </label>
                    <input type="file" name="esig" class="form-control">
                </div>
            </div>
        <?php
        }else{
        ?>
            <div class="col-md-2">
                <div class="form-group">
                    <label for=""> E-sig File: </label>
                    <input type="file" name="esig" class="form-control">
                </div>
            </div>

            <div class="col-md-1">
                <div class="form-group">
                    <label for=""> &nbsp; &nbsp;</label>
                   <input type="button" class="btn btn-info view_btn" ca_pic="<?php echo $e_signatory; ?>" value="view" data-toggle="modal" data-target="#view_doc">
                </div> 
           </div>
        <?php
        }
        ?>
            
            <div class="col-md-3">
                <table style="width: 100%;">
                    <tr>
                        <td> <input type="button" <?php if(isset($esig_status)){  if($esig_status== "1"){ ?>  class=" btn btn-success pull-left form-control activate_esig_business_permit" ca_id="1"  style="margin-top:25px;"   value="Deactivate E-sig"  <?php }else{  ?>  class=" btn btn-danger pull-left form-control activate_esig_business_permit" ca_id="0"  style="margin-top:25px;"   value="Activate E-sig"  <?php  } } ?>  ></td>
                        <td> <input type="submit" name="update_business_permit form-control" style="margin-top:25px;" class="btn btn-success pull-right" value="Update"></td>
                    </tr>
                </table>
            </div>
        </div>
        </form>
<!-- ========================================================= -->

<!-- ========================================================= -->

<h2>Business Retirement Signatories</h2>

<!-- ========================================================= -->

<?php
    $q0 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = 'business_retirement_tres'");
    $r0 = mysqli_fetch_assoc($q0);
    $signatory_name = $r0["signatory_name"];
    $signatory_position = $r0["signatory_position"];
    $e_signatory = $r0["e_signatory"];
?>
<form method="POST" action=""  enctype="multipart/form-data">
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <label for=""> Position: </label>
            <input type="text" name="sig_position" class="form-control" value="Municipal Treasurer" >
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for=""> Name: </label>
            <input type="text" name="sig_name" class="form-control" value="<?php echo $signatory_name; ?>">
        </div>
    </div>
    
    <div class="col-md-2">
        <div class="form-group">
            <label for=""> &nbsp; &nbsp;</label>
            <input type="submit" name="update_business_retire_tres"  class="form-control btn btn-success" value="Update">
        </div>
    </div>
</div>
</form>
<!-- ========================================================= -->



<!-- ========================================================= -->

<?php
    $q0 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = 'business_retirement_bplo'");
    $r0 = mysqli_fetch_assoc($q0);
    $signatory_name = $r0["signatory_name"];
    $signatory_position = $r0["signatory_position"];
    $e_signatory = $r0["e_signatory"];
?>
<form method="POST" action=""  enctype="multipart/form-data">
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <label for=""> Position: </label>
            <input type="text" name="sig_position" class="form-control" value="BPLO - Designate" >
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for=""> Name: </label>
            <input type="text" name="sig_name" class="form-control" value="<?php echo $signatory_name; ?>">
        </div>
    </div>
    
    <div class="col-md-2">
        <div class="form-group">
            <label for=""> &nbsp; &nbsp;</label>
            <input type="submit" name="update_business_retire_bplo"  class="form-control btn btn-success" value="Update">
        </div>
    </div>
</div>
</form>
<!-- ========================================================= -->

<?php
    $q0 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = 'business_retirement_clerk'");
    $r0 = mysqli_fetch_assoc($q0);
    $signatory_name = $r0["signatory_name"];
    $signatory_position = $r0["signatory_position"];
    $e_signatory = $r0["e_signatory"];
?>
<form method="POST" action=""  enctype="multipart/form-data">
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <label for=""> Position: </label>
            <input type="text" name="sig_position" class="form-control" value="Collection Clerk" >
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for=""> Name: </label>
            <input type="text" name="sig_name" class="form-control" value="<?php echo $signatory_name; ?>">
        </div>
    </div>
    
    <div class="col-md-2">
        <div class="form-group">
            <label for=""> &nbsp; &nbsp;</label>
            <input type="submit" name="update_business_retire_clerk"  class="form-control btn btn-success" value="Update">
        </div>
    </div>
</div>
</form>

<!-- ========================================================= -->

<!-- ========================================================= -->

<?php
    $q0 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = 'business_retirement_mo'");
    $r0 = mysqli_fetch_assoc($q0);
    $signatory_name = $r0["signatory_name"];
    $signatory_position = $r0["signatory_position"];
    $e_signatory = $r0["e_signatory"];
?>
<form method="POST" action=""  enctype="multipart/form-data">
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <label for=""> Position: </label>
            <input type="text" name="sig_position" class="form-control" value="Municipal Mayor" >
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for=""> Name: </label>
            <input type="text" name="sig_name" class="form-control" value="<?php echo $signatory_name; ?>">
        </div>
    </div>
    
    <div class="col-md-2">
        <div class="form-group">
            <label for=""> &nbsp; &nbsp;</label>
            <input type="submit" name="update_business_retire_mo"  class="form-control btn btn-success" value="Update">
        </div>
    </div>
</div>
</form>

<!-- ========================================================= -->


<h2>BPLS 51C Receipt Signatories</h2>

<?php
    $q0 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = '51c_receipt'");
    $r0 = mysqli_fetch_assoc($q0);
    $signatory_name = $r0["signatory_name"];
    $signatory_position = $r0["signatory_position"];
    $e_signatory = $r0["e_signatory"];
?>
<form method="POST" action=""  enctype="multipart/form-data">
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for=""> Position: </label>
            <input type="text" name="sig_position" class="form-control" value="<?php echo $signatory_position; ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for=""> Name: </label>
            <input type="text" name="sig_name" class="form-control" value="<?php echo $signatory_name; ?>">
        </div>
    </div>
<?php 
    if($e_signatory == ""){
?>
    <div class="col-md-3">
        <div class="form-group">
            <label for=""> E-sig File: </label>
            <input type="file" name="esig" class="form-control">
        </div>
    </div>
<?php
}else{
?>
    <div class="col-md-2">
        <div class="form-group">
            <label for=""> E-sig File: </label>
            <input type="file" name="esig" class="form-control">
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label for=""> &nbsp; &nbsp;</label>
           <input type="button" class="btn btn-info view_btn" ca_pic="<?php echo $e_signatory; ?>" value="view" data-toggle="modal" data-target="#view_doc">
        </div>
    </div>
<?php
}
?>
    
    <div class="col-md-2">
        <div class="form-group">
            <label for=""> &nbsp; &nbsp;</label>
            <input type="submit" name="update_51c"  class="form-control btn btn-success" value="Update">
        </div>
    </div>
</div>
</form>
<!-- ========================================================= -->



<!-- ========================================================= -->

<h2>Compliance Monitoring Signatories</h2>
<div class="row">

<?php
    $q0 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = 'compliance_monitoring_report_s1'");
    while($r0 = mysqli_fetch_assoc($q0)){
    $signatory_name = $r0["signatory_name"];
    $signatory_position = $r0["signatory_position"];
    $e_signatory = $r0["e_signatory"];
?>
<form method="POST" action=""  enctype="multipart/form-data">
    <div class="col-md-3">
        <div class="form-group">
            <label for=""> Position: </label>
            <input type="text" name="sig_position" class="form-control" value="<?php echo $signatory_position; ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for=""> Name: </label>
            <input type="text" name="sig_name" class="form-control" value="<?php echo $signatory_name; ?>">
        </div>
    </div>
<?php 
    if($e_signatory == ""){
?>
    <div class="col-md-3">
        <div class="form-group">
            <label for=""> E-sig File: </label>
            <input type="file" name="esig" class="form-control">
        </div>
    </div>
<?php
}else{
?>
    <div class="col-md-2">
        <div class="form-group">
            <label for=""> E-sig File: </label>
            <input type="file" name="esig" class="form-control">
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label for=""> &nbsp; &nbsp;</label>
           <input type="button" class="btn btn-info view_btn" ca_pic="<?php echo $e_signatory; ?>" value="view" data-toggle="modal" data-target="#view_doc">
        </div>
    </div>
<?php
}
?>
    
    <div class="col-md-2">
        <div class="form-group">
            <label for=""> &nbsp; &nbsp;</label>
            <input type="submit" name="compliance_monitoring1"  class="form-control btn btn-success" value="Update">
        </div>
    </div>
</div>

<?php } ?>
</form>

<div class="row">

<?php
    $q0 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = 'compliance_monitoring_report_s2'");
    while($r0 = mysqli_fetch_assoc($q0)){
    $signatory_name = $r0["signatory_name"];
    $signatory_position = $r0["signatory_position"];
    $e_signatory = $r0["e_signatory"];
?>
<form method="POST" action=""  enctype="multipart/form-data">
    <div class="col-md-3">
        <div class="form-group">
            <label for=""> Position: </label>
            <input type="text" name="sig_position" class="form-control" value="<?php echo $signatory_position; ?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for=""> Name: </label>
            <input type="text" name="sig_name" class="form-control" value="<?php echo $signatory_name; ?>">
        </div>
    </div>
<?php 
    if($e_signatory == ""){
?>
    <div class="col-md-3">
        <div class="form-group">
            <label for=""> E-sig File: </label>
            <input type="file" name="esig" class="form-control">
        </div>
    </div>
<?php
}else{
?>
    <div class="col-md-2">
        <div class="form-group">
            <label for=""> E-sig File: </label>
            <input type="file" name="esig" class="form-control">
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label for=""> &nbsp; &nbsp;</label>
           <input type="button" class="btn btn-info view_btn" ca_pic="<?php echo $e_signatory; ?>" value="view" data-toggle="modal" data-target="#view_doc">
        </div>
    </div>
<?php
}
?>
    
    <div class="col-md-2">
        <div class="form-group">
            <label for=""> &nbsp; &nbsp;</label>
            <input type="submit" name="compliance_monitoring2"  class="form-control btn btn-success" value="Update">
        </div>
    </div>
</div>

<?php } ?>


</form>
<!-- ========================================================= -->



    </div>
</div>


<!-- -- view doc Modal -->
                    <div class="modal fade" id="view_doc" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <!-- body start -->
                                            <div class="fetch_view_doc"> </div>
                                    <!-- body end -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger pull-left"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                  <!-- view doc Modal -->

        <script>
            $(document).on("click",".view_btn",function(){
                ca_pic = $(this).attr("ca_pic");
                
                $(".fetch_view_doc").html("<img src='bpls/images_file/e_sig/"+ca_pic+"' style='width:100%; height:100%'> ");
            });
            $(document).on("click",".activate_esig_business_permit",function(){
                if(confirm("Are you sure do you want update status?")){
                if($(this).attr("ca_id") == "1"){
                    $(this).removeClass("btn-success");
                    $(this).addClass("btn-danger");
                    $(this).attr("ca_id","0");
                    $(this).val("Activate E-sig");
                    ca_id = $(this).attr("ca_id");
                        $.ajax({
                            method:"POST",
                            url:"bpls/ajax_esig_activation.php",
                            data:{"type":"business_permit",ca_id:ca_id},
                                success:function(result){
                            }
                        });
                }else{
                    $(this).removeClass("btn-danger");
                    $(this).addClass("btn-success");
                    $(this).attr("ca_id","1");
                    $(this).val("Deactivate E-sig");
                    ca_id = $(this).attr("ca_id");
                    $.ajax({
                        method:"POST",
                        url:"bpls/ajax_esig_activation.php",
                        data:{"type":"business_permit",ca_id:ca_id},
                        success:function(result){
                        }
                    });
                }
            }
               
            });
        </script>


<?php
   if(isset($_POST["update_business_permit"]) ||  isset($_POST["update_51c"])  ||  isset($_POST["compliance_monitoring1"])  ||  isset($_POST["compliance_monitoring2"]) ||  isset($_POST["update_business_retire_clerk"]) ||  isset($_POST["update_business_retire_tres"])  ||  isset($_POST["update_business_retire_bplo"])  ||  isset($_POST["update_business_retire_mo"])  ){
    
    if(isset($_POST["update_business_permit"])){
        $target_file_cond = "business_permit";
    }
    if(isset($_POST["update_51c"])){
        $target_file_cond = "51c_receipt";
    }
    if(isset($_POST["compliance_monitoring1"])){
        $target_file_cond = "compliance_monitoring_report_s1";
    }
    if(isset($_POST["compliance_monitoring2"])){
        $target_file_cond = "compliance_monitoring_report_s2";
    }

    if(isset($_POST["update_business_retire_clerk"])){
        $target_file_cond = "business_retirement_clerk";
    }

    if(isset($_POST["update_business_retire_tres"])){
        $target_file_cond = "business_retirement_tres";
    }
    if(isset($_POST["update_business_retire_bplo"])){
        $target_file_cond = "business_retirement_bplo";
    }

    if(isset($_POST["update_business_retire_mo"])){
        $target_file_cond = "business_retirement_mo";
    }
    
    $sig_position = mysqli_real_escape_string($conn,$_POST["sig_position"]);
    $sig_name = mysqli_real_escape_string($conn,$_POST["sig_name"]);
    
    
    
    if($_FILES["esig"]["name"] != ""){

                $temp = explode(".", $_FILES["esig"]["name"]);
                $attachment_file = date("Ymdhis").".".end($temp);
                $target_dir = "bpls/images_file/e_sig/";
                $target_file = $target_dir . $attachment_file;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if ($uploadOk == 0) {
                    // echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["esig"]["tmp_name"], $target_file)) {
                        
                        // check old file if meron iuunlink
                        $q22 = mysqli_query($conn,"SELECT * FROM `geo_bpls_signatory` where target_file = '$target_file_cond'");
                        $r22 = mysqli_fetch_assoc($q22);
                        $e_signatory = $r22["e_signatory"];
                        if($e_signatory != ""){
                            unlink("bpls/images_file/e_sig/".$e_signatory);
                        }
                        $q = mysqli_query($conn,"UPDATE `geo_bpls_signatory` SET `signatory_name`='$sig_name',`signatory_position`='$sig_position',`e_signatory`= '$attachment_file' where target_file = '$target_file_cond' ");
                        if($q){
                            ?>
                            <script>
                                alert("Business Permit Signatories Updated asd");
                                location.replace("bplsmodule.php?redirect=signatories");
                            </script>
                            <?php
                        }
                    }
                }

               


            }else{
                $q = mysqli_query($conn,"UPDATE `geo_bpls_signatory` SET `signatory_name`='$sig_name',`signatory_position`='$sig_position' where target_file = '$target_file_cond' ");
                if($q){
                    ?>
                    <script>
                        alert("Business Permit Signatories Updated");
                        location.replace("bplsmodule.php?redirect=signatories");
                    </script>
                    <?php
                }
            }
    
}


?>
