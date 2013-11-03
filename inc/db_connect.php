<?php

/* DB_CONNECT.PHP
 * 
 * Created by Mart Kuper
 * Last edit date 10/14/2013
 */

try{
    $link = new PDO("mysql:host=project13.db.12050811.hostedresource.com;dbname=project13", "project13", "Aantafel13!");
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e){
    trigger_error("MySQL connection failure: " . $e->getMessage(), E_USER_ERROR);
}
?>
