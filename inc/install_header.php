<?php
/**
 * Created by PhpStorm.
 * User: martkuper
 * Date: 11/3/13
 * Time: 8:07 PM
 */
/* HEADER.PHP
 *
 * Created by Loran Oosterhaven
 * Last edit 11/2/2013
 */

include "inc/functions.php";
include "inc/db_connect.php";

function displayHeader($pageTitle) {

    include 'inc/db_connect.php';
    include 'inc/functions.php';

    begin_secure_session();
    $connection = mysql_connect('project13.db.12050811.hostedresource.com', 'project13', 'Aantafel13!');

    mysql_select_db('project13', $connection);

    $headerResult = mysql_query('SELECT Header FROM General');
    $header = mysql_fetch_row($headerResult);

    mysql_close();

    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <link rel="stylesheet" href="css/style.css" type="text/css"  />
          <link rel="stylesheet" href="css/navigation.css" type="text/css"  />
          <link rel="icon" href="favicon.ico" type="image/x-icon"/>
          <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
          <title>@Tafel - ' . $pageTitle . '</title></head>';

    echo '<body style="background-image:url(images/background.jpg);">
            <div class="wrapper">';

    echo '<div class="header">
                    <br />
                    <img src="' . $header[0] . '">
                    <br />
                </div>';



    echo '<div class="content" align="center">';
}
?>
