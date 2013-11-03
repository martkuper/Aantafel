<?php

/* PASSWORD_STATUS.PHP
 * 
 * Created by Mart Kuper
 * Last edit date 10/31/2013
 */

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

echo '<response>';
    $input = $_POST['password'];
    $input = strip_tags($input);
           
    if($input == ''){
        echo '<div id="enter_password"></div>';
    }elseif(strlen($input) >= 8){
        echo '<div id="password_available"></div>'; 
    }else{
        echo '<div id="enter_password"></div>';
    }
echo '</response>';
?>
