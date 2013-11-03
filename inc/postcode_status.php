<?php

/* POSTCODE_STATUS.PHP
 * 
 * Created by Mart Kuper
 * Last edit date 10/31/2013
 */

include 'db_connect.php';

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

echo '<response>';
    $input = $_POST['postcode'];
    $input = preg_replace("/[^0-9][^a-zA-Z]+/", "", $input);
    
    if($input == ''){
        echo '<div id="enter_postcode"></div>';
    }elseif(ereg("([0-9]{4})([a-zA-Z]{2})", $input)){
        echo '<div id="postcode_available"></div>'; 
    }else{
        echo '<div id="enter_postcode"></div>';
    }
echo '</response>';
?>
