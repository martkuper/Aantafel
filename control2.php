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

#define MAXIMGSIZE 20000000
#define PHOTOPATH "images/products/"

displayHeader('Configuratiescherm');

echo '<h2>Configuratiescherm</h2><br>';

echo '<center><a href="control2.php?do=orderlog">Bestellog</a> | <a href="control2.php?do=manageproducts">Beheer producten</a> | <a href="control2.php?do=managenews">Beheer nieuws</a> | <a href="control2.php?do=changeabout">Verander over ons pagina</a></center>';

if (isset($_GET['do']) && $_GET['do'] != 'orderlog') {
    
} else if ($_GET['do'] == 'managenews') {
    echo '<br><h3>Beheer nieuws</h3><br>';

    $connection = mysql_connect('project13.db.12050811.hostedresource.com', 'project13', 'Aantafel13!');
    mysql_select_db('project13', $connection);

    if (isset($_POST['addbutton'])) {
        mysql_query('INSERT INTO News VALUES (\'DEFAULT\', \'' . $_POST['title'] . '\', \'' . $_POST['newscontent'] . '\', \'DEFAULT\')');
        echo 'Nieuws toegevoegd!<br><br>';
    }

    echo '<br><h4>Voeg nieuws toe:</h4><br>
            <form action="" method="POST">
                Title: <br><input type="text" name="title"><br><br>
                Bericht: <br><textarea name="newscontent" cols="100" rows="10"></textarea><br><br>
                <input type="submit" name="addbutton" value="Toevoegen" /> 
            </form>';

    echo '<br><h4>Beheer bestaand nieuws:</h4><br>';
} else if ($_GET['do'] == 'changeabout') {

    echo '<br><h3>Verander over ons pagina:</h3><br>';

    $connection = mysql_connect('project13.db.12050811.hostedresource.com', 'project13', 'Aantafel13!');
    mysql_select_db('project13', $connection);

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
if ($_GET['do'] == 'manageproducts') {

    $connection = mysql_connect('project13.db.12050811.hostedresource.com', 'project13', 'Aantafel13!');
    mysql_select_db('project13', $connection);

    if (isset($_POST['submitbutton'])) {
        if (uploadPhoto()) {
            $q = 'INSERT INTO Producten VALUES (\'DEFAULT\', \'' . $_POST['name'] . '\', \'' . $_POST['price']
                    . '\', \'' . $_POST['description'] . '\', \'' . "images/products/" . $_FILES['photo']['name'] . '\', 1)';
            mysql_query($q);
            echo 'Artikel toegevoegd!';
        }
    }

    if (isset($_POST['submiteditbutton'])) {
        
    }

    if (isset($_GET['edit'])) {
        diplayEditProduct();
    } else {
        echo '<br><h3>Voeg een product toe: </h3><br>
                <form action="" method="POST" enctype="multipart/form-data"><br>
                <table>
                <tr><td>Naam: </td> <td><input type="text" name="name"></td></tr>
                <tr><td>Prijs: </td> <td><input type="text" name="price"></td></tr>
                <tr><td>Omschrijving: </td> <td><input type="text" name="description"></td></tr>
                <tr><td>Upload een foto: </td> <td><input type="file" name="photo"></td></tr>
                <tr><td><br></td></tr>
                <tr><td><td><input type="submit" name="submitbutton" value="Toevoegen"/></td></td></tr>
                </table>
                </form>';
    }

    echo '<br><br><b>Verander bestaand product</b></br>';

    if (isset($_GET['delete'])) {
        mysql_query('DELETE FROM Producten WHERE Productnr=' . $_GET['delete']);
        echo "Product verwijderd.";
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
                        <td><a href="control2.php?do=manageproducts&edit=' . $prod['Productnr'] . '"><img src="images/edit.png"></a></td>
                        <td><a href="control2.php?do=manageproducts&delete=' . $prod['Productnr'] . '"><img src="images/close.png"></a></td>
                      </tr>';
        }

        echo '</table>';
    }
} else {
    echo '<br>Bestelog';
}

function uploadPhoto() {
    if (($_FILES["photo"]["type"] == "image/png") ||
            ($_FILES["photo"]["type"] == "image/jpeg") ||
            ($_FILES["photo"]["type"] == "image/pjpeg") && $_FILES["photo"]["size"] < MAXIMGSIZE) {
        if ($_FILES["photo"]["error"] > 0) {
            echo "Fout bij uploaden: " . $_FILES["photo"]["error"] . "<br>";
            return false;
        } else {
            $ext = "." . end(explode(".", $_FILES["photo"]["name"]));
            $photoname = hash('md5', $_FILES["photo"]["name"] . $_SERVER["HTTP_USER_AGENT"] . time());
            $photoname .= $ext;
            $_FILES["photo"]["name"] = $photoname;

            if (file_exists(PHOTOPATH . $_FILES["photo"]["name"])) {
                echo $_FILES["photo"]["name"] . " already exists. ";
                return false;
            } else {
                move_uploaded_file($_FILES["photo"]["tmp_name"], "images/products/" . $_FILES["photo"]["name"]);
                return true;
            }
        }
    } else {
        echo "Invalid File";
        return false;
    }
}

function diplayEditProduct() {
    $q = "SELECT * FROM Producten where Productnr =" . $_GET['edit'];
    $r = mysql_query($q);
    $prod = mysql_fetch_assoc($r);

    echo '<br><h3>Bewerk een product: </h3><br>
            <form action="" method="POST" enctype="multipart/form-data"><br>
            <table>
            <tr><td>Naam: </td> <td><input type="text" name="name" value= ' . $prod['Naam'] . '></td></tr>
            <tr><td>Prijs: </td> <td><input type="text" name="price" value= ' . $prod['Verkoopprijs'] . '></td></tr>
            <tr><td>Omschrijving: </td> <td><input type="text" name="description" value= ' . $prod['Omschrijving'] . '></td></tr>
            <tr><td>Categorienummer: </td> <td><input type="text" name="categorienr" value= ' . $prod['Categorienr'] . '></td></tr>
            <tr><td>Upload een foto: </td> <td><input type="file" name="photo"></td></tr>
            <tr><td><br></td></tr>
            <tr><td><td><input type="submit" name="submiteditbutton" value="Toevoegen"/></td></td></tr>
            </table>
            </form>';
}

displayFooter();
?>
