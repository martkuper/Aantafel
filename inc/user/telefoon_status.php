<?php

/* TELEFOON_STATUS.PHP
 * 
 * Created by Mart Kuper
 * Last edit date 10/31/2013
 */



header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

echo '<response>';
    $input = $_POST['telefoon'];
    $input = preg_replace("/[^0-9]+/", "", $input);
    
    if($input == ''){
        echo '<div id="enter_telefoon"></div>';
    }elseif(ereg("([0-9]{10})", $input)){
        echo '<div id="telefoon_available"></div>'; 
    }else{
        echo '<div id="enter_telefoon"></div>';
    }
echo '</response>';
?>
