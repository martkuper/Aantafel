<?php

/* REGISTER_SCRIPT.PHP
 * 
 * Created by Mart Kuper
 * Last edit date 10/31/2013
 */

include 'db_connect.php';
//echo basename($_SERVER['REQUEST_URI']); <script>document.write(window.location.hash); </script><?php

//Het gehashte wachtwoord dat je van het formulier (via javascript) ontvangt
$password = preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['p']);

//De overige geposte variabelen
$voornaam = preg_replace("/[^a-zA-Z]+/", "", $_POST['voornaam']);
$achternaam = preg_replace("/[^a-zA-Z]+/", "", $_POST['achternaam']);
$adres = preg_replace("/[^a-zA-Z]+/", "", $_POST['adres']);
$postcode = preg_replace("/[^0-9][^a-zA-Z]+/", "", $_POST['postcode']);
$stad = preg_replace("/[^a-zA-Z]+/", "", $_POST['stad']);
$telefoon = preg_replace("/[^0-9]+/", "", $_POST['telefoon']);
$email = preg_replace("/@[^a-zA-Z]+/", "", $_POST['email']);

$stmt = $link->prepare("SELECT Email FROM Klant WHERE Email=:email");
$stmt->execute(array(':email' => $email));
while($row = $stmt->fetch()){
    extract($row);
}


if(empty($password) || empty($voornaam) || empty($achternaam) || empty($adres) || empty($postcode) || empty($stad) || empty($telefoon) || empty($email) || strlen($password) <> 128 || $email == $Email){
    header('Location: /@tafel/register.php?error=1');
}
;
//Maak een random salt
$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));

//Maak het nieuwe wachtwoord met de gegenereerde salt
$password = hash('sha512', $password.$random_salt);

//Voeg toe aan de database

try{ 

    $insert_stmt = $link->prepare("INSERT INTO Klant (Klantnr, Achternaam, Voornaam, Adres, Postcode, Stad, Email, Telefoon, Wachtwoord, Salt, Admin)
                                   VALUES (DEFAULT, :achternaam, :voornaam, :adres, :postcode, :stad, :email, :telefoon, :wachtwoord, :salt, 0)");
    
    $insert_stmt->bindParam(':achternaam', $achternaam);
    $insert_stmt->bindParam(':voornaam', $voornaam);
    $insert_stmt->bindParam(':adres', $adres);
    $insert_stmt->bindParam(':postcode', $postcode);
    $insert_stmt->bindParam(':stad', $stad);
    $insert_stmt->bindParam(':email', $email);
    $insert_stmt->bindParam(':telefoon', $telefoon);
    $insert_stmt->bindParam(':wachtwoord', $password);
    $insert_stmt->bindParam(':salt', $random_salt);
    

    
    $insert_stmt->execute();
    
    }catch(PDOException $e){
    trigger_error("MySQL connection failure: " . $e->getMessage(), E_USER_ERROR);

};
?>
