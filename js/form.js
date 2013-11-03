function formhash(form, password) {
   //Maak een nieuw input element, hier komt het gehashte wachtwoord in te staan
   var p = document.createElement("input");
   //Voeg het nieuwe element toe aan het formulier
   form.appendChild(p);
   p.name = "p";
   p.type = "hidden";
   p.value = hex_sha512(password.value);
   //Zorg dat het wachtwoord niet in plaintext wordt verzonden
   password.value = "";
   //Submit het formulier
   form.submit();
}