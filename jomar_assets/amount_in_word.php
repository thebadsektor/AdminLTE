<?php

function AmountInWords($num)
{

$ones = array(
0 =>"Zero",
1 => "One",
2 => "Two",
3 => "Three",
4 => "Four",
5 => "Five",
6 => "Six",
7 => "Seven",
8 => "Eight",
9 => "Nine",
10 => "Ten",
11 => "Eleven",
12 => "Twelve",
13 => "Thirteen",
14 => "Fourteen",
15 => "Fifteen",
16 => "Sixteen",
17 => "Seventeen",
18 => "Eighteen",
19 => "Nineteen",
"014" => "Fourteen"
);
$tens = array( 
0 => "Zero",
1 => "Ten",
2 => "Twenty",
3 => "Thirty", 
4 => "Forty", 
5 => "Fifty", 
6 => "Sixty", 
7 => "Seventy", 
8 => "Eighty", 
9 => "Ninety" 
); 
$hundreds = array( 
"Hundred", 
"Thousand", 
"Million", 
"Billion", 
"Trillion", 
"Quadrillion" 
); /*limit t quadrillion */
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr,1); 
$rettxt = ""; 
 $counter =0;
foreach($whole_arr as $key => $i){
    $counter++;
   
while(substr($i,0,1)=="0")

        $i=substr($i,1,5);
       
if($i < 20){ 
// echo "getting:".$i; 
    if ($counter == 2) {
    }else{
        $rettxt .= $ones[$i];
    }

}elseif($i < 100){ 
    
if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];

        // echo substr($i,2,3)."br";
        // echo "(".$i.")";
        if(substr($i,1,2) >=1 && substr($i,1,2) <= 19 ){
            if(substr($i, 1, 1) == 0){
                $rettxt .= " " . $ones[substr($i, 2, 1)];
            }else{
                $rettxt .= " " . $ones[substr($i, 1, 2)];

            }

        }else{
            
            if(substr($i,1,2) == "00" ||   substr($i,1,2) == 00 ){

            }else{
                
                if(substr($i,2,2) == 0){
                    $rettxt .= " ".$tens[substr($i,1,1)];

                }else{
                    if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
                    if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
                }
        }
      
    
}


} 

if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
}
}
if($decnum > 0){
    $rettxt .= " Pesos ";
if($decnum < 100){
    if(substr($decnum,0,1) == 0){
              $rettxt .= "and ".$ones[substr($decnum,1,2)]." Centavo/s "; 
    }else{
         $rettxt .=" and ";
         if(substr($decnum,1,2) == 0){
               $rettxt .= " ".$tens[substr($decnum,0,1)]." Centavo/s";
         }else{
             if(substr($decnum,0,2) >=1 && substr($decnum,0,2) <= 19 ){
                 $rettxt .= " ".$ones[substr($decnum,0,2)]." Centavo/s"; 
            }else{
                if(substr($decnum,1,2) == "00" ||   substr($decnum,1,2) == 00 ){

                }else{
                        if(substr($decnum,1,1)!="0")$rettxt .= " ".$tens[substr($decnum,0,1)]; 
                        if(substr($decnum,2,1)!="0")$rettxt .= " ".$ones[substr($decnum,1,1)]; 
                        $rettxt .= " Centavo/s"; 
                }
                
            }
         }
       
    }
}
}else{
    $rettxt .= " Pesos ";
}


// if(substr($decnum,0,2) == 00 || substr($decnum,0,2) == "00"){
//     $rettxt .= " PESOS"; 
// }
return $rettxt." Only";
}

function numberTowords(float $amount)
{
    $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
    // Check if there is any number after decimal
    $amt_hundred = null;
    $count_length = strlen($num);
    $x = 0;
    $string = array();
    $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred', 'Thousand', 'Million', 'Billion');
    while ($x < $count_length) {
        $get_divider = ($x == 2) ? 10 : 100;
        $amount = floor($num % $get_divider);
        $num = floor($num / $get_divider);
        $x += $get_divider == 10 ? 1 : 2;
        if ($amount) {
            $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
            $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
            $string[] = ($amount < 21) ? $change_words[$amount] . ' ' . $here_digits[$counter] . $add_plural . '
         ' . $amt_hundred : $change_words[floor($amount / 10) * 10] . ' ' . $change_words[$amount % 10] . '
         ' . $here_digits[$counter] . $add_plural . ' ' . $amt_hundred;
        } else {
            $string[] = null;
        }

    }
    $implode_to_Pesos = implode('', array_reverse($string));
    $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] ." ". $change_words[$amount_after_decimal % 10]) . ' Centavo/s' : '';
    return ($implode_to_Pesos ? $implode_to_Pesos . 'Pesos ' : '') . $get_paise;
}
 

function convert_number_to_words($number) {
  
    $hyphen      = '-';
    $conjunction = '  ';
    $separator   = ' ';
    $negative    = 'negative ';
    $decimal     = ' And ';
    $dictionary  = array(
        0                   => 'Zero',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Fourty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety',
        100                 => 'Hundred',
        1000                => 'Thousand',
        1000000             => 'Million',
        1000000000          => 'Billion',
        1000000000000       => 'Trillion',
        1000000000000000    => 'Quadrillion',
        1000000000000000000 => 'Quintillion'
    );
  
    if (!is_numeric($number)) {
        return false;
    }
  
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }
 
    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
  
    $string = $fraction = null;
  
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
  
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
  
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
  
    return $string;
}

 ?>