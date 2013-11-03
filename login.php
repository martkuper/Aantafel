<?php

/* LOGIN.PHP
 * 
 * Created by Mart Kuper
 * Last edit 10/31/2013
 */

include 'inc/header.php';
include 'inc/cart.php';
include 'inc/footer.php';

displayHeader('Login');


echo '
<link type="text/css" rel="stylesheet" href="css/login-form.css" />
<script type="text/javascript" src="js/sha512.js"></script>
<script type="text/javascript" src="js/form.js"></script>
';

echo '
<div class="container">
        <section id="content2">
		<form action="inc/login_script.php" method="POST" name="login_form">
			<h1>Inloggen</h1>
			<div>
				<!--<input name="email" autocomplete="off" type="text" placeholder="Email" required id="email"/>-->
                                    <input name="email" type="email" autocomplete="off" placeholder="Email" id="email" required/>
                                <!--<div id="status"><img id="image" src="images/trans-back.png" /></div>-->
			</div>
			<div>
				<input name="password" autocomplete="off" type="password" placeholder="Password"  id="password" required/>
			</div>
			<div>
				<input id="login" type="button" value="Log in" name="submitbutton" onclick="formhash(this.form, this.form.password)"/>
				<a href="lostpass.php">Wachtwoord vergeten?</a>
			</div>
		</form><!-- form -->
		<div class="button">';
            if(isset($_GET['error']) && $_GET['error'] == 1){
                echo '<div style="color: red; font-size: 16px">Je hebt een verkeerd wachtwoord ingevuld.</div>';
            }elseif(isset($_GET['error']) && $_GET['error'] == 2){
                echo '<div style="color:red; font-size: 16px">Je account is geblokkeerd.</div>';
            }
            if(isset($_GET['status']) && $_GET['status'] == 1){
                echo '<div style="color: green; font-size: 16px">Je account is succesvol aangemaakt. <br></div>';

            }
echo '
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
';

displayFooter();
?>