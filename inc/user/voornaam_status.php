<?php

/* VOORNAAM_STATUS.PHP
 * 
 * Created by Mart Kuper
 * Last edit date 10/31/2013
 */



header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

echo '<response>';
    $input = $_POST['voornaam'];
    $input = preg_replace("/[^a-zA-Z]+/", "", $input);
    
    if($input == ''){
        echo '<div id="enter_voornaam"></div>';
    }elseif(strlen($input) >= 2 && strlen($input) <= 15){
        echo '<div id="voornaam_available"></div>'; 
    }else{
        echo '<div id="enter_voornaam"></div>';
    }
echo '</response>';
?>
