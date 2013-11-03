<?php
/**
 * Created by PhpStorm.
 * User: martkuper
 * Date: 11/3/13
 * Time: 2:36 PM
 */

include 'db_connect.php';

if(isset($_POST['token']) && !empty($_POST['token'])){
    $token = preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['token']);
}else{
    header('Location: /@tafel/resetpass.php?error=1');
}
if(isset($_POST['p']) && !empty($_POST['p'])){
    $password = preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['p']);
}else{
    header('Location: /@tafel/resetpass.php?error=2');
}

$stmt = $link->prepare("SELECT Salt FROM Klant WHERE Wachtwoord=:pass");
$stmt->execute(array(':pass' => $token));

$newpass = hash('sha512', $password.$Salt);

try{
    $stmt = $link->prepare("UPDATE Klant SET Wachtwoord=:newpass WHERE Wachtwoord=:oldpass");
    $stmt->execute(array(':newpass' => $newpass, ':oldpass' => $token));

}catch(PDOException $e){
    trigger_error("MySQL failure: " . $e->getMessage(), E_USER_ERROR);
}


