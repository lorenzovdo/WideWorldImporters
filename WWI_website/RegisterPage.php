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
        <div class="row justify-content-md-center main-container">
			<div class="col-md-6">
				<?php
				if (isset($_SESSION["invalidRegister"])) { ?>
				<div class="card shadow mb-5">
					<div class="card-body">
						Foutmelding:
						<?php
							print($_SESSION["invalidRegister"]);
							unset($_SESSION["invalidRegister"]);
							?>
					</div>
				</div>
				<?php } ?>
				<form action="RegisterToDatabase.php" method="post">
					<div class="form-row">
						<h4 class="w-100">Registreren</h4>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="inputVoornaam">Voornaam*</label>
							<input type="text" class="form-control" id="inputVoornaam" name="firstname" placeholder="Voornaam" required>
						</div>
						<div class="form-group col-md-3">
							<label for="inputTussenvoegsel">Tussenvoegsel</label>
							<input type="text" class="form-control" id="inputTussenvoegsel" name="infix" placeholder="Tussenvoegsel">
						</div>
						<div class="form-group col-md-5">
							<label for="inputAchternaam">Achternaam*</label>
							<input type="text" class="form-control" id="inputAchternaam" name="lastname" placeholder="Achternaam" required>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputEmail">Email*</label>
							<input type="text" class="form-control" id="inputEmail" name="email" placeholder="Email" required>
						</div>
						<div class="form-group col-md-6">
							<label for="inputGeboortedatum">Geboortedatum*</label>
							<input type="date" class="form-control" id="inputGeboortedatum" name="birthdate" required>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputPasswordOne">Wachtwoord*</label>
							<input type="password" class="form-control" id="inputPasswordOne" name="passwordone" placeholder="Wachtwoord" required>
						</div>
						<div class="form-group col-md-6">
							<label for="inputPasswordTwo">Bevestiging wachtwoord*</label>
							<input type="password" class="form-control" id="inputPasswordTwo" name="passwordtwo" placeholder="Bevestiging wachtwoord" required>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-3">
							<label for="inputPostcode">Postcode*</label>
							<input type="text" class="form-control" id="inputPostcode" name="postalcode" placeholder="Postcode" required>
						</div>
						<div class="form-group col-md-6">
							<label for="inputStraatnaam">Straatnaam*</label>
							<input type="text" class="form-control" id="inputStraatnaam" name="streetname" placeholder="Straatnaam" required>
						</div>
						<div class="form-group col-md-3">
							<label for="inputHuisnummer">Huisnummer*</label>
							<input type="text" class="form-control" id="inputHuisnummer" name="housenumber" placeholder="Huisnummer" required>
						</div>
					</div>
					<input type="submit" class="btn btn-primary" value="Verder">
				</form>
			</div>
            <!--<form action="RegisterToDatabase.php" method="post">
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
        </form>-->
		</div>
    </body>
    <?php
    include"footer.php";
    ?>
</html>