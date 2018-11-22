<?php
include 'Header.php';
?>
<!DOCTYPE html>
<html>
    <body>
        <div class="row" style="background-color:#EEEEEE; border: 1px solid black; margin-left: 25%; margin-right: 25%; height: 500px;">
            <div class="col-5" style="">
                <form>
                    <br><br>
                    <p>Ik heb al een account</p>
                    <br><br><br>
                    <p>Gebruikersnaam</p>
                    <input type="text" name="email" placeholder="Email"/><br>
                    <p>Wachtwoord</p>
                    <input type="password" name="password" placeholder="Wachtwoord"/><br><br><br>
                    <input type="submit" name="submit" value="Inloggen"/>
                </form>
            </div>
            <div class="col-1" style="border-left: 3px solid black">
            </div>
            <div class="col-6" style="">
                    <br><br>
                    <p>Ik heb nog geen account</p>
                    <br><br><br>
                    <a href="SignUp.php">Account aanmaken</a>
                    <br><br><br>
                    <a href="SignUpWithoutAccount.php">Doorgaan zonder account</a>
            </div>
        </div>
    </body>
    <?php
    include"footer.php";
    ?>
</html>
