<?php

/* ACTIONS.PHP
 * 
 * Created by Loran Oosterhaven
 * Start date 10/29/2013
 * Last edit date 10/29/2013
 */

include 'inc/header.php';
include 'inc/cart.php';
include 'inc/footer.php';

displayHeader('Acties');
displayCart();

echo '<h2>Acties</h2><br>';
    
for( $index = 0; $index < 4; $index++ ) 
    echo '<div id="actionbox">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
    Aenean commodo ligula eget dolor. Aenean massa. 
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. 
    Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. 
    Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.</div>';

displayFooter();
?>
