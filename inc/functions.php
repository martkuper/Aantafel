<?php

/* FUNCTIONS.PHP
 * 
 * Created by Mart Kuper
 * Last edit date 10/31/2013
 */

function begin_secure_session(){ //Bron: https://www.security.nl/posting/29281#posting251183 en http://www.pfz.nl/wiki/beveiliging/
    
    ini_set('session.use_only_cookies', 1);
    ini_set('session.entropy_length', 512); 
    $current_settings = session_get_cookie_params(); //Haal de huidige cookie parameters op
    session_set_cookie_params($current_settings["lifetime"], $current_settings["path"], $current_settings["domain"], false, true); //Huidige lifetime, huidige path, huidig domain, allow https?(true/false), httponly?(javascript heeft geen toegang tot de cookie)(true/false)
    session_name("secure_login"); //Zet de sessienaam zoals hierboven gedefinieerd
    session_start(); //Start de sessie
    session_regenerate_id(); //Verwijder de oude sessie
    $_SESSION['remote_addr'] = $_SERVER['REMOTE_ADDR']; //Sla het ip-address van de gebruiker op
       
    if($_SESSION['remote_addr'] != $_SERVER['REMOTE_ADDR']){ //Als het huidige ip-address niet overeenkomt met het opgeslagen address is de sessie overgenomen door iemand anders
        echo 'Session Hijacked!';
        session_destroy();
    }
     
}

function login_user($user_email, $user_password, $dbconn){
    
    $stmt = $dbconn->prepare("SELECT Klantnr, Voornaam, Achternaam, Wachtwoord, Salt, Admin FROM Klant WHERE Email =:email");
    $stmt->execute(array(':email' => $user_email)); //Bind "$user_email" aan de statement :email in de query en voer de query uit
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($row = $stmt->fetch()){
        extract($row);
    }
    
    if(isset($Klantnr)){ 
        $password_in = hash('sha512', $user_password.$Salt); //Hash het ingevoerde wachtwoord met de bijbehorende salt uit de database, gebruik hiervoor de 'SHA512' methode

        if($stmt->rowCount() == 1){ //Kijk of de query ook resultaten heeft opgelevert

            if(check_login_attempts($Klantnr, $dbconn) == true){ //Kijk of de gebruiker geblokkeerd is of niet
                //Account is geblokkeerd

                return 2;
            }else{

                //Account is niet geblokkeerd
                if($Wachtwoord == $password_in){ //Kijk of het ingevoerde wachtwoord overeenkomt met het opgeslagen wachtwoord
                    //Ingevoerde wachtwoord is correct


                    $browser_type = $_SERVER['HTTP_USER_AGENT']; //Verkrijg alle informatie over de browser van de gebruiker. Wordt gebruikt om een unieke login id te maken en gaat session hijacking tegen.
                                                                 //De kans is immers klein dat de gebruiker gedurende een sessie van browser wisselt
                    $Klantnr = preg_replace("/[^0-9]+/", "", $Klantnr); //Tegen XSS, verwijdert alles behalve cijfers
                    $_SESSION['klantnr'] = $Klantnr; //Sla het id van de gebruiker op in de sessie
                    $Voornaam = preg_replace("/[^a-zA-Z]+/", "", $Voornaam); //Tegen XSS, verwijdert alle tekens behalve a-z, A-Z. HTML/SQL injection wordt bij de form tegengegaan
                    $Achternaam = preg_replace("/[^a-zA-Z]+/", "", $Achternaam); //Tegen XSS, verwijdert alle tekens behalve a-z, A-Z. HTML/SQL injection wordt bij de form tegengegaan
                    $_SESSION['voornaam'] = $Voornaam; //Sla de voornaam van de gebruiker op in de sessie
                    $_SESSION['achternaam'] = $Achternaam; //Sla de achternaam van de gebruiker op in de sessie
                    $_SESSION['unique_id'] = hash('sha512', $Wachtwoord.$browser_type); //Sla een uniek login id op in de sessie
                    $_SESSION['admin'] = $Admin;


                    //Login gelukt
                    return 1;
                }else{

                    //Het ingevoerde wachtwoord is fout en wordt opgeslagen in de database
                    $now = time(); //de huidige tijd in de vorm van een timestamp
                    $dbconn->query("INSERT INTO Login_pogingen (Klant_Klantnr, Tijd) VALUES ('$Klantnr', '$now')"); //Voeg de mislukte login toe aan de database
                    return 0;
                }
                   
            }
                
        }else{
            //De gebruiker bestaat niet

            return 0;
        }
    }else{

       //Gebruiker bestaat niet
        return 0;
        
    }
}

function check_login_attempts($user_id, $dbconn){
    $now = time(); //De huidige tijd in vorm van een timestamp
    $valid_logins = $now - (60 * 60); //De logins van het afgelopen uur worden meegenomen in de check, meer dan 5 keer inloggen per uur kan dus niet.
        
    $stmt = $dbconn->prepare("SELECT Tijd FROM Login_pogingen WHERE Klant_Klantnr=:klantnr AND Tijd > '$valid_logins'"); //Haal alle login pogingen van het afgelopen uur op voor het gegeven user id
    $stmt->execute(array(':klantnr' => $user_id)); //Voer de query uit
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
    while($row = $stmt->fetch()){
                extract($row);
                
            }
           
    if($stmt->rowCount() > 5){ //Kijk of het aantal login pogingen in het afgelopen uur groter is dan 5
        return true;
    }else{
        return false;
    }
    
}

function check_login_status($dbconn){
    if(isset($_SESSION['klantnr'], $_SESSION['voornaam'], $_SESSION['achternaam'], $_SESSION['unique_id'])){ //Kijk of alle sessie variabelen bestaan
        $klantnr = $_SESSION['klantnr']; 
        $voornaam = $_SESSION['voornaam'];
        $achternaam = $_SESSION['achternaam'];
        $unique_id = $_SESSION['unique_id'];
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        

       // if($stmt = $dbconn->prepare("SELECT Wachtwoord FROM klant WHERE Klantnr=:klantnr")){ //Haal het wachtwoord het het opgegeven id uit de database
            $stmt = $dbconn->prepare("SELECT Wachtwoord FROM Klant WHERE Klantnr=:klantnr");
            
            $stmt->bindParam(':klantnr', $klantnr);
            $stmt->execute(); //Voer de query uit
            
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
   
            while($row = $stmt->fetch()){
                extract($row);
                
            }
            
            if($stmt->rowCount() == 1){ //De gebruiker bestaat
                $login_check = hash('sha512', $Wachtwoord.$user_browser);
               
                if($login_check == $unique_id){
                    //Logged in
                    
                    return true;
                }else{
                    //Not logged in
                    return false;
                }
            }else{
                //Not logged in
                return false;
            }
        
   }else{
       //Not logged in
       return false;
   }
}

function checkmail_unix($email){
    list($userName, $mailDomain) = preg_split("@", $email);

if (checkdnsrr($mailDomain, "MX")) { 

  // this is a valid email domain! 
    return true;

} 

else { 

  // this email domain doesn't exist! bad dog! no biscuit! 
    return false;

} 
}
?>
