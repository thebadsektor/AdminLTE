<?php

function me_encrypt($string)
{
$plaintext = $string;
$key = "GEO_mis12345678lb";
$ivlen = openssl_cipher_iv_length($cipher = "camellia-256-ofb");

  //Generate Random IV
  $iv = openssl_random_pseudo_bytes($ivlen);
  $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
  $ciphertext = base64_encode( $iv.$ciphertext_raw );
  $ciphertext = str_replace("+","[p]",$ciphertext);
  $ciphertext = str_replace("/","[sl]",$ciphertext);
  return str_replace("=","-",$ciphertext);
}

function me_decrypt($string)
{ 
    $str_lenght = strlen($string);
    if($str_lenght>18){
      $key = "GEO_mis12345678lb";
      $ciphertext = str_replace("-","=",$string);
      $ciphertext = str_replace("[p]", "+", $ciphertext);
      $ciphertext = str_replace("[sl]", "/", $ciphertext);

      //php camellia-256-ofb Dec Example
      $c = base64_decode($ciphertext);
      $ivlen = openssl_cipher_iv_length($cipher="camellia-256-ofb");
      $iv = substr($c, 0, $ivlen);
      $ciphertext_raw = substr($c, $ivlen);
      $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
      return $original_plaintext;

    }else{
      return "0";
    }
    
}

?>