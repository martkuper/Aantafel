<?php
/**
 * Created by PhpStorm.
 * User: martkuper
 * Date: 11/2/13
 * Time: 3:59 PM
 */

include 'inc/functions.php';
begin_secure_session();
// Verwijder alle sessie variabelen
$_SESSION = array();
// Allle sessie parameters
$params = session_get_cookie_params();
// Delete de cookie.
setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
// Destroy session
session_destroy();
header('Location: index.php');