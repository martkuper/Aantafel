<?php

/* MENU.PHP
 * 
 * Created by Loran Oosterhaven
 * Start date 10/29/2013
 * Last edit date 10/29/2013
 */

include 'inc/header.php';
include 'inc/cart.php';
include 'inc/footer.php';

if (isset($_GET['addorder'])) {
    //Product toevoegen aan cart in klant db
}

displayHeader('Menu');
displayCart();

echo '<h2>Menu</h2><br>';

$connection = mysql_connect('project13.db.12050811.hostedresource.com', 'project13', 'Aantafel13!');
mysql_select_db('project13', $connection);

$categorieResult = mysql_query('SELECT * FROM Categorie');

$firstCategorie = true;

if (mysql_num_rows($categorieResult) > 0) {
    while ($categorie = mysql_fetch_assoc($categorieResult)) {
        if ($firstCategorie)
            $firstCategorie = false;
        else
            echo '<br><br><hr><br>';

        echo '<h3>' . $categorie['Name'] . ':</h3>';

        $productsResult = mysql_query('SELECT * FROM Producten, Categorie WHERE Producten.Categorienr = Categorie.Categorienr AND Categorie.Name = \'' . $categorie['Name'] . '\'');

        if (mysql_num_rows($productsResult) > 0) {

            while ($product = mysql_fetch_assoc($productsResult)) {
                echo '<a href="menu.php?addorder=' . $product['Productnr'] . '"><div id="productbox"><h3>' . $product['Naam'] . '</h3><img src="' . $product['Image'] . '" align="left" style="margin: 10px"><br>
            ' . $product['Omschrijving'] . '<br><br><h2>€' . $product['Verkoopprijs'] . '</h2></div></a>';
            }
        } else {
            echo '<br>Geen ' . $categorie['Name'] . ' beschikbaar!';
        }
    }
} else {
    echo 'Geen categorieën!';
}

mysql_close();

displayFooter();
?>
