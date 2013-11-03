<?php

/* EMAIL_STATUS.PHP
 * 
 * Created by Mart Kuper
 * Last edit date 10/31/2013
 */

include '../db_connect.php';

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

echo '<response>';
    $input = $_POST['email'];
    $input = preg_replace("/@[^a-zA-Z]+/", "", $input);

    $stmt = $link->prepare("SELECT Email FROM Klant WHERE Email =:email");
    $stmt->execute(array(':email' => $input)); //Bind "$user_email" aan de statement :email in de query en voer de query uit
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($row = $stmt->fetch()){
        extract($row);
    }

    if($input == ''){
        echo '<div id="enter_email"></div>';
    }elseif($input == $Email){
        echo '<div id="email_exists"></div>';
    }elseif(strlen($input) < 10){
        echo '<div id="enter_email"></div>';
    }else{
        echo '<div id="email_available"></div>';
    }
echo '</response>';
?>
