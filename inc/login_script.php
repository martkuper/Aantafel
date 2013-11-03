<?php

/* LOGIN_SCRIPT.PHP
 * 
 * Created by Mart Kuper
 * Last edit date 10/31/2013
 */

    include 'db_connect.php';
    include 'functions.php';
    
    begin_secure_session();
    
    if(isset($_POST['email'], $_POST['p'])){
        $email = preg_replace("/@[^a-zA-Z]+/", "", $_POST['email']);
        $password = $_POST['p'];

        if(login_user($email, $password, $link) == 1){
            //Login success
            header('Location: /@tafel/index.php');
        }elseif(login_user($email, $password, $link) == 2){
            //Account geblokkeerd

            header('Location: /@tafel/login.php?error=2');
        }elseif(login_user($email, $password, $link) == 0){
            //Login mislukt

            header('Location: /@tafel/login.php?error=1');
        }

    }else{

    }

?>
