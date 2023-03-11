<?php
include('../../php/connect.php');
$q = mysqli_query($conn,"SELECT * FROM `geo_bpls_bfp_settings` where id = '1' ");
$r = mysqli_fetch_assoc($q);
$val = $r["percentage"];
?>
<label for="">PERCENTAGE OF REGULATORY FEES AND CHARGES</label>
<input type="text" name="percentage" class="form-control" value="<?php echo $val; ?>" required>