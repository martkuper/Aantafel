<?php
/**
 * Created by PhpStorm.
 * User: martkuper
 * Date: 11/3/13
 * Time: 6:32 PM
 */
include 'inc/db_connect.php';
include 'inc/functions.php';
begin_secure_session();
$stmt = $link->prepare("SELECT Wachtwoord FROM Klant WHERE Klantnr=:klantnr");
$stmt->execute(array(':klantnr' => $_SESSION['klantnr']));
while($row = $stmt->fetch()){
    extract($row);
}

if(!isset($_GET['error'])){
    if(isset($Wachtwoord) && !empty($Wachtwoord) && isset($_SESSION['klantnr']) && !empty($_SESSION['klantnr'])){
        $token = preg_replace("/[^a-zA-Z0-9]+/", "", $Wachtwoord);
        $id = preg_replace("/[^0-9]+/", "", $_SESSION['klantnr']);
    }else{
        header('Location: /@tafel/resetpass.php?error=1');
    }
}
include 'inc/header.php';
include 'inc/cart.php';
include 'inc/footer.php';

displayHeader('Wachtwoord veranderen');


echo '
<link type="text/css" rel="stylesheet" href="css/resetpass-form.css" />
<script type="text/javascript" src="js/sha512.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/ajax-functions.js"></script>
<script type="text/javascript">
    window.onload=function(){
        document.getElementById("verzend").disabled = true;
    };
</script>
';


echo '
<div class="container">
        <section id="content2">
		<form action="inc/changepass_script.php" method="POST" name="lostpass_form">
			<h1>Wachtwoord veranderen</h1>
			<div>
				<!--<input name="email" autocomplete="off" type="text" placeholder="Email" required id="email"/>-->
                                    <input name="password" type="password" autocomplete="off" onkeyup="process_password()" placeholder="Nieuw Wachtwoord" id="password" required/>
                                    <div id="password_status"><img id="password_image" src="images/trans-back.png" /></div>
                                    <input name="token" type="hidden" value="' . $token . '" />
                                    <input name="id" type="hidden" value="' . $id . '" />
                                <!--<div id="status"><img id="image" src="images/trans-back.png" /></div>-->
			</div>
			<div onmouseover="checkfields2()">
			    <input type="button" id="verzend" value="Verzenden" name="submitbutton" onclick="formhash(this.form, this.form.password);"/>
				<!--<input id="login" type="submit" value="Verzenden" name="submitbutton"/>-->

			</div>
		</form><!-- form -->
		<div class="button" id="button">';
            if(isset($_GET['error']) && $_GET['error'] == 1){
                echo '<div style="color: red; font-size: 16px">Ongeldig verzoek. <br></div>';
                echo '<div style="color: red; font-size: 16px">Probeer het opnieuw.</div>';
            }
            if(isset($_GET['error']) && $_GET['error'] == 2){
                echo '<div style="color: red; font-size: 16px">Je moet een wachtwoord invullen. <br></div>';
                echo '<div style="color: red; font-size: 16px">Probeer het nog eens.</div>';
            }
            if(isset($_GET['status']) && $_GET['status'] == 1){
                echo '<div style="color: green; font-size: 16px">Wachtwoord veranderd. <br></div>';
                echo '<div style="color: green; font-size: 16px">Log de volgende keer in met je nieuwe wachtwoord.</div>';
            }
            if(isset($_GET['status']) && $_GET['status'] == 2){
                echo '<div style="color: red; font-size: 16px">Wachtwoord veranderen mislukt. <br></div>';
                echo '<div style="color: red; font-size: 16px">Probeer het nog een keer.</div>';
            }
echo '
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
';

displayFooter();
?>