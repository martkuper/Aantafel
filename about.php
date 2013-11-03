<?php

/* ABOUT.PHP
 * 
 * Created by Loran Oosterhaven
 * Start date 10/29/2013
 * Last edit date 10/29/2013
 */

include 'inc/header.php';
include 'inc/cart.php';
include 'inc/footer.php';

displayHeader('Over ons');

$connection = mysql_connect('project13.db.12050811.hostedresource.com', 'project13', 'Aantafel13!');
mysql_select_db('project13', $connection);

$aboutResult = mysql_query('SELECT About FROM General');
$about = mysql_fetch_row( $aboutResult );
    
echo '<h2>Over ons</h2><br>' . $about[0];

mysql_close();

displayFooter();

