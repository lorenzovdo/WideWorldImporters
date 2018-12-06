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
            <div class="col-4">
                <div style="background-color: red">
                    <?php
                    if (isset($_SESSION["invalidData"])) {
                        print("Niet alle velden zijn goed ingevuld");
                        unset($_SESSION["invalidData"]);
                    }
                    if (isset($_SESSION["emailTaken"])) {
                        print("Het opgegeven emailadres is al in gebruik");
                        unset($_SESSION["differentPass"]);
                    }
                    if (isset($_SESSION["differentPass"])) {
                        print("Je hebt twee verschillende wachtwoorden ingevuld");
                        unset($_SESSION["differentPass"]);
                    }
                    ?>
                </div>
                <form action="RegisterToDatabase.php" method="post">
                    <div style="margin-bottom: 2%;margin-top: 2%">Voornaam*</div> <input class="col-3" type="text" name="firstname" required style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">Tussenvoegsel</div> <input class="col-3" type="text" name="infix" style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">Achternaam*</div> <input class="col-3" type="text" name="lastname" required style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">Geboortedatum*</div> <input class="col-3" type="date" name="birthdate" required style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">E-mail*</div><input class="col-3" type="email" name="email" required style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">Wachtwoord*</div> <input class="col-3" type="password" name="passwordone" required style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">Wachtwoord opnieuw*</div> <input class="col-3" type="password" name="passwordtwo" required style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">Postcode*</div> <input class="col-3" type="text" name="postalcode" required style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">Straatnaam*</div> <input class="col-3" type="text" name="streetname" required style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">Huisnummer*</div> <input class="col-3" type="text" name="housenumber" required style="margin-bottom: 2%;margin-top: 2%;width: 600px"><br>
                    <input class="col-4" type="submit" value="Verder" style="margin-bottom: 2%;margin-top: 2%">
                </form>
            </div>
        </div>
    </body>
    <?php
    include"footer.php";
    ?>
</html>