<?php
 if (!defined('WHMCS'))
     die('You cannot access this file directly.');
     
     
add_hook('ClientDetailsValidation', 1, function($vars) {
    $n_id = $vars['customfield'][1];
    if(strlen($n_id) == 10 && checkMeliCode($n_id))
        return "";
    elseif(strlen($n_id) == 11)
        return "";
    return "کد ملی صحیح نیست";
});


add_hook('ShoppingCartValidateCheckout', 1, function($vars) {
    $n_id = $vars['customfield'][1];
    if(strlen($n_id) == 10 && checkMeliCode($n_id))
        return "";
    elseif(strlen($n_id) == 11)
        return "";
    return '<a href="'.$systemurl.'clientarea.php?action=details#'.$national_id_field.'"> جهت اتصال به درگاه لطفا کد ملی خود را وارد نمایید</a>';
});

function checkMeliCode($meli)
{
   
  $cDigitLast = substr($meli , strlen($meli)-1);
  $fMeli = strval(intval($meli));
 
  if((str_split($fMeli))[0] == "0" && !(8 <= strlen($fMeli)  && strlen($fMeli) < 10)) return false;
 
  $nineLeftDigits = substr($meli , 0 , strlen($meli) - 1);
   
  $positionNumber = 10;
  $result = 0;
 
  foreach(str_split($nineLeftDigits) as $chr){
        $digit = intval($chr);
        $result += $digit * $positionNumber;
        $positionNumber--;
  }
 
  $remain = $result % 11;
 
  $controllerNumber = $remain;
 
  if(2 <= $remain){
    $controllerNumber = 11-$remain;
  }
 
  return $cDigitLast == $controllerNumber;
   
}

