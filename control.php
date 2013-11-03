<?php

/* MENU.PHP
 * 
 * Created by Loran Oosterhaven and Hein Rietman
 * Start date 10/29/2013
 * Last edit date 10/29/2013
 */

include 'inc/header.php';
include 'inc/cart.php';
include 'inc/footer.php';

#define MAXIMGSIZE 20000000
#define PHOTOPATH "images/products/"

function uploadPhoto() {
    if (($_FILES["photo"]["type"] == "image/png") ||
            ($_FILES["photo"]["type"] == "image/jpeg") ||
            ($_FILES["photo"]["type"] == "image/pjpeg") && $_FILES["photo"]["size"] < MAXIMGSIZE) {
        if ($_FILES["photo"]["error"] > 0) {
            return false;
        } else {
            $ext = "." . end(explode(".", $_FILES["photo"]["name"]));
            $photoname = hash('md5', $_FILES["photo"]["name"] . $_SERVER["HTTP_USER_AGENT"] . time());
            $photoname .= $ext;
            $_FILES["photo"]["name"] = $photoname;

            move_uploaded_file($_FILES["photo"]["tmp_name"], "images/products/" . $_FILES["photo"]["name"]);
            return true;
        }
    } else {
        return false;
    }
}

function showCustomerOrderLog() {
    echo '<br><h3>Klanten bestellog</h3><br>';

    if (isset($_GET['delete'])) {
        mysql_query('DELETE FROM KlantBestelling WHERE Bestellingnr=' . $_GET['delete']);
    }

    $ordersResult = mysql_query('SELECT * FROM KlantBestelling');

    if (mysql_num_rows($ordersResult) > 0) {
        echo '<table border="0" align="center">
                    <tr>
                    <th width="200px" bgcolor="#999">Nummer</th>
                    <th width="200px" bgcolor="#999">Klantnummer</th>
                    <th width="200px" bgcolor="#999">Besteldatum</th>
                    <th width="200px" bgcolor="#999">Producten</th>
                    <th width="200px" bgcolor="#999">Totaalprijs</th></tr>';

        while ($order = mysql_fetch_assoc($ordersResult)) {
            echo '<tr>
                            <td bgcolor="#DDD">' . $order['Bestellingnr'] . '</td>
                            <td bgcolor="#DDD">' . $order['Klantnr'] . '</td>
                            <td bgcolor="#DDD">' . $order['Besteldatum'] . '</td>
                            <td bgcolor="#DDD">' . $order['Producten'] . '</td>
                            <td bgcolor="#DDD">' . $order['Totaalprijs'] . '</td>
                            <td><a href="control.php?do=customerorderlog&delete=' . $order['Bestellingnr'] . '"><img src="images/close.png"></a></td>
                          </tr>';
        }

        echo '</table>';
    } else {
        echo 'Geen bestellingen!';
    }
}

function generalSettings() {
    echo '<br><h3>Bewerk algemene instellingen</h3><br>';

    if (isset($_POST['editbutton'])) {
        mysql_query('UPDATE General SET Email=\'' . $_POST['email'] . '\', Telefoon=\'' . $_POST['telefoon'] . '\', Adres=\'' . $_POST['adres'] . '\'');
        echo 'Algemene instellingen bijgewerkt!<br><br>';
    }

    $generalResult = mysql_query('SELECT Email, Telefoon, Adres FROM General');
    $general = mysql_fetch_assoc($generalResult);

    echo '<form action="" method="POST">
                    Email: <br><input type="text" name="email" value="' . $general['Email'] . '"><br><br>
                    Telefoon: <br><input type="text" name="telefoon" value="' . $general['Telefoon'] . '"><br><br>
                    Adres: <br><input type="text" name="adres" value="' . $general['Adres'] . '"><br><br>
                    <input type="submit" name="editbutton" value="Bewerk" /> 
                </form>';
}

function manageProducts() {
    echo '<br><h3>Beheer producten</h3>';

    if (isset($_POST['addbutton'])) {
        if (uploadPhoto()) {
            $q = 'INSERT INTO Producten VALUES (\'DEFAULT\', \'' . $_POST['name'] . '\', \'' . $_POST['price']
                    . '\', \'' . $_POST['description'] . '\', \'' . "images/products/" . $_FILES['photo']['name'] . '\', ' . $_POST['categorienr'] .')';
            mysql_query($q);
            echo 'Artikel toegevoegd!';
        }
    }

    if (isset($_POST['submiteditbutton'])) {
        
    }

    if (isset($_GET['edit'])) {
        $productResult = mysql_query('SELECT * FROM Producten where Productnr =' . $_GET['edit']);
        $product = mysql_fetch_assoc($productResult);

        echo '<br><h4>Bewerk een product: </h4><br>
            <form action="" method="POST" enctype="multipart/form-data"><br>
            <table>
            <tr><td>Naam: </td> <td><input type="text" name="name" value= ' . $product['Naam'] . '></td></tr>
            <tr><td>Prijs: </td> <td><input type="text" name="price" value= ' . $product['Verkoopprijs'] . '></td></tr>
            <tr><td>Omschrijving: </td> <td><input type="text" name="description" value= ' . $product['Omschrijving'] . '></td></tr>
            <tr><td>Categorienummer: </td> <td><input type="text" name="categorienr" value= ' . $product['Categorienr'] . '></td></tr>
            <tr><td>Upload een foto: </td> <td><input type="file" name="photo"></td></tr>
            <tr><td><br></td></tr>
            <tr><td><td><input type="submit" name="submiteditbutton" value="Toevoegen"/></td></td></tr>
            </table>
            </form>';
    } else {
        $categorieResult = mysql_query('SELECT * FROM Categorie');

        echo '<br><h4>Voeg een product toe: </h4><br>
                <form action="" method="POST" enctype="multipart/form-data">
                Naam: <br><input type="text" name="name"><br><br>
                Prijs: <br><input type="text" name="price"><br><br>
                Omschrijving: <br><input type="text" name="description"><br><br>
                Categorie: <br><select name="categorienr">';

        while ($categorie = mysql_fetch_assoc($categorieResult)) {
            echo '<option value="' . $categorie['Categorienr'] . '">' . $categorie['Name'] . '</option>';
        }

        echo '</select><br><br>
                Upload een foto: <br><input type="file" name="photo"><br><br>
                <input type="submit" name="addbutton" value="Toevoegen"/>
                </form>';
    }

    echo '<br><h4>Beheer bestaand product</h4><br>';

    if (isset($_GET['delete'])) {
        mysql_query('DELETE FROM Producten WHERE Productnr=' . $_GET['delete']);
    }

    $productResult = mysql_query('SELECT * FROM Producten');

    if (mysql_num_rows($productResult) > 0) {
        echo '<table border="0" align="center">
                <tr>
                <th width="200px" bgcolor="#999">Naam</th>
                <th width="200px" bgcolor="#999">Prijs</th>
                <th width="200px" bgcolor="#999">Omschrijving</th>
                <th width="200px" bgcolor="#999">Categorienummer</th></tr>';

        while ($prod = mysql_fetch_assoc($productResult)) {
            echo '<tr>
                        <td bgcolor="#DDD">' . $prod['Naam'] . '</td>
                        <td bgcolor="#DDD">' . $prod['Verkoopprijs'] . '</td>
                        <td bgcolor="#DDD">' . $prod['Omschrijving'] . '</td>
                        <td bgcolor="#DDD">' . $prod['Categorienr'] . '</td>
                        <td><a href="control.php?do=manageproducts&edit=' . $prod['Productnr'] . '"><img src="images/edit.png"></a></td>
                        <td><a href="control.php?do=manageproducts&delete=' . $prod['Productnr'] . '"><img src="images/close.png"></a></td>
                      </tr>';
        }

        echo '</table>';
    } else {
        echo 'Geen producten!';
    }
}

function manageCategories() {
    echo '<br><h3>Beheer categorieën</h3>';

    if (!isset($_GET['edit'])) {
        echo '<br><h4>Voeg categorie toe:</h4><br>';

        if (isset($_POST['addbutton'])) {
            mysql_query('INSERT INTO Categorie VALUES (\'DEFAULT\', \'' . $_POST['name'] . '\' )');
        }

        echo '<form action="" method="POST">
                    Naam: <br><input type="text" name="name"><br><br>
                    <input type="submit" name="addbutton" value="Toevoegen" /> 
                </form>';

        echo '<br><h4>Beheer bestaanden categorieën:</h4><br>';

        if (isset($_GET['delete'])) {
            mysql_query('DELETE FROM Categorie WHERE Categorienr=' . $_GET['delete']);
        }

        $categorieResult = mysql_query('SELECT * FROM Categorie');

        if (mysql_num_rows($categorieResult) > 0) {
            echo '<table border="0" align="center">
                    <tr>
                    <th width="100px" bgcolor="#999">Nummer</th>
                    <th width="200px" bgcolor="#999">Title</th>';

            while ($categorie = mysql_fetch_assoc($categorieResult)) {
                echo '<tr>
                            <td bgcolor="#DDD">' . $categorie['Categorienr'] . '</td>
                            <td bgcolor="#DDD">' . $categorie['Name'] . '</td>
                            <td><a href="control.php?do=managecategories&edit=' . $categorie['Categorienr'] . '"><img src="images/edit.png"></a></td>
                            <td><a href="control.php?do=managecategories&delete=' . $categorie['Categorienr'] . '"><img src="images/close.png"></a></td>
                          </tr>';
            }

            echo '</table>';
        } else {
            echo 'Geen categorieën!';
        }
    } else {
        echo '<br><h4>Bewerk categorie:</h4><br>';

        if (isset($_POST['editbutton'])) {
            mysql_query('UPDATE Categorie SET Name=\'' . $_POST['name'] . '\'WHERE Categorienr=' . $_GET['edit']);
            echo 'Categorie bijgewerkt!<br><br>';
        }

        $categorieResult = mysql_query('SELECT * FROM Categorie WHERE Categorienr=' . $_GET['edit']);
        $categorie = mysql_fetch_assoc($categorieResult);

        echo '<form action="" method="POST">
                    Naam: <br><input type="text" name="name" value="' . $categorie['Name'] . '"><br><br>
                    <input type="submit" name="editbutton" value="Bewerk" /> 
                </form>';
    }
}

function manageNews() {
    echo '<br><h3>Beheer nieuws</h3>';

    if (!isset($_GET['edit'])) {
        echo '<br><h4>Voeg nieuws toe:</h4><br>';

        if (isset($_POST['addbutton'])) {
            mysql_query('INSERT INTO News VALUES (\'DEFAULT\', \'' . $_POST['title'] . '\', \'' . $_POST['newscontent'] . '\', NOW())');
        }

        echo '<form action="" method="POST">
                    Title: <br><input type="text" name="title"><br><br>
                    Bericht: <br><textarea name="newscontent" cols="100" rows="10"></textarea><br><br>
                    <input type="submit" name="addbutton" value="Toevoegen" /> 
                </form>';

        echo '<br><h4>Beheer bestaand nieuws:</h4><br>';

        if (isset($_GET['delete'])) {
            mysql_query('DELETE FROM News WHERE Newsnr=' . $_GET['delete']);
        }

        $newsResult = mysql_query('SELECT * FROM News');

        if (mysql_num_rows($newsResult) > 0) {
            echo '<table border="0" align="center">
                    <tr>
                    <th width="200px" bgcolor="#999">Nummer</th>
                    <th width="200px" bgcolor="#999">Title</th>
                    <th width="200px" bgcolor="#999">Bericht</th>
                    <th width="200px" bgcolor="#999">Date</th></tr>';

            while ($news = mysql_fetch_assoc($newsResult)) {
                echo '<tr>
                            <td bgcolor="#DDD">' . $news['Newsnr'] . '</td>
                            <td bgcolor="#DDD">' . $news['Title'] . '</td>
                            <td bgcolor="#DDD">' . $news['Message'] . '</td>
                            <td bgcolor="#DDD">' . $news['Date'] . '</td>
                            <td><a href="control.php?do=managenews&edit=' . $news['Newsnr'] . '"><img src="images/edit.png"></a></td>
                            <td><a href="control.php?do=managenews&delete=' . $news['Newsnr'] . '"><img src="images/close.png"></a></td>
                          </tr>';
            }

            echo '</table>';
        } else {
            echo 'Geen nieuws!';
        }
    } else {
        $newsResult = mysql_query('SELECT * FROM News WHERE Newsnr=' . $_GET['edit']);
        $news = mysql_fetch_assoc($newsResult);

        echo '<br><h4>Bewerk nieuws:</h4><br>';

        if (isset($_POST['editbutton'])) {
            mysql_query('UPDATE News SET Title=\'' . $_POST['title'] . '\', Message=\'' . $_POST['newscontent'] . '\'WHERE Newsnr=' . $_GET['edit']);
            echo 'Nieuws bijgewerkt!<br><br>';
        }

        echo '<form action="" method="POST">
                    Title: <br><input type="text" name="title" value="' . $news['Title'] . '"><br><br>
                    Bericht: <br><textarea name="newscontent" cols="100" rows="10">' . $news['Message'] . '</textarea><br><br>
                    <input type="submit" name="editbutton" value="Bewerk" /> 
                </form>';
    }
}

function changeAbout() {
    echo '<br><h3>Verander over ons pagina:</h3><br>';


    if (isset($_POST['submitbutton'])) {
        mysql_query('UPDATE General SET About=\'' . $_POST['aboutcontent'] . '\'');
        echo 'Over ons pagina bijgewerkt!<br><br>';
    }

    $aboutResult = mysql_query('SELECT About FROM General');
    $about = mysql_fetch_row($aboutResult);

    echo '<form action="" method="POST">
                <textarea name="aboutcontent" cols="100" rows="20">'
    . $about[0] .
    '</textarea><br><br>
                <input type="submit" name="submitbutton" value="Bewerk" />  
            </form>';
}

displayHeader('Configuratiescherm');

echo '<h2>Configuratiescherm</h2><br>';

echo '<center><a href="control.php?do=customerorderlog">Klant bestellog</a> | <a href="control.php?do=generalsettings">Algemene instellingen</a> | <a href="control.php?do=manageproducts">Beheer producten</a>
    | <a href="control.php?do=managecategories">Beheer categorie</a> | <a href="control.php?do=managenews">Beheer nieuws</a> | <a href="control.php?do=changeabout">Verander over ons pagina</a></center>';

$connection = mysql_connect('project13.db.12050811.hostedresource.com', 'project13', 'Aantafel13!');
mysql_select_db('project13', $connection);

if (isset($_GET['do']) && $_GET['do'] != 'customerorderlog') {
    if ($_GET['do'] == 'generalsettings') {
        generalSettings();
    } else if ($_GET['do'] == 'manageproducts') {
        manageProducts();
    } else if ($_GET['do'] == 'managecategories') {
        manageCategories();
    } else if ($_GET['do'] == 'managenews') {
        manageNews();
    } else if ($_GET['do'] == 'changeabout') {
        changeAbout();
    }
} else {
    showCustomerOrderLog();
}

mysql_close();

displayFooter();
?>
