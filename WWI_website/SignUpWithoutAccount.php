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
            <div class="col-3">
                <div style="background-color: red">
                    <?php
                    if (isset($_SESSION["correctData"])) {
                        print("Er is iets misgegaan, probeer het nog eens");
                        unset($_SESSION["correctData"]);
                    }
                    ?>
                </div>
                <form action="SignUpWithoutAccountControl.php" method="post">
                    <div style="margin-bottom: 2%;margin-top: 2%">Voornaam*</div> <input class="col-3 form-control" type="text" name="firstname" required="" style="margin-bottom: 2%;margin-top: 2%;">
                    <div style="margin-bottom: 2%;margin-top: 2%">Tussenvoegsel</div> <input class="col-3 form-control" type="text" name="infix" style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">Achternaam*</div> <input class="col-3 form-control" type="text" name="lastname" required style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">E-mail*</div><input class="col-3 form-control" type="email" name="email" required style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">Postcode*</div> <input class="col-3 form-control" type="text" name="postalcode" required style="margin-bottom: 2%;margin-top: 2%;width: 600px">
                    <div style="margin-bottom: 2%;margin-top: 2%">Huisnummer*</div> <input class="col-3 form-control" type="text" name="housenumber" required style="margin-bottom: 2%;margin-top: 2%;width: 600px"><br>
                    <input class="col-4 form-control" type="submit" value="Verder" style="margin-bottom: 2%;margin-top: 2%">
                </form>
            </div>
        </div>
    </body>
    <?php
    include"footer.php";
    ?>
</html>