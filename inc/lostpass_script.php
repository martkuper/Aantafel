<?php
/**
 * Created by PhpStorm.
 * User: martkuper
 * Date: 11/2/13
 * Time: 5:56 PM
 */

include 'db_connect.php';

$email = preg_replace("/@[^a-zA-Z]+/", "", $_POST['email']);
$Wachtwoord = '';

$stmt = $link->prepare("SELECT Wachtwoord FROM Klant WHERE Email=:email");
$stmt->execute(array(':email' => $email));
while($row = $stmt->fetch()){
    extract($row);
}

$onderwerp = 'Aantafel: Wachtwoord vergeten';
$bericht = '
    <html>
    <body>
        <p>Wachtwoord opnieuw instellen</p> <br><br>
        Je ontvangt deze email omdat je hebt aangegeven dat je je wachtwoord bij Aantafel bent vergeten. <br>
        Heb je dit niet gedaan? Dan kun je deze email beschouwen als niet verzonden. <br><br>
        Klik <a href="eltrastero.nl/@tafel/resetpass.php?token=' . $Wachtwoord . '">hier</a> om een nieuw wachtwoord in te stellen,
        je wordt dan doorgestuurd naar onze website waar je je nieuwe wachtwoord kunt invullen.<br>
    </body>
    </html>
';

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: admin@eltrastero.nl';


if(empty($Wachtwoord)){
    header('Location: /@tafel/lostpass.php?sent=3');
}elseif(mail($email, $onderwerp, $bericht, $headers)){
    header('Location: /@tafel/lostpass.php?sent=1');
}else{
    header('Location: /@tafel/lostpass.php?sent=2');
}
