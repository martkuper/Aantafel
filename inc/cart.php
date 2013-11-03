<?php

/* CART.PHP
 * 
 * Created by Loran Oosterhaven
 * Start date 10/28/2013
 * Last edit date 10/28/2013
 */

function displayCart() {

    if (isset($_SESSION['klantnr'])) {
        echo '<h2>Bestelling:</h2><br>';

        echo '<div id="cartbox"><img src="images/close.png"><h4>Pizza Margherita €9,95</h4></div>
            <div id="cartbox"><img src="images/close.png"><h4>Cola €2,95</h4></div>
            <div id="cartbox"><img src="images/close.png"><h4>Pizza Margherita €9,95</h4></div>
            <div id="cartbox"><img src="images/close.png"><h4>Pizza Margherita €9,95</h4></div>
            <div id="cartbox"><img src="images/close.png"><h4>Pizza Margherita €9,95</h4></div><br><br><br><br><div id="orderbutton"><a href="order.php">Afrekenen</a></div></div>';
    } else {
        echo '<h3><center>U moet ingelogt zijn om te kunnen bestellen!</center></h3></div>';
    }
    
    echo '<div class="content" align="center">';
}

?>
