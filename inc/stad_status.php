<?php

/* STAD_STATUS.PHP
 * 
 * Created by Mart Kuper
 * Last edit date 10/31/2013
 */

include 'db_connect.php';

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

echo '<response>';
    $input = $_POST['stad'];
    $input = preg_replace("/[^a-zA-Z]+/", "", $input);
    
    if($input == ''){
        echo '<div id="enter_stad"></div>';
    }elseif(strlen($input) >= 2 && strlen($input) <= 25){
        echo '<div id="stad_available"></div>'; 
    }else{
        echo '<div id="enter_stad"></div>';
    }
echo '</response>';
?>
