<?php
    function month_diff($d1, $d2){
        $date_now = date("Y-m-d");
        //  quarter
        $datetime1 = date_create($d1);
        $datetime2 = date_create($d2);
        $interval = date_diff($datetime1, $datetime2);
          return $interval->format('%m');

    }
?>