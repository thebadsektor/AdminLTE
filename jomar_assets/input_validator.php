<?php
function validate_str($conn,$input){

    if(!empty($input)){
        $input = mysqli_real_escape_string($conn, $input);
        $input = htmlspecialchars($input);

        // if(!preg_match('/^[\p{L}\p{N}_ -]+$/u', $input))
        //     {
        //         $input = "1_1"; //not valid String
        //     }

        return $input;
    }else{
        $input = "";
        return $input;
    }
}
function validate_num($conn,$input){

    if(!empty($input)){
        $input = mysqli_real_escape_string($conn, $input);
        $input = htmlspecialchars($input);

        // if(!preg_match('/^[\p{L}\p{N}_ -]+$/u', $input))
        //     {
        //         $input = "1_1"; //not valid String
        //     }

        return $input;
    }else{
        $input = "0";
        return $input;
    }
}
?>