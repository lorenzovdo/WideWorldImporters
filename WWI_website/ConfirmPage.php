<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
if(!filter_has_var(INPUT_GET, "logged")) {
	include_once 'Functions.php';
	if(filter_input(INPUT_POST, "firstname")==="" || filter_input(INPUT_POST, "lastname")==="" || filter_input(INPUT_POST, "email")==="" ||
        filter_input(INPUT_POST, "postalcode")==="" || filter_input(INPUT_POST, "housenumber")==="" || !postalcodeCheck(filter_input(INPUT_POST, "postalcode"))){
    	if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		$_SESSION["invalidData"] = true;
		header('Location: SignUpWithoutAccount.php');
		exit();
	}
}

include 'header.php';
if (isset($_POST['firstname'])) {
    createAnonymousUser();
}
?>
<html>
	<body>
        <div class="row justify-content-md-center main-container">
            <div class="col-md-5">
                <div class="row">
                    <?php
                    foreach ($_SESSION["Shoppingcart"] as $key => $value) { ?>
						<div class="col-12 rounded shadow" style="background-color:#cecece; height: 200 px; padding: 1%; margin-bottom: 2%;">
							<img style="width: 30%;" src="<?php print($value[3]); ?>">
							<div class="col-8" style="float: right;"><p> Product: <?php print($value[0]); ?></p>
								Aantal: <?php print($value[1]); ?>
								<p>Prijs per stuk: €<?php print($value[2]); ?></p>
								<p>Totaal product: €<?php print(number_format($value[2] * $value[1],2)); ?></p>
							</div>
						</div>
					<?php } ?>
				</div>
            </div>
			<div class="col-2">
				<div class="card shadow">
					<div class="card-header cat-header">Bevestiging</div>
					<div class="card-body">
						<?php getUserInfo();?>
						<hr>
						<?php
						$totaalPrijs = null;
						foreach ($_SESSION["Shoppingcart"] as $key => $value) {
							$totaalPrijs = $totaalPrijs + ($value[2] * $value[1]);
						}
						?>
						<p>Subtotaal: €<?php print(number_format($totaalPrijs,2)); ?></p>
						<p>Verzending: Gratis</p>
						<hr>
						<p>Totaalprijs (inclusief btw): €<?php print(number_format($totaalPrijs,2)); ?></p>
					</div>
					<div class="card-footer cat-footer">
						<form action="CheckoutPage.php" method="post">
							<input class="btn btn-primary" type="submit" value="Verder">
						</form>
					</div>
				</div>
        	</div>
		</div>
    </body>
</html>
