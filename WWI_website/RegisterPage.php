<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
include 'Header.php';
?>
<html>
    <body>
        <div class="row justify-content-md-center" style="align-items:  center">
            <form action="RegisterToDatabase.php" method="post">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Voornaam:</div> <input class="col-3"type="text" name="firstname" style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Tussenvoegsel:</div> <input class="col-3"type="text" name="infix"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Achternaam:</div> <input class="col-3"type="text" name="lastname"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Geboortedatum:</div> <input class="col-3"type="date" name="birthdate"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">E-mail:</div><input class="col-3"type="email" name="email"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Wachtwoord:</div> <input class="col-3"type="password" name="passwordone"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Wachtwoord opnieuw:</div> <input class="col-3"type="password" name="passwordtwo"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Postcode:</div> <input class="col-3"type="text" name="postalcode"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Straatnaam:</div> <input class="col-3"type="text" name="streetname"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Huisnummer:</div> <input class="col-3"type="text" name="housenumber"style="margin-bottom: 2%;margin-top: 2%;width: 600px"><br>
            <input class="col-4"type="submit" value="Verder"style="margin-bottom: 2%;margin-top: 2%">
        </form></div>
    </body>
    <?php
    include"footer.php";
    ?>
</html>