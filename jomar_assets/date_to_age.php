<?php
function date_to_age($birthDate){
  $convert_date_arr = explode("-", $birthDate);
  $convert_date = $convert_date_arr[1] . "/" . $convert_date_arr[2] ."/". $convert_date_arr[0];

//explode the date to get month, day and year
$birthDate = explode("/", $convert_date);
//get age from date or birthdate
$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
    ? ((date("Y") - $birthDate[2]) - 1)
    : (date("Y") - $birthDate[2]));

    return $age;
    }


    function age_to_month($bday){
      $birthday = new DateTime($bday);
      $diff = $birthday->diff(new DateTime());
      $months = $diff->format('%m') + 12 * $diff->format('%y');
      return $months;
    }
?>