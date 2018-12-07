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
        <div class="row justify-content-md-center main-container" style="align-items: center">
			<div class="col-md-6">
				<?php
				if (isset($_SESSION["invalidData"])) { ?>
				<div class="card shadow mb-5">
					<div class="card-body">
						Foutmelding:
						<?php
							print("Er is iets misgegaan, probeer het nog eens");
							unset($_SESSION["invalidData"]);
							?>
					</div>
				</div>
				<?php } ?>
				<form action="ConfirmPage.php" method="post">
					<div class="form-row">
						<h4 class="w-100">Contactgegevens</h4>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="inputVoornaam">Voornaam*</label>
							<input type="text" class="form-control" id="inputVoornaam" name="firstname" placeholder="Voornaam">
						</div>
						<div class="form-group col-md-3">
							<label for="inputTussenvoegsel">Tussenvoegsel</label>
							<input type="text" class="form-control" id="inputTussenvoegsel" name="infix" placeholder="Tussenvoegsel">
						</div>
						<div class="form-group col-md-5">
							<label for="inputAchternaam">Achternaam*</label>
							<input type="text" class="form-control" id="inputAchternaam" name="lastname" placeholder="Achternaam">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail">Email*</label>
							<input type="text" class="form-control" id="inputEmail" name="email" placeholder="Email">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputPostcode">Postcode*</label>
							<input type="text" class="form-control" id="inputPostcode" name="postalcode" placeholder="Postcode">
						</div>
						<div class="form-group col-md-6">
							<label for="inputHuisnummer">Huisnummer*</label>
							<input type="text" class="form-control" id="inputHuisnummer" name="housenumber" placeholder="Huisnummer">
						</div>
					</div>
					<input type="submit" class="btn btn-primary" value="Verder">
				</form>
			</div>
            <!--<form action="ConfirmPage.php" method="post">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Voornaam:</div> <input class="col-3"type="text" name="firstname" style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Tussenvoegsel:</div> <input class="col-3"type="text" name="infix"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Achternaam:</div> <input class="col-3"type="text" name="lastname"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">E-mail:</div><input class="col-3"type="email" name="email"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Postcode:</div> <input class="col-3"type="text" name="postalcode"style="margin-bottom: 2%;margin-top: 2%;width: 600px">
            <div class="col-4" style="margin-bottom: 2%;margin-top: 2%">Huisnummer:</div> <input class="col-3"type="text" name="housenumber"style="margin-bottom: 2%;margin-top: 2%;width: 600px"><br>
            <input class="col-4"type="submit" value="Verder"style="margin-bottom: 2%;margin-top: 2%">
        </form>-->
		</div>
    </body>
    <?php
    include"footer.php";
    ?>
</html>