<?php
include 'Header.php';
?>
<!DOCTYPE html>
<html>
    <body>
        <div class="row justify-content-md-center main-container">
			<!--<div class="row rounded shadow" style="background-color: #cecece; height: 500px;">-->
			<div class="col-md-2">
				<div class="card shadow">
					<form action="loginDatabase.php" method="post">
						<div class="card-header cat-header">Inloggen</div>
						<div class="card-body">
							<div class="form-group">
								<label for="InputEmail">Email</label>
								<input type="email" name="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" placeholder="Email">
							</div>
							<div class="form-group">
								<label for="InputPassword">Password</label>
								<input type="password" name="password" class="form-control" id="InputPassword" placeholder="Password">
							</div>
						</div>
						<div class="card-footer cat-footer">
							<button type="submit" class="btn btn-primary" name="submit">Inloggen</button>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-2">
				<div class="card shadow">
					<div class="card-header cat-header">Geen account</div>
					<div class="card-body">
						<p>Een account heeft vele voordelen. Bijvoorbeeld het automatische aanvullen van contactgegevens. Daarnaast kunt u ervoor kiezen om op de hoogte te blijven van nieuws of aanbiedingen.</p>
					</div>
					<div class="card-footer cat-footer">
						<a class="btn btn-primary" href="RegisterPage.php" role="button">Account aanmaken</a><br>
						<a href="SignUpWithoutAccount.php">Doorgaan zonder account</a>
					</div>
				</div>
			</div>
		</div>
    </body>
    <?php
    include"footer.php";
    ?>
</html>
