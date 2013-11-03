<?php
/**
 * Created by PhpStorm.
 * User: martkuper
 * Date: 11/2/13
 * Time: 5:56 PM
 */


if(mail("martkuper@hotmail.com", "testen testen", "test message, test bericht 222", "From: admin@eltrastero.nl")){
    header('Location: ../lostpass.php?sent=1');
}else{
    header('Location: ../lostpass.php?sent=2');
}