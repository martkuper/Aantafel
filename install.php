<?php
/**
 * Created by PhpStorm.
 * User: martkuper
 * Date: 11/3/13
 * Time: 8:03 PM
 */


if(isset($_GET['step']) && $_GET['step'] == 1){
    include 'inc/install_header.php';
    include 'inc/footer.php';

    displayHeader('Administrator account maken');

    echo '
<link type="text/css" rel="stylesheet" href="css/register-form.css" />
<script type="text/javascript" src="js/sha512.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/ajax-functions.js"></script>
<script type="text/javascript">
    window.onload=function(){
        document.getElementById("register").disabled = true;
    };
</script>


<div class="container">
        <section id="content">
		<form action="inc/process_install.php?step=1" method="POST" name="login_form">
                    <h1>Maak account</h1>
                        <div>
                            <input name="voornaam" type="text" onblur="process_voornaam();" placeholder="Voornaam" id="voornaam" required/>
                            <div id="voornaam_status"><img id="voornaam_image" src="images/trans-back.png" /></div>
			</div>
                        <div>
                            <input name="achternaam" type="text" onblur="process_achternaam();" placeholder="Achternaam" id="achternaam" required/>
                            <div id="achternaam_status"><img id="achternaam_image" src="images/trans-back.png" /></div>
			</div>
                        <div>
                            <input name="adres" type="text" onblur="process_adres();" placeholder="Adres en Huisnummer" id="adres" required/>
                            <div id="adres_status"><img id="adres_image" src="images/trans-back.png" /></div>
			</div>
                        <div>
                            <input name="postcode" type="text" onblur="process_postcode();" placeholder="Postcode (bijv. 1234AB)" id="postcode" required/>
                            <div id="postcode_status"><img id="postcode_image" src="images/trans-back.png" /></div>
			</div>
                        <div>
                            <input name="stad" type="text" onblur="process_stad();" placeholder="Stad" id="stad" required/>
                            <div id="stad_status"><img id="stad_image" src="images/trans-back.png" /></div>
			</div>
                        <div>
                            <input name="telefoon" type="text" onblur="process_telefoon();" placeholder="Telefoonnummer" id="telefoon" required/>
                            <div id="telefoon_status"><img id="telefoon_image" src="images/trans-back.png" /></div>
			</div>
			<div>
                            <input name="email" type="email" onblur="process_email();" autocomplete="off" placeholder="Email" id="email" required/>
                            <div id="email_status"><img id="email_image" src="images/trans-back.png" /></div>
			</div>
			<div>
                            <input name="password" autocomplete="off" onblur="process_password();" type="password" placeholder="Wachtwoord (minimale lengte 8)"  id="password" required/>
                            <div id="password_status"><img id="password_image" src="images/trans-back.png" /></div>
			</div>
			<div onmouseover="checkfields()">
                            <input type="button" id="register" value="Maak account" name="submitbutton" onclick="formhash(this.form, this.form.password);"/>
                            <!--<input  type="button" id="register" value="Registreer" name="submitbutton" />-->
                        </div>
		</form><!-- form -->
		<div class="button" id="button">';
            if(isset($_GET['error']) && $_GET['error'] == 1){
                echo '<div style="color: red; font-size: 16px">Je bent iets vergeten in te vullen</div>';
            }

    echo '
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
';

}

if(isset($_GET['step']) && $_GET['step'] == 2){
    if(isset($_GET['status']) && $_GET['status'] == 1){
        echo 'Account maken geslaagd!';
    }
}