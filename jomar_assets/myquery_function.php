<?php

    function delete_this($conn,$tbl_name,$col_name,$value){
            mysqli_query($conn,"DELETE FROM $tbl_name WHERE MD5($col_name) = '$value' ") or die(mysqli_error());
    }
    
?>