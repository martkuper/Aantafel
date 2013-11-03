<?php

/* FOOTER.PHP
 * 
 * Created by Loran Oosterhaven
 * Start date 10/28/2013
 * Last edit date 10/29/2013
 */

function displayFooter() {
    echo '</div>';
    
    $connection = mysql_connect('project13.db.12050811.hostedresource.com', 'project13', 'Aantafel13!');

    mysql_select_db('project13', $connection);

    $footerResult = mysql_query('SELECT Email, Telefoon, Adres FROM General');
    $footer = mysql_fetch_assoc($footerResult);
    
    echo '<div class="footer" style="background-image:url(images/navbar.jpg);">
            <br />
            <div id="footer_contact">
                <h2>Contact:</h2>
                Emailadres: ' . $footer['Email'] . '
                <br />
                Telefoonnummer: ' . $footer['Telefoon'] . '
                <br />
                Adres: ' . $footer['Adres'] . '
            </div>  
          </div> 
            <div id="footer_copyright" align="center" >
                Copyright &copy; 2013 @Tafel
            </div>  
          </body>
          </html>';
}

?>
