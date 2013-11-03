<?php
/**
 * Created by PhpStorm.
 * User: martkuper
 * Date: 11/2/13
 * Time: 2:32 PM
 */

include 'inc/functions.php';
include 'inc/db_connect.php';
begin_secure_session();

echo login_user("martkuper@hotmail.com", "asdfasdf", $link);
echo 'test_updatdde2';