<?php
/**
 * Created by PhpStorm.
 * User: martkuper
 * Date: 11/3/13
 * Time: 2:23 PM
 */

if(!isset($_GET['error'])){
    if(isset($_GET['token']) && !empty($_GET['token'])){
        $token = preg_replace("/[^a-zA-Z0-9]+/", "", $_GET['token']);
    }else{
        header('Location: /@tafel/resetpass.php?error=1');
    }
}
include 'inc/header.php';
include 'inc/cart.php';
include 'inc/footer.php';

displayHeader('Reset wachtwoord');


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
		<form action="inc/resetpass_script.php" method="POST" name="lostpass_form">
			<h1>Nieuw Wachtwoord</h1>
			<div>
				<!--<input name="email" autocomplete="off" type="text" placeholder="Email" required id="email"/>-->
                                    <input name="password" type="password" autocomplete="off" onkeyup="process_password()" placeholder="Nieuw Wachtwoord" id="password" required/>
                                    <div id="password_status"><img id="password_image" src="images/trans-back.png" /></div>
                                    <input name="token" type="hidden" value="' . $token . '" />
                                <!--<div id="status"><img id="image" src="images/trans-back.png" /></div>-->
			</div>
			<div onmouseover="checkfields2()">
			    <input type="button" id="verzend" value="Verzenden" name="submitbutton" onclick="formhash(this.form, this.form.password);"/>
				<!--<input id="login" type="submit" value="Verzenden" name="submitbutton"/>-->

			</div>
		</form><!-- form -->
		<div class="button" id="button">';
			if(isset($_GET['error']) && $_GET['error'] == 1){
                echo 'Ongeldig verzoek. <br>';
                echo 'Probeer het opnieuw.';
            }
            if(isset($_GET['error']) && $_GET['error'] == 2){
                echo 'Je moet een wachtwoord invullen. <br>';
                echo 'Probeer het nog eens.';
            }
echo '
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
';

displayFooter();
?>