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
    <body
        <br><br>
        <div class="row justify-content-md-center" style="align-items: center">
            <img src="Img/gegevens.png" width="50%" height="50%;">
        </div>
    </body>
    <body>
        <div class="row justify-content-md-center" style="align-items:  center">
            <form action="CheckoutPage.php" method="post">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Voornaam:</div> <input class="col-3"type="text" name="firstname" style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Tussenvoegsel:</div> <input class="col-3"type="text" name="infix"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Achternaam:</div> <input class="col-3"type="text" name="lastname"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">E-mail:</div><input class="col-3"type="email" name="email"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Postcode:</div> <input class="col-3"type="text" name="postalcode"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Huisnummer:</div> <input class="col-3"type="number" name="housenumber"style="margin-bottom: 2%;margin-top: 2%;width: 600px"><br>
            <input class="col-4"type="submit" value="Verder"style="margin-bottom: 2%;margin-top: 2%">
        </form></div>
    </body> 
    <?php
    include"footer.php";
    ?>
</html>
