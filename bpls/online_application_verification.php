<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
include 'jomar_assets/enc.php';
include 'php/web_connection.php';



    if(isset($_GET["a"]) && isset($_GET["b"])){
        $md5id  = me_decrypt($_GET["b"]);
        $uniqID = $_GET["a"];
        $ver = 0;
        $q = mysqli_query($wconn,"SELECT * FROM `geo_bpls_ol_application` where md5(id) = '$md5id' and uniqID ='$uniqID'   ");
        $count = mysqli_num_rows($q);
        if($count >0){
        $r = mysqli_fetch_assoc($q);
        $step = $r["step"];
           ?>
         <form method="POST" action="" enctype="multipart/form-data">
       <div class="box box-success">
        
        <div class="box-body">
        <div class="panel-group" style="cursor:pointer;">
                        <div class="panel panel-default">
                            <div class="panel-heading"
                                style="color:white; text-align:center; background:#343536; font-size:19px; padding:2px;"
                                data-toggle="collapse" href="#collapse0" aria-expanded="true">
                                REQUIREMENTS VALIDATION
                            </div>
                            <div id="collapse0" class="panel-collapse collapse in" aria-expanded="true">
                                
                            <div class="row" style="margin:2px;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for=""> First Name: </label>
                                        <input type="text" class="form-control"  value="<?php echo $r["fname"]; ?>"  readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for=""> Middle Name: </label>
                                        <input type="text" class="form-control"  value="<?php echo $r["mname"]; ?>"  readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for=""> Last Name: </label>
                                        <input type="text" class="form-control"  value="<?php echo $r["lname"]; ?>"  readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin:2px;">
                                <div class="col-md-8">
                                     <div class="form-group">
                                        <label for="">Business Name: </label>
                                        <input type="text" class="form-control" value="<?php echo $r["b_name"]; ?>"  readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Date: </label>
                                        <input type="date" class="form-control" value="<?php echo $r["date"]; ?>"  readonly>
                                    </div>
                                </div>
                                <div class="row" style="margin:2px;">
                                    <div class="col-md-12">
                                        <label>Owner's Address:</label>
                                        <textarea class="form-control" name="o_address" readonly> <?php echo $r["address"]; ?> </textarea>
                                    </div>
                                </div>
                            </div>
                                <table class="table">
                                    <tr style="font-size:15px;">
                                        <td class="bg-primary"> Requirements file</td>
                                        <td class="bg-primary"> Status</td>
                                        <td class="bg-primary"> View</td>
                                    </tr>
                                    <?php
                                    $query = mysqli_query($wconn, "SELECT * FROM geo_bpls_business_requirement_ol inner join geo_bpls_requirement on  geo_bpls_requirement.requirement_id = geo_bpls_business_requirement_ol.requirement_id where uniqID = '$uniqID'");
                                        while($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <label for=""> <b><?php echo $row["requirement_desc"]; ?>:</b></label>
                                            <?php
                                                // preventing to show if application is approved
                                            if($step == "REQUIREMENTS APPROVAL"){
                                               if($row["requirement_status"] != 1){
                                            ?>
                                            <input type="file" name="requirement_file[]"  class="select_all_req saving_validator " > 
                                            <input type="hidden" name="requirement_id[]"  class="select_all_req" value="<?php echo $row["requirement_id"]; ?>">
                                            <?php }
                                            } ?> 
                                        </td>
                                        <td>
                                            <?php
                                                 if($row["requirement_status"] == 1){
                                                     
                                                    ?>
                                                   <span class="label  bg-green" style="font-size:14px;">Verified</span>
                                                    <?php
                                                }elseif($row["requirement_status"] ==2){
                                                    $ver++;
                                                    ?>
                                                       <span class="label  bg-red" style="font-size:14px;">Disapproved</span>
                                                    <?php
                                                }else{
                                                    $ver++;
                                                    ?>
                                                        <span class="label  bg-orange" style="font-size:14px;">Pending</span>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        <td>
                                           <button type="button" class="btn btn-info form-control btn_pic" data-toggle="modal" data-target="#viewfile" r_desc="<?php echo $row["requirement_desc"]; ?>" br_id="<?php echo md5($row["business_requirement_id"]); ?>" r_id="<?php echo md5($row["requirement_id"]); ?>" >View</button>
                                        </td>
                                    </tr>
                                    <?php
                                        } ?>
                                        <td colspan="3" >
                                            <?php
                                                if($ver == 0){

                                                    // if tapos na sa verification then show application form
                                                    if($step != "REQUIREMENTS APPROVAL"){
                                                        // get permit_id
                                                    $q64d = mysqli_query($wconn,"SELECT permit_id from geo_bpls_ol_application where uniqID =  '$uniqID' ");
                                                    $r64d = mysqli_fetch_assoc($q64d);
                                                    $md5_permit_id = md5($r64d["permit_id"]);
                                                    ?>
                                                   <a href="bpls/pdf_excel/bpls_application.php?target=<?php echo $md5_permit_id; ?>" target="_blank" class="btn btn-success pull-right" style="margin-left:3px;">Print Application Form</a>
                                                    <?php
                                                    }else{

                                                        //check Online if this is renewal
                                                            $q4562 = mysqli_query($wconn,"SELECT * FROM `geo_bpls_ol_renewal` where uniqID =  '$uniqID'");

                                                            if(mysqli_num_rows($q4562)>0){
                                                            // getting permit id of business to renew
                                                            $r4562 = mysqli_fetch_assoc($q4562);
                                                            
                                                                $permit_no = $r4562["permit_no"];
                                                                
                                                                $q009 = mysqli_query($conn,"SELECT * FROM `geo_bpls_business_permit` where permit_no = '$permit_no' ");
                                                                $r009 = mysqli_fetch_assoc($q009);
                                                                $renew_permit_id = $r009["permit_id"];
                                                                $business_id = $r009["business_id"];
                                                                // get business_name
                                                                $q0029 = mysqli_query($conn,"SELECT * FROM `geo_bpls_business` where business_id = '$business_id' ");
                                                                $r0029 = mysqli_fetch_assoc($q0029);
                                                                $business_name = $r0029["business_name"];
                                                            ?>
                                                              <a href='#'   class='btn btn-success renew_btn pull-right' ca_business='<?php echo  str_replace("'","&#8217;",$business_name); ?>' ca_target='<?php echo md5($renew_permit_id); ?>' md5id="<?php echo $md5id; ?>" uniqID='<?php echo $uniqID; ?>' title='Renew'>Procees to "BUSINESS RENEWAL"</a> 

                                                            <?php
                                                            }else{
                                                                ?>
                                                                <a href="bplsmodule.php?redirect=OAV2&a=<?php echo $_GET['a']; ?>" class="btn btn-success pull-right" style="margin-left:3px;">Continue to verify  "BUSINESS APPLICATION"</a>
                                                                 
                                                                <?php 
                                                            }


                                                    }
                                                }else{
                                                    ?>
                                                    <input type="submit" name="update_requirement" class="btn btn-warning pull-right" value="UPDATE">
                                                    <?php
                                                }
                                            ?>
                                        </td>            
                                    </tr>
                                </table>
                                <!-- <div class="panel-footer">Footer</div> -->
                            </div>
                        </div>
                    </div>
        </div>
    </div>
    </form>
       <?php
        }
    }
?>

<form method="POST" action="">
<!-- Modal -->
<div id="viewfile" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> <span id="pic_header"> </span> </h4>
      </div>
      <div class="modal-body">
		  <span id="pic_body"> </span>
          
           <?php
              // preventing to show if application is approved
             if($step == "REQUIREMENTS APPROVAL"){
           ?>
        <div class="row" style="margin:5px;">
            <div class="col-md-12">
                <div class="form-group">
                    <label for=""> Add Comments </label>
                    <textarea class="form-control" name="comment" style="height:120px;" ></textarea>
                    <input type="hidden" name="r_id" id="r_id">
                    <input type="hidden" name="requirements_name" id="requirements_name">
                    <input type="hidden" name="br_id" id="br_id">
                    <input type="hidden" name="uniqID" value="<?php echo $_GET["a"]; ?>">
                </div>
            </div>
        </div>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
         <?php
              // preventing to show if application is approved
             if($step == "REQUIREMENTS APPROVAL"){
           ?>
        <button type="submit" name="approve" class="btn btn-success pull-right" >Approve</button>
        <button type="submit" name="disapprove" class="btn btn-warning pull-right" >Disapprove</button>
          <?php } ?>
      </div>
    </div>

  </div>
</div>
</form>
<?php
    // documents approval
    if(isset($_POST["approve"])){
        $r_id = $_POST["r_id"];
        $br_id = $_POST["br_id"];
        $uniqID = $_POST["uniqID"];
        $comment = $_POST["comment"];
        if($comment != ""){
            $str_comment = " `comment`= '$comment' ,";
        }else{
            $str_comment = "";

        }

     
        $q = mysqli_query($wconn,"UPDATE `geo_bpls_business_requirement_ol` SET $str_comment  requirement_status = 1 WHERE uniqID = '$uniqID' and md5(business_requirement_id) = '$br_id' and md5(requirement_id) = '$r_id' ");
       
        // count the pending and disapprove docs
        $q768 = mysqli_query($wconn,"SELECT * from geo_bpls_business_requirement_ol where uniqID = '$uniqID' and  (requirement_status = 0 or requirement_status = 2)");
        $q768_count = mysqli_num_rows($q768);
            // send notif pag wala ng pending at disapprove
        if($q768_count == 0){
         //  EMAIL NOTIFICATION================
        $q433 = mysqli_query($wconn,"SELECT email from usersacc_tbl inner join geo_bpls_ol_application on geo_bpls_ol_application.customer_id =  usersacc_tbl.usersacc_id where uniqID = '$uniqID' ");
        $r433 = mysqli_fetch_assoc($q433);
         $to = $r433["email"];

            //Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'great.system.mailer@gmail.com';                     //SMTP username
                $mail->Password   = 'ahyou1324^^_mailer';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 465;                                    // 587 TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                //Recipients
                $mail->setFrom('great.system.mailer@gmail.com', 'GreatSystem');
                // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
                $mail->AddAddress($to);      //Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');
                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Business Permit';
                $mail->Body  = '<table style="width:100%; font-size:16px; margin-top:5px;">
                <tr>
                    <td><p>Good Day, This is to inform you that all of your requirement in Business Permit has been approved, you may now proceed to filing Business Application.</p></td>
                    </tr>
                </table>
                <br>
                <br>
                <br>';
                if($comment != ""){
                $mail->Body  .= '<div style=" font-size:16px;" >
                    Reason: <i style="color:red;">'.$comment.'</i>
                </div>
                ';
                    }
                $mail->send();
                ?>
                <script>
                    // alert("We already sent you an email");
                    // location.replace("login.php");
                </script>
                <?php
                } catch (Exception $e) {
                    ?>
                <script>
                    // alert("Sending error");
                    // location.replace("login.php");
                </script>
                <?php
                }       
        
                //  EMAIL NOTIFICATION================
            }


        ?>
        <script>
            alert("Document Approved!");
            location.replace("bplsmodule.php?redirect=OAV&a=<?php echo $uniqID; ?>&b=<?php echo $_GET["b"]; ?>");
        </script>
        <?php
    }
// documents approval
    if(isset($_POST["disapprove"])){
        $requirements_name = $_POST["requirements_name"];
        $r_id = $_POST["r_id"];
        $br_id = $_POST["br_id"];
        $uniqID = $_POST["uniqID"];
        $comment = $_POST["comment"];
        if ($comment != "") {
            $str_comment = " `comment`= '$comment' ,";
        } else {
            $str_comment = "";
        }
        
        $q = mysqli_query($wconn, "UPDATE `geo_bpls_business_requirement_ol` SET $str_comment  requirement_status = 2 WHERE uniqID = '$uniqID' and md5(business_requirement_id) = '$br_id' and md5(requirement_id) = '$r_id' ");
         //  EMAIL NOTIFICATION================
        $q433 = mysqli_query($wconn,"SELECT email from usersacc_tbl inner join geo_bpls_ol_application on geo_bpls_ol_application.customer_id =  usersacc_tbl.usersacc_id where uniqID = '$uniqID' ");
        $r433 = mysqli_fetch_assoc($q433);
         $to = $r433["email"];

            //Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'great.system.mailer@gmail.com';                     //SMTP username
                $mail->Password   = 'ahyou1324^^_mailer';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 465;                                    // 587 TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                //Recipients
                $mail->setFrom('great.system.mailer@gmail.com', 'GreatSystem');
                // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
                $mail->AddAddress($to);      //Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');
                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Business Permit';
                $mail->Body  = '<table style="width:100%; font-size:16px; margin-top:5px;">
                <tr>
                    <td><p>Good Day, This is to inform you that your "'.$requirements_name.'" requirement has been disapproved!</p></td>
                    </tr>
                </table>
                <br>
                <br>
                <br>';
                if($comment != ""){
                $mail->Body  .= '<div style=" font-size:16px;" >
                    Reason: <i style="color:red;">'.$comment.'</i>
                </div>
                ';
                    }
                $mail->send();
        ?>
        <script>
            // alert("We already sent you an email");
            // location.replace("login.php");
        </script>
        <?php
        } catch (Exception $e) {
            ?>
        <script>
            // alert("Sending error");
            // location.replace("login.php");
        </script>
        <?php
        }       
 
        //  EMAIL NOTIFICATION================

        ?>
                <script>
                    alert("Document Dispproved!");
                    location.replace("bplsmodule.php?redirect=OAV&a=<?php echo $uniqID; ?>&b=<?php echo $_GET["b"]; ?>");
                </script>
                <?php
    }
    


    if(isset($_POST["update_requirement"])){
        if (isset($_FILES["requirement_file"])) {
        $arr_count2 = count($_FILES["requirement_file"]["name"]);
        // insert
		
        if($arr_count2 > 0){
            for($ib = 0; $ib < $arr_count2; $ib++) {
                if($_FILES["requirement_file"]["name"][$ib] != ""){
				
                $requirement_id = $_POST["requirement_id"][$ib];
                $target_dir = "https://majayjay.com/eServices/bpls/bpls_files/";
                $target_file = $target_dir . basename($_FILES["requirement_file"]["name"][$ib]);
                $filename = basename($_FILES["requirement_file"]["name"][$ib]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				// get old file to unlink
				$q232 = mysqli_query($wconn,"SELECT requirement_file from geo_bpls_business_requirement_ol where uniqID = '$uniqID' and requirement_id = '$requirement_id' ");
				$r232 = mysqli_fetch_assoc($q232);
				if($r232["requirement_file"] != "" || $r232["requirement_file"] != null ){
					$to_unlink_file = $target_dir.$r232["requirement_file"];
					// updating files
					mysqli_query($wconn,"UPDATE `geo_bpls_business_requirement_ol` SET `requirement_file`= '$filename', requirement_status = '1' , check_status = 1  where uniqID = '$uniqID' and requirement_id = '$requirement_id' ");
					unlink($to_unlink_file);
				}else{
					// insert pag walapang exist
					$q = mysqli_query($wconn, "INSERT INTO `geo_bpls_business_requirement_ol`(`uniqID`,  `requirement_id`, `requirement_file`, `business_id`, `requirement_active`, `requirement_status`, `comment`,`check_status`) VALUES ('$uniqID','$requirements_id','$filename','0','1','1',' ',1) ") or die(mysqli_error($wconn));
				}
				if (move_uploaded_file($_FILES["requirement_file"]["tmp_name"][$ib], $target_file)) {
						// echo "The file ". htmlspecialchars( basename( $_FILES["requirement_file"]["name"][$ib])). " has been uploaded.";
				}
            }
        }
      }
    }
    // requirement ----------------------------------------------
?>
        <script>
            alert("Requirements updated!");
            window.location.replace("bplsmodule.php?redirect=OAV&a=<?php echo $_GET["a"]; ?>&b=<?php echo $_GET["b"]; ?>");
        </script>
        <?php
    }
?>
<script>
	$(document).on("click",".btn_pic",function(){
		r_desc = $(this).attr("r_desc");
		r_id = $(this).attr("r_id");
		br_id = $(this).attr("br_id");
        
        $("#br_id").val(br_id);
        $("#r_id").val(r_id);
		$("#pic_header").html("<b>"+r_desc+"</b>");
		$("#requirements_name").val(r_desc);
		
		
		$.ajax({
			method:"POST",
			url:"bpls/online_verify_doc.php",
			data:{br_id:br_id,r_id:r_id, uniqID:"<?php echo $uniqID; ?>"},
			success:function(result){
				$("#pic_body").html(result);
			}
		});
	});

    $(document).on("click",".renew_btn",function(){
        var target = $(this).attr("ca_target");
        var ca_business = $(this).attr("ca_business");
        var uniqID = $(this).attr("uniqID");
        var md5id = $(this).attr("md5id");

      myalert_success("Proceed to renewal of this "+ca_business+" Business?");
      $('.modal-open').css({"overflow":"visible","padding-right":"0px"});
    $(".s35343_btn").click(function() {
        location.replace("bplsmodule.php?redirect=business_renewal_online&target=ren_"+target+"&uniqID="+uniqID+"&md5id="+md5id);
    });
    $(".s64534_btn").click(function() {
        // $('#myModal_alert_w').modal('hide');
        $('#myModal_alert_s').remove();
        $('.modal-backdrop').remove();
        // add for datatbales disabled scrol and padding-right;
        $('.modal-open').css({"overflow":"visible","padding-right":"0px"});

    });
});
</script>	