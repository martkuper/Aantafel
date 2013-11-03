<?php
/**
 * Created by PhpStorm.
 * User: martkuper
 * Date: 11/2/13
 * Time: 5:49 PM
 */


include 'inc/header.php';
include 'inc/cart.php';
include 'inc/footer.php';

displayHeader('Wachtwoord vergeten');
 
echo '
<link type="text/css" rel="stylesheet" href="css/lostpass-form.css" />
<script type="text/javascript" src="js/sha512.js"></script>
<script type="text/javascript" src="js/form.js"></script>
';


echo '
<div class="container">
        <section id="content2">
		<form action="inc/lostpass_script.php" method="POST" name="lostpass_form">
			<h1>Wachtwoord vergeten</h1>
			<div>
				<!--<input name="email" autocomplete="off" type="text" placeholder="Email" required id="email"/>-->
                                    <input name="email" type="email" autocomplete="off" placeholder="Email" id="email" required/>

                                <!--<div id="status"><img id="image" src="images/trans-back.png" /></div>-->
			</div>
			<div>
				<input id="login" type="submit" value="Verzenden" name="submitbutton"/>

			</div>
		</form><!-- form -->
		<div class="button">';
			if(isset($_GET['sent']) && $_GET['sent'] == 1){
                echo '<div style="color: red; font-size: 16px">Wachtwoord verzonden. <br></div>';
                echo '<div style="color: red; font-size: 16px">Het kan even duren voordat je je mail ontvangt.</div>';
            }
            if(isset($_GET['sent']) && $_GET['sent'] == 2){
                echo '<div style="color: red; font-size: 16px">Er is een fout opgetreden. <br></div>';
                echo '<div style="color: red; font-size: 16px">Probeer het later nog eens.</div>';
            }
            if (isset($_GET['sent']) && $_GET['sent'] == 3) {
                echo '<div style="color: red; font-size: 16px">Je hebt een ongeldig email addres ingevuld. <br></div>';
                echo '<div style="color: red; font-size: 16px">Probeer het nog eens.</div>';
            }
echo '
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
';

displayFooter();
?>