/* AJAX-FUNCTIONS.JS
 * 
 * Created by Mart Kuper
 * Last edit date 11/02/2013
 */

var xmlHttp = createXmlHttpRequestObject();

function createXmlHttpRequestObject(){
    var xmlHttp;
    
    if(window.XMLHttpRequest){
        try{
            xmlHttp = new XMLHttpRequest();
        }catch(e){
            xmlHttp = false;
        }
    }else{
        try{
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(e){
            xmlHttp = false;
        }
    }
    
    if(!xmlHttp){
        alert("Can't create object");
    }else{
        return xmlHttp;
    }
}

function disable_button(){
    document.getElementById("register").disabled = true;
}

function process_voornaam(){
    if(xmlHttp.readyState === 4 || xmlHttp.readyState === 0){
        input = encodeURIComponent(document.getElementById("voornaam").value);
        
        console.log("voornaam " + input);
        
        xmlHttp.open("POST", "inc/user/voornaam_status.php", true);
        xmlHttp.onreadystatechange = handleServerResponse_voornaam;
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.send("voornaam=" + input);

    }else{
        alert("Something went wrong!");
    }
       
}

function handleServerResponse_voornaam(){
    if(xmlHttp.readyState === 4){
        if(xmlHttp.status === 200){
            xmlResponse = xmlHttp.responseXML;
            xmlDocumentElement = xmlResponse.documentElement;
            message = xmlHttp.responseXML.getElementsByTagName("response")[0].getElementsByTagName("div")[0].id;
            
            console.log("voornaam " + message);
            
            if(message === "enter_voornaam"){
                document.getElementById("voornaam_image").src="images/close.png";
            }
            if(message === "voornaam_available"){
                document.getElementById("voornaam_image").src="images/tick.png";
            }
                        

        }else{
            alert('Something went wrong!');
        }
    }
}

function process_achternaam(){
    if(xmlHttp.readyState === 4 || xmlHttp.readyState === 0){
        input = encodeURIComponent(document.getElementById("achternaam").value);
        
        console.log("achternaam " + input);
        
        xmlHttp.open("POST", "inc/user/achternaam_status.php", true);
        xmlHttp.onreadystatechange = handleServerResponse_achternaam;
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.send("achternaam=" + input);

    }else{
    }
       
}

function handleServerResponse_achternaam(){
    if(xmlHttp.readyState === 4){
        if(xmlHttp.status === 200){
            xmlResponse = xmlHttp.responseXML;
            xmlDocumentElement = xmlResponse.documentElement;
            message = xmlHttp.responseXML.getElementsByTagName("response")[0].getElementsByTagName("div")[0].id;
            
            console.log("achternaam " + message);
            
            if(message === "enter_achternaam"){
                document.getElementById("achternaam_image").src="images/close.png";
            }
            if(message === "achternaam_available"){
                document.getElementById("achternaam_image").src="images/tick.png";
            }
                        

        }else{
            alert('Something went wrong!');
        }
    }
}

function process_adres(){
    if(xmlHttp.readyState === 4 || xmlHttp.readyState === 0){
        input = encodeURIComponent(document.getElementById("adres").value);
        
        console.log("adres " + input);
        
        xmlHttp.open("POST", "inc/user/adres_status.php", true);
        xmlHttp.onreadystatechange = handleServerResponse_adres;
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.send("adres=" + input);

    }else{
    }
       
}

function handleServerResponse_adres(){
    if(xmlHttp.readyState === 4){
        if(xmlHttp.status === 200){
            xmlResponse = xmlHttp.responseXML;
            xmlDocumentElement = xmlResponse.documentElement;
            message = xmlHttp.responseXML.getElementsByTagName("response")[0].getElementsByTagName("div")[0].id;
            
            console.log("adres " + message);
            
            if(document.getElementById("huisnummer_error")){
                document.getElementById("huisnummer_error").remove();
            }
            
            adres = document.getElementById("adres").value;
            huisnummer = adres.split(" ");
            huisnummer_length = huisnummer.length;
            huisnummer = huisnummer[huisnummer_length - 1];
            pattern = /[0-9]+[a-zA-Z]?/i;
                        
            console.log("huisnummer: " + huisnummer);          
            
            if(huisnummer.match(pattern)){
                if(message === "enter_adres"){
                    document.getElementById("adres_image").src="images/close.png";
                }
                if(message === "adres_available"){
                    document.getElementById("adres_image").src="images/tick.png";
                }
            }else{
                document.getElementById("adres_image").src="images/close.png";
                newdiv = document.createElement("div");
                newdiv.id="huisnummer_error";
                newdiv.innerHTML = "Je bent je adres en/of huisnummer vergeten in te vullen";
                document.getElementById("button").appendChild(newdiv);
            }
            
            
                        

        }else{
            alert('Something went wrong!');
        }
    }
}

function process_postcode(){
    if(xmlHttp.readyState === 4 || xmlHttp.readyState === 0){
        input = encodeURIComponent(document.getElementById("postcode").value);
        
        console.log("postcode " + input);
        
        xmlHttp.open("POST", "inc/user/postcode_status.php", true);
        xmlHttp.onreadystatechange = handleServerResponse_postcode;
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.send("postcode=" + input);

    }else{
    }
       
}

function handleServerResponse_postcode(){
    if(xmlHttp.readyState === 4){
        if(xmlHttp.status === 200){
            xmlResponse = xmlHttp.responseXML;
            xmlDocumentElement = xmlResponse.documentElement;
            message = xmlHttp.responseXML.getElementsByTagName("response")[0].getElementsByTagName("div")[0].id;
            
            console.log("postcode " + message);
            
            if(message === "enter_postcode"){
                document.getElementById("postcode_image").src="images/close.png";
            }
            if(message === "postcode_available"){
                document.getElementById("postcode_image").src="images/tick.png";
            }
                        

        }else{
            alert('Something went wrong!');
        }
    }
}

function process_stad(){
    if(xmlHttp.readyState === 4 || xmlHttp.readyState === 0){
        input = encodeURIComponent(document.getElementById("stad").value);
        
        console.log("stad " + input);
        
        xmlHttp.open("POST", "inc/user/stad_status.php", true);
        xmlHttp.onreadystatechange = handleServerResponse_stad;
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.send("stad=" + input);

    }else{
    }
       
}

function handleServerResponse_stad(){
    if(xmlHttp.readyState === 4){
        if(xmlHttp.status === 200){
            xmlResponse = xmlHttp.responseXML;
            xmlDocumentElement = xmlResponse.documentElement;
            message = xmlHttp.responseXML.getElementsByTagName("response")[0].getElementsByTagName("div")[0].id;
            
            console.log("stad " + message);
            
            if(message === "enter_stad"){
                document.getElementById("stad_image").src="images/close.png";
            }
            if(message === "stad_available"){
                document.getElementById("stad_image").src="images/tick.png";
            }
                        

        }else{
            alert('Something went wrong!');
        }
    }
}

function process_telefoon(){
    if(xmlHttp.readyState === 4 || xmlHttp.readyState === 0){
        input = encodeURIComponent(document.getElementById("telefoon").value);
        
        console.log("telefoon " + input);
        
        xmlHttp.open("POST", "inc/user/telefoon_status.php", true);
        xmlHttp.onreadystatechange = handleServerResponse_telefoon;
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.send("telefoon=" + input);

    }else{
    }
       
}

function handleServerResponse_telefoon(){
    if(xmlHttp.readyState === 4){
        if(xmlHttp.status === 200){
            xmlResponse = xmlHttp.responseXML;
            xmlDocumentElement = xmlResponse.documentElement;
            message = xmlHttp.responseXML.getElementsByTagName("response")[0].getElementsByTagName("div")[0].id;
            
            console.log("telefoon " + message);
            
            if(message === "enter_telefoon"){
                document.getElementById("telefoon_image").src="images/close.png";
            }
            if(message === "telefoon_available"){
                document.getElementById("telefoon_image").src="images/tick.png";
            }
                        

        }else{
            alert('Something went wrong!');
        }
    }
}

function process_email(){
    if(xmlHttp.readyState === 4 || xmlHttp.readyState === 0){
        input = encodeURIComponent(document.getElementById("email").value);
        input = decodeURIComponent(input);
        console.log("email " + input);
        
        xmlHttp.open("POST", "inc/user/email_status.php", true);
        xmlHttp.onreadystatechange = handleServerResponse_email;
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.send("email=" + input);

    }else{
    }
       
}

function handleServerResponse_email(){
    if(xmlHttp.readyState === 4){
        if(xmlHttp.status === 200){
            xmlResponse = xmlHttp.responseXML;
            xmlDocumentElement = xmlResponse.documentElement;
            message = xmlHttp.responseXML.getElementsByTagName("response")[0].getElementsByTagName("div")[0].id;
            
            console.log("email " + message);
            
            if(message === "enter_email"){
                document.getElementById("email_image").src="images/close.png";
            }
            if(message === "email_available"){
                document.getElementById("email_image").src="images/tick.png";
            }
            if(message === "email_exists"){
                document.getElementById("email_image").src="images/close.png";
            }
            

        }else{
            alert('Something went wrong!');
        }
    }
}

function process_password(){
    if(xmlHttp.readyState === 4 || xmlHttp.readyState === 0){
        input = encodeURIComponent(document.getElementById("password").value);
        
        console.log("password " + input);
        
        xmlHttp.open("POST", "inc/user/password_status.php", true);
        xmlHttp.onreadystatechange = handleServerResponse_password;
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.send("password=" + input);

    }else{
    }
       
}

function handleServerResponse_password(){
    if(xmlHttp.readyState === 4){
        if(xmlHttp.status === 200){
            xmlResponse = xmlHttp.responseXML;
            xmlDocumentElement = xmlResponse.documentElement;
            message = xmlHttp.responseXML.getElementsByTagName("response")[0].getElementsByTagName("div")[0].id;
            
            console.log("password " + message);
            
            if(message === "enter_password"){
                document.getElementById("password_image").src="images/close.png";
            }
            if(message === "password_available"){
                document.getElementById("password_image").src="images/tick.png";
            }
                        

        }else{
            alert('Something went wrong!');
        }
    }
}

function checkfields(){
    if(document.getElementById("register_error")){
        document.getElementById("register_error").remove();
    }
    
    voornaam = document.getElementById("voornaam_image").src;
    voornaam = /[^/]*$/.exec(voornaam)[0];
    achternaam = document.getElementById("achternaam_image").src;
    achternaam = /[^/]*$/.exec(achternaam)[0];
    adres = document.getElementById("adres_image").src;
    adres = /[^/]*$/.exec(adres)[0];
    postcode = document.getElementById("postcode_image").src;
    postcode = /[^/]*$/.exec(postcode)[0];
    stad = document.getElementById("stad_image").src;
    stad = /[^/]*$/.exec(stad)[0];
    telefoon = document.getElementById("telefoon_image").src;
    telefoon = /[^/]*$/.exec(telefoon)[0];
    email = document.getElementById("email_image").src;
    email = /[^/]*$/.exec(email)[0];
    password = document.getElementById("password_image").src;
    password = /[^/]*$/.exec(password)[0];
    
        
    if(voornaam == "tick.png" && achternaam == "tick.png" && adres == "tick.png" && postcode == "tick.png" && stad == "tick.png" && telefoon == "tick.png" && email == "tick.png" && password == "tick.png"){
        document.getElementById("register").disabled = false;
        console.log("gelukt");
    }else{
        newdiv = document.createElement("div");
        newdiv.id="register_error";
        newdiv.innerHTML = "Je hebt een van de velden onjuist ingevuld";
        document.getElementById("button").appendChild(newdiv);
        console.log("mislukt");
    }
            
}

function checkfields2(){
    if(document.getElementById("reset_error")){
        document.getElementById("reset_error").remove();
    }

    password = document.getElementById("password_image").src;
    password = /[^/]*$/.exec(password)[0];


    if(password == "tick.png"){
        document.getElementById("verzend").disabled = false;
        console.log("gelukt");
    }else{
        newdiv = document.createElement("div");
        newdiv.id="reset_error";
        newdiv.innerHTML = "Je hebt een ongeldig wachtwoord ingevuld. <br>";
        newdiv.innerHTML = "Je wachtwoord moet ten minste 8 tekens lang zijn";
        document.getElementById("button").appendChild(newdiv);
        console.log("mislukt");
    }

}