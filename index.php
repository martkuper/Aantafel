<?php

/* INDEX.PHP
 * 
 * Created by Loran Oosterhaven
 * Start date 10/28/2013
 * Last edit date 10/29/2013
 */

include 'inc/header.php';
include 'inc/cart.php';
include 'inc/footer.php';

displayHeader('Home');
displayCart();

echo '<h2>Nieuws</h2><br>';

$connection = mysql_connect('project13.db.12050811.hostedresource.com', 'project13', 'Aantafel13!');
mysql_select_db('project13', $connection);

$newsResult = mysql_query('SELECT * FROM News ORDER BY Date');

if (mysql_num_rows($newsResult)) {
    $firstNews = true;

    while ($news = mysql_fetch_assoc($newsResult)) {
        if ($firstNews)
            $firstNews = false;
        else
            echo '<hr><br>';

        echo '<b>' . $news['Title'] . '</b> | ' . $news['Date'] . '<br><br>' . $news['Message'] . '<br><br>';
    }
}
else {
    echo 'Geen nieuws!';
}

mysql_close();

displayFooter();
?>
